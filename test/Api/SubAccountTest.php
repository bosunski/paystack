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

use Illuminate\Support\Collection;
use Xeviant\Paystack\Api\SubAccount;

class SubAccountTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldGetSubAccount(): void
    {
        $expectedResult = ['data' => ['integration' => 900713]];
        $account = 'ACC_x123';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/subaccount/'.$account)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->fetch($account));
    }

    /**
     * @test
     */
    public function shouldGetSubAccounts(): void
    {
        $attributes = ['integration' => 900713];

        $finalResult = Collection::make([
            $this->createApplication()->makeModel('subaccount', ['attributes' => $attributes]),
        ]);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/subaccount')
            ->willReturn($finalResult);

        $this->assertEquals($finalResult, $api->list());
    }

    /**
     * @test
     */
    public function shouldCreateSubAccount(): void
    {
        $expectedResult = ['data' => ['integration' => 90713]];
        $input = [
            'business_name'     => 'Name',
            'settlement_bank'   => 'Bank',
            'account_number'    => '011123232',
            'percentage_charge' => 10,
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/subaccount', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->create($input));
    }

    /**
     * @test
     */
    public function shouldUpdateSubAccount(): void
    {
        $input = ['business_name' => 'Example Name'];
        $expectedResult = ['data' => ['first_name' => 'Example Name']];
        $accountId = 'ACC_x123';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with("/subaccount/$accountId", $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->update($accountId, $input));
    }

    /**
     * @test
     */
    public function shouldGetTransactionsApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(SubAccount::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return SubAccount::class;
    }
}
