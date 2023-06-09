<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\BudgetTracker\DataObjects\Wallet;


class WalletDataTest extends TestCase
{
    public function testWalletDataObject()
    {
        
        $wallet = new Wallet();
        $this->assertEquals(0, $wallet->getBalance());

        $wallet->setBalance(1000);
        $wallet->deposit(100);
        $this->assertEquals(1100, $wallet->getBalance());

        $wallet->withdraw(1000);
        $this->assertEquals(100, $wallet->getBalance());

        $toSum = [
            ['amount' => 100],
            ['amount' => 100],
            ['amount' => 100],
            ['amount' => 100],
            ['amount' => 500],
            ['amount' => -500],
        ];
        $wallet->sum($toSum);
        $this->assertEquals(500, $wallet->getBalance());


    }
}
