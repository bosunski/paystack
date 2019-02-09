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


class Subscriptions extends AbstractApi
{
	const BASE_PATH = '/subscription';

	public function fetch(string $subscriptionId)
	{
		$this->required->setRequiredParameters(['id_or_subscription_code']);
		if ($this->required->checkParameters(['id_or_subscription_code' => $subscriptionId])) {
			return $this->get(self::BASE_PATH . '/' . $subscriptionId);
		}
	}

	public function list(array $parameters = [])
	{
		return $this->get(self::BASE_PATH, $parameters);
	}

	public function create(array $parameters)
	{
		$this->required->setRequiredParameters(['customer', 'plan', 'authorization']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}

	public function enable(array $parameters)
	{
		$this->required->setRequiredParameters(['code', 'token']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . "/enable", $parameters);
		}
	}

	public function disable(array $parameters)
	{
		$this->required->setRequiredParameters(['code', 'token']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . "/disable", $parameters);
		}
	}

	public function update(string $accountId, array $parameters)
	{
		return $this->put(self::BASE_PATH . "/$accountId", $parameters);
	}
}