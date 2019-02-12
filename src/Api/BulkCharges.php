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


class BulkCharges extends AbstractApi
{
	const BASE_PATH = '/bulkcharge';

	public function fetch($bulkChargeId)
	{
		return $this->get(self::BASE_PATH . '/' . $bulkChargeId);
	}

	public function pause($bulkChargeId)
	{
		return $this->get(self::BASE_PATH . '/pause/' . $bulkChargeId);
	}

	public function resume($bulkChargeId)
	{
		return $this->get(self::BASE_PATH . '/resume/' . $bulkChargeId);
	}

	public function charges($bulkChargeId)
	{
		return $this->get(self::BASE_PATH . "/$bulkChargeId" . '/charges');
	}

	public function list()
	{
		return $this->get(self::BASE_PATH );
	}

	public function initiate(array $parameters)
	{
		$this->validator->setRequiredParameters([]);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}
}