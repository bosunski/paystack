<?php

namespace Xeviant\Paystack\Test\HttpClient\Plugin;

use GuzzleHttp\Psr7\Response;
use Http\Promise\Promise;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Xeviant\Paystack\Exception\ApiLimitExceededException;
use Xeviant\Paystack\Exception\ErrorException;
use Xeviant\Paystack\Exception\ExceptionInterface;
use Xeviant\Paystack\HttpClient\Plugin\PaystackExceptionThrower;

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
 * @copyright   (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link            https://github.com/bosunski/paystack
 */
final class PaystackExceptionThrowerTest extends TestCase
{
    /**
     * @test
     *
     * @param ResponseInterface       $response
     * @param ExceptionInterface|null $exception
     *
     * @dataProvider responseProvider
     *
     * @throws \ReflectionException
     */
    public function shouldHandleRequest(ResponseInterface $response, ExceptionInterface $exception = null): void
    {
        $request = $this->getMockForAbstractClass(RequestInterface::class);

        $promise = $this
            ->getMockBuilder(Promise::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $promise->expects($this->once())
            ->method('then')
            ->willReturnCallback(function ($callback) use ($response) {
                return $callback($response);
            });

        $plugin = new PaystackExceptionThrower();

        if ($exception) {
            $this->expectException(get_class($exception));
            $this->expectExceptionCode($exception->getCode());
            $this->expectExceptionMessage($exception->getMessage());
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
                'response'  => new Response(),
                'exception' => null,
            ],
            'Too Many Request' => [
                'response' => new Response(
                    429,
                    [
                        'Content-Type'          => 'application/json',
                        'X-RateLimit-Remaining' => 0,
                        'X-RateLimit-Limit'     => 5000,
                    ],
                    ''
                ),
                'exception' => new ApiLimitExceededException(5000),
            ],
            '400 Bad Request' => [
                'response' => new Response(
                    400,
                    [
                        'Content-Type' => 'application/json',
                    ],
                    json_encode(['message' => 'Bad Request'])
                ),
                'exception' => new ErrorException('Bad Request', 400),
            ],
            '422 Unprocessable Entity' => [
                'response' => new Response(
                    422,
                    [
                        'Content-Type' => 'application/json',
                    ],
                    json_encode(
                        [
                            'message' => 'Bad Request',
                            'errors'  => [
                                [
                                    'code'     => 'missing',
                                    'field'    => 'field',
                                    'value'    => 'value',
                                    'resource' => 'resource',
                                ],
                            ],
                        ]
                    )
                ),
                'exception' => new ErrorException('Validation Failed: The field value does not exist, for resource "resource"', 422),
            ],
        ];
    }
}
