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

class Plans extends AbstractApi implements ModelAware
{
    const BASE_PATH = '/plan';

    const SETTLEMENT_SCHEDULES = ['hourly', 'daily', 'weekly', 'monthly', 'biannually', 'annually'];

    /**
     * Fetches a Plan.
     *
     * @param $planId
     *
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return array|string
     */
    public function fetch($planId)
    {
        $this->validator->setRequiredParameters(['plan_id']);
        if ($this->validator->checkParameters(['plan_id' => $planId])) {
            return $this->get(self::BASE_PATH.'/'.$planId);
        }
    }

    /**
     * List Plans.
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
     * Create Customer.
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
        $this->validator->setRequiredParameters(['name', 'amount', 'interval']);

        if ($this->validator->checkParameters($parameters)) {
            if (isset($parameters['interval']) && $this->validator->contains(['interval' => (string) $parameters['interval']], self::SETTLEMENT_SCHEDULES)) {
                return $this->post(self::BASE_PATH, $parameters);
            }

            return $this->post(self::BASE_PATH, $parameters);
        }
    }

    /**
     * Updates a plan.
     *
     * @param string $planId
     * @param array  $parameters
     *
     * @throws \Xeviant\Paystack\Exception\ValueNotAllowedException
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function update(string $planId, array $parameters)
    {
        if (isset($parameters['interval']) && $this->validator->contains(['interval' => (string) $parameters['interval']], self::SETTLEMENT_SCHEDULES)) {
            return $this->put(self::BASE_PATH."/$planId", $parameters);
        }

        return $this->put(self::BASE_PATH."/$planId", $parameters);
    }

    /**
     * Retrieves Model accessor inside container.
     *
     * @return string
     */
    public function getApiModelAccessor(): string
    {
        return 'plan';
    }
}
