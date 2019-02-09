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

	public function verify(string $invoiceId)
	{
		if ($this->required->checkParameter($invoiceId)) {
			return $this->get(self::BASE_PATH . '/verify/' . rawurlencode($invoiceId));
		}
	}

	public function totals()
	{
		return $this->get(self::BASE_PATH . '/totals');
	}

	public function list()
	{
		return $this->get(self::BASE_PATH);
	}

	public function notify(string $invoiceId, array $parameters = [])
	{
		return $this->post(self::BASE_PATH . "/notify/$invoiceId", $parameters);
	}

	public function finalize(string $invoiceId, array $parameters = [])
	{
		return $this->post(self::BASE_PATH . "/finalize/$invoiceId", $parameters);
	}

	public function archive(string $invoiceId, array $parameters = [])
	{
		return $this->post(self::BASE_PATH . "/archive/$invoiceId", $parameters);
	}

	public function markAsPaid(string $invoiceId, array $parameters = [])
	{
		$this->required->setRequiredParameters(['amount_paid', 'paid_by', 'payment_date', 'payment_method']);
		// ToDo: Implement ENUM for payment_method
		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . "/mark_as_paid/$invoiceId", $parameters);
		}
	}

	public function update(string $invoiceId, array $parameters = [])
	{
		$this->required->setRequiredParameters([]);
		if ($this->required->checkParameters($parameters)) {
			return $this->put(self::BASE_PATH . "/$invoiceId", $parameters);
		}
	}

	public function create(array $parameters)
	{
		$this->required->setRequiredParameters(['customer', 'amount', 'due_date']);
		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}
}