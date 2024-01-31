<?php

namespace App\Auth\Controllers;

use App\Auth\Entity\Token;
use Throwable;
use App\User\Models\User;
use Illuminate\Http\Request;
use App\Auth\Service\AuthService;
use App\Mailer\Entities\AuthMail;
use Illuminate\Support\Facades\Log;
use App\Mailer\Services\MailService;
use App\Mailer\Exceptions\MailExeption;
use Ellaisys\Cognito\Auth\RegistersUsers;
use App\Auth\Service\CognitoClientService;
use App\BudgetTracker\Entity\Cache;
use App\Traits\Encryptable;
use Illuminate\Validation\ValidationException;

class AuthRegisterController
{
    use RegistersUsers, Encryptable;

    const URL_SIGNUP_CONFIRM = '/app/auth/confirm/';
    const PASSWORD_VALIDATION = '/^(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[A-Z])(?=.*[a-z]).{8,}$/';

    /**
     * register
     *
     * @param  Request $request
     * @return void
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:64|unique:users',
                'password' => 'sometimes|confirmed|min:6|max:64|regex:' . self::PASSWORD_VALIDATION,
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        //save in cache user password
        $collection = collect([
            'name' => $request->name,
            'email' => $request->email,
            'password' => generateRandomPassword()
        ]);

        $data = $collection->only('name', 'email', 'password');

        if ($cognito = $this->createCognitoUser($data)) {

            try {
                //If successful, create the user in local db
                $user = $this->userSignUp($request->toArray());

                AuthService::createAccountEntry($user->id);
                AuthService::setUpDefaultSettings($user->id);

                $this->sendMail($user);
            } catch (Throwable $e) {
                CognitoClientService::init($request->email)->client->deleteUser($request->emai);
                Log::critical($e->getMessage());
                //Redirect to view
                return response()->json([
                    "success" => false,
                    "error" => "An error occurred ty again"
                ], 201);
            }
        }

        //Redirect to view
        return response()->json([
            "success" => "Registration successfully",
            "details" => $cognito
        ], 201);
    }


    /**
     * userSignUp
     *
     * @param  array $request
     * @return User
     */
    private function userSignUp(array $request): User
    {
        $user = new User();
        $user->uuid = uniqid();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->save();

        $token = Token::create($user)->saveCache()->getToken();
        Cache::create($token . 'password')->set($request['password']);

        return $user;
    }


    /**
     * sendMail
     *
     * @param  User $user
     * @return void
     */
    private function sendMail(User $user)
    {
        $token = Token::create($user)->saveCache()->getToken();

        $data = [
            'name' => $user->name,
            'email' => $user->email->email,
            'confirm_link' => config("app.url") . self::URL_SIGNUP_CONFIRM . $token
        ];

        try {
            $mailer = new MailService(new AuthMail(
                'Welcome to ' . config("app.name"),
                $data
            ));

            $mailer->send($user->email);
        } catch (MailExeption $e) {
            Log::emergency("Unable to send email :" . $e->getMessage());
        }
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

    /**
     * confirm user
     */
    public function confirm(string $token): bool
    {
        $user = Cache::create($token)->get();
        if (empty($user)) {
            return false;
        }

        $password = Cache::create($token . "password")->get();
        if (!empty($password)) {
            CognitoClientService::init($user->email->email)->verifyUserEmail()
                ->forceUserPassword($password);
        }

        $user->email_verified_at = date('Y-m-d H:i:s');
        $user->save();

        //auth user with congito
        return true;
    }
}
