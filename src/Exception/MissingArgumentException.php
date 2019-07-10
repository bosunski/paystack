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

namespace Xeviant\Paystack\Exception;

class MissingArgumentException extends ErrorException
{
    /**
     * MissingArgumentException constructor.
     *
     * @param $required
     * @param int  $code
     * @param null $previous
     */
    public function __construct($required, int $code = 0, $previous = null)
    {
        if (is_string($required)) {
            $required = [$required];
        }

        $word = count($required) > 1 ? 'parameters' : 'parameter';
        parent::__construct(sprintf("Required $word ('%s') is missing!", implode('", "', $required)), $code, $previous);
    }
}
