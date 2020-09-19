<?php

/**
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version         1.0
 *
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link            https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack;

use Xeviant\Paystack\App\PaystackApplication;
use Xeviant\Paystack\Contract\Config;
use Xeviant\Paystack\Contract\EventInterface;

/**
 * @method \Xeviant\Paystack\Api\Customers          customers()
 * @method \Xeviant\Paystack\Api\Balance            balance()
 * @method \Xeviant\Paystack\Api\Bank               bank()
 * @method \Xeviant\Paystack\Api\BulkCharges        bulkCharges()
 * @method \Xeviant\Paystack\Api\Bvn                bvn()
 * @method \Xeviant\Paystack\Api\Charge             charge()
 * @method \Xeviant\Paystack\Api\Integration        integration()
 * @method \Xeviant\Paystack\Api\Invoices           invoices()
 * @method \Xeviant\Paystack\Api\Pages              pages()
 * @method \Xeviant\Paystack\Api\Plans              plans()
 * @method \Xeviant\Paystack\Api\Refund             refund()
 * @method \Xeviant\Paystack\Api\Settlements        settlements()
 * @method \Xeviant\Paystack\Api\SubAccount         subAccount()
 * @method \Xeviant\Paystack\Api\Subscriptions      subscriptions()
 * @method \Xeviant\Paystack\Api\Transactions       transactions()
 * @method \Xeviant\Paystack\Api\TransferRecipients transferRecipients()
 * @method \Xeviant\Paystack\Api\Transfers          transfers()
 */
class Paystack
{
    /**
     * The Package Version.
     *
     * @var string
     */
    const VERSION = '1.0';

    /**
     * Paystack Configuration.
     *
     * @var
     */
    protected $config;

    /**
     * Paystack Client.
     *
     * @var Client
     */
    private $client;

    public function __construct($publicKey = null, $secretKey = null)
    {
        $app = new PaystackApplication($publicKey, $secretKey);
        $this->client = $app->make(Client::class);
        $this->config = $app->make(Config::class);
    }

    /**
     * Creates a new Paystack API Instance.
     *
     * @param null $publicKey
     * @param null $secretKey
     * @param null $apiVersion
     *
     * @return Paystack
     */
    public static function make($publicKey = null, $secretKey = null, $apiVersion = null)
    {
        return new static($publicKey, $secretKey);
    }

    /**
     * Gets the Public Key.
     *
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->config->getPublicKey();
    }

    /**
     * Sets the Public Key.
     *
     * @param $publicKey
     *
     * @return self
     */
    public function setPublicKey($publicKey): self
    {
        $this->config->setPublicKey($publicKey);

        return $this;
    }

    /**
     * Sets the Public Key.
     *
     * @param $secretKey
     *
     * @return self
     */
    public function setSecretKey($secretKey): self
    {
        $this->config->setSecretKey($secretKey);

        return $this;
    }

    /**
     * Sets the Public Key.
     *
     * @param $version
     *
     * @return self
     */
    public function setApiVersion($version): self
    {
        $this->config->setApiVersion($version);

        return $this;
    }

    /**
     * Gets the Secret Key.
     *
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->config->getSecretKey();
    }

    /**
     * Returns the Package Version.
     *
     * @return string
     */
    public static function getPackageVersion()
    {
        return self::VERSION;
    }

    /**
     * Returns the Paystack API Version.
     *
     * @return string
     */
    public function getApiVersion()
    {
        return $this->config->getApiVersion();
    }

    /**
     * Creates access for dynamically handling missing method.
     *
     * @param       $method
     * @param array $arguments
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return mixed
     */
    public function __call(string $method, array $arguments)
    {
        return $this->client->api($method);
    }

    public function __get($attribute)
    {
        return $this->client->model($attribute);
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @return EventInterface
     */
    public function getEventHandler(): EventInterface
    {
        return $this->client->getEvent();
    }
}
