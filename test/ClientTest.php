<?php

use Http\Client\HttpClient;
use PHPUnit\Framework\TestCase;
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
}