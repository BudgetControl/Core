<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use App\Console\Kernel;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
