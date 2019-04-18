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
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link            https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Api;


use Xeviant\Paystack\Client;
use Xeviant\Paystack\Contract\ApiInterface;
use Xeviant\Paystack\Event\EventPayload;
use Xeviant\Paystack\HttpClient\Message\ResponseMediator;
use Xeviant\Paystack\Validator;

abstract class AbstractApi implements ApiInterface
{
	/**
     * The HTTP Client
     *
	 * @var Client
	 */
	protected $client;

	/**
     * Specifies the current page
     *
	 * @var
	 */
	private $page;

	/**
     * Specifies Items per page in a List
     *
	 * @var
	 */
	private $perPage;

	/**
     * A simple Validator Object
     *
	 * @var Validator
	 */
	protected $validator;

    /**
     * AbstractApi constructor.
     *
     * @param Client $client
     */
	public function __construct(Client $client)
	{
		$this->client    = $client;
		$this->validator = new Validator;
	}

    /**
     * Performs a GET Request through the Client
     *
     * @param $path
     * @param array $parameters
     * @param array $requestHeaders
     * @return array|string
     * @throws \Http\Client\Exception
     */
	protected function get($path, array $parameters = [], array $requestHeaders = [])
	{
		if (null !== $this->page && !isset($parameters['page'])) {
			$parameters['page'] = $this->page;
		}

		if (null !== $this->perPage && !isset($parameters['per_page'])) {
			$parameters['per_page'] = $this->perPage;
		}

		if (count($parameters) > 0) {
			$path .= '?' . http_build_query($parameters);
		}

		$response = $this->client->getHttpClient()->get($path, $requestHeaders);

		return ResponseMediator::getContent($response);
	}

    /**
     * Performs a PATCH Request through the Client
     *
     * @param string $path
     * @param array $parameters
     * @param array $requestHeaders
     * @return array|string
     * @throws \Http\Client\Exception
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
     * Performs a PUT Request through the Client
     *
     * @param string $path
     * @param array $parameters
     * @param array $requestHeaders
     * @return array|string
     * @throws \Http\Client\Exception
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
     * Performs a Delete Request through the Client
     *
     * @param string $path
     * @param array $parameters
     * @param array $requestHeader
     * @return array|string
     * @throws \Http\Client\Exception
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
     * Performs a POST Request through the client
     *
     * @param $path
     * @param array $parameters
     * @param array $requestHeaders
     * @return array|string
     * @throws \Http\Client\Exception
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
     * Performs a raw POST request through the client
     *
     * @param $path
     * @param $body
     * @param array $requestHeaders
     * @return array|string
     * @throws \Http\Client\Exception
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
	 * Creates a JSON stream from parameter array
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
     * Returns the Items per page
     *
	 * @return int
	 */
	public function getPerPage(): int
	{
		return $this->perPage;
	}

	/**
     * Sets the Items per page
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
     * Fires an Event
     *
     * @param string $event
     * @param array $payload
     * @return mixed
     */
	protected function fire(string $event, array $payload = [])
    {
        return $this->client->getEvent()->fire($event, $payload);
    }
}
