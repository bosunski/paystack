<?php
/**
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version          1.0
 *
 * @author           Olatunbosun Egberinde
 * @license          MIT Licence
 * @copyright        (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link             https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\Tests\Api;

use Xeviant\Paystack\Api\Integration;

class IntegrationTest extends ApiTestCase
{
    const PATH = '/integration';

    /**
     * @test
     */
    public function shouldGetPaymentSessionTimeout(): void
    {
        $expectedResult = ['data' => ['payment_session_timeout' => 30]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/payment_session_timeout')
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->fetchPaymentSessionTimeout());
    }

    /**
     * @test
     */
    public function shouldUpdatePaymentSessionTimeout(): void
    {
        $input = ['timeout' => 60];
        $expectedResult = ['data' => ['payment_session_timeout' => 60]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with(self::PATH.'/payment_session_timeout')
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->updatePaymentSessionTimeout($input));
    }

    /**
     * @test
     */
    public function shouldGetTransactionsApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Integration::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Integration::class;
    }
}
