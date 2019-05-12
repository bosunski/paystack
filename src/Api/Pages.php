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

class Pages extends AbstractApi implements ModelAware
{
	const BASE_PATH = '/page';

    /**
     * Retrieves a Payment Page
     *
     * @param $pageId
     * @return array|string
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
	public function fetch($pageId)
	{
		$this->validator->setRequiredParameters(['page_id']);
		if ($this->validator->checkParameters([ 'page_id' => $pageId])) {
			return $this->get(self::BASE_PATH . '/' . $pageId);
		}
	}

    /**
     * Checks if a page slug is available
     *
     * @param $slug
     * @return array|string
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
	public function checkSlugAvailability($slug)
	{
		$this->validator->setRequiredParameters(['slug']);
		if ($this->validator->checkParameters([ 'slug' => $slug])) {
			return $this->get(self::BASE_PATH . '/check_slug_availability/' . $slug);
		}
	}

    /**
     * Retrieves all Payment pages
     *
     * @param array $parameters
     * @return Collection
     * @throws \Http\Client\Exception
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
	public function list(array $parameters = []): Collection
	{
		return $this->get(self::BASE_PATH, $parameters);
	}

    /**
     * Creates a payment Page
     *
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function create(array $parameters)
	{
		$this->validator->setRequiredParameters(['name']);

		if ($this->validator->checkParameters($parameters)) {
			return $this->post(self::BASE_PATH, $parameters);
		}
	}

    /**
     * Updates a payment page
     *
     * @param string $pageId
     * @param array $parameters
     * @return array|string
     * @throws \Http\Client\Exception
     */
	public function update(string $pageId, array $parameters)
	{
		return $this->put(self::BASE_PATH . "/$pageId", $parameters);
	}

    public function getApiModelAccessor(): string
    {
        return 'page';
    }
}
