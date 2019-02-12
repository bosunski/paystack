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
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link             https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Api;


class Plans extends AbstractApi
{
	const BASE_PATH = '/plan';

	public function fetch($planId)
	{
		$this->validator->setRequiredParameters(['plan_id']);
		if ($this->validator->checkParameters([ 'plan_id' => $planId])) {
			return $this->get(self::BASE_PATH . '/' . $planId);
		}
	}

	public function list(array $parameters = [])
	{
		return $this->get(self::BASE_PATH, $parameters);
	}

	public function create(array $parameters)
	{
		// ToDO: Implement ENUM for Interval
		$this->validator->setRequiredParameters(['name', 'amount', 'interval',]);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}

	public function update(string $planId, array $parameters)
	{
		return $this->put(self::BASE_PATH . "/$planId", $parameters);
	}
}