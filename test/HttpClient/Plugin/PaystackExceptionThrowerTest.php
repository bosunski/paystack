<?php

namespace Xeviant\Paystack\Test\HttpClient\Plugin;

use GuzzleHttp\Promise\FulfilledPromise;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Xeviant\Paystack\Exception\ExceptionInterface;
use Xeviant\Paystack\HttpClient\Plugin\PaystackExceptionThrower;

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

final class PaystackExceptionThrowerTest extends TestCase
{
	/**
	 * @param ResponseInterface       $response
	 * @param ExceptionInterface|null $exception
	 *
	 * @dataProvider responseProvider
	 * @throws \ReflectionException
	 */
	public function testHandlerRequest(ResponseInterface $response, ExceptionInterface $exception = null)
	{
		$request = $this->getMockForAbstractClass(RequestInterface::class);

		$promise = $this->getMockBuilder(FulfilledPromise::class)->disableOriginalConstructor()->getMock();
		$promise->expects(self::once())
			->method('then')
			->willReturnCallback(function ($callback) use ($response) {
				return $callback($response);
			});

		$plugin = new PaystackExceptionThrower();

		if ($exception) {
			$this->expectException(get_class($exception));
			$this->expectExceptionCode($exception->getCode());
			$this->expectExceptionCode($exception->getMessage());
		}

		$plugin->handleRequest(
			$request,
			function (RequestInterface $request) use ($promise) {
				return $promise;
			},
			function (RequestInterface $request) use ($promise) {
				return $promise;
			}
		);
	}

	/**
	 * @return array
	 */
	public function responseProvider(): array
	{
		return [
			'200 Response' => [
				'response' => new Response(),
				'exception' => null,
			],
			'Too Many Request' => [
				'response' => new Response(
					429,
					[
						'Content-Type' => 'application/json',
						'X-RateLimit-Remaining' => 0,
						'X-RateLimit-Limit' => 5000,
					],
					''
				),
				'exception' => null
			],
		];
	}
}