<?php
/**
 *
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package         Paystack
 * @version         1.0
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link            https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Api;


class Customers extends AbstractApi
{
	const BASE_PATH = '/customer';

	const RISK_ACTIONS = ['allow', 'deny'];

	public function fetch($email)
	{
		return $this->get(self::BASE_PATH . DIRECTORY_SEPARATOR . $email);
	}

	public function list()
	{
		return $this->get(self::BASE_PATH);
	}

	public function create(array $parameters)
	{
		$this->validator->setRequiredParameters(['email']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}

	public function whitelist(string $customerId)
	{
		if ($this->validator->checkParameter($customerId)) {
			$parameters = ['customer' => $customerId, 'risk_action' => 'allow'];
			return $this->post(self::BASE_PATH . DIRECTORY_SEPARATOR . 'set_risk_action', $parameters);
		}
	}

	public function blacklist(string $customerId)
	{
		if ($this->validator->checkParameter($customerId)) {
			$parameters = ['customer' => $customerId, 'risk_action' => 'deny'];
			return $this->post(self::BASE_PATH . DIRECTORY_SEPARATOR . 'set_risk_action', $parameters);
		}
	}

	public function deactivateAuthorization(array $parameters)
	{
		$this->validator->setRequiredParameters(['authorization_code']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . DIRECTORY_SEPARATOR . 'deactivate_authorization', $parameters);
		}
	}

	public function update($customerId, array $parameters)
	{
		return $this->put(self::BASE_PATH . DIRECTORY_SEPARATOR. $customerId, $parameters);
	}
}