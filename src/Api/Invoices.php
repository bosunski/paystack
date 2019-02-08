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
 * @copyright    (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link             https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Api;


class Invoices extends AbstractApi
{
	const BASE_PATH = '/paymentrequest';

	public function fetch(string $invoiceId)
	{
		if ($this->required->checkParameter($invoiceId)) {
			return $this->get(self::BASE_PATH . '/' . rawurlencode($invoiceId));
		}
	}

	public function totals(string $invoiceId)
	{
		if ($this->required->checkParameter($invoiceId)) {
			return $this->get(self::BASE_PATH . '/' . rawurlencode($invoiceId));
		}
	}

}