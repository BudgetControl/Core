<?php

namespace App\User\Controllers;

use Exception;
use App\User\Models\User;
use App\Traits\Encryptable;
use Illuminate\Http\Request;
use App\Mailer\Entities\AuthMail;
use App\User\Models\UserSettings;
use App\User\Services\AuthService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Mailer\Services\MailService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\User\Exceptions\AuthException;
use App\Mailer\Exceptions\MailExeption;
use Illuminate\Database\QueryException;
use App\User\Models\PersonalAccessToken;
use App\Mailer\Entities\RecoveryPasswordMail;
use Illuminate\Validation\ValidationException;
use App\BudgetTracker\Services\AccountsService;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class AuthController extends Controller
{
    use Encryptable;

    const URL_PSW_RESET = '/app/auth/reset-password/';
    const URL_SIGNUP_CONFIRM = '/app/auth/confirm/';

    /**
     * make authentication for API user
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function authenticate(Request $request)
    {
        $expiredToken = new \DateTime();
        $expiredToken->modify('+ 7 days');

        $JWT_PAYLOAD = [
            'user' => $request->user,
            'email' => $request->email,
            'password' => $request->password,
            'domain' => env("APP_URL", "https://www.budgetcontrol.cloud")
        ];

        try {
            if (!Auth::attempt([
                'email' => self::encrypt(['email' => $request->email]),
                'password' => $request->password
            ])) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            $user = Auth::user();
            //first check if user have confirmed the email
            if (is_null($user->email_verified_at)) {
                throw new AuthException("User email is not verified");
            };

            $token = $user->retriveNotExpiredToken();

            if (empty($token)) {
                $jwt = self::encrypt($JWT_PAYLOAD);
                $token = $user->createToken('access_token', $jwt, ['*'], \DateTime::createFromFormat('Y-m-d H:i:s', $expiredToken->format('Y-m-d H:i:s')));
            }

            $user->useToken();
        } catch (\Exception $e) {
            Log::critical("could_not_create_token " . $e->getMessage());
            return response()->json(['error' => 'could_not_create_token'], 500);
        }

        return response()->json(['token' => $token]);
    }

    /**
     * check if user is logged
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function check()
    {
        //middelware will be check if token exist
        return response()->json(['success' => 'user authenticated']);
    }

    /**
     * login user
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        if (Auth::attempt([
            'email' => self::encrypt(['email' => $request->email]),
            'password' => $request->password
        ])) {

            try {

                $expiredToken = new \DateTime();
                $expiredToken->modify('+ 7 days');

                $token = PersonalAccessToken::where('tokenable_id', Auth::id())
                    ->where('name', 'access_token')->where('expires_at', '>', date('Y-m-d H:i:s', time()))->first();
                if($token) {
                    $token->expires_at = $expiredToken->format('Y-m-d H:i:s');
                    $token->save();
                }

            } catch (Exception $e) {
                Log::error("Can not refresh a token " . $e->getMessage());
            }

            return $this->authenticate($request);
        } else {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
    }

    public function recovery(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $user = User::where('email', self::encrypt(['email' => $request->email]))->firstOrFail();
            $service = new AuthService();
            $service->user = $user;

            $userData = $user->toArray();
            $userData['link'] = env("APP_URL", "https://www.budgetcontrol.cloud") . self::URL_PSW_RESET . $service->token($user);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'User email not foud, please sign up :-)'], 401);
        }

        try {

            $mailer = new MailService(
                new RecoveryPasswordMail(
                    "Recovery password",
                    $userData
                )
            );

            $mailer->send($user->email);

            return response()->json(['success' => 'Sended recovery'], 200);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reset(Request $request, string $token): \Illuminate\Http\JsonResponse
    {
        try {
            $service = new AuthService();
            $user = $service->retriveToken($token);
        } catch (AuthException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }


        if (empty($user)) {
            return response()->json(['error' => 'Token is not valid'], 401);
        }

        $user->password = bcrypt($request['password']);
        $user->save();

        return response()->json(['success' => 'Success recovery'], 200);
    }

    /**
     * register user
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): \Illuminate\Http\JsonResponse
    {
        $service = new AuthService();
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);

            try {
                $user = $service->signUp($request->toArray());
            } catch (QueryException $e) {
                return response()->json(["error" => "User with these email already exist"],400);
            }

            try {
                //create first free account
                $service->createAccountEntry();
                $service->setUpDefaultSettings();

            } catch (Exception $e) {
                Log::error("Unable to create new account on signup, user wil be deleted");
                Log::error($e);
                $user->delete();
                throw new AuthException("Unable to create new account on signup, user wil be deleted");
            }

            $this->sendMail($user);
            return response()->json(["sucess" => "Registration successfully"]);

        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * logout user
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Logged out'], 200);
    }

    /**
     * 
     */
    private function sendMail(User $user)
    {
        $AuthService = new AuthService($user);
        $token = $AuthService->token();

        $data = [
            'name' => $user->name,
            'email' => $user->email->email,
            'confirm_link' => env("APP_URL", "https://www.budgetcontrol.cloud") . self::URL_SIGNUP_CONFIRM . $token
        ];

        try {
            $mailer = new MailService(new AuthMail(
                'Welcome to ' . env("APP_NAME", "Budget Control"),
                $data
            ));

            $mailer->send($user->email);
            Cache::put($token,$user,3600);

        } catch (MailExeption $e) {
            Log::emergency("Unable to send email :" . $e->getMessage());
        }
    }

    public function confirm(string $token)
    {
        $service = new AuthService();
        $service->confirm($token);
    }

    /** 
     * send email verify 
     * 
     * @param Request $request
     * */
    public function sendVerifyEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        $email = self::encrypt(['email' => $request->email]);
        $user = User::where("email", $email)->firstOrFail();

        $this->sendMail($user);

        return response()->json(["success" => "email sended"]);
    }
}
