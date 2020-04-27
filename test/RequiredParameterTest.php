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

namespace Xeviant\Paystack\Tests;

use PHPUnit\Framework\TestCase;
use Xeviant\Paystack\Exception\MissingArgumentException;
use Xeviant\Paystack\Validator;

class RequiredParameterTest extends TestCase
{
    /**
     * @var Validator
     */
    private $required;

    protected function setUp(): void
    {
        $this->required = new Validator();
    }

    public function tearDown(): void
    {
        $this->required = null;
    }

    /**
     * @test
     */
    public function shouldSetAndGetRequiredParameters(): void
    {
        $requiredParameters = collect(['name', 'email']);
        $this->required->setRequiredParameters($requiredParameters);

        $this->assertEquals($requiredParameters, $this->required->getRequiredParameters());
    }

    /**
     * @test
     */
    public function shouldThrowExceptionWhenRequiredParameterIsMissing(): void
    {
        $this->expectException(MissingArgumentException::class);

        $values = ['name' => 'Bosun'];
        $this->required->setRequiredParameters(collect(['email']));
        $this->required->checkParameters($values);
    }

    /**
     * @test
     */
    public function shouldNotThrowExceptionWhenRequiredParameterIsPresent(): void
    {
        $values = ['name' => 'Bosun'];
        $this->required->setRequiredParameters(collect(['name']));
        $this->assertTrue($this->required->checkParameters($values));
    }
}
