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


class TransferRecipients extends AbstractApi
{
	const BASE_PATH = '/transferrecipient';

	public function deleteTransferRecipient(string $recipientCode)
	{
		$this->required->setRequiredParameters(['recipient_code_or_id']);
		if ($this->required->checkParameters(['recipient_code_or_id' => $recipientCode])) {
			return $this->delete(self::BASE_PATH . '/' . $recipientCode);
		}
	}

	public function list(array $parameters = [])
	{
		return $this->get(self::BASE_PATH, $parameters);
	}

	public function create(array $parameters)
	{
		$this->required->setRequiredParameters(['type', 'name']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}

	public function update(string $recipientCode, array $parameters)
	{
		return $this->put(self::BASE_PATH . "/$recipientCode", $parameters);
	}
}