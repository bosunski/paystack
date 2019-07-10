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

namespace Xeviant\Paystack\HttpClient\Plugin;

use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Xeviant\Paystack\Contract\Config;

class HeaderDefaultsPlugin implements Plugin
{
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var Config
     */
    private $config;

    public function __construct(array $headers, Config $config = null)
    {
        $this->headers = $headers;
        $this->config = $config;
    }

    /**
     * Handle the request and return the response coming from the next callable.
     *
     * @see http://docs.php-http.org/en/latest/plugins/build-your-own.html
     *
     * @param RequestInterface $request
     * @param callable         $next    Next middleware in the chain, the request is passed as the first argument
     * @param callable         $first   First middleware in the chain, used to to restart a request
     *
     * @return Promise Resolves a PSR-7 Response or fails with an Http\Client\Exception (The same as HttpAsyncClient)
     */
    public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
    {
        $this->headers = array_merge($this->headers, $this->getDefaultHeaders());
        foreach ($this->headers as $header => $headerValue) {
            if (!$request->hasHeader($header)) {
                $request = $request->withHeader($header, $headerValue);
            }
        }

        return $next($request);
    }

    /**
     * Retrieves default headers.
     *
     * @return array
     */
    protected function getDefaultHeaders(): array
    {
        $secretKey = null !== $this->config ? $this->config->getSecretKey() : '';

        return [
            'Content-Type'  => 'application/json',
            'Accept'        => 'application/json',
            'Authorization' => "Bearer $secretKey",
        ];
    }
}
