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

namespace Xeviant\Paystack\Api;

use Exception;
use Illuminate\Support\Collection;
use Xeviant\Paystack\App\PaystackApplication;
use Xeviant\Paystack\Client;
use Xeviant\Paystack\Collection as PaystackCollection;
use Xeviant\Paystack\Contract\ApiInterface;
use Xeviant\Paystack\Contract\ApplicationInterface;
use Xeviant\Paystack\Contract\ModelAware;
use Xeviant\Paystack\HttpClient\Message\ResponseMediator;
use Xeviant\Paystack\Validator;

abstract class AbstractApi implements ApiInterface
{
    /**
     * The HTTP Client.
     *
     * @var Client
     */
    protected $client;

    /**
     * Specifies the current page.
     *
     * @var
     */
    private $page;

    /**
     * Specifies Items per page in a List.
     *
     * @var
     */
    private $perPage;

    /**
     * A simple Validator Object.
     *
     * @var Validator
     */
    protected $validator;
    /**
     * @var ApplicationInterface|null
     */
    private $app;

    /**
     * AbstractApi constructor.
     *
     * @param Client                    $client
     * @param ApplicationInterface|null $app
     */
    public function __construct(Client $client, ApplicationInterface $app = null)
    {
        $this->client = $client;
        $this->validator = new Validator();
        $this->app = $app ?? new PaystackApplication();
    }

    /**
     * Performs a GET Request through the Client.
     *
     * @param $path
     * @param array $parameters
     * @param array $requestHeaders
     *
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return array|string|PaystackCollection
     */
    protected function get($path, array $parameters = [], array $requestHeaders = [])
    {
        if (null !== $this->page && !isset($parameters['page'])) {
            $parameters['page'] = $this->page;
        }

        if (null !== $this->perPage && !isset($parameters['perPage'])) {
            $parameters['perPage'] = $this->perPage;
        }

        if (count($parameters) > 0) {
            $path .= '?'.http_build_query($parameters);
        }

        $response = $this->client->getHttpClient()->get($path, $requestHeaders);

        $response = ResponseMediator::getContent($response);

        if ($response instanceof Collection && $this instanceof ModelAware) {
            return $response->map(function ($item) {
                return $this->getApiModel($item);
            });
        }

        if (is_array($response) && $this instanceof ModelAware) {
            return $this->getApiModel($response);
        }

        return $response;
    }

    /**
     * Performs a PATCH Request through the Client.
     *
     * @param string $path
     * @param array  $parameters
     * @param array  $requestHeaders
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    protected function patch(string $path, array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->patch(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Performs a PUT Request through the Client.
     *
     * @param string $path
     * @param array  $parameters
     * @param array  $requestHeaders
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    protected function put(string $path, array $parameters = [], array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->put(
            $path,
            $requestHeaders,
            $this->createJsonBody($parameters)
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Performs a Delete Request through the Client.
     *
     * @param string $path
     * @param array  $parameters
     * @param array  $requestHeader
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    protected function delete(string $path, array $parameters = [], array $requestHeader = [])
    {
        $response = $this->client->getHttpClient()->delete(
            $path,
            $requestHeader,
            $this->createJsonBody($parameters)
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Performs a POST Request through the client.
     *
     * @param $path
     * @param array $parameters
     * @param array $requestHeaders
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    protected function post($path, array $parameters = [], array $requestHeaders = [])
    {
        return $this->postRaw(
            $path,
            $this->createJsonBody($parameters),
            $requestHeaders
        );
    }

    /**
     * Performs a raw POST request through the client.
     *
     * @param $path
     * @param $body
     * @param array $requestHeaders
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    protected function postRaw($path, $body, array $requestHeaders = [])
    {
        $response = $this->client->getHttpClient()->post(
            $path,
            $requestHeaders,
            $body
        );

        return ResponseMediator::getContent($response);
    }

    /**
     * Creates a JSON stream from parameter array.
     *
     * @param array $parameters
     *
     * @return false|string|null
     */
    protected function createJsonBody(array $parameters)
    {
        return (count($parameters) === 0) ? null : json_encode($parameters, empty($parameters) ? JSON_FORCE_OBJECT : 0);
    }

    /**
     * Returns the Items per page.
     *
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

    /**
     * Sets the Items per page.
     *
     * @param int $page
     *
     * @return ApiInterface
     */
    public function setPerPage(int $page): ApiInterface
    {
        $this->perPage = $page;

        return $this;
    }

    /**
     * Fires an Event.
     *
     * @param string $event
     * @param array  $payload
     *
     * @return mixed
     */
    protected function fire(string $event, $payload = null)
    {
        return $this->client->getEvent()->fire($event, $payload);
    }

    /**
     * @param array $attributes
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws Exception
     *
     * @return mixed
     */
    protected function getApiModel(array $attributes)
    {
        if ($this instanceof ModelAware) {
            return $this->app->makeModel($this->getApiModelAccessor(), ['attributes' => $attributes]);
        }

        throw new Exception("This API doesn't support Model!");
    }
}
