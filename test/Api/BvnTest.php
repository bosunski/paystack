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

namespace Xeviant\Paystack\Tests\Api;

use Xeviant\Paystack\Api\Bvn;

class BvnTest extends ApiTestCase
{
    const PATH = '/bank';

    /**
     * @test
     */
    public function shouldResolveBvn(): void
    {
        $expectedResult = ['data' => ['first_name' => 'WES']];
        $bvn = '21212917741';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/resolve_bvn/'.$bvn)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->resolve($bvn));
    }

    /**
     * @test
     */
    public function shouldResolveCardBin(): void
    {
        $expectedResult = ['data' => ['brand' => 'Mastercard']];
        $bin = '539983';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/decision/bin/'.$bin)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->resolveCardBin($bin));
    }

    /**
     * @test
     */
    public function shouldResolveAccountNumber(): void
    {
        $expectedResult = ['data' => ['first_name' => 'WES']];
        $accountDetails = [
            'account_number' => '21212917741',
            'bank_code'      => '056',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/resolve?'.http_build_query($accountDetails))
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->resolveAccountNumber($accountDetails));
    }

    /**
     * @test
     */
    public function shouldResolvePhoneNumber(): void
    {
        $expectedResult = ['data' => ['requestId' => 'zLXHzm_DqHcv09ghFQuLfBQ81Cs']];
        $input = [
            'verification_type' => '21212917741',
            'phone'             => '056213456',
            'callback_url'      => 'https://example.com/callback',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/verifications', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->resolvePhoneNumber($input));
    }

    /**
     * @test
     */
    public function shouldGetBvnApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Bvn::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Bvn::class;
    }
}
