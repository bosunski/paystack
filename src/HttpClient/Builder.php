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


use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\HeaderAppendPlugin;
use Http\Client\Common\PluginClientFactory;
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
	private $headers = [];
	private $plugins = [];

	/**
	 * This plugin must always be the last plugin, so it's always appended.
	 *
	 * @var Plugin\CachePlugin
	 */
	private $cachePlugin;

	/**
	 * An HTTP Client with all our plugins
	 *
	 * @var HttpMethodsClient
	 */
	private $pluginClient;

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

	/**
	 * @param string $header
	 * @param string $headerValue
	 */
	public function addHeaderValue($header, $headerValue)
	{
		if (!isset($this->headers[$header])) {
			$this->headers[$header] = $headerValue;
		} else {
			$this->headers[$header] = array_merge((array) $this->headers[$header], [$headerValue]);
		}

		$this->removePlugin(Plugin\HeaderAppendPlugin::class);
		$this->addPlugin(new Plugin\HeaderAppendPlugin($this->headers));
	}

	/**
	 * @param array $headers
	 */
	public function addHeaders(array $headers)
	{
		$this->headers = array_merge($this->headers, $headers);

		$this->removePlugin(Plugin\HeaderAppendPlugin::class);
		$this->addPlugin(new Plugin\HeaderAppendPlugin($this->headers));
	}

	/**
	 * @return HttpMethodsClient
	 */
	public function getHttpClient(): HttpMethodsClient
	{
		if ($this->httpClientModified) {
			$this->httpClientModified = false;

			$plugins = $this->plugins;
			if ($this->cachePlugin) {
				$plugins[] = $this->cachePlugin;
			}

			$this->pluginClient = new HttpMethodsClient(
				(new PluginClientFactory())->createClient($this->httpClient, $plugins),
				$this->requestFactory
			);

			return $this->pluginClient;
		}
	}
}