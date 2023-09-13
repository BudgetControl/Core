<?php

namespace App\Http\Controllers;

use App\BudgetTracker\Services\AccountsService;
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
use Illuminate\Log\Logger;

class AuthController extends Controller
{
    use Encryptable;

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

    /**
     * register user
     * @param Request $request
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ]);
    
            $user = new User();
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->password = bcrypt($request['password']);
            $user->save();

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
            'username' => $user->name,
            'email' => $user->email,
            'confirm_link' => 'link'
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
}
