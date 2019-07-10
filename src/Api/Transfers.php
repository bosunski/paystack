<?php

/**
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version          1.0
 *
 * @author           Olatunbosun Egberinde
 * @license          MIT Licence
 * @copyright        (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link             https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\Api;

use Illuminate\Support\Collection;
use Xeviant\Paystack\Contract\ModelAware;
use Xeviant\Paystack\Contract\PaystackEventType;

class Transfers extends AbstractApi implements ModelAware
{
    const BASE_PATH = '/transfer';

    /**
     * Retrieves a Transfer.
     *
     * @param string $transferId
     *
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return array|string
     */
    public function fetch(string $transferId)
    {
        $this->validator->setRequiredParameters(['id_or_code']);
        if ($this->validator->checkParameters(['id_or_code' => $transferId])) {
            return $this->get(self::BASE_PATH.'/'.$transferId);
        }
    }

    /**
     * Retrieves all Transfers.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Collection
     */
    public function list(array $parameters = []): Collection
    {
        return $this->get(self::BASE_PATH, $parameters);
    }

    /**
     * Starts a Transfer.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function initiate(array $parameters)
    {
        $this->validator->setRequiredParameters(['source', 'amount', 'recipient']);

        if ($this->validator->checkParameters($parameters)) {
            $response = $this->post(self::BASE_PATH, $parameters);

            if ($response['success'] ?? null && isset($response['data']['status']) && $response['data']['status'] !== 'otp') {
                $this->fire(PaystackEventType::TRANSFER_SUCCESS);
            } else {
                $this->fire(PaystackEventType::TRANSFER_FAILED);
            }

            return $response;
        }
    }

    /**
     * Finalizes a Transfer.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function finalize(array $parameters)
    {
        $this->validator->setRequiredParameters(['transfer_code', 'otp']);

        if ($this->validator->checkParameters($parameters)) {
            $response = $this->post(self::BASE_PATH.'/finalize_transfer', $parameters);

            if ($response['status'] ?? null) {
                $this->fire(PaystackEventType::TRANSFER_SUCCESS, $response['data']);
            } else {
                $this->fire(PaystackEventType::TRANSFER_FAILED, $response['data'] ?? null);
            }

            return $response;
        }
    }

    /**
     * Starts a Bulk Transfer.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function bulk(array $parameters)
    {
        $this->validator->setRequiredParameters([]);

        if ($this->validator->checkParameters($parameters)) {
            $response = $this->post(self::BASE_PATH.'/bulk', $parameters);

            if ($response['status'] ?? null) {
                $this->fire(PaystackEventType::BULK_TRANSFER_SUCCESS, $response['data']);
            } else {
                $this->fire(PaystackEventType::BULK_TRANSFER_FAILED, $response['data'] ?? null);
            }

            return $response;
        }
    }

    /**
     * Resend an OTP.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function resendOtp(array $parameters)
    {
        $this->validator->setRequiredParameters(['transfer_code', 'reason']);

        if ($this->validator->checkParameters($parameters)) {
            return $this->post(self::BASE_PATH.'/resend_otp', $parameters);
        }
    }

    /**
     * Disable OTP Used for Transfer.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function disableOtp(array $parameters = [])
    {
        $this->validator->setRequiredParameters([]);

        if ($this->validator->checkParameters($parameters)) {
            return $this->post(self::BASE_PATH.'/disable_otp', $parameters);
        }
    }

    /**
     * Enable OTP used for transfer.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function enableOtp(array $parameters = [])
    {
        $this->validator->setRequiredParameters([]);

        if ($this->validator->checkParameters($parameters)) {
            return $this->post(self::BASE_PATH.'/enable_otp', $parameters);
        }
    }

    /**
     * Finalizes the disabling of OTP used for transfer.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function disableOtpFinalize(array $parameters)
    {
        $this->validator->setRequiredParameters(['otp']);

        if ($this->validator->checkParameters($parameters)) {
            return $this->post(self::BASE_PATH.'/disable_otp_finalize', $parameters);
        }
    }

    /**
     * Retrieves Model accessor inside container.
     *
     * @return string
     */
    public function getApiModelAccessor(): string
    {
        return 'transfer';
    }
}
