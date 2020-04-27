<?php
/**
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version         2.0
 *
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link            https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\Tests\Api;

use Xeviant\Paystack\Api\Customers;

class CustomerTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldGetCustomer(): void
    {
        $expectedResult = ['data' => ['email' => 'email@example.com']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/customer/email@example.com')
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->fetch('email@example.com'));
    }

    /**
     * @test
     */
    public function shouldGetCustomers(): void
    {
        $expectedResult = collect(['data' => [['email' => 'email@example.com']]]);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/customer')
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->list());
    }

    /**
     * @test
     */
    public function shouldCreateCustomer(): void
    {
        $expectedResult = ['data' => ['email' => 'email@example.com']];
        $input = $expectedResult['data'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/customer', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->create($input));
    }

    /**
     * @test
     */
    public function shouldUpdateCustomer(): void
    {
        $input = ['first_name' => 'Example Name'];
        $expectedResult = ['data' => ['first_name' => 'Example Name']];
        $customerId = 'email@example.com';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with("/customer/$customerId", $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->update($customerId, $input));
    }

    /**
     * @test
     */
    public function shouldWhiteListCustomer(): void
    {
        $customer = 'CUS_xbxb';
        $input = ['customer' => $customer, 'risk_action' => 'allow'];
        $expectedResult = ['data' => ['first_name' => 'Example Name']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/customer/set_risk_action', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->whitelist($customer));
    }

    /**
     * @test
     */
    public function shouldBlackListCustomer(): void
    {
        $customer = 'CUS_xbxb';
        $input = ['customer' => $customer, 'risk_action' => 'deny'];
        $expectedResult = ['data' => ['first_name' => 'Example Name']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/customer/set_risk_action', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->blacklist($customer));
    }

    /**
     * @test
     */
    public function shouldDeactivateAuthorization(): void
    {
        $input = ['authorization_code' => 'AUTH_au6hc0de'];
        $expectedResult = ['status' => true, 'message' => 'Authorization has been disabled'];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/customer/deactivate_authorization', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->deactivateAuthorization($input));
    }

    /**
     * @test
     */
    public function shouldGetCustomerApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Customers::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Customers::class;
    }
}
