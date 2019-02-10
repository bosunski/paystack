<?php


/**
 *
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package         Paystack
 * @version         2.0
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link            https://github.com/bosunski/paystack
 *
 */
namespace Xeviant\Paystack;

class Paystack
{
	/**
	 * The Package Version
	 *
	 * @var string
	 */
	const VERSION = '1.0';

	/**
	 * Paystack Configuration
	 *
	 * @var
	 */
	protected $config;

	/**
	 * Paystack Client
	 *
	 * @var Client
	 */
	private $client;

	public function __construct($publicKey = null, $secretKey = null, $apiVersion = null)
	{
		$this->config = new Config(self::VERSION, $publicKey, $secretKey, $apiVersion);
		$this->client = new Client(null, null, $this->config);
	}

	/**
	 * Creates a new Paystack API Instance
	 *
	 * @param null $publicKey
	 * @param null $secretKey
	 * @param null $apiVersion
	 *
	 * @return Paystack
	 */
	public static function make($publicKey = null, $secretKey = null, $apiVersion = null)
	{
		return new static($publicKey, $secretKey, $apiVersion);
	}

	/**
	 * Gets the Public Key
	 *
	 * @return string
	 */
	public function getPublicKey(): string
	{
		return $this->config->getPublicKey();
	}

	/**
	 * Sets the Public Key
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
	 * Sets the Public Key
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
	 * Sets the Public Key
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
	 * Gets the Secret Key
	 *
	 * @return string
	 */
	public function getSecretKey(): string
	{
		return $this->config->getSecretKey();
	}

	/**
	 * Returns the Package Version
	 *
	 * @return string
	 */
	public static function getPackageVersion()
	{
		return self::VERSION;
	}

	/**
	 * Returns the Paystack API Version
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
	 * @return mixed
	 */
	public function __call(string $method, array $arguments)
	{
		return $this->client->api($method);
	}
}