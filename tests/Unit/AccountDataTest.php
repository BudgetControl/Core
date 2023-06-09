<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\BudgetTracker\ValueObject\Accounts\BankAccount;
use App\BudgetTracker\ValueObject\Accounts\SavingAccount;
use App\BudgetTracker\ValueObject\Accounts\CreditCardAccount;


class AccountDataTest extends TestCase
{
    public function testAccountBankDataObject()
    {
        $name = 'john_doe';
        $color = '#928343';
        $balance = 1024.00;
        $currency = 'EUR';

        $user = new BankAccount($name,$currency,$color,$balance);

        $this->assertEquals($name, $user->getName());
        $this->assertEquals($currency, $user->getCurrency());
        $this->assertEquals($color, $user->getColor());
        $this->assertEquals($balance, $user->getBalance());
    }

    public function testAccountCreditCardInstallementDataObject()
    {
        $name = 'john_doe';
        $color = '#928343';
        $balance = 1024.00;
        $currency = 'EUR';
        $date = new \DateTime();
        $installement = false;

        $user = new CreditCardAccount($name,$currency,$color,$balance,$date,$installement);

        $this->assertEquals($name, $user->getName());
        $this->assertEquals($currency, $user->getCurrency());
        $this->assertEquals($color, $user->getColor());
        $this->assertEquals($balance, $user->getBalance());
        $this->assertEquals($date->format('Y-m-d h:i:s'), $user->getDate());
        $this->assertEquals($installement, $user->getInstallement());
    }

    public function testAccountCreditCardDataObject()
    {
        $name = 'john_doe';
        $color = '#928343';
        $balance = 1024.00;
        $currency = 'EUR';
        $date = new \DateTime();
        $installement = true;
        $installementValue = 100;

        $user = new CreditCardAccount($name,$currency,$color,$balance,$date,$installement,$installementValue);

        $this->assertEquals($name, $user->getName());
        $this->assertEquals($currency, $user->getCurrency());
        $this->assertEquals($color, $user->getColor());
        $this->assertEquals($balance, $user->getBalance());
        $this->assertEquals($date->format('Y-m-d h:i:s'), $user->getDate());
        $this->assertEquals($installement, $user->getInstallement());
        $this->assertEquals($installementValue, $user->getInstallementValue());
    }

    public function testAccountSavingDataObject()
    {
        $name = 'john_doe';
        $color = '#928343';
        $balance = 1024.00;
        $currency = 'EUR';
        $amount = 200;
        $date = new \DateTime();

        $user = new SavingAccount($name,$currency,$color,$amount, $balance, $date);

        $this->assertEquals($name, $user->getName());
        $this->assertEquals($currency, $user->getCurrency());
        $this->assertEquals($color, $user->getColor());
        $this->assertEquals($balance, $user->getBalance());
        $this->assertEquals($amount, $user->getAmount());
        $this->assertEquals($date->format('Y-m-d h:i:s'), $user->getDate());
    }
}
