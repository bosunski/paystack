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

class SubAccount extends AbstractApi implements ModelAware
{
    const BASE_PATH = '/subaccount';

    const SETTLEMENT_SCHEDULES = ['auto', 'weekly', 'monthly', 'manual'];

    /**
     * Retrieves an already existing SubAccount.
     *
     * @param string $accountId
     *
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return array|string
     */
    public function fetch(string $accountId)
    {
        $this->validator->setRequiredParameters(['id_or_slug']);
        if ($this->validator->checkParameters(['id_or_slug' => $accountId])) {
            return $this->get(self::BASE_PATH.'/'.$accountId);
        }
    }

    /**
     * Lists all created SubAccounts.
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
     * Creates a fresh SubAccount.
     *
     * @param array $parameters
     *
     * @throws \Xeviant\Paystack\Exception\ValueNotAllowedException
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
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

    /**
     * Updates an already existing SubAccount.
     *
     * @param string $accountId
     * @param array  $parameters
     *
     * @throws \Xeviant\Paystack\Exception\ValueNotAllowedException
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function update(string $accountId, array $parameters)
    {
        if (isset($parameters['settlement_schedule']) && $this->validator->contains(['settlement_schedule' => (string) $parameters['settlement_schedule']], self::SETTLEMENT_SCHEDULES)) {
            return $this->put(self::BASE_PATH."/$accountId", $parameters);
        }

        return $this->put(self::BASE_PATH."/$accountId", $parameters);
    }

    /**
     * Retrieves Model accessor inside container.
     *
     * @return string
     */
    public function getApiModelAccessor(): string
    {
        return 'subaccount';
    }
}
