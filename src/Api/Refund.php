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


class Refund extends AbstractApi
{
	const BASE_PATH = '/refund';

    /**
     * Retrieves a Refund
     *
     * @param $refundId
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function fetch($refundId)
	{
		$this->validator->setRequiredParameters(['refund_id']);
		if ($this->validator->checkParameters([ 'refund_id' => $refundId])) {
			return $this->get(self::BASE_PATH . '/' . $refundId);
		}
	}

    /**
     * Retrieves all refunds
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
     * Creates a refund
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function create(array $parameters)
	{
		$this->validator->setRequiredParameters(['transaction']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}
}