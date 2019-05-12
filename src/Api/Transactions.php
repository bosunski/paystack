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
use Xeviant\Paystack\Contract\ModelAware;

class Transactions extends AbstractApi implements ModelAware
{
	const BASE_PATH = '/transaction';

	const CHARGES_BEARER = ['account', 'subaccount'];

	const BOOLEANS = ['true', 'false'];

    /**
     * Verifies a Transaction
     *
     * @param string $reference
     * @return array|bool|string
     * @throws \Http\Client\Exception
     */
	public function verify(string $reference)
	{
		$this->validator->setRequiredParameters(['reference']);

		if ($this->validator->checkParameters([ 'reference' => $reference])) {
			return $this->get(self::BASE_PATH . '/verify/' . $reference);
		}

		return true;
	}

    /**
     * Retrieves all Transactions
     *
     * @param array $parameters
     * @return \Illuminate\Support\Collection
     * @throws \Http\Client\Exception
     */
    public function list(array $parameters = []): Collection
    {
        return $this->get(self::BASE_PATH, $parameters)->map(function ($transaction) {
            return $this->getApiModel($transaction);
        });
    }

    /**
     * Authorizes a Charge
     *
     * @param array $parameters
     * @return array|string
     * @throws \Xeviant\Paystack\Exception\ValueNotAllowedException
     * @throws \Http\Client\Exception
     */
	public function charge(array $parameters)
	{
		$this->validator->setRequiredParameters([]);

		if ($this->validator->checkParameters($parameters)) {
			if (isset($parameters['queue']) && $this->validator->contains(['queue' => (string) $parameters['queue']], self::BOOLEANS)) {
				return $this->post(self::BASE_PATH . '/charge_authorization', $parameters);
			}

			return $this->post(self::BASE_PATH . '/charge_authorization', $parameters);
		}
	}


    /**
     * Creates a new Transaction
     *
     * @param array $parameters
     * @return array|string
     * @throws \Xeviant\Paystack\Exception\ValueNotAllowedException
     * @throws \Http\Client\Exception
     */
	public function initialize(array $parameters)
	{
		$this->validator->setRequiredParameters(['email', 'amount']);

		if ($this->validator->checkParameters($parameters)) {
			if (isset($parameters['bearer']) && $this->validator->contains(['bearer' => $parameters['bearer']], self::CHARGES_BEARER)) {
				return $this->post(self::BASE_PATH . '/initialize', $parameters);
			}

			return $this->post(self::BASE_PATH . '/initialize', $parameters);
		}
	}

    /**
     * Requests a re-authorization
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function reauthorize(array $parameters)
	{
		$this->validator->setRequiredParameters(['authorization_code', 'amount', 'email']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/request_reauthorization', $parameters);
		}
	}

    /**
     * Checks a authorization
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function checkAuthorization(array $parameters)
	{
		$this->validator->setRequiredParameters(['authorization_code', 'amount', 'email']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH . '/check_authorization', $parameters);
		}
	}

    /**
     * Retrieves a Transaction
     *
     * @param int $transactionId
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function fetch(int $transactionId)
	{
		$this->validator->setRequiredParameters(['id']);
		if ($this->validator->checkParameters([ 'id' => $transactionId])) {
			return $this->get(self::BASE_PATH . '/' . $transactionId);
		}
	}

    /**
     * Gets the timeline of a Transaction
     *
     * @param string $transactionId
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function timeline(string $transactionId)
	{
		$this->validator->setRequiredParameters(['id']);
		if ($this->validator->checkParameters([ 'id' => $transactionId])) {
			return $this->get(self::BASE_PATH . '/timeline/' . $transactionId);
		}
	}

    /**
     * Retrieves the totals of all transactions
     *
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function totals()
	{
		return $this->get(self::BASE_PATH . '/totals');
	}

    /**
     * Exports transaction as CSV
     *
     * @param array $parameters
     * @return array|string
     * @throws \Xeviant\Paystack\Exception\ValueNotAllowedException
     * @throws \Http\Client\Exception
     */
	public function export(array $parameters = [])
	{
		if (isset($parameters['settled']) && $this->validator->contains(['settled' => (string) $parameters['queue']], self::BOOLEANS)) {
			return $this->get(self::BASE_PATH . '/export', $parameters);
		}

		return $this->get(self::BASE_PATH . '/export', $parameters);
	}

	public function getApiModelAccessor(): string
    {
        return 'transaction';
    }
}
