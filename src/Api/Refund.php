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


class Refund extends AbstractApi
{
	const BASE_PATH = '/refund';

	public function fetch($refundId)
	{
		$this->required->setRequiredParameters(['refund_id']);
		if ($this->required->checkParameters(['refund_id' => $refundId])) {
			return $this->get(self::BASE_PATH . '/' . $refundId);
		}
	}

	public function list(array $parameters = [])
	{
		return $this->get(self::BASE_PATH, $parameters);
	}

	public function create(array $parameters)
	{
		$this->required->setRequiredParameters(['transaction']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}
}