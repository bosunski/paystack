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
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link             https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Tests\Api;


use Xeviant\Paystack\Api\Settlements;

class SettlementsTest extends ApiTestCase
{

	/**
	 * @test
	 */
	public function shouldGetSettlements(): void
	{
		$expectedResult = collect(['data' => [['integration' => 900713]]]);

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('get')
		    ->with('/settlement')
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->list());
	}



	/**
	 * @test
	 */
	public function shouldGetTransactionsApiObject()
	{
		$api = $this->getApiMock();

		self::assertInstanceOf(Settlements::class, $api);
	}


	/**
	 * @return string
	 */
	protected function getApiClass(): string
	{
		return Settlements::class;
	}
}
