<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\BudgetTracker\Entity\Accounts\BankAccount;
use App\BudgetTracker\Entity\Accounts\SavingAccount;
use App\BudgetTracker\Entity\Accounts\CreditCardAccount;
use App\BudgetTracker\Entity\Accounts\CreditCardRevolvingAccount;

class AccountDataTest extends TestCase
{
    public function testAccountBankDataObject()
    {
        $name = 'john_doe';
        $color = '#92834321';
        $balance = 1024.00;
        $currency = 'USD';

        $user = new BankAccount($name,$currency,$color,$balance,0);

        $this->assertEquals($name, $user->getName());
        $this->assertEquals('USD', $user->getCurrency());
        $this->assertEquals($color, $user->getColor());
        $this->assertEquals($balance, $user->getBalance());
    }

    public function testAccountCreditCardInstallementDataObject()
    {
        $name = 'john_doe';
        $color = '#92834321';
        $balance = 1024.00;
        $currency = 'USD';
        $date = new \DateTime();
        $installement = false;

        $user = new CreditCardAccount($name,$currency,$color,$balance,$date,$installement,0);

        $this->assertEquals($name, $user->getName());
        $this->assertEquals('USD', $user->getCurrency());
        $this->assertEquals($color, $user->getColor());
        $this->assertEquals($balance, $user->getBalance());
        $this->assertEquals($date->format('Y-m-d H:i:s'), $user->getDate());
        $this->assertEquals($installement, $user->getInstallement());
    }

    public function testAccountCreditCardDataObject()
    {
        $name = 'john_doe';
        $color = '#92834321';
        $balance = 1024.00;
        $currency = 'USD';
        $date = new \DateTime();

        $user = new CreditCardAccount($name,$currency,$color,$balance,$date,0);

        $this->assertEquals($name, $user->getName());
        $this->assertEquals('USD', $user->getCurrency());
        $this->assertEquals($color, $user->getColor());
        $this->assertEquals($balance, $user->getBalance());
        $this->assertEquals($date->format('Y-m-d H:i:s'), $user->getDate());
        $this->assertEquals(false, $user->getInstallement());
    }

    public function testAccountCreditCardRevolvingDataObject()
    {
        $name = 'john_doe';
        $color = '#92834321';
        $balance = 1024.00;
        $currency = 'USD';
        $date = new \DateTime();
        $installementValue = 100;

        $user = new CreditCardRevolvingAccount($name,$currency,$color,$balance,$date,$installementValue,true);

        $this->assertEquals($name, $user->getName());
        $this->assertEquals('USD', $user->getCurrency());
        $this->assertEquals($color, $user->getColor());
        $this->assertEquals($balance, $user->getBalance());
        $this->assertEquals($date->format('Y-m-d H:i:s'), $user->getDate());
        $this->assertEquals($installementValue, $user->getInstallementValue());
    }

    public function testAccountSavingDataObject()
    {
        $name = 'john_doe';
        $color = '#92834312';
        $balance = 1024.00;
        $currency = 'USD';
        $date = new \DateTime();

        $user = new SavingAccount($name,$currency,$color, $balance, $date,0);

        $this->assertEquals($name, $user->getName());
        $this->assertEquals('USD', $user->getCurrency());
        $this->assertEquals($color, $user->getColor());
        $this->assertEquals($balance, $user->getBalance());
        $this->assertEquals($date->format('Y-m-d H:i:s'), $user->getDate());
    }
}
