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
use Xeviant\Paystack\Api\Settlements;

class SettlementsTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldGetSettlements(): void
    {
        $attributes = ['integration' => 900713];

        $finalResult = Collection::make([
            $this->createApplication()->makeModel('settlement', ['attributes' => $attributes]),
        ]);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/settlement')
            ->willReturn($finalResult);

        $this->assertEquals($finalResult, $api->list());
    }

    /**
     * @test
     */
    public function shouldGetTransactionsApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Settlements::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Settlements::class;
    }
}
