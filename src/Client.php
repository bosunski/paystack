<?php

namespace Xeviant\Paystack;

use Http\Client\Common\HttpMethodsClientInterface;
use Http\Client\Common\Plugin\AddHostPlugin;
use Http\Client\Common\Plugin\HistoryPlugin;
use Http\Client\Common\Plugin\RedirectPlugin;
use Http\Client\HttpClient;
use Http\Discovery\UriFactoryDiscovery;
use Xeviant\Paystack\App\PaystackApplication;
use Xeviant\Paystack\Contract\ApiInterface;
use Xeviant\Paystack\Contract\ApplicationInterface;
use Xeviant\Paystack\Contract\Config;
use Xeviant\Paystack\Contract\EventInterface;
use Xeviant\Paystack\Event\EventHandler;
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

    /**
     * @var EventInterface
     */
    private $event;
    /**
     * @var ApplicationInterface
     */
    private $app;

    /**
     * Client constructor.
     *
     * @param ApplicationInterface $app
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __construct(ApplicationInterface $app = null)
    {
        $this->app = $app ?? new PaystackApplication;

        $this->config = $this->app->make(Config::class);

        $this->responseHistory = new History();
        $this->httpClientBuilder = $builder = $this->app->make(Builder::class);

        $builder->addPlugin(new HistoryPlugin($this->responseHistory));
        $builder->addPlugin(new RedirectPlugin());
        $builder->addPlugin(new AddHostPlugin(UriFactoryDiscovery::find()->createUri('https://api.paystack.co')));
        $builder->addPlugin(new HeaderDefaultsPlugin([], $this->config));

        $this->apiVersion = $this->config ? $this->config->getApiVersion() : 'v1';
        $builder->addHeaderValue('Accept', sprintf('application/json'));

        $this->httpClientBuilder = $builder;

        $this->event = $this->app->make(EventInterface::class);
    }

    /**
     * Creates The Paystack client with an HTTP Client
     *
     * @param HttpClient $httpClient
     *
     * @return Client
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function createWithHttpClient(HttpClient $httpClient): Client
    {
        $app = new PaystackApplication;

        $app->bind(Builder::class, function ($app) use ($httpClient) {
            return new Builder($httpClient);
        });

        return new self($app);
    }

    /**
     * Retrieves an HTTP Client Object
     *
     * @return \Http\Client\Common\HttpMethodsClientInterface
     */
    public function getHttpClient(): HttpMethodsClientInterface
    {
        return $this->getHttpClientBuilder()->getHttpClient();
    }

    /**
     * Retrieves an HTTP Client builder object
     *
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
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function api($name): ApiInterface
    {
        try {
            return $this->app->makeApi($name);
        }
        catch (InvalidArgumentException $e) {
                throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return ApiInterface
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function __call($name, $arguments): ApiInterface
    {
        try {
            return $this->api($name);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(sprintf('Undefined method called: "%s', $name));
        }
    }

    public function getEvent(): EventInterface
    {
        return $this->event;
    }
}
