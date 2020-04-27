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

use Illuminate\Support\Collection;
use Xeviant\Paystack\Api\Transfers;

class TransfersTest extends ApiTestCase
{
    const PATH = '/transfer';

    /**
     * @test
     */
    public function shouldGetTransfer(): void
    {
        $expectedResult = ['data' => ['recipient' => []]];
        $transferId = 'TRF_2x5j67tnnw1t98k';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/'.$transferId)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->fetch($transferId));
    }

    /**
     * @test
     */
    public function shouldGetTransfers(): void
    {
        $attributes = ['integration' => 900713];

        $finalResult = Collection::make([
            $this->createApplication()->makeModel('transfer', ['attributes' => $attributes]),
        ]);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH)
            ->willReturn($finalResult);

        $this->assertEquals($finalResult, $api->list());
    }

    /**
     * @test
     */
    public function shouldInitiateTransfer(): void
    {
        $expectedResult = ['data' => ['integration' => 673243]];
        $input = [
            'source'    => 'balance',
            'amount'    => 5000,
            'recipient' => 'RCP_gx2wn530m0i3w3m',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH, $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->initiate($input));
    }

    /**
     * @test
     */
    public function shouldInitiateBulkTransfer(): void
    {
        $expectedResult = ['data' => ['integration' => 673243]];
        $input = [
            'source'    => 'balance',
            'transfers' => [
                'amount'    => 5000,
                'recipient' => 'RCP_gx2wn530m0i3w3m',
            ],
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/bulk', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->bulk($input));
    }

    /**
     * @test
     */
    public function shouldFinalizeTransfer(): void
    {
        $expectedResult = [];
        $input = [
            'otp'           => '928783',
            'transfer_code' => 'TRF_vsyqdmlzble3uii',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/finalize_transfer', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->finalize($input));
    }

    /**
     * @test
     */
    public function shouldResendOtp(): void
    {
        $expectedResult = ['message' => 'OTP has been resent'];
        $input = [
            'reason'        => 'This is a reason',
            'transfer_code' => 'TRF_vsyqdmlzble3uii',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/resend_otp', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->resendOtp($input));
    }

    /**
     * @test
     */
    public function shouldResendDisableOtp(): void
    {
        $expectedResult = ['message' => 'OTP has been sent to mobile number ending with 4321'];
        $input = [];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/disable_otp', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->disableOtp($input));
    }

    /**
     * @test
     */
    public function shouldResendEnableOtp(): void
    {
        $expectedResult = ['message' => 'OTP requirement for transfers has been enabled'];
        $input = [];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/enable_otp', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->enableOtp($input));
    }

    /**
     * @test
     */
    public function shouldResendDisableOtpAndFinalize(): void
    {
        $expectedResult = ['message' => 'OTP requirement for transfers has been disabled'];
        $input = [
            'otp' => '888345',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/disable_otp_finalize', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->disableOtpFinalize($input));
    }

    /**
     * @test
     */
    public function shouldGetTransactionsApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Transfers::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Transfers::class;
    }
}
