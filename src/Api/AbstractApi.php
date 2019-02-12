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

namespace Xeviant\Paystack\Api;


use Xeviant\Paystack\Client;
use Xeviant\Paystack\Contract\ApiInterface;
use Xeviant\Paystack\HttpClient\Message\ResponseMediator;
use Xeviant\Paystack\RequiredParameter;

abstract class AbstractApi implements ApiInterface
{
	/**
	 * @var Client
	 */
	private $client;

	/**
	 * @var
	 */
	private $page;

	/**
	 * @var
	 */
	private $perPage;

	/**
	 * @var RequiredParameter
	 */
	protected $validator;

	public function __construct(Client $client)
	{
		$this->client    = $client;
		$this->validator = new RequiredParameter;
	}

	protected function get($path, array $parameters = [], array $requestHeaders = [])
	{
		if (null !== $this->page && !isset($parameters['page'])) {
			$parameters['page'] = $this->page;
		}
		if (null !== $this->perPage && !isset($parameters['per_page'])) {
			$parameters['per_page'] = $this->perPage;
		}
		if (array_key_exists('ref', $parameters) && is_null($parameters['ref'])) {
			unset($parameters['ref']);
		}

		if (count($parameters) > 0) {
			$path .= '?' . http_build_query($parameters);
		}

		$response = $this->client->getHttpClient()->get($path, $requestHeaders);

		return ResponseMediator::getContent($response);
	}

	protected function patch(string $path, array $parameters = [], array $requestHeaders = [])
	{
		$response = $this->client->getHttpClient()->patch(
			$path,
			$requestHeaders,
			$this->createJsonBody($parameters)
		);

		return ResponseMediator::getContent($response);
	}

	protected function put(string $path, array $parameters = [], array $requestHeaders = [])
	{
		$response = $this->client->getHttpClient()->put(
			$path,
			$requestHeaders,
			$this->createJsonBody($parameters)
		);

		return ResponseMediator::getContent($response);
	}

	protected function delete(string $path, array $parameters = [], array $requestHeader = [])
	{
		$response = $this->client->getHttpClient()->delete(
			$path,
			$requestHeader,
			$this->createJsonBody($parameters)
		);

		return ResponseMediator::getContent($response);
	}

	protected function post($path, array $parameters = [], array $requestHeaders = [])
	{
		return $this->postRaw(
			$path,
			$this->createJsonBody($parameters),
			$requestHeaders
		);
	}

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

	public function getPerPage()
	{
	}

	public function setPerPage()
	{
	}
}