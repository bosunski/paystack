<?php

namespace Xeviant\Paystack\App;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Message\StreamFactory;
use Illuminate\Container\Container;
use ReflectionException;
use Xeviant\Paystack\Client;
use Xeviant\Paystack\Config as PaystackConfig;
use Xeviant\Paystack\Contract\ApiInterface;
use Xeviant\Paystack\Contract\ApplicationInterface;
use Xeviant\Paystack\Contract\Config;
use Xeviant\Paystack\Contract\EventInterface;
use Xeviant\Paystack\Event\EventHandler;
use Xeviant\Paystack\Exception\InvalidArgumentException;
use Xeviant\Paystack\HttpClient\Builder;

class PaystackApplication extends Container implements ApplicationInterface
{

    /**
     * The Package Version
     *
     * @var string
     */
    const VERSION = '1.0';

    /**
     * The Package Version
     *
     * @var string
     */
    const API_VERSION = '1.0';

    /**
     * @var null
     */
    private $basePath;
    private $paystackBindings = [];
    /**
     * @var string
     */
    private $publicKey;
    /**
     * @var string
     */
    private $secretKey;

    public function __construct(string $publicKey, string $secretKey, $basePath = null)
    {
        $this->basePath = $basePath;
        $this->paystackBindings = require_once "{$this->basePath}/config/bindings.php";
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;

        // This order must be maintained
        $this->registerInstances();
        $this->registerVendorServices();
        $this->registerBaseBindings();
        $this->registerApiServices();
        $this->registerApiModels();
    }

    protected function registerInstances()
    {
    }

    protected function registerApiModels()
    {
    }

    protected function registerApiServices()
    {
        $services = $this->paystackBindings['providers'];
        foreach ($services as $key => $service) {
            $this->bind($key, $service);
        }
    }

    protected function registerBaseBindings()
    {
        $this->bind(Builder::class, Builder::class);
        $this->bind(Config::class, function ($app) {
            return new PaystackConfig(self::VERSION, $this->publicKey, $this->secretKey, self::API_VERSION);
        });
        $this->bind(EventInterface::class, EventHandler::class);

        $this->instance(ApplicationInterface::class, $this);

        $this->bind(Client::class, Client::class);
    }

    protected function registerVendorServices()
    {
        $this->bind(HttpClient::class, function($app) {
            return HttpClientDiscovery::find();
        });

        $this->bind(RequestFactory::class, function ($app) {
            return MessageFactoryDiscovery::find();
        });

        $this->bind(StreamFactory::class, function($app) {
            return StreamFactoryDiscovery::find();
        });
    }

    public function makeApi(string $apiName): ApiInterface
    {
        try {
            return $this->make($apiName);
        } catch (ReflectionException $e) {
            throw new InvalidArgumentException(sprintf('Undefined API called: "%s', $apiName));
        }
    }

    public function makeModel(string $apiName)
    {
    }
}
