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

namespace Xeviant\Paystack\Tests\Api;


use Xeviant\Paystack\Api\AbstractApi;

class Charge extends AbstractApi
{
	const BASE_PATH = '/charge';

	public function charge(array $parameters)
	{
		$this->required->setRequiredParameters(['email', 'amount', 'card.number', 'card.cvv', 'card.expiry_month', 'card.expiry_year', 'bank.code', 'bank.account_number']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}

	public function submitPin(array $parameters)
	{
		$this->required->setRequiredParameters(['pin', 'reference']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/submit_pin', $parameters);
		}
	}

	public function submitOtp(array $parameters)
	{
		$this->required->setRequiredParameters(['otp', 'reference']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/submit_otp', $parameters);
		}
	}

	public function submitPhone(array $parameters)
	{
		$this->required->setRequiredParameters(['phone', 'reference']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/submit_phone', $parameters);
		}
	}

	public function submitBirthday(array $parameters)
	{
		$this->required->setRequiredParameters(['birthday', 'reference']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/submit_birthday', $parameters);
		}
	}

	public function checkPendingCharge(string $reference)
	{
		if ($this->required->checkParameter($reference)) {
			return $this->get(self::BASE_PATH . "/$reference");
		}
	}
}