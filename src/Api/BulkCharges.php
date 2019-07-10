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

class BulkCharges extends AbstractApi
{
    const BASE_PATH = '/bulkcharge';

    /**
     * Retrieves a Bulk Charge.
     *
     * @param $bulkChargeId
     *
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return array|string
     */
    public function fetch($bulkChargeId)
    {
        return $this->get(self::BASE_PATH.'/'.$bulkChargeId);
    }

    /**
     * Pauses a Bulk charge.
     *
     * @param $bulkChargeId
     *
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return array|string
     */
    public function pause($bulkChargeId)
    {
        return $this->get(self::BASE_PATH.'/pause/'.$bulkChargeId);
    }

    /**
     * Resumes a Bulk charge.
     *
     * @param $bulkChargeId
     *
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return array|string
     */
    public function resume($bulkChargeId)
    {
        return $this->get(self::BASE_PATH.'/resume/'.$bulkChargeId);
    }

    /**
     * Retrieves the charges belonging to a bulk charge.
     *
     * @param $bulkChargeId
     *
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return array|string
     */
    public function charges($bulkChargeId)
    {
        return $this->get(self::BASE_PATH."/$bulkChargeId".'/charges');
    }

    /**
     * Lists all bulk charges.
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
     * Initiates a fresh bulk charge.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function initiate(array $parameters)
    {
        $this->validator->setRequiredParameters([]);

        if ($this->validator->checkParameters($parameters)) {
            return $this->post(self::BASE_PATH, $parameters);
        }
    }
}
