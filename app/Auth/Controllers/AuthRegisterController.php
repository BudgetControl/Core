<?php

namespace App\Auth\Controllers;

use App\Auth\Service\AuthService;
use App\Auth\Service\CognitoClientService;
use Ellaisys\Cognito\Auth\RegistersUsers;
use Illuminate\Http\Request;
use App\User\Models\User;
use Exception;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthRegisterController
{

    use RegistersUsers;

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email|max:64|unique:users',
                'password' => 'sometimes|confirmed|min:6|max:64',
            ]);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }

        $collection = collect($request->all());
        $data = $collection->only('name', 'email', 'password');

        if ($cognito = $this->createCognitoUser($data)) {

            try {
                //If successful, create the user in local db

                $user = $this->userSignUp($request->toArray());

                AuthService::createDatabse($user->database_name);
                AuthService::migrate($user->database_name);
                AuthService::createAccountEntry($user->database_name);
                AuthService::setUpDefaultSettings($user->database_name);

            } catch (Throwable $e) {
                CognitoClientService::init()->client->deleteUser($request->email);
            }
        }

        //Redirect to view
        return response()->json([
            "succedd" => "Registration successfully",
            "details" => $cognito
        ],201);
    }

    /**
     *  sign up user
     */
    private function userSignUp(array $request): User {

        $user = new User();
        $user->uuid = uniqid();
        $user->name = $request['name'];
        $user->email = $request['email'];
        $user->password = bcrypt($request['password']);
        $user->database_name = uniqid('budgetV2_');
        $user->save();

        return $user;
    }
}
