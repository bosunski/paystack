<?php
/**
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version         2.0
 *
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link            https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack;

use Illuminate\Support\Collection;
use Xeviant\Paystack\Exception\MissingArgumentException;
use Xeviant\Paystack\Exception\ValueNotAllowedException;

class Validator
{
    /**
     * @var Collection
     */
    private $parameters;

    /**
     * Sets the required parameters that values will be evaluated against.
     *
     * @param $parameters
     */
    public function setRequiredParameters($parameters): void
    {
        $this->parameters = $parameters instanceof Collection ? $parameters : collect($parameters);
    }

    /**
     * Get Required Parameters.
     *
     * @return Collection
     */
    public function getRequiredParameters(): Collection
    {
        return $this->parameters;
    }

    /**
     * Checks if required parameters are provided.
     *
     * @param array $values
     *
     * @return bool
     */
    public function checkParameters(array $values): bool
    {
        $values = collect($values);

        $this->getRequiredParameters()->each(function ($requiredParam) use ($values) {
            if (!$values->has($requiredParam) || $values->get($requiredParam) === null) {
                throw new MissingArgumentException($requiredParam);
            }
        });

        return true;
    }

    /**
     * Checks for the required parameters.
     *
     * @param $value
     *
     * @throws MissingArgumentException
     *
     * @return bool
     */
    public function checkParameter($value): bool
    {
        if (empty($value) || $value === '' || null === $value) {
            throw new MissingArgumentException($value);
        }

        return true;
    }

    /**
     * @param array $value
     * @param array $options
     *
     * @throws ValueNotAllowedException
     *
     * @return bool
     */
    public function contains(array $value, array $options): bool
    {
        if (!in_array(array_values($value)[0], $options)) {
            throw new ValueNotAllowedException($value, $options);
        }

        return true;
    }
}
