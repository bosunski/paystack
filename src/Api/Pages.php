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


class Pages extends AbstractApi
{
	const BASE_PATH = '/page';

	public function fetch($pageId)
	{
		$this->required->setRequiredParameters(['page_id']);
		if ($this->required->checkParameters(['page_id' => $pageId])) {
			return $this->get(self::BASE_PATH . '/' . $pageId);
		}
	}

	public function checkSlugAvailability($slug)
	{
		$this->required->setRequiredParameters(['slug']);
		if ($this->required->checkParameters(['slug' => $slug])) {
			return $this->get(self::BASE_PATH . '/check_slug_availability/' . $slug);
		}
	}

	public function list(array $parameters = [])
	{
		return $this->get(self::BASE_PATH, $parameters);
	}

	public function create(array $parameters)
	{
		$this->required->setRequiredParameters(['name']);

		if ($this->required->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}

	public function update(string $pageId, array $parameters)
	{
		return $this->put(self::BASE_PATH . "/$pageId", $parameters);
	}
}