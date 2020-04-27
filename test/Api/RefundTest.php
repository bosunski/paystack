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

use Xeviant\Paystack\Api\Refund;

class RefundTest extends ApiTestCase
{
    const PATH = '/refund';

    /**
     * @test
     */
    public function shouldGetPaymentPage(): void
    {
        $expectedResult = ['data' => ['integration' => 900713]];
        $reference = 'RF_X1234';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/'.$reference)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->fetch($reference));
    }

    /**
     * @test
     */
    public function shouldGetRefunds(): void
    {
        $expectedResult = ['data' => [['integration' => 900713]]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->list());
    }

    /**
     * @test
     */
    public function shouldCreateRefund(): void
    {
        $expectedResult = ['data' => ['integration' => 90713]];
        $input = [
            'transaction' => '345623423h23535',
            'amount'      => 5000,
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH, $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->create($input));
    }

    /**
     * @test
     */
    public function shouldGetTransactionsApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Refund::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Refund::class;
    }
}
