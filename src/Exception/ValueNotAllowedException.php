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

class ValueNotAllowedException extends ErrorException
{
    /**
     * ValueNotAllowedException constructor.
     *
     * @param $value
     * @param $options
     * @param int  $code
     * @param null $previous
     */
    public function __construct($value, $options, int $code = 0, $previous = null)
    {
        $key = array_keys($value)[0];
        $message = sprintf("The parameter '%s' only support options of %s, you provided '%s' which is not part of the options.", $key, '['.implode(', ', $options).']', array_values($value)[0]);
        parent::__construct($message, $code, $previous);
    }
}
