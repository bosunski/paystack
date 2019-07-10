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
 * @copyright   (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link            https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\HttpClient\Plugin;

use GuzzleHttp\Promise\Promise as GuzzlePromise;
use Http\Adapter\Guzzle6\Promise as AdaptedPromise;
use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Xeviant\Paystack\Exception\ApiLimitExceededException;
use Xeviant\Paystack\Exception\ErrorException;
use Xeviant\Paystack\Exception\RuntimeException;
use Xeviant\Paystack\Exception\ValidationFailedException;
use Xeviant\Paystack\HttpClient\Message\ResponseMediator;

class PaystackExceptionThrower implements Plugin
{
    /**
     * Handle the request and return the response coming from the next callable.
     *
     * @see http://docs.php-http.org/en/latest/plugins/build-your-own.html
     *
     * @param RequestInterface $request
     * @param callable         $next    Next middleware in the chain, the request is passed as the first argument
     * @param callable         $first   First middleware in the chain, used to to restart a request
     *
     * @return Promise Resolves a PSR-7 Response or fails with an Http\Client\Exception (The same as HttpAsyncClient)
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        return $next($request)->then(function (ResponseInterface $response) use ($request) {
            if ($response->getStatusCode() < 400 || $response->getStatusCode() > 600) {
                return $this->convertResponseToPromise($response, $request);
            }

            $remaining = ResponseMediator::getHeader($response, 'X-RateLimit-Remaining');
            if (null != $remaining && 1 > $remaining && 'rate_limit' !== substr($request->getRequestTarget(), 1, 10)) {
                $limit = ResponseMediator::getHeader($response, 'X-RateLimit-Limit');
                $reset = ResponseMediator::getHeader($response, 'X-RateLimit-Reset');

                throw new ApiLimitExceededException($limit, $reset);
            }

            $content = ResponseMediator::getContent($response);

            if (is_array($content) && isset($content['message'])) {
                if (400 == $response->getStatusCode()) {
                    throw new ErrorException($content['message'], 400);
                } elseif (422 == $response->getStatusCode() && isset($content['errors'])) {
                    $errors = [];

                    foreach ($content['errors'] as $error) {
                        switch ($error['code']) {
                            case 'missing':
                                $errors[] = sprintf('The %s %s does not exist, for resource "%s"', $error['field'], $error['value'], $error['resource']);
                                break;

                            case 'missing_field':
                                $errors[] = sprintf('Field "%s" is missing, for resource "%s"', $error['field'], $error['resource']);
                                break;

                            case 'invalid':
                                if (isset($error['message'])) {
                                    $errors[] = sprintf('Field "%s" is invalid, for resource "%s": "%s"', $error['field'], $error['resource'], $error['message']);
                                } else {
                                    $errors[] = sprintf('Field "%s" is invalid, for resource "%s"', $error['field'], $error['resource']);
                                }
                                break;

                            case 'already_exists':
                                $errors[] = sprintf('Field "%s" already exists, for resource "%s"', $error['field'], $error['resource']);
                                break;

                            default:
                                $errors[] = $error['message'];
                                break;
                        }
                    }

                    throw new ValidationFailedException('Validation Failed: '.implode(', ', $errors), 422);
                }
            }

            if (502 == $response->getStatusCode() && isset($content['errors']) && is_array($content['errors'])) {
                $errors = [];
                foreach ($content['errors'] as $error) {
                    if (isset($error['message'])) {
                        $errors[] = $error['message'];
                    }
                }

                throw new RuntimeException(implode(', ', $errors), 502);
            }

            throw new RuntimeException(isset($content['message']) ? $content['message'] : $content, $response->getStatusCode());
        });
    }

    /**
     * Adapts a Guzzle based Promise to PSR Promise.
     *
     * @param ResponseInterface $response
     * @param $request
     *
     * @return AdaptedPromise
     */
    protected function convertResponseToPromise(ResponseInterface $response, $request)
    {
        $promise = new GuzzlePromise(function () use (&$promise, $response) {
            $promise->resolve($response);
        });

        return new AdaptedPromise($promise, $request);
    }
}
