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
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link             https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\Tests\Api;

use Illuminate\Support\Collection;
use Xeviant\Paystack\Api\Subscriptions;

class SubscriptionsTest extends ApiTestCase
{
    const PATH = '/subscription';

    /**
     * @test
     */
    public function shouldGetSubscription(): void
    {
        $expectedResult = ['data' => ['invoices' => [], 'customer' => []]];
        $subId = 'SUB_x123';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/'.$subId)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->fetch($subId));
    }

    /**
     * @test
     */
    public function shouldGetSubscriptions(): void
    {
        $attributes = ['invoices' => [], 'customer' => []];

        $finalResult = Collection::make([
            $this->createApplication()->makeModel('subscription', ['attributes' => $attributes]),
        ]);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH)
            ->willReturn($finalResult);

        $this->assertEquals($finalResult, $api->list());
    }

    /**
     * @test
     */
    public function shouldCreateSubscription(): void
    {
        $expectedResult = ['data' => ['customer' => 'CUS_x123']];

        $input = [
            'customer'      => 'CUS_x123',
            'plan'          => 'PLN_x123',
            'authorization' => 'AUT_x123',
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
    public function shouldDisableSubscription(): void
    {
        $input = ['code' => 'x123', 'token' => 'qwercgteweqw'];
        $expectedResult = ['message' => 'Subscription disabled successfully'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/disable', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->disable($input));
    }

    /**
     * @test
     */
    public function shouldEnableSubscription(): void
    {
        $input = ['code' => 'x123', 'token' => 'qwercgteweqw'];
        $expectedResult = ['message' => 'Subscription enabled successfully'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/enable', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->enable($input));
    }

    /**
     * @test
     */
    public function shouldGetTransactionsApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Subscriptions::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Subscriptions::class;
    }
}
