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
 * @copyright        (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link             https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Api;


class Transactions extends AbstractApi
{
	const BASE_PATH = '/transaction';

	public function verify(string $reference)
	{
		$this->required->setRequiredParameters(['reference']);

		if ($this->required->checkParameters(['reference' => $reference])) {
			return $this->get(self::BASE_PATH . '/verify/' . $reference);
		}

		return true;
	}

	public function charge(array $parameters)
	{
		$this->required->setRequiredParameters(['authorization_code', 'email', 'amount']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/charge_authorization', $parameters);
		}
	}

	public function initialize(array $parameters)
	{
		$this->required->setRequiredParameters(['email', 'amount']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/initialize', $parameters);
		}
	}

	public function reauthorize(array $parameters)
	{
		$this->required->setRequiredParameters(['authorization_code', 'amount', 'email']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/request_reauthorization', $parameters);
		}
	}

	public function checkAuthorization(array $parameters)
	{
		$this->required->setRequiredParameters(['authorization_code', 'amount', 'email']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/check_authorization', $parameters);
		}
	}

	public function fetch(string $transactionId)
	{
		$this->required->setRequiredParameters(['id']);
		if ($this->required->checkParameters(['id' => $transactionId])) {
			return $this->get(self::BASE_PATH . '/' . $transactionId);
		}
	}

	public function timeline(string $transactionId)
	{
		$this->required->setRequiredParameters(['id']);
		if ($this->required->checkParameters(['id' => $transactionId])) {
			return $this->get(self::BASE_PATH . '/timeline/' . $transactionId);
		}
	}

	public function totals()
	{
		return $this->get(self::BASE_PATH . '/totals');
	}

	public function export()
	{
		return $this->get(self::BASE_PATH . '/export');
	}
}