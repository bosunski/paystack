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


class Customer extends AbstractApi
{
	const BASE_PATH = '/customer';

	public function show($email)
	{
		return $this->get(self::BASE_PATH . DIRECTORY_SEPARATOR . $email);
	}

	public function list()
	{
		return $this->get(self::BASE_PATH);
	}

	public function create(array $parameters)
	{
		$this->required->setRequiredParameters(['email']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}

	public function whitelist(array $parameters)
	{
		$this->required->setRequiredParameters(['customer']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . DIRECTORY_SEPARATOR . 'set_risk_action', $parameters);
		}
	}

	public function blacklist(array $parameters)
	{
		$this->required->setRequiredParameters(['customer']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . DIRECTORY_SEPARATOR . 'set_risk_action', $parameters);
		}
	}

	public function deactivateAuthorization(array $parameters)
	{
		$this->required->setRequiredParameters(['authorization_code']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . DIRECTORY_SEPARATOR . 'deactivate_authorization', $parameters);
		}
	}

	public function update($customerId, array $parameters)
	{
		return $this->put(self::BASE_PATH . DIRECTORY_SEPARATOR. $customerId, $parameters);
	}
}