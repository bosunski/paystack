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


class BulkChargesTest extends ApiTestCase
{
	const PATH = '/bulkcharge';


	/**
	 * @test
	 */
	public function shouldGetBulkCharge(): void
	{
		$expectedResult = ['data' => ['batch_code' => 'BCH_180tl7oq7cayggh']];
		$bulkChargeId = 'BCH_180tl7oq7cayggh';

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('get')
		    ->with(self::PATH .'/' . $bulkChargeId)
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->fetch($bulkChargeId));
	}

	/**
	 * @test
	 */
	public function shouldPauseBulkCharge(): void
	{
		$expectedResult = ['data' => ['message' => 'Bulk charge batch has been paused']];
		$bulkChargeId = 'BCH_180tl7oq7cayggh';

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('get')
		    ->with(self::PATH .'/pause/' . $bulkChargeId)
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->fetch($bulkChargeId));
	}

	/**
	 * @test
	 */
	public function shouldResumeBulkCharge(): void
	{
		$expectedResult = ['data' => ['message' => 'Bulk charge batch has been resumed']];
		$bulkChargeId = 'BCH_180tl7oq7cayggh';

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('get')
		    ->with(self::PATH .'/resume/' . $bulkChargeId)
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->fetch($bulkChargeId));
	}

	/**
	 * @test
	 */
	public function shouldGetChargesInBatch(): void
	{
		$expectedResult = ['data' => [['integration' => 1231244]]];
		$bulkChargeId = 'BCH_180tl7oq7cayggh';

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('get')
		    ->with(self::PATH .'/' . $bulkChargeId . '/charges')
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->fetch($bulkChargeId));
	}

	/**
	 * @test
	 */
	public function shouldGetBulkCharges(): void
	{
		$expectedResult = ['data' => [['batch_code' => 'BCH_180tl7oq7cayggh']]];

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('get')
		    ->with(self::PATH)
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->list());
	}

	/**
	 * @test
	 */
	public function shouldInitiateBulkCharge(): void
	{
		$expectedResult = ['data' => ['batch_code' => 'BCH_180tl7oq7cayggh']];
		$input = [['authorization' => 'AUTH_n95vpedf']];

		$api = $this->getApiMock();
		$api->expects(self::once())
		    ->method('post')
		    ->with(self::PATH, $input)
		    ->willReturn($expectedResult);

		$this->assertEquals($expectedResult, $api->initiate($input));
	}

	/**
	 * @test
	 */
	public function shouldGetTransactionsApiObject()
	{
		$api = $this->getApiMock();

		self::assertInstanceOf(BulkCharges::class, $api);
	}


	/**
	 * @return string
	 */
	protected function getApiClass(): string
	{
		return BulkCharges::class;
	}
}