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
 * @copyright   (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link            https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Tests\Api;


use Xeviant\Paystack\Api\Customer;

class CustomerTest extends ApiTestCase
{

	/**
	 * @test
	 */
	public function shouldGetCustomer(): void
	{
		$expectedResult = ['data' => ['email' => 'email@example.com']];

		$api = $this->getApiMock();
		$api->expects(self::once())
			->method('get')
			->with('/customer/email@example.com')
			->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->show('email@example.com'));
	}

	protected function getApiClass(): string
	{
		return Customer::class;
	}
}