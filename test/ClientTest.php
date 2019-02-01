<?php

use Http\Client\HttpClient;
use PHPUnit\Framework\TestCase;
use Xeviant\Paystack\Api\Customer;
use Xeviant\Paystack\Client;

final class ClientTest extends TestCase
{
	/**
	 * @test
	 */
	public function shouldNotHaveToPassHttpClientToConstructor()
	{
		$client = new Client();

		$this->assertInstanceOf(HttpClient::class, $client->getHttpClient());
	}

	/**
	 * @test
	 */
	public function shouldPassHttpClientInterfaceToConstructor()
	{
		$httpClientMock = $this->getMockBuilder(HttpClient::class)->getMock();

		$client = Client::createWithHttpClient($httpClientMock);

		$this->assertInstanceOf(HttpClient::class, $client->getHttpClient());
	}

	/**
	 * @param $apiName
	 * @param $class
	 * @test
	 * @dataProvider getApiServiceProvider
	 */
	public function shouldGetApiInstance($apiName, $class)
	{
		$client = new Client();

		$this->assertInstanceOf($class, $client->api($apiName));
	}

	/**
	 * @param $apiName
	 * @param $class
	 * @test
	 * @dataProvider getApiServiceProvider
	 */
	public function shouldMagicallyGetApiInstance($apiName, $class)
	{
		$client = new Client;

		$this->assertInstanceOf($class, $client->$apiName());
	}

	/**
	 * @test
	 * @expectedException \Xeviant\Paystack\Exception\InvalidArgumentException
	 */
	public function shouldNotBeAbleToGetApiInstanceThatDoesntExits()
	{
		$client = new Client;
		$client->api('this_doesnt_exist');
	}

	/**
	 * @test
	 * @expectedException \Xeviant\Paystack\Exception\BadMethodCallException
	 */
	public function shouldNotBeAbleToGetMagicApiInstanceThatDoesntExits()
	{
		$client = new Client;
		$client->doesNotExist();
	}

	public function getApiServiceProvider(): array
	{
		return [
			['customer', Customer::class]
		];
	}
}