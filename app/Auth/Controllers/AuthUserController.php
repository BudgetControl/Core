<?php
namespace App\User\Controllers;

use Illuminate\Http\Request;
use Ellaisys\Cognito\AwsCognitoClient;
use Ellaisys\Cognito\Auth\RefreshToken;
use Ellaisys\Cognito\Auth\VerifiesEmails;
use Ellaisys\Cognito\Auth\ResetsPasswords;
use Ellaisys\Cognito\Auth\SendsPasswordResetEmails;

class AuthUserController {

    use ResetsPasswords, VerifiesEmails, SendsPasswordResetEmails, RefreshToken;
    
    public function delete(Request $request, AwsCognitoClient $client) {
        
        $client->deleteUser($request->email);
    }
    
}