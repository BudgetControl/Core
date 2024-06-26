<?php

namespace App\Mailer\Entities;

use Illuminate\Mail\Mailable;
use App\Mailer\Exceptions\MailExeption;
use Illuminate\Support\Facades\View;

class Mail extends Mailable implements MailInterface
{
    public $view = 'mail-base';
    public $subject = "New mail from Budget Control";
    /** @var string  */
    public $fromAddress = "postmaster@budgetcontrol.cloud";
    private array $data;

    protected $dataValidation = [
        'name', 'email'
    ];

    /**
     * @param array <user_name,email,message> $data
     */
    public function __construct(array $data)
    {
        View::addLocation(__DIR__."/../Views");
        $this->data = $data;
    }

    public function build(): Mailable
    {
        $this->validate();
        return $this->from(config("app.mail_from", $this->fromAddress),config("app.name"))->subject($this->subject)
            ->view($this->view, $this->data);
    }

    /**
     * @throws MailExeption
     */
    private function validate()
    {
        if (empty($this->fromAddress)) {
            throw new MailExeption("Mail must contain a from");
        }

        if($this->checkArrayKeys() === false) {
            throw new MailExeption("Wrong data into template");
        }
    }

    private function checkArrayKeys(): bool
    {
        $status = true;

        foreach($this->dataValidation as $_ => $field) {
            if(empty($this->data[$field])) {
                $status = false;
            }
        }

        return $status;
    }
}
