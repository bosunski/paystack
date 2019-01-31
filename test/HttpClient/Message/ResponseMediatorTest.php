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

namespace Xeviant\Paystack\Test\HttpClient;


use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;
use PHPUnit\Framework\TestCase;
use Xeviant\Paystack\HttpClient\Message\ResponseMediator;

class ResponseMediatorTest extends TestCase
{
	public function testGetContent()
	{
		$body = ['foo' => 'bax'];
		$response = new Response(
			200,
			['Content-Type' => 'application/json'],
			stream_for(json_encode($body))
		);

		$this->assertEquals($body, ResponseMediator::getContent($response));
	}
}