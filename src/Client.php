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

	public function __construct(Builder $httpClientBuilder = null, $apiVersion = null)
	{
		$this->responseHistory = new History();
		$this->httpClientBuilder = $builder = $httpClientBuilder ?: new Builder();

		$this->apiVersion = $apiVersion ?: 'v1';
		$builder->addHeaderValue('Accept', sprintf('application/json'));
	}
}