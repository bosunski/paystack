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
 * @copyright   (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link            https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\HttpClient;

use Http\Client\Common\HttpMethodsClient;
use Http\Client\Common\Plugin;
use Http\Client\Common\Plugin\HeaderAppendPlugin;
use Http\Client\Common\PluginClientFactory;
use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;
use Http\Message\RequestFactory;
use Http\Message\StreamFactory;

class Builder
{
    /**
     * The HTTP Client object.
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * Flags for knowing If Client has been modified.
     *
     * @var bool
     */
    private $httpClientModified = true;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    /**
     * @var StreamFactory
     */
    private $streamFactory;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $plugins = [];

    /**
     * This plugin must always be the last plugin, so it's always appended.
     *
     * @var Plugin\CachePlugin
     */
    private $cachePlugin;

    /**
     * An HTTP Client with all our plugins.
     *
     * @var HttpMethodsClient
     */
    private $pluginClient;

    public function __construct(
        HttpClient $httpClient = null,
        RequestFactory $requestFactory = null,
        StreamFactory $streamFactory = null
    ) {
        $this->httpClient = $httpClient ?? HttpClientDiscovery::find();
        $this->requestFactory = $requestFactory ?? MessageFactoryDiscovery::find();
        $this->streamFactory = $streamFactory ?? StreamFactoryDiscovery::find();
    }

    /**
     * Removes all the headers.
     */
    public function clearHeaders(): void
    {
        $this->headers = [];

        $this->removePlugin(HeaderAppendPlugin::class);
        $this->addPlugin(new HeaderAppendPlugin($this->headers));
    }

    /**
     * Adds a Plugin to the Plugin list.
     *
     * @param Plugin $plugin
     */
    public function addPlugin(Plugin $plugin): void
    {
        $this->plugins[] = $plugin;
        $this->httpClientModified = true;
    }

    /**
     * Removes a Plugin from the List.
     *
     * @param $fqcn
     */
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
     * Add the Value for a header.
     *
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
     * Add Headers.
     *
     * @param array $headers
     */
    public function addHeaders(array $headers)
    {
        $this->headers = array_merge($this->headers, $headers);

        $this->removePlugin(Plugin\HeaderAppendPlugin::class);
        $this->addPlugin(new Plugin\HeaderAppendPlugin($this->headers));
    }

    /**
     * Retrieves HTTP Client Instance.
     *
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
