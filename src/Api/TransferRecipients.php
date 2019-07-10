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
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link             https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\Api;

use Illuminate\Support\Collection;
use Xeviant\Paystack\Contract\ModelAware;

class TransferRecipients extends AbstractApi implements ModelAware
{
    const BASE_PATH = '/transferrecipient';

    /**
     * Deleted a Transfer Recipient.
     *
     * @param string $recipientCode
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function deleteTransferRecipient(string $recipientCode)
    {
        $this->validator->setRequiredParameters(['recipient_code_or_id']);
        if ($this->validator->checkParameters(['recipient_code_or_id' => $recipientCode])) {
            return $this->delete(self::BASE_PATH.'/'.$recipientCode);
        }
    }

    /**
     * Retrieves all Transfer recipients.
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
     * Creates a Transfer Recipient.
     *
     * @param array $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function create(array $parameters)
    {
        $this->validator->setRequiredParameters(['type', 'name']);

        if ($this->validator->checkParameters($parameters)) {
            return $this->post(self::BASE_PATH, $parameters);
        }
    }

    /**
     * Updates a Transfer Recipient.
     *
     * @param string $recipientCode
     * @param array  $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function update(string $recipientCode, array $parameters)
    {
        return $this->put(self::BASE_PATH."/$recipientCode", $parameters);
    }

    /**
     * Retrieves Model accessor inside container.
     *
     * @return string
     */
    public function getApiModelAccessor(): string
    {
        return 'transfer.recipient';
    }
}
