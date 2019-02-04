<?php
/**
 *
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package         Paystack
 * @version         2.0
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright   (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link            https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Tests\Api;


use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;
use Http\Client\Common\HttpMethodsClientInterface;
use Xeviant\Paystack\Api\AbstractApi;
use Xeviant\Paystack\Client;

class AbstractApiTest extends ApiTestCase
{
	/**
	 * @test
	 */
	public function shouldPassGETRequestToClient()
	{
		$expectedArray = ['value'];

		$httpClient = $this->getHttpMethodsMock(['get']);
		$httpClient->expects($this->any())
			->method('get')
			->with('/path?param1=param1value', ['header1' => 'header1value'])
			->willReturn($this->getPSR7Response($expectedArray));

		$client = $this->getMockBuilder(Client::class)
			->setMethods(['getHttpClient'])
			->getMock();

		$client->expects($this->any())
			->method('getHttpClient')
			->willReturn($httpClient);

		$api = $this->getAbstractApiObject($client);
		$actual = $this->getMethod($api, 'get')
			->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['header1' => 'header1value']]);

		$this->assertEquals($expectedArray, $actual);
	}

	/**
	 * @test
	 */
	public function shouldPassPOSTRequestToClient()
	{
		$expectedResult = ['value'];

		$httpClient = $this->getHttpMethodsMock(['post']);
		$httpClient->expects($this->once())
			->method('post')
			->with('/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value']))
			->willReturn($this->getPSR7Response($expectedResult));

		$client = $this->getMockBuilder(Client::class)
			->setMethods(['getHttpClient'])
			->getMock();

		$client->expects($this->any())
			->method('getHttpClient')
			->willReturn($httpClient);

		$api = $this->getAbstractApiObject($client);
		$actual = $this->getMethod($api, 'post')
			->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

		$this->assertEquals($expectedResult, $actual);
	}

	/**
	 * @test
	 * @throws \ReflectionException
	 */
	public function shouldPassPATCHRequestToClient()
	{
		$expectedValue = ['value'];

		$httpClient = $this->getHttpMethodsMock(['patch']);
		$httpClient->expects(self::once())
			->method('patch')
			->with('/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value']))
			->willReturn($this->getPSR7Response($expectedValue));

		$client = $this->getMockBuilder(Client::class)
			->setMethods(['getHttpClient'])
			->getMock();
		$client->expects(self::any())
			->method('getHttpClient')
			->willReturn($httpClient);

		$api = $this->getAbstractApiObject($client);
		$actual = $this->getMethod($api, 'patch')
			->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

		$this->assertEquals($expectedValue, $actual);
	}

	/**
	 * @test
	 * @throws \ReflectionException
	 */
	public function shouldPassPUTRequestToClient()
	{
		$expectedValue = ['value'];

		$httpClient = $this->getHttpMethodsMock(['put']);
		$httpClient->expects(self::once())
			->method('put')
			->with('/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value']))
			->willReturn($this->getPSR7Response($expectedValue));

		$client = $this->getMockBuilder(Client::class)
			->setMethods(['getHttpClient'])
			->getMock();

		$client->expects(self::any())
			->method('getHttpClient')
			->willReturn($httpClient);

		$api = $this->getAbstractApiObject($client);
		$actual = $this->getMethod($api, 'put')
			->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

		$this->assertEquals($expectedValue, $actual);
	}

	/**
	 * @test
	 * @throws \ReflectionException
	 */
	public function shouldPassDELETERequest()
	{
		$expectedValue = ['value'];

		$httpClient = $this->getHttpMethodsMock(['delete']);
		$httpClient->expects(self::once())
			->method('delete')
			->with('/path', ['option1' => 'option1value'], json_encode(['param1' => 'param1value']))
			->willReturn($this->getPSR7Response($expectedValue));

		$client = $this->getMockBuilder(Client::class)
			->setMethods(['getHttpClient'])
			->getMock();
		$client->expects(self::any())
			->method('getHttpClient')
			->willReturn($httpClient);

		$api = $this->getAbstractApiObject($client);
		$actual = $this->getMethod($api, 'delete')
			->invokeArgs($api, ['/path', ['param1' => 'param1value'], ['option1' => 'option1value']]);

		$this->assertEquals($expectedValue, $actual);
	}


	public function getHttpMethodsMock(array $methods = [])
	{
		$methods = array_merge(['sendRequest'], $methods);

		$mock = $this->getMockBuilder(HttpMethodsClientInterface::class)
						->disableOriginalConstructor()
						->setMethods($methods)
						->getMockForAbstractClass();

		$mock->expects($this->any())
			->method('sendRequest');

		return $mock;
	}

	/**
	 * @param $expectedArray
	 *
	 * @return Response
	 */
	public function getPSR7Response($expectedArray): Response
	{
		return new Response(
			200,
			['Content-Type' => 'application/json'],
			stream_for(json_encode($expectedArray))
		);
	}

	protected function getAbstractApiObject($client)
	{
		return $this->getMockBuilder($this->getApiClass())
			->setMethods(null)
			->setConstructorArgs([$client])
			->getMock();
	}

	protected function getApiClass(): string
	{
		return AbstractApi::class;
	}

}