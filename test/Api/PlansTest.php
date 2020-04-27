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

use Xeviant\Paystack\Api\Plans;

class PlansTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldGetPlan(): void
    {
        $expectedResult = ['data' => ['integration' => 900713]];
        $plan = 'PLN_x123';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/plan/'.$plan)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->fetch($plan));
    }

    /**
     * @test
     */
    public function shouldGetPlans(): void
    {
        $expectedResult = collect([['integration' => 900713]]);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/plan')
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->list());
    }

    /**
     * @test
     */
    public function shouldCreatePlan(): void
    {
        $expectedResult = ['data' => ['integration' => 90713]];
        $input = [
            'name'     => 'Name',
            'amount'   => 5000,
            'interval' => 'hourly',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/plan', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->create($input));
    }

    /**
     * @test
     */
    public function shouldUpdatePlan(): void
    {
        $input = ['name' => 'Example Name 2'];
        $expectedResult = ['data' => ['name' => 'Example Name 2']];
        $planId = 'PLN_x123';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with("/plan/$planId", $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->update($planId, $input));
    }

    /**
     * @test
     */
    public function shouldGetTransactionsApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Plans::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Plans::class;
    }
}
