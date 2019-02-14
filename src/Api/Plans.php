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

	const SETTLEMENT_SCHEDULES = ['hourly', 'daily', 'weekly', 'monthly', 'biannually', 'annually'];

	/**
     * Fetch Customer
     *
	 * @param $planId
	 *
	 * @return array|string
	 */
	public function fetch($planId)
	{
		$this->validator->setRequiredParameters(['plan_id']);
		if ($this->validator->checkParameters([ 'plan_id' => $planId])) {
			return $this->get(self::BASE_PATH . '/' . $planId);
		}
	}

	/**
     * List Customer
     *
	 * @param array $parameters
	 *
	 * @return array|string
	 */
	public function list(array $parameters = [])
	{
		return $this->get(self::BASE_PATH, $parameters);
	}

	/**
     * Create Customer
     *
	 * @param array $parameters
	 *
	 * @return array|string
	 * @throws \Xeviant\Paystack\Exception\ValueNotAllowedException
	 */
	public function create(array $parameters)
	{
		$this->validator->setRequiredParameters(['name', 'amount', 'interval',]);

		if ($this->validator->checkParameters($parameters)) {
			if (isset($parameters['interval']) && $this->validator->contains(['interval' => (string) $parameters['interval']], self::SETTLEMENT_SCHEDULES)) {
				return $this->post(self::BASE_PATH, $parameters);
			}

			return $this->post(self::BASE_PATH, $parameters);
		}
	}

	/**
     * Updates a plan
     *
	 * @param string $planId
	 * @param array  $parameters
	 *
	 * @return array|string
	 * @throws \Xeviant\Paystack\Exception\ValueNotAllowedException
	 */
	public function update(string $planId, array $parameters)
	{
		if (isset($parameters['interval']) && $this->validator->contains(['interval' => (string) $parameters['interval']], self::SETTLEMENT_SCHEDULES)) {
			return $this->put(self::BASE_PATH . "/$planId", $parameters);
		}

		return $this->put(self::BASE_PATH . "/$planId", $parameters);
	}
}