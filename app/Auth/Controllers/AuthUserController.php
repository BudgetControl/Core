<?php

namespace App\Auth\Controllers;

use App\User\Models\User;
use App\Auth\Entity\Token;
use App\Traits\Encryptable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mailer\Services\MailService;
use App\Auth\Exception\AuthException;
use App\Auth\Service\CognitoClientService;
use App\Mailer\Entities\RecoveryPasswordMail;
use Illuminate\Validation\ValidationException;
use App\Auth\Controllers\AuthRegisterController;
use App\BudgetTracker\Entity\Cache;
use App\User\Services\UserService;
use Illuminate\Support\Facades\Auth;

class AuthUserController
{

    use Encryptable;

    const URL_PSW_RESET = '/app/auth/reset-password/';

    /**
     * delete
     *
     * @param  mixed $request
     * @param  mixed $client
     * @return void
     */
    public function delete(Request $request)
    {

        try {
            $request->validate([
                'email' => 'required|email',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        CognitoClientService::init($request->email)->delete();

        return response()->json([
            'success' => true
        ], 200);
    }

    /**
     * recoveryPassword
     *
     * @param  mixed $request
     * @return Response
     */
    public function recoveryPassword(Request $request)
    {

        try {
            $user = User::where('email', self::encrypt(['email' => $request->email]))->firstOrFail();
            $token = Token::create([
                'email' => $user->email,
                'id' => $user->id,
                'date_time' => microtime()
            ])->getToken();

            //save user information on cache
            Cache::create($token)->set($user);

            $userData['email'] = $request->email;
            $userData['name'] = $user->name;
            $userData['link'] = config("app.url") . self::URL_PSW_RESET . $token;
        } catch (AuthException $e) {
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


    /**
     * resetPassword
     *
     * @param  mixed $request
     * @param  mixed $token
     * @return Response
     */
    public function resetPassword(Request $request, string $token)
    {
        try {
            $request->validate([
                'password' => 'sometimes|confirmed|min:6|max:64|regex:' . AuthRegisterController::PASSWORD_VALIDATION,
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        //save user information on cache
        $user = Cache::create($token)->get();
        CognitoClientService::init($user->email->email)->forceUserPassword($request->password);
        $user->password = $request->password;
        $user->save();

        return response()->json([
            'success' => true
        ], 201);
    }

    /**
     * logout
     *
     * @return void
     */
    public function logout()
    {
        Auth::logout();
        UserService::clearUserCache();
        CognitoClientService::init('')->client->signOut(
            UserService::getTokenCache()
        );

        return response()->json([
            'success' => true
        ], 200);
    }
    
    /**
     * check
     */
    public function check()
    {
        return response()->json([
            'success' => true
        ], 200);
    }
}
