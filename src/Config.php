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

namespace Xeviant\Paystack;

use Xeviant\Paystack\Contract\Config as ConfigInterface;
use Xeviant\Paystack\Exception\RuntimeException;

class Config implements ConfigInterface
{
    /**
     * The current Package version.
     *
     * @var string
     */
    protected $packageVersion;

    /**
     * Paystack Secret Key.
     *
     * @var string
     */
    protected $secretKey;

    /**
     * Paystack Public Key.
     *
     * @var string
     */
    protected $publicKey;

    /**
     * Paystack API Version.
     *
     * @var string
     */
    protected $apiVersion;

    public function __construct($packageVersion = '', $publicKey = '', $secretKey = '', $apiVersion = '')
    {
        $this->setPackageVersion($packageVersion);

        $this->setApiVersion($apiVersion);

        $this->setPublicKey($publicKey ?: getenv('PAYSTACK_PUBLIC_KEY'));

        $this->setSecretKey($secretKey ?: getenv('PAYSTACK_SECRET_KEY'));

        if (!$this->publicKey) {
            throw new RuntimeException('Paystack Public Key is not set!');
        }

        if (!$this->secretKey) {
            throw new RuntimeException('Paystack Secret Key is not set!');
        }
    }

    /**
     * Returns Paystack Public Key.
     *
     * @return string
     */
    public function getPublicKey(): string
    {
        return $this->publicKey;
    }

    /**
     * Sets Paystack Public Key.
     *
     * @param $publicKey
     *
     * @return mixed
     */
    public function setPublicKey($publicKey): ConfigInterface
    {
        $this->publicKey = $publicKey;

        return $this;
    }

    /**
     * Returns Paystack Secret Key.
     *
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * Sets Paystack Secret Key.
     *
     * @param $secretKey
     *
     * @return mixed
     */
    public function setSecretKey($secretKey): ConfigInterface
    {
        $this->secretKey = $secretKey;

        return $this;
    }

    /**
     * Returns current package version.
     *
     * @return string
     */
    public function getPackageVersion(): string
    {
        return $this->packageVersion;
    }

    /**
     * Sets current package version.
     *
     * @param $version
     *
     * @return ConfigInterface
     */
    public function setPackageVersion($version): ConfigInterface
    {
        $this->packageVersion = $version;

        return $this;
    }

    /**
     * Returns the Paystack API version.
     *
     * @return string
     */
    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }

    /**
     * Sets the Paystack API version.
     *
     * @param string $apiVersion
     *
     * @return ConfigInterface
     */
    public function setApiVersion($apiVersion): ConfigInterface
    {
        $this->apiVersion = $apiVersion;

        return $this;
    }
}
