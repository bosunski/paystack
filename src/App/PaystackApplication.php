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

namespace Xeviant\Paystack\App;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Message\StreamFactory;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use ReflectionException;
use Throwable;
use Xeviant\Paystack\Client;
use Xeviant\Paystack\Config as PaystackConfig;
use Xeviant\Paystack\Contract\ApiInterface;
use Xeviant\Paystack\Contract\ApplicationInterface;
use Xeviant\Paystack\Contract\Config;
use Xeviant\Paystack\Contract\EventInterface;
use Xeviant\Paystack\Event\EventHandler;
use Xeviant\Paystack\Exception\InvalidArgumentException;
use Xeviant\Paystack\HttpClient\Builder;
use Xeviant\Paystack\Model\Model;

class PaystackApplication extends Container implements ApplicationInterface
{
    const MODEL_PREFIX = 'model.';
    /**
     * The Package Version.
     *
     * @var string
     */
    const VERSION = '1.0';

    /**
     * The API Version.
     *
     * @var string
     */
    const API_VERSION = '1.0';

    /**
     * Source path.
     *
     * @var null
     */
    private $basePath;

    /**
     * The Paystack Client APIs + Models + Core Classes.
     *
     * @var array
     */
    private $paystackBindings = [];

    /**
     * Paystack Public key.
     *
     * @var string
     */
    private $publicKey;

    /**
     * Paystack Secret Key.
     *
     * @var string
     */
    private $secretKey;

    /**
     * PaystackApplication constructor.
     *
     * @param string|null $publicKey
     * @param string|null $secretKey
     * @param null        $basePath
     */
    public function __construct(string $publicKey = null, string $secretKey = null, $basePath = null)
    {
        $this->publicKey = $publicKey;
        $this->secretKey = $secretKey;

        $this->setBasePath($basePath);
        $this->loadBindings();

        // This order should be maintained
        $this->registerSharedObjects();
        $this->registerVendorServices();
        $this->registerBaseBindings();
        $this->registerApiServices();
        $this->registerApiModels();
    }

    protected function setBasePath($basePath)
    {
        if (!$basePath) {
            $this->basePath = __DIR__.'/../';

            return $this;
        }

        $this->basePath = $basePath;
    }

    protected function registerSharedObjects()
    {
        $this->instance(ApplicationInterface::class, $this);
    }

    /**
     * Registers all the Application Models.
     */
    protected function registerApiModels()
    {
        $models = $this->paystackBindings['models'];

        foreach ($models as $key => $service) {
            $this->bind(self::MODEL_PREFIX.$key, $service);
        }
    }

    /**
     * Registers all API services.
     */
    protected function registerApiServices()
    {
        $services = $this->paystackBindings['providers'];

        foreach ($services as $key => $service) {
            $this->bind($key, $service);
        }
    }

    /**
     * Registers.
     */
    protected function registerBaseBindings()
    {
        $this->bind(Builder::class, Builder::class);

        $this->bind(Config::class, function ($app) {
            return new PaystackConfig(self::VERSION, $this->publicKey, $this->secretKey, self::API_VERSION);
        });

        $this->bind(EventInterface::class, EventHandler::class);
        $this->bind(Client::class, Client::class);

        $this->bind(Model::class, Model::class);
    }

    /**
     * Registers all External tools used.
     */
    protected function registerVendorServices()
    {
        $this->bind(HttpClient::class, function ($app) {
            return HttpClientDiscovery::find();
        });

        $this->bind(RequestFactory::class, function ($app) {
            return MessageFactoryDiscovery::find();
        });

        $this->bind(StreamFactory::class, function ($app) {
            return StreamFactoryDiscovery::find();
        });
    }

    /**
     * Creates an instance of an API.
     *
     * @param string $apiName
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return ApiInterface
     */
    public function makeApi(string $apiName): ApiInterface
    {
        try {
            return $this->make($apiName);
        } catch (BindingResolutionException $e) {
            throw new InvalidArgumentException(sprintf('Undefined API called: "%s', $apiName));
        } catch (Throwable $e) {
            /**
             * Catching the Throwable interface is not the best solution but it tends to solve the
             * problem of tests builds failing for PHP 7.1 when \Illuminate\Contracts\Container\BindingResolutionException
             * is not caught.
             */
            throw new InvalidArgumentException(sprintf('Undefined API called: "%s', $apiName));
        }
    }

    /**
     * Creates an instance of a model.
     *
     * @param string $modelName
     * @param array  $parameters
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    public function makeModel(string $modelName, $parameters = [])
    {
        try {
            return $this->make(self::MODEL_PREFIX.$modelName, $parameters);
        } catch (ReflectionException $e) {
            throw new InvalidArgumentException(sprintf('Undefined Model called: "%s', $modelName));
        }
    }

    /**
     * Loads all the app bindings Core + APIs + Models.
     */
    private function loadBindings()
    {
        $this->paystackBindings = require __DIR__.'/../config/bindings.php';
    }
}
