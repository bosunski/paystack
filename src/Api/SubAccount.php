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


class SubAccount extends AbstractApi
{
	const BASE_PATH = '/subaccount';

	const SETTLEMENT_SCHEDULES = ['auto', 'weekly', 'monthly', 'manual'];

	public function fetch(string $accountId)
	{
		$this->validator->setRequiredParameters(['id_or_slug']);
		if ($this->validator->checkParameters([ 'id_or_slug' => $accountId])) {
			return $this->get(self::BASE_PATH . '/' . $accountId);
		}
	}

	public function list(array $parameters = [])
	{
		return $this->get(self::BASE_PATH, $parameters);
	}

	public function create(array $parameters)
	{
		$this->validator->setRequiredParameters(['business_name', 'settlement_bank', 'account_number', 'percentage_charge']);

		if ($this->validator->checkParameters($parameters)) {
			if (isset($parameters['settlement_schedule']) && $this->validator->contains(['settlement_schedule' => (string) $parameters['settlement_schedule']], self::SETTLEMENT_SCHEDULES)) {
				return $this->post(self::BASE_PATH, $parameters);
			}

			return $this->post(self::BASE_PATH, $parameters);
		}
	}

	public function update(string $accountId, array $parameters)
	{
		return $this->put(self::BASE_PATH . "/$accountId", $parameters);
	}
}