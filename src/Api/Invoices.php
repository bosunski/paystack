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

use Http\Client\Exception;
use Illuminate\Support\Collection;
use Xeviant\Paystack\Contract\ModelAware;
use Xeviant\Paystack\Contract\PaystackEventType;

class Invoices extends AbstractApi implements ModelAware
{
    const BASE_PATH = '/paymentrequest';

    /**
     * Retrieves an Invoice.
     *
     * @param string $invoiceId
     *
     * @throws Exception
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Xeviant\Paystack\Exception\MissingArgumentException
     *
     * @return array|string
     */
    public function fetch(string $invoiceId)
    {
        if ($this->validator->checkParameter($invoiceId)) {
            return $this->get(self::BASE_PATH.'/'.rawurlencode($invoiceId));
        }
    }

    /**
     * Verifies an Invoice.
     *
     * @param string $invoiceId
     *
     * @throws Exception
     * @throws \Xeviant\Paystack\Exception\MissingArgumentException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return array|string
     */
    public function verify(string $invoiceId)
    {
        if ($this->validator->checkParameter($invoiceId)) {
            return $this->get(self::BASE_PATH.'/verify/'.rawurlencode($invoiceId));
        }
    }

    /**
     * Retrieves Invoice totals.
     *
     * @throws Exception
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     *
     * @return array|string
     */
    public function totals()
    {
        return $this->get(self::BASE_PATH.'/totals');
    }

    /**
     * Retrieves all Invoices.
     *
     * @throws Exception
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
     * Creates notification about an Invoice.
     *
     * @param string $invoiceId
     * @param array  $parameters
     *
     * @throws Exception
     *
     * @return array|string
     */
    public function notify(string $invoiceId, array $parameters = [])
    {
        return $this->post(self::BASE_PATH."/notify/$invoiceId", $parameters);
    }

    /**
     * Finalizes an Invoice.
     *
     * @param string $invoiceId
     * @param array  $parameters
     *
     * @throws Exception
     *
     * @return array|string
     */
    public function finalize(string $invoiceId, array $parameters = [])
    {
        return $this->post(self::BASE_PATH."/finalize/$invoiceId", $parameters);
    }

    /**
     * Archives an Invoice.
     *
     * @param string $invoiceId
     * @param array  $parameters
     *
     * @throws Exception
     *
     * @return array|string
     */
    public function archive(string $invoiceId, array $parameters = [])
    {
        return $this->post(self::BASE_PATH."/archive/$invoiceId", $parameters);
    }

    /**
     * Marks an Invoice as Paid.
     *
     * @param string $invoiceId
     * @param array  $parameters
     *
     * @throws Exception
     *
     * @return array|string
     */
    public function markAsPaid(string $invoiceId, array $parameters = [])
    {
        $this->validator->setRequiredParameters(['amount_paid', 'paid_by', 'payment_date', 'payment_method']);
        // ToDo: Implement ENUM for payment_method
        if ($this->validator->checkParameters($parameters)) {
            return $this->post(self::BASE_PATH."/mark_as_paid/$invoiceId", $parameters);
        }
    }

    /**
     * Updates an Invoice.
     *
     * @param string $invoiceId
     * @param array  $parameters
     *
     * @throws Exception
     *
     * @return array|string
     */
    public function update(string $invoiceId, array $parameters = [])
    {
        $this->validator->setRequiredParameters([]);
        if ($this->validator->checkParameters($parameters)) {
            $response = $this->put(self::BASE_PATH."/$invoiceId", $parameters);

            if ($response['status'] ?? null) {
                $this->fire(PaystackEventType::INVOICE_UPDATED, $response['data'] ?? null);
            }

            return $response;
        }
    }

    /**
     * Creates an Invoice.
     *
     * @param array $parameters
     *
     * @throws Exception
     *
     * @return array|string
     */
    public function create(array $parameters)
    {
        $this->validator->setRequiredParameters(['customer', 'amount', 'due_date']);
        if ($this->validator->checkParameters($parameters)) {
            $response = $this->post(self::BASE_PATH, $parameters);

            if ($response['status'] ?? null) {
                $this->fire(PaystackEventType::INVOICE_CREATED, $response['data'] ?? null);
            } else {
                $this->fire(PaystackEventType::INVOICE_FAILED, $response['data'] ?? null);
            }

            return $response;
        }
    }

    public function getApiModelAccessor(): string
    {
        return 'invoice';
    }
}
