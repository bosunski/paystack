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

require "vendor/autoload.php";

$paystack = new Xeviant\Paystack\Paystack('pk_test_36dc4b43cff51a514fd4614052df39cfb3e534bc', 'sk_test_def568ce5a86bf98b1c2f199e90e4b990bbed2fa');

var_dump($paystack->customer()->list());
