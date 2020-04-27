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
 * @copyright    (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link             https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\Tests\Api;

use Xeviant\Paystack\Api\Bank;

class BankTest extends ApiTestCase
{
    const PATH = '/bank';

    /**
     * @test
     */
    public function shouldGetBanks(): void
    {
        $expectedResult = collect(['data' => [['name' => 'Access Bank']]]);

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
    public function shouldGetBankApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Bank::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Bank::class;
    }
}
