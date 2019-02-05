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


class PlansTest extends ApiTestCase
{
	/**
	 * @test
	 */
	public function shouldGetSubAccount(): void
	{
		$expectedResult = ['data' => ['integration' => 900713]];
		$account = 'ACC_x123';

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('get')
		    ->with('/plan/' . $account)
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->fetch($account));
	}

	/**
	 * @test
	 */
	public function shouldGetSubAccounts(): void
	{
		$expectedResult = ['data' => [['integration' => 900713]]];

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('get')
		    ->with('/plan')
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->list());
	}

	/**
	 * @test
	 */
	public function shouldCreateSubAccount(): void
	{
		$expectedResult = ['data' => ['integration' => 90713]];
		$input = [
			'business_name' => 'Name',
		];

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('post')
		    ->with('/plan', $input)
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->create($input));
	}

	/**
	 * @test
	 */
	public function shouldUpdateSubAccount(): void
	{
		$input = ['business_name' => 'Example Name'];
		$expectedResult = ['data' => ['first_name' => 'Example Name']];
		$accountId = 'ACC_x123';

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('put')
		    ->with("/plan/$accountId", $input)
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->update($accountId, $input));
	}

	/**
	 * @test
	 */
	public function shouldGetTransactionsApiObject()
	{
		$api = $this->getApiMock();

		self::assertInstanceOf(Plans::class, $api);
	}


	/**
	 * @return string
	 */
	protected function getApiClass(): string
	{
		return Plans::class;
	}
}