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

namespace Xeviant\Paystack\Api;


class Bvn extends AbstractApi
{
	const BASE_PATH = '/bank';

	public function resolve($bvn)
	{
		if ($this->validator->checkParameter($bvn)) {
			return $this->get(self::BASE_PATH . "/resolve_bvn/$bvn");
		}
	}

	public function resolveCardBin($bin)
	{
		if ($this->validator->checkParameter($bin)) {
			return $this->get("/decision/bin/$bin");
		}
	}

	public function resolveAccountNumber($parameters)
	{
		$this->validator->setRequiredParameters([]);
		if ($this->validator->checkParameters($parameters)) {
			return $this->get(self::BASE_PATH . "/resolve?" . http_build_query($parameters));
		}
	}

	public function resolvePhoneNumber($parameters)
	{
		$this->validator->setRequiredParameters(['verification_type', 'phone', 'callback_url']);
		if ($this->validator->checkParameters($parameters)) {
			return $this->post("/verifications", $parameters);
		}
	}
}