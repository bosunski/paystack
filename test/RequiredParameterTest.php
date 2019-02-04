<?php
/**
 *
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package         Paystack
 * @version         2.0
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link            https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Tests;


use PHPUnit\Framework\TestCase;
use Xeviant\Paystack\RequiredParameter;

class RequiredParameterTest extends TestCase
{
	/**
	 * @var RequiredParameter
	 */
	private $required;

	public function setUp()
	{
		$this->required = new RequiredParameter;
	}

	public function tearDown()
	{
		$this->required = null;
	}

	public function testShouldSetAndGetRequiredParameters(): void
	{
		$requiredParameters = collect(['name', 'email']);
		$this->required->setParameters($requiredParameters);

		$this->assertEquals($requiredParameters, $this->required->getRequiredParameters());
	}

	/**
	 * @test
	 * @expectedException \Xeviant\Paystack\Exception\MissingArgumentException
	 */
	public function testShouldThrowExceptionWhenRequiredParameterIsMissing()
	{
		$values = ['name' => 'Bosun'];
		$this->required->setParameters(collect(['email']));
		$this->required->checkParameters($values);
	}

	/**
	 * @return void
	 */
	public function testShouldNotThrowExceptionWhenRequiredParameterIsPresent(): void
	{
		$values = ['name' => 'Bosun'];
		$this->required->setParameters(collect(['name']));
		$this->assertTrue($this->required->checkParameters($values));
	}
}