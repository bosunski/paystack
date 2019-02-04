<?php
/**
 *
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @package         Paystack
 * @version         2.0
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright   (c) Olatunbosun Egberinde <bosunski@gmail.com>
 * @link            https://github.com/bosunski/paystack
 *
 */

namespace Xeviant\Paystack\Api;


class Customer extends AbstractApi
{
	public function show($email)
	{
		return $this->get('/customer/' . $email);
	}

	public function list()
	{
		return $this->get('/customer');
	}

	public function create(array $params)
	{
		$this->required->setParameters(['email']);

		if ($this->required->checkParameters($params)) {
			return $this->post('/customer', $params);
		}
	}
}