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


class Subscriptions extends AbstractApi
{
	const BASE_PATH = '/subscription';

    /**
     * Retrieves a Subscription
     *
     * @param string $subscriptionId
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function fetch(string $subscriptionId)
	{
		$this->validator->setRequiredParameters(['id_or_subscription_code']);
		if ($this->validator->checkParameters([ 'id_or_subscription_code' => $subscriptionId])) {
			return $this->get(self::BASE_PATH . '/' . $subscriptionId);
		}
	}

    /**
     * Retrieves all Subscriptions
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
     * Creates a Subscription
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function create(array $parameters)
	{
		$this->validator->setRequiredParameters(['customer', 'plan', 'authorization']);

		if ($this->validator->checkParameters($parameters)) {
			$response =  $this->post(self::BASE_PATH, $parameters);

			if ($response['status']) {
			    $this->client->getEvent()->fire('subscription.create');
            }

			return $response;
		}
	}

    /**
     * Enable a Subscription
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function enable(array $parameters)
	{
		$this->validator->setRequiredParameters(['code', 'token']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . "/enable", $parameters);
		}
	}

    /**
     * Disable a subscription
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function disable(array $parameters)
	{
		$this->validator->setRequiredParameters(['code', 'token']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . "/disable", $parameters);
		}
	}

    /**
     * Updates a Subscription
     *
     * @param string $accountId
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function update(string $accountId, array $parameters)
	{
		return $this->put(self::BASE_PATH . "/$accountId", $parameters);
	}
}
