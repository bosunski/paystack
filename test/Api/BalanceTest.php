<?php
/**
 *
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package          Paystack
 * @version          1.0
 * @author           Olatunbosun Egberinde
 * @license          MIT Licence
 * @copyright        (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link             https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Tests\Api;


class BalanceTest extends ApiTestCase
{
	const PATH = '/balance';
	/*
	 * @test
	 */
	public function shouldGetBalance(): void
	{
		$expectedResult = ['data' => [['balance' => 123000]]];

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('get')
		    ->with(self::PATH)
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->fetch());
	}


	/**
	 * @test
	 */
	public function shouldGetTransactionsApiObject()
	{
		$api = $this->getApiMock();

		self::assertInstanceOf(Balance::class, $api);
	}


	/**
	 * @return string
	 */
	protected function getApiClass(): string
	{
		return Balance::class;
	}
}