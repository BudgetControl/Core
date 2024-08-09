<?php

use Budgetcontrol\Seeds\Resources\Seed;
use Phinx\Seed\AbstractSeed;

class MainSeeds extends AbstractSeed
{

    public function run(): void
    {
        $dateTime = new DateTime();

        $seeds = new Seed();
        $seeds->runAllSeeds();

    }
}
