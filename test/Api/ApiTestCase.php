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


use Http\Client\HttpClient;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;
use Xeviant\Paystack\Client;

abstract class ApiTestCase extends TestCase
{
	/**
	 * @return string
	 */
	abstract protected function getApiClass(): string;

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    protected function getApiMock()
	{
		$httpClient = $this->getMockBuilder(HttpClient::class)
			->setMethods(['sendRequest'])
			->getMock();
		$httpClient->expects(self::any())
			->method('sendRequest');

		$client = Client::createWithHttpClient($httpClient);

		return $this->getMockBuilder($this->getApiClass())
			->setMethods(['get', 'post', 'postRaw', 'patch', 'put', 'delete', 'head'])
			->setConstructorArgs([$client])
			->getMock();
	}
	/**
	 * @param $object
	 * @param $methodName
	 *
	 * @return ReflectionMethod
	 * @throws \ReflectionException
	 */
	protected function getMethod($object, $methodName)
	{
		$method = new ReflectionMethod($object, $methodName);
		$method->setAccessible(true);

		return $method;
	}
}
