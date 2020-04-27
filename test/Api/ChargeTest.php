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

use Xeviant\Paystack\Api\Charge;

class ChargeTest extends ApiTestCase
{
    const PATH = '/charge';

    /**
     * @test
     */
    public function shouldCharge(): void
    {
        $expectedResult = [
            'data' => [
                'reference'    => '0t4gwo2ft6q0n9h',
                'status'       => 'send_otp',
                'display_text' => 'Please send OTP',
            ],
        ];

        $input = [
            'email'               => 'email@example.com',
            'amount'              => 5000,
            'card.number'         => '5399123456',
            'card.cvv'            => '156',
            'card.expiry_month'   => '12',
            'card.expiry_year'    => '3000',
            'bank.code'           => '156',
            'bank.account_number' => '156234235',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH, $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->charge($input));
    }

    /**
     * @test
     */
    public function shouldSubmitPin(): void
    {
        $expectedResult = [
            'data' => [
                'reference' => '0t4gwo2ft6q0n9h',
                'status'    => 'pending',
            ],
        ];

        $input = [
            'pin'       => '1994',
            'reference' => '0t4gwo2ft6q0n9h',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/submit_pin', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->submitPin($input));
    }

    /**
     * @test
     */
    public function shouldSubmitOtp(): void
    {
        $expectedResult = [
            'data' => [
                'reference' => '0t4gwo2ft6q0n9h',
                'status'    => 'pending',
            ],
        ];

        $input = [
            'otp'       => '199412',
            'reference' => '0t4gwo2ft6q0n9h',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/submit_otp', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->submitOtp($input));
    }

    /**
     * @test
     */
    public function shouldSubmitPhone(): void
    {
        $expectedResult = [
            'data' => [
                'reference' => '0t4gwo2ft6q0n9h',
                'status'    => 'pending',
            ],
        ];

        $input = [
            'phone'     => '08269545481',
            'reference' => '0t4gwo2ft6q0n9h',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/submit_phone', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->submitPhone($input));
    }

    /**
     * @test
     */
    public function shouldSubmitBirthday(): void
    {
        $expectedResult = [
            'data' => [
                'reference' => '0t4gwo2ft6q0n9h',
                'status'    => 'pending',
            ],
        ];

        $input = [
            'birthday'  => '17-9-2001',
            'reference' => '0t4gwo2ft6q0n9h',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/submit_birthday', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->submitBirthday($input));
    }

    /**
     * @test
     */
    public function shouldCheckPendingCharge(): void
    {
        $expectedResult = [
            'data' => [
                'reference' => '0t4gwo2ft6q0n9h',
                'status'    => 'pending',
            ],
        ];

        $reference = '0t4gwo2ft6q0n9h';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/'.$reference)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->checkPendingCharge($reference));
    }

    /**
     * @test
     */
    public function shouldGetTransactionsApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Charge::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Charge::class;
    }
}
