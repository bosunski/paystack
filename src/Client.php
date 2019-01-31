<?php

namespace Xeviant\Paystack;


use Xeviant\Paystack\HttpClient\Builder;
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

		$this->apiVersion = $apiVersion ?: 'v1';
		$builder->addHeaderValue('Accept', sprintf('application/json'));
	}

	public function getHttpClient()
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