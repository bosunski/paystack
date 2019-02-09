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


class Transfers extends AbstractApi
{
	const BASE_PATH = '/transfer';

	public function fetch(string $transferId)
	{
		$this->required->setRequiredParameters(['id_or_code']);
		if ($this->required->checkParameters(['id_or_code' => $transferId])) {
			return $this->get(self::BASE_PATH . '/' . $transferId);
		}
	}

	public function list(array $parameters = [])
	{
		return $this->get(self::BASE_PATH, $parameters);
	}

	public function initiate(array $parameters)
	{
		$this->required->setRequiredParameters(['source', 'amount', 'recipient']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}

	public function finalize(array $parameters)
	{
		$this->required->setRequiredParameters(['transfer_code', 'otp']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/finalize_transfer', $parameters);
		}
	}

	public function bulk(array $parameters)
	{
		$this->required->setRequiredParameters([]);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/bulk', $parameters);
		}
	}

	public function resendOtp(array $parameters)
	{
		$this->required->setRequiredParameters(['transfer_code', 'reason']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/resend_otp', $parameters);
		}
	}

	public function disableOtp(array $parameters = [])
	{
		$this->required->setRequiredParameters([]);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/disable_otp', $parameters);
		}
	}

	public function enableOtp(array $parameters = [])
	{
		$this->required->setRequiredParameters([]);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/enable_otp', $parameters);
		}
	}

	public function disableOtpFinalize(array $parameters)
	{
		$this->required->setRequiredParameters(['otp']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/disable_otp_finalize', $parameters);
		}
	}
}