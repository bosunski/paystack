<?php

namespace Xeviant\Paystack;


use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HistoryPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Client\HttpClient;
use Http\Discovery\UriFactoryDiscovery;
use Xeviant\Paystack\Api\Customer;
use Xeviant\Paystack\Contract\ApiInterface;
use Xeviant\Paystack\Exception\BadMethodCallException;
use Xeviant\Paystack\Exception\InvalidArgumentException;
use Xeviant\Paystack\HttpClient\Builder;
use Xeviant\Paystack\HttpClient\Plugin\HeaderDefaultsPlugin;
use Xeviant\Paystack\HttpClient\Plugin\History;

class Client
{
	/**
	 * @var History
	 */
	private $responseHistory;
	/**
	 * @var Builder
	 */
	private $httpClientBuilder;

	/**
	 * @var string
	 */
	private $apiVersion;

	public function __construct(Builder $httpClientBuilder = null, $apiVersion = null)
	{
		$this->responseHistory = new History();
		$this->httpClientBuilder = $builder = $httpClientBuilder ?: new Builder();

		$builder->addPlugin(new HistoryPlugin($this->responseHistory));
		$builder->addPlugin(new RedirectPlugin());
		$builder->addPlugin(new AddHostPlugin(UriFactoryDiscovery::find()->createUri('https://api.paystack.co')));
		$builder->addPlugin(new HeaderDefaultsPlugin([]));

		$this->apiVersion = $apiVersion ?: 'v1';
		$builder->addHeaderValue('Accept', sprintf('application/json'));
	}

	/**
	 * @param HttpClient $httpClient
	 *
	 * @return Client
	 */
	public static function createWithHttpClient(HttpClient $httpClient): Client
	{
		$builder = new Builder($httpClient);

		return new self($builder);
	}

	/**
	 * @return \Http\Client\Common\HttpMethodsClientInterface
	 */
	public function getHttpClient(): HttpMethodsClientInterface
	{
		return $this->getHttpClientBuilder()->getHttpClient();
	}

	/**
	 * @return Builder
	 */
	protected function getHttpClientBuilder(): Builder
	{
		return $this->httpClientBuilder;
	}

	/**
	 * Gets the API Instance
	 *
	 * @param $name
	 *
	 * @return ApiInterface
	 */
	public function api($name): ApiInterface
	{
		switch ($name) {
			case 'customer':
				$api = new Customer($this);
				break;
			default:
				throw new InvalidArgumentException(sprintf('Undefined method called: "%s', $name));
		}

		return $api;
	}

	/**
	 * @param $name
	 * @param $arguments
	 *
	 * @return ApiInterface
	 */
	public function __call($name, $arguments): ApiInterface
	{
		try {
			return $this->api($name);
		} catch (InvalidArgumentException $e) {
			throw new BadMethodCallException(sprintf('Undefined method called: "%s', $name));
		}
	}

}