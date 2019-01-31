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

namespace Xeviant\Paystack\HttpClient\Plugin;


use Http\Client\Common\Plugin;
use Http\Promise\Promise;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PaystackExceptionThrower implements Plugin
{

	/**
	 * Handle the request and return the response coming from the next callable.
	 *
	 * @see http://docs.php-http.org/en/latest/plugins/build-your-own.html
	 *
	 * @param RequestInterface $request
	 * @param callable         $next  Next middleware in the chain, the request is passed as the first argument
	 * @param callable         $first First middleware in the chain, used to to restart a request
	 *
	 * @return Promise Resolves a PSR-7 Response or fails with an Http\Client\Exception (The same as HttpAsyncClient)
	 */
	public function handleRequest(RequestInterface $request, callable $next, callable $first): Promise
	{
		return $next($request)->then(function (ResponseInterface $response) use ($request) {
			if ($response->getStatusCode() < 400 || $response->getStatusCode() > 600) {
				return $response;
			}

			return null;
//			$remaining = ResponseMe
		});
	}
}