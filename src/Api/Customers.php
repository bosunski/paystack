<?php
/**
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version         1.0
 *
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link            https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\Api;

use Illuminate\Support\Collection;
use Xeviant\Paystack\Contract\ModelAware;

class Customers extends AbstractApi implements ModelAware
{
    const BASE_PATH = '/customer';

    /**
     * Retrieves a Customer.
     *
     * @param $email
     *
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return array|string
     */
    public function fetch($email)
    {
        return $this->get(self::BASE_PATH.DIRECTORY_SEPARATOR.$email);
    }

    /**
     * Retrieves all Customers.
     *
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return Collection
     */
    public function list(): Collection
    {
        return $this->get(self::BASE_PATH);
    }

    /**
     * Creates a Customer.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function create(array $parameters)
    {
        $this->validator->setRequiredParameters(['email']);

        if ($this->validator->checkParameters($parameters)) {
            return $this->post(self::BASE_PATH, $parameters);
        }
    }

    /**
     * Whitelists a customer.
     *
     * @param string $customerId
     *
     * @throws \Http\Client\Exception
     * @throws \Xeviant\Paystack\Exception\MissingArgumentException
     *
     * @return array|string
     */
    public function whitelist(string $customerId)
    {
        if ($this->validator->checkParameter($customerId)) {
            $parameters = ['customer' => $customerId, 'risk_action' => 'allow'];

            return $this->post(self::BASE_PATH.DIRECTORY_SEPARATOR.'set_risk_action', $parameters);
        }
    }

    /**
     * Blacklists a Customer.
     *
     * @param string $customerId
     *
     * @throws \Http\Client\Exception
     * @throws \Xeviant\Paystack\Exception\MissingArgumentException
     *
     * @return array|string
     */
    public function blacklist(string $customerId)
    {
        if ($this->validator->checkParameter($customerId)) {
            $parameters = ['customer' => $customerId, 'risk_action' => 'deny'];

            return $this->post(self::BASE_PATH.DIRECTORY_SEPARATOR.'set_risk_action', $parameters);
        }
    }

    /**
     * Deactivates Authorization.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function deactivateAuthorization(array $parameters)
    {
        $this->validator->setRequiredParameters(['authorization_code']);

        if ($this->validator->checkParameters($parameters)) {
            return $this->post(self::BASE_PATH.DIRECTORY_SEPARATOR.'deactivate_authorization', $parameters);
        }
    }

    /**
     * Updates a Customer.
     *
     * @param $customerId
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function update($customerId, array $parameters)
    {
        return $this->put(self::BASE_PATH.DIRECTORY_SEPARATOR.$customerId, $parameters);
    }

    public function getApiModelAccessor(): string
    {
        return 'customer';
    }
}
