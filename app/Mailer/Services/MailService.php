<?php
namespace App\Mailer\Services;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mailer\Entities\MailInterface;

class MailService
{
    private $mailer;
    private $cc;
    private $bcc;

    public function __construct(MailInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(mixed $to): void
    {
        Log::debug("Sending email");
        Mail::to($to)->send($this->mailer->build());
    }

    public function queue(mixed $to): void
    {
        Log::debug("Sending email ");
        Mail::to($to)->queue($this->mailer->build());
    }

    /**
     * Set the value of bcc
     *
     * @return  self
     */ 
    public function setBcc($bcc)
    {
        $this->bcc = Mail::bcc($bcc);

        return $this;
    }

    /**
     * Set the value of cc
     *
     * @return  self
     */ 
    public function setCc($cc)
    {
        $this->cc = Mail::cc($cc);

        return $this;
    }
}
