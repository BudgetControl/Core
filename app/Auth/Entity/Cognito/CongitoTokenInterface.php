<?php
namespace App\Auth\Entity\Cognito;

interface CongitoTokenInterface {
    
    public function value(): string;

}