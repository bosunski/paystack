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
	public function shouldGetCustomerApiObject()
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