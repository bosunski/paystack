<?php

/**
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version         2.0
 *
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link            https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\Test;

use PHPUnit\Framework\TestCase;
use Xeviant\Paystack\Exception\InvalidArgumentException;
use Xeviant\Paystack\Exception\RuntimeException;
use Xeviant\Paystack\Paystack;

class PaystackTest extends TestCase
{
    /**
     * Paystack Object.
     *
     * @var Paystack
     */
    protected $paystack;

    protected function setUp(): void
    {
        $this->paystack = new Paystack('public-key', 'secret-key');
    }

    public function tearDown(): void
    {
        $this->paystack = null;
    }

    /**
     * @test
     */
    public function it_can_create_a_new_instance_using_make_method(): void
    {
        $paystack = Paystack::make('public-key', 'secret-key');
        $this->assertEquals('public-key', $paystack->getPublicKey());
        $this->assertEquals('secret-key', $paystack->getSecretKey());
        $this->assertEquals('1.0', $paystack->getApiVersion());
    }

    /**
     * @test
     */
    public function it_can_create_a_new_instance_using_env_variables(): void
    {
        $paystack = new Paystack();
        $this->assertEquals(getenv('PAYSTACK_PUBLIC_KEY'), $paystack->getPublicKey());
        $this->assertEquals(getenv('PAYSTACK_SECRET_KEY'), $paystack->getSecretKey());
    }

    /**
     * @test
     */
    public function it_can_set_and_get_public_and_secret_keys(): void
    {
        $this->paystack->setPublicKey('pk_test_1234');
        $this->paystack->setSecretKey('sk_test_1234');

        $this->assertEquals('sk_test_1234', $this->paystack->getSecretKey());
        $this->assertEquals('pk_test_1234', $this->paystack->getPublicKey());
    }

    /**
     * @test
     */
    public function it_throws_an_exception_when_the_public_or_secret_key_is_not_set(): void
    {
        $this->expectException(RuntimeException::class);
        putenv('PAYSTACK_PUBLIC_KEY');
        putenv('PAYSTACK_SECRET_KEY');

        new Paystack();
    }

    /**
     * @test
     */
    public function it_can_set_and_get_api_version(): void
    {
        $this->paystack->setApiVersion('1.0');

        $this->assertEquals('1.0', $this->paystack->getApiVersion());
    }

    /**
     * @test
     */
    public function it_can_get_the_current_package_version(): void
    {
        $this->assertNotEmpty($this->paystack->getPackageVersion());
    }

    /**
     * @test
     */
    public function it_can_create_request(): void
    {
        $this->assertNotNull($this->paystack->customers());
    }

    /**
     * @test
     */
    public function if_exception_is_thrown_when_the_request_is_invalid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->paystack->thisApiDoesNotExist();
    }
}
