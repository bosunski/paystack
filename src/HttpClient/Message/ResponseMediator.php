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

namespace Xeviant\Paystack\HttpClient\Message;


use Psr\Http\Message\ResponseInterface;

class ResponseMediator
{
	/**
	 * @param ResponseInterface $response
	 * @return array|string
	 */
	public static function getContent(ResponseInterface $response)
	{
		$body = $response->getBody()->__toString();

		if (strpos($response->getHeaderLine('Content-Type'), 'application/json') === 0) {
			$content = json_decode($body, true);

			if (JSON_ERROR_NONE === json_last_error()) {
				return $content;
			}
		}

		return $body;
	}
}