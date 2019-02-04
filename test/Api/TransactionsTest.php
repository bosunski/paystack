<?php
/**
 *
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package         Paystack
 * @version         1.0
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link            https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Tests\Api;


use Xeviant\Paystack\Api\Transactions;

class TransactionsTest extends ApiTestCase
{
	/**
	 * @test
	 */
	public function shouldVerifyTransactions()
	{
		$reference = 'DG4uishudoq90LD';
		$expectedResult = ['data' => ['amount' => 50000]];

		$api = $this->getApiMock();
		$api->expects(self::once())
			->method('get')
			->with('/transaction/verify/' . $reference)
			->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->verify($reference));
	}

	/**
	 * @test
	 */
	public function shouldChargeReturningCustomer()
	{
		$input = [
				'amount' => 500000,
				'email' => 'customer@email.com',
				"reference" => '0bxco8lyc2aa0fq',
				'authorization_code' => 'AUTH_72btv547',
		];

		$expectedResult = ['data' => ['amount' => 5000]];

		$api = $this->getApiMock();
		$api->expects(self::once())
			->method('post')
			->with('/transaction/charge_authorization', $input)
			->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->charge($input));
	}

	/**
	 * @test
	 */
	public function shouldGetTransactionsApiObject()
	{
		$api = $this->getApiMock();

		self::assertInstanceOf(Transactions::class, $api);
	}
	/**
	 * @return string
	 */
	protected function getApiClass(): string
	{
		return Transactions::class;
	}
}