<?php
namespace App\Auth\Controllers;

use Throwable;
use App\User\Models\User;
use App\Traits\Encryptable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Auth\Service\CognitoClientService;
use Ellaisys\Cognito\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;

class AuthLoginController extends AuthController {

    use AuthenticatesUsers, Encryptable;

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
                'rememberMe' => 'boolean'
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $toCollect = [
            'email' => $request->email,
            'password' => $request->password,
            'crypted_email' => self::encrypt(['email' => $request->email]),
            'rememberMe' => $request->rememberMe
        ];

        try {
            $result = CognitoClientService::init($toCollect['email'])->authLogin($toCollect['password']);
            if(Auth::attempt([
                'email' => $toCollect['crypted_email'],
                'password' => $toCollect['password']
            ], $toCollect['rememberMe']) ) {
                
                /** @var AccessToken $accessToken */
                $token = $this->authenticateUserCognito($result);

                $user = User::find(Auth::id());
                //check if user has verified email
                if (is_null($user->email_verified_at)) {
                    return response()->json([
                        'success' => false,
                        'error' => 'email not verified',
                        'code' => 'EML_NaN'
                    ], 401);
                }

                return response()->json([
                    'success' => true,
                    'access_token' => $token->value()
                ]);
            }

        } catch (Throwable $e) {
            Log::error($e->getMessage());

        }

        return response()->json([
            "success" => false,
            "error" => "An error occuring, try later",
        ], 401);

    }

}