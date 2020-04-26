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
use Xeviant\Paystack\Validator;

class RequiredParameterTest extends TestCase
{
    /**
     * @var Validator
     */
    private $required;

    protected function setUp()
    {
        $this->required = new Validator();
    }

    public function tearDown()
    {
        $this->required = null;
    }

    public function testShouldSetAndGetRequiredParameters(): void
    {
        $requiredParameters = collect(['name', 'email']);
        $this->required->setRequiredParameters($requiredParameters);

        $this->assertEquals($requiredParameters, $this->required->getRequiredParameters());
    }

    /**
     * @test
     * @expectedException \Xeviant\Paystack\Exception\MissingArgumentException
     */
    public function testShouldThrowExceptionWhenRequiredParameterIsMissing()
    {
        $values = ['name' => 'Bosun'];
        $this->required->setRequiredParameters(collect(['email']));
        $this->required->checkParameters($values);
    }

    /**
     * @return void
     */
    public function testShouldNotThrowExceptionWhenRequiredParameterIsPresent(): void
    {
        $values = ['name' => 'Bosun'];
        $this->required->setRequiredParameters(collect(['name']));
        $this->assertTrue($this->required->checkParameters($values));
    }
}
