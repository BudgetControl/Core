<?php

namespace App\Mailer\Entities;

use Illuminate\Contracts\Mail\Mailable;

interface MailInterface {
    
    public function build(): Mailable;
    
}