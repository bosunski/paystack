<?php

namespace Xeviant\Paystack\Tests;

use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Xeviant\Paystack\App\PaystackApplication;

class TestCase extends PHPUnitTestCase
{
    public function createApplication(): PaystackApplication
    {
        return new PaystackApplication();
    }
}
