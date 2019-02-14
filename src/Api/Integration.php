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



class Integration extends AbstractApi
{
	const BASE_PATH = '/integration';

    /**
     * Retrieves timeout for payment session
     *
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function fetchPaymentSessionTimeout()
	{
		return $this->get(self::BASE_PATH . "/payment_session_timeout");
	}

    /**
     * Updates Payment session timeout
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function updatePaymentSessionTimeout(array $parameters)
	{
		return $this->put(self::BASE_PATH . "/payment_session_timeout", $parameters);
	}
}