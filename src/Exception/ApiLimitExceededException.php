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

use Throwable;

class ApiLimitExceededException extends RuntimeException
{
    private $reset;
    private $limit;

    /**
     * ApiLimitExceededException constructor.
     *
     * @param int            $limit
     * @param int            $reset
     * @param string         $message
     * @param int            $code
     * @param Throwable|null $previous
     */
    public function __construct($limit = 5000, $reset = 1800, string $message = '', int $code = 0, Throwable $previous = null)
    {
        $this->limit = (int) $limit;
        $this->reset = (int) $reset;

        parent::__construct(sprintf('You have reached Paystack API limit! Limit is: %d', $limit), $code, $previous);
    }

    /**
     * Gets the API Limit.
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Get Reset Time.
     *
     * @return int
     */
    public function getResetTime()
    {
        return $this->reset;
    }
}
