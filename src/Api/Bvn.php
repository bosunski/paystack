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
 * @copyright        (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link             https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\Api;

class Bvn extends AbstractApi
{
    const BASE_PATH = '/bank';

    /**
     * Resolves a Bank Verification Number.
     *
     * @param $bvn
     *
     * @throws \Http\Client\Exception
     * @throws \Xeviant\Paystack\Exception\MissingArgumentException
     *
     * @return array|string
     */
    public function resolve($bvn)
    {
        if ($this->validator->checkParameter($bvn)) {
            return $this->get(self::BASE_PATH."/resolve_bvn/$bvn");
        }
    }

    /**
     * Resolves a Card BIN.
     *
     * @param $bin
     *
     * @throws \Http\Client\Exception
     * @throws \Xeviant\Paystack\Exception\MissingArgumentException
     *
     * @return array|string
     */
    public function resolveCardBin($bin)
    {
        if ($this->validator->checkParameter($bin)) {
            return $this->get("/decision/bin/$bin");
        }
    }

    /**
     * Resolves an Account Number.
     *
     * @param $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function resolveAccountNumber($parameters)
    {
        $this->validator->setRequiredParameters([]);
        if ($this->validator->checkParameters($parameters)) {
            return $this->get(self::BASE_PATH.'/resolve?'.http_build_query($parameters));
        }
    }

    /**
     * Resolves a Phone Number.
     *
     * @param $parameters
     *
     * @throws \Http\Client\Exception
     *
     * @return array|string
     */
    public function resolvePhoneNumber($parameters)
    {
        $this->validator->setRequiredParameters(['verification_type', 'phone', 'callback_url']);
        if ($this->validator->checkParameters($parameters)) {
            return $this->post('/verifications', $parameters);
        }
    }
}
