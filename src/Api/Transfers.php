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


class Transfers extends AbstractApi
{
	const BASE_PATH = '/transfer';

    /**
     * Retrieves a Transfer
     *
     * @param string $transferId
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function fetch(string $transferId)
	{
		$this->validator->setRequiredParameters(['id_or_code']);
		if ($this->validator->checkParameters([ 'id_or_code' => $transferId])) {
			return $this->get(self::BASE_PATH . '/' . $transferId);
		}
	}

    /**
     * Retrieves all Transfers
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function list(array $parameters = [])
	{
		return $this->get(self::BASE_PATH, $parameters);
	}

    /**
     * Starts a Transfer
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function initiate(array $parameters)
	{
		$this->validator->setRequiredParameters(['source', 'amount', 'recipient']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}

    /**
     * Finalizes a Transfer
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function finalize(array $parameters)
	{
		$this->validator->setRequiredParameters(['transfer_code', 'otp']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/finalize_transfer', $parameters);
		}
	}

    /**
     * Starts a Bulk Transfer
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function bulk(array $parameters)
	{
		$this->validator->setRequiredParameters([]);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/bulk', $parameters);
		}
	}

    /**
     * Resend an OTP
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function resendOtp(array $parameters)
	{
		$this->validator->setRequiredParameters(['transfer_code', 'reason']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/resend_otp', $parameters);
		}
	}

    /**
     * Disable OTP Used for Transfer
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function disableOtp(array $parameters = [])
	{
		$this->validator->setRequiredParameters([]);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/disable_otp', $parameters);
		}
	}

    /**
     * Enable OTP used for transfer
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function enableOtp(array $parameters = [])
	{
		$this->validator->setRequiredParameters([]);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/enable_otp', $parameters);
		}
	}

    /**
     * Finalizes the disabling of OTP used for transfer
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function disableOtpFinalize(array $parameters)
	{
		$this->validator->setRequiredParameters(['otp']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/disable_otp_finalize', $parameters);
		}
	}
}