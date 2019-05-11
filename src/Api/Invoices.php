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


use Illuminate\Support\Collection;
use Xeviant\Paystack\Contract\PaystackEventType;

class Invoices extends AbstractApi
{
	const BASE_PATH = '/paymentrequest';

    /**
     * Retrieves an Invoice
     *
     * @param string $invoiceId
     * @return array|string
     * @throws \Http\Client\Exception
     * @throws \Xeviant\Paystack\Exception\MissingArgumentException
     */
	public function fetch(string $invoiceId)
	{
		if ($this->validator->checkParameter($invoiceId)) {
			return $this->get(self::BASE_PATH . '/' . rawurlencode($invoiceId));
		}
	}

    /**
     * Verifies an Invoice
     *
     * @param string $invoiceId
     * @return array|string
     * @throws \Http\Client\Exception
     * @throws \Xeviant\Paystack\Exception\MissingArgumentException
     */
	public function verify(string $invoiceId)
	{
		if ($this->validator->checkParameter($invoiceId)) {
			return $this->get(self::BASE_PATH . '/verify/' . rawurlencode($invoiceId));
		}
	}

    /**
     * Retrieves Invoice totals
     *
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function totals()
	{
		return $this->get(self::BASE_PATH . '/totals');
	}

    /**
     * Retrieves all Invoices
     *
     * @return Collection
     * @throws \Http\Client\Exception
     */
	public function list(): Collection
	{
		return $this->get(self::BASE_PATH);
	}

    /**
     * Creates notification about an Invoice
     *
     * @param string $invoiceId
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function notify(string $invoiceId, array $parameters = [])
	{
		return $this->post(self::BASE_PATH . "/notify/$invoiceId", $parameters);
	}

    /**
     * Finalizes an Invoice
     *
     * @param string $invoiceId
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function finalize(string $invoiceId, array $parameters = [])
	{
		return $this->post(self::BASE_PATH . "/finalize/$invoiceId", $parameters);
	}

    /**
     * Archives an Invoice
     *
     * @param string $invoiceId
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function archive(string $invoiceId, array $parameters = [])
	{
		return $this->post(self::BASE_PATH . "/archive/$invoiceId", $parameters);
	}

    /**
     * Marks an Invoice as Paid
     *
     * @param string $invoiceId
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function markAsPaid(string $invoiceId, array $parameters = [])
	{
		$this->validator->setRequiredParameters(['amount_paid', 'paid_by', 'payment_date', 'payment_method']);
		// ToDo: Implement ENUM for payment_method
		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . "/mark_as_paid/$invoiceId", $parameters);
		}
	}

    /**
     * Updates an Invoice
     *
     * @param string $invoiceId
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function update(string $invoiceId, array $parameters = [])
	{
		$this->validator->setRequiredParameters([]);
		if ($this->validator->checkParameters($parameters)) {
			$response = $this->put(self::BASE_PATH . "/$invoiceId", $parameters);

			if ($response['status'] ?? null) {
			    $this->fire(PaystackEventType::INVOICE_UPDATED, $response['data'] ?? null);
            }

			return $response;
		}
	}

    /**
     * Creates an Invoice
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function create(array $parameters)
	{
		$this->validator->setRequiredParameters(['customer', 'amount', 'due_date']);
		if ($this->validator->checkParameters($parameters)) {
			$response = $this->post(self::BASE_PATH, $parameters);

			if ($response['status'] ?? null) {
			    $this->fire(PaystackEventType::INVOICE_CREATED, $response['data']);
            } else {
			    $this->fire(PaystackEventType::INVOICE_FAILED, $response['data'] ?? null);
            }

			return $response;
		}
	}
}
