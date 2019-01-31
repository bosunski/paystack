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
 * @copyright   (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link            https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\HttpClient;


use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\HeaderAppendPlugin;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Message\StreamFactory;

class Builder
{
	/**
	 * @var HttpClient
	 */
	private $httpClient;

	private $httpClientModified = true;
	/**
	 * @var RequestFactory
	 */
	private $requestFactory;
	/**
	 * @var StreamFactory
	 */
	private $streamFactory;
	private $headers;
	private $plugins;

	public function __construct(
		HttpClient $httpClient = null,
		RequestFactory $requestFactory = null,
		StreamFactory $streamFactory = null
	)
	{
		$this->httpClient = $httpClient ?: HttpClientDiscovery::find();
		$this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
		$this->streamFactory = $streamFactory ?: StreamFactoryDiscovery::find();
	}

	public function clearHeaders(): void
	{
		$this->headers = [];
		
		$this->removePlugin(HeaderAppendPlugin::class);
		$this->addPlugin(new HeaderAppendPlugin($this->headers));
	}

	public function addPlugin(Plugin $plugin): void
	{
		$this->plugins[] = $plugin;
		$this->httpClientModified = true;
	}

	public function removePlugin($fqcn): void
	{
		foreach ($this->plugins as $key => $plugin) {
			if ($plugin instanceof $fqcn) {
				unset($this->plugins[$key]);
				$this->httpClientModified = true;
			}
		}
	}
}