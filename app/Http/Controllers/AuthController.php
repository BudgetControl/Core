<?php

namespace App\Http\Controllers;

use App\BudgetTracker\Services\AccountsService;
use App\Http\Exceptions\AuthException;
use App\Http\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Traits\Encryptable;
use Exception;
use Illuminate\Validation\ValidationException;
use App\Mailer\Services\MailService;
use App\Mailer\Entities\AuthMail;
use App\Mailer\Exceptions\MailExeption;
use App\Mailer\Entities\RecoveryPasswordMail;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Log\Logger;

class AuthController extends Controller
{
    use Encryptable;

    const URL_PSW_RESET = '/auth/reset/';
    const URL_SIGNUP_CONFIRM = '/auth/confirm/';

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
            'domain' => env('APP_URL')
        ];

        try {
            if (!Auth::attempt([
                'email' => self::encrypt(['email' => $request->email]),
                'password' => $request->password
            ])) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }

            $user = Auth::user();
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
            $userData['link'] = env("APP_URL").self::URL_PSW_RESET.$service->link($user);
        } catch (ModelNotFoundException $e){
            return response()->json(['error' => 'User is not valid'], 401);
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
            
        } catch(ValidationException $e) {
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


        if(empty($user)) {
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
    public function register(Request $request)
    {
        $service = new AuthService();
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);
    
            $user = $service->signUp($request->toArray());

            try {
                //create first free account
                $serviceAccount = new AccountsService();
                $serviceAccount->save([
                    "user_id" => $user->id,
                    "name" => "Cash",
                    "color" => "F9A602",
                    "type" => "Cash",
                    "balance" => 0,
                    "installement" => false,
                    "installementValue" => 0,
                    "currency" => "EUR",
                    "amount" => 0
                ]);
            } catch (Exception $e) {
                Log::error("Unable to create new account on signup, user wil be deleted");
                Log::error($e);

                $user->delete();
            }

            $this->sendMail($user);
    
            return $this->authenticate($request);

        } catch(ValidationException $e) {

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
        $data = [
            'name' => $user->name,
            'email' => $user->email->email,
            'confirm_link' => env("APP_URL").self::URL_SIGNUP_CONFIRM.$user->link
        ];

        try {
            $mailer = new MailService(new AuthMail(
                'Registrazione',
                $data
            ));
    
            $mailer->send($user->email);
        } catch (MailExeption $e) {
            Log::emergency("Unable to send email :".$e->getMessage());
        }   
       
    }

    public function confirm(string $token)
    {
        $service = new AuthService();
        $service->confirm($token);
    }
}
