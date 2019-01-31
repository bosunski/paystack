<?php

namespace Xeviant\Paystack;


use Http\Client\Common\HttpMethodsClient;
use Http\Client\HttpClient;
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
	 * @return \Http\Client\Common\HttpMethodsClient
	 */
	public function getHttpClient(): HttpMethodsClient
	{
		return $this->getHttpClientBuilder()->getHttpClient();
	}

	/**
	 * @return Builder
	 */
	protected function getHttpClientBuilder()
	{
		return $this->httpClientBuilder;
	}
}