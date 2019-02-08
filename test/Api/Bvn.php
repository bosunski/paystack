<?php
/**
 *
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package          Paystack
 * @version          1.0
 * @author           Olatunbosun Egberinde
 * @license          MIT Licence
 * @copyright    (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link             https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Tests\Api;


use Xeviant\Paystack\Api\AbstractApi;

class Bvn extends AbstractApi
{
	const BASE_PATH = '/bank';

	public function resolve($bvn)
	{
		if ($this->required->checkParameter($bvn)) {
			return $this->get(self::BASE_PATH . "/resolve_bvn/$bvn");
		}
	}

	public function resolveCardBin($bin)
	{
		if ($this->required->checkParameter($bin)) {
			return $this->get("/decision/bin/$bin");
		}
	}

	public function resolveAccountNumber($parameters)
	{
		$this->required->setRequiredParameters([]);
		if ($this->required->checkParameters($parameters)) {
			return $this->get(self::BASE_PATH . "/resolve?" . http_build_query($parameters));
		}
	}

	public function resolvePhoneNumber($parameters)
	{
		$this->required->setRequiredParameters(['verification_type', 'phone', 'callback_url']);
		if ($this->required->checkParameters($parameters)) {
			return $this->post("/verifications", $parameters);
		}
	}
}