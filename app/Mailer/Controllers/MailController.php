<?php

namespace App\Mailer\Controllers;

use App\Mailer\Entities\Mail;
use App\Mailer\Services\MailService;
use App\User\Models\User;
use App\User\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\Response;

class MailController extends Controller
{

    public function assistance(Request $request): Response
    {
        $userId = UserService::getCacheUserID();
        $user = User::find($userId);

        $message = $request->text;
        $mail = new Mail(
            [
                "name" => $user->name,
                "email" => $user->email->email,
                "text" => $message
            ]
        );
        $mail->subject("Assistance request!");

        $mail = new MailService(
            $mail
        );
        $mail->send(env("MAIL_POSTMASTER", 'postmaster@budgetcontrol.cloud'));

        return response("ok");
    }
}
