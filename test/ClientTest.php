<?php

namespace Xeviant\Paystack\Tests;

use Http\Client\HttpClient;
use Xeviant\Paystack\Api\Balance;
use Xeviant\Paystack\Api\Bank;
use Xeviant\Paystack\Api\BulkCharges;
use Xeviant\Paystack\Api\Bvn;
use Xeviant\Paystack\Api\Charge;
use Xeviant\Paystack\Api\Customers;
use Xeviant\Paystack\Api\Integration;
use Xeviant\Paystack\Api\Invoices;
use Xeviant\Paystack\Api\Pages;
use Xeviant\Paystack\Api\Plans;
use Xeviant\Paystack\Api\Refund;
use Xeviant\Paystack\Api\Settlements;
use Xeviant\Paystack\Api\SubAccount;
use Xeviant\Paystack\Api\Subscriptions;
use Xeviant\Paystack\Api\Transactions;
use Xeviant\Paystack\Api\TransferRecipients;
use Xeviant\Paystack\Api\Transfers;
use Xeviant\Paystack\Client;
use Xeviant\Paystack\Exception\BadMethodCallException;
use Xeviant\Paystack\Exception\InvalidArgumentException;

final class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function shouldNotHaveToPassHttpClientToConstructor(): void
    {
        $client = new Client();

        $this->assertInstanceOf(HttpClient::class, $client->getHttpClient());
    }

    /**
     * @test
     */
    public function shouldPassHttpClientInterfaceToConstructor(): void
    {
        $httpClientMock = $this->getMockBuilder(HttpClient::class)->getMock();

        $client = Client::createWithHttpClient($httpClientMock);

        $this->assertInstanceOf(HttpClient::class, $client->getHttpClient());
    }

    /**
     * @param $apiName
     * @param $class
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @test
     * @dataProvider getApiServiceProvider
     */
    public function shouldGetApiInstance($apiName, $class): void
    {
        $client = $this->createApplication()->make(Client::class);

        $this->assertInstanceOf($class, $client->api($apiName));
    }

    /**
     * @param $apiName
     * @param $class
     * @test
     * @dataProvider getApiServiceProvider
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function shouldMagicallyGetApiInstance($apiName, $class): void
    {
        $client = new Client();

        $this->assertInstanceOf($class, $client->$apiName());
    }

    /**
     * @test
     */
    public function shouldNotBeAbleToGetApiInstanceThatDoesntExits(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $client = new Client();
        $client->api('this_doesnt_exist');
    }

    /**
     * @test
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function shouldNotBeAbleToGetMagicApiInstanceThatDoesntExits(): void
    {
        $this->expectException(BadMethodCallException::class);
        $client = new Client();
        $client->doesNotExist();
    }

    public function getApiServiceProvider(): array
    {
        return [
            ['bvn', Bvn::class],
            ['bank', Bank::class],
            ['pages', Pages::class],
            ['plans', Plans::class],
            ['charge', Charge::class],
            ['charge', Charge::class],
            ['refund', Refund::class],
            ['balance', Balance::class],
            ['invoices', Invoices::class],
            ['transfers', Transfers::class],
            ['customers', Customers::class],
            ['subAccount', SubAccount::class],
            ['settlements', Settlements::class],
            ['bulkCharges', BulkCharges::class],
            ['integration', Integration::class],
            ['transactions', Transactions::class],
            ['subscriptions', Subscriptions::class],
            ['transferRecipients', TransferRecipients::class],
        ];
    }
}
