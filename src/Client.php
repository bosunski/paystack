<?php

namespace Xeviant\Paystack;


use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HistoryPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Client\HttpClient;
use Http\Discovery\UriFactoryDiscovery;
use Xeviant\Paystack\Api\Balance;
use Xeviant\Paystack\Api\Bank;
use Xeviant\Paystack\Api\BulkCharges;
use Xeviant\Paystack\Api\Bvn;
use Xeviant\Paystack\Api\Charge;
use Xeviant\Paystack\Api\Customers;
use Xeviant\Paystack\Api\Integration;
use Xeviant\Paystack\Api\Invoices;
use Xeviant\Paystack\Api\Pages;
use Xeviant\Paystack\Api\Plans;
use Xeviant\Paystack\Api\Refund;
use Xeviant\Paystack\Api\Settlements;
use Xeviant\Paystack\Api\SubAccount;
use Xeviant\Paystack\Api\Subscriptions;
use Xeviant\Paystack\Api\Transactions;
use Xeviant\Paystack\Api\TransferRecipients;
use Xeviant\Paystack\Api\Transfers;
use Xeviant\Paystack\Contract\ApiInterface;
use Xeviant\Paystack\Contract\Config;
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
	/**
	 * @var Config
	 */
	private $config;

	public function __construct(Builder $httpClientBuilder = null, $apiVersion = null, Config $config = null)
	{
		$this->config = $config;

		$this->responseHistory = new History();
		$this->httpClientBuilder = $builder = $httpClientBuilder ?: new Builder();

		$builder->addPlugin(new HistoryPlugin($this->responseHistory));
		$builder->addPlugin(new RedirectPlugin());
		$builder->addPlugin(new AddHostPlugin(UriFactoryDiscovery::find()->createUri('https://api.paystack.co')));
		$builder->addPlugin(new HeaderDefaultsPlugin([], $config));

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
			case 'balance':
				$api = new Balance($this);
				break;
			case 'bank':
				$api = new Bank($this);
				break;
			case 'bulkCharges':
				$api = new BulkCharges($this);
				break;
			case 'bvn':
				$api = new Bvn($this);
				break;
			case 'charge':
				$api = new Charge($this);
				break;
			case 'customers':
				$api = new Customers($this);
				break;
			case 'integration':
				$api = new Integration($this);
				break;
			case 'invoices':
				$api = new Invoices($this);
				break;
			case 'pages':
				$api = new Pages($this);
				break;
			case 'plans':
				$api = new Plans($this);
				break;
			case 'refund':
				$api = new Refund($this);
				break;
			case 'settlements':
				$api = new Settlements($this);
				break;
			case 'subAccount':
				$api = new SubAccount($this);
				break;
			case 'subscriptions':
				$api = new Subscriptions($this);
				break;
			case 'transactions':
				$api = new Transactions($this);
				break;
			case 'transferRecipients':
				$api = new TransferRecipients($this);
				break;
			case 'transfers':
				$api = new Transfers($this);
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