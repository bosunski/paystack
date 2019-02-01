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

namespace Xeviant\Paystack\Api;


use Xeviant\Paystack\Client;
use Xeviant\Paystack\Contract\ApiInterface;
use Xeviant\Paystack\HttpClient\Message\ResponseMediator;

abstract class AbstractApi implements ApiInterface
{
	/**
	 * @var Client
	 */
	private $client;

	/**
	 * @var
	 */
	private $page;

	/**
	 * @var
	 */
	private $perPage;

	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	protected function get($path, array $parameters = [], array $requestHeaders = [])
	{
		if (null !== $this->page && !isset($parameters['page'])) {
			$parameters['page'] = $this->page;
		}
		if (null !== $this->perPage && !iset($parameters['per_page'])) {
			$parameters['per_page'] = $this->perPage;
		}
		if (array_key_exists('ref', $parameters) && is_null($parameters['ref'])) {
			unset($parameters['ref']);
		}

		if (count($parameters) > 0) {
			$path .= '?' . http_build_query($parameters);
		}

		$response = $this->client->getHttpClient()->get($path, $requestHeaders);

		return ResponseMediator::getContent($response);
	}

	public function getPerPage()
	{
	}

	public function setPerPage()
	{
	}
}