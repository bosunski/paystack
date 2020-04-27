<?php
/**
 * This file is part of the Xeviant Paystack package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @version         1.0
 *
 * @author          Olatunbosun Egberinde
 * @license         MIT Licence
 * @copyright       (c) Olatunbosun Egberinde <bosunski@gmail.com>
 *
 * @link            https://github.com/bosunski/paystack
 */

namespace Xeviant\Paystack\Tests\Api;

use Illuminate\Support\Collection;
use Xeviant\Paystack\Api\Transactions;

class TransactionsTest extends ApiTestCase
{
    /**
     * @test
     */
    public function shouldVerifyTransactions(): void
    {
        $reference = 'DG4uishudoq90LD';
        $expectedResult = ['data' => ['amount' => 50000]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/transaction/verify/'.$reference)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->verify($reference));
    }

    /**
     * @test
     */
    public function shouldChargeReturningCustomer(): void
    {
        $input = [
            'amount'             => 20000,
            'email'              => 'customer@email.com',
            'reference'          => '0bxco8lyc2aa0fq',
            'authorization_code' => 'AUTH_72btv547',
        ];

        $expectedResult = ['data' => ['amount' => 5000]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/transaction/charge_authorization', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->charge($input));
    }

    /**
     * @test
     */
    public function shouldInitializeTransaction(): void
    {
        $input = [
            'reference' => '7PVGX8MEk85tgeEpVDtD',
            'amount'    => 500000,
            'email'     => 'customer@email.com',
        ];

        $expectedResult = ['data' => ['authorization_url' => 'https://checkout.paystack.com/0peioxfhpn']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/transaction/initialize', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->initialize($input));
    }

    /**
     * @test
     */
    public function shouldListTransactions()
    {
        $attributes = ['authorization_url' => 'https://checkout.paystack.com/0peioxfhpn'];

        $finalResult = Collection::make([
            $this->createApplication()->makeModel('transaction', ['attributes' => $attributes]),
        ]);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/transaction')
            ->willReturn($finalResult);

        $this->assertEquals($finalResult, $api->list());
    }

    /**
     * @test
     */
    public function shouldGetTransaction(): void
    {
        $expectedResult = ['data' => ['email' => 'email@example.com']];
        $id = 123;

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/transaction/'.$id)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->fetch($id));
    }

    /**
     * @test
     */
    public function shouldGetTransactionTimeline(): void
    {
        $expectedResult = ['data' => ['time_spent' => 900]];
        $id = 'x123';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/transaction/timeline/'.$id)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->timeline($id));
    }

    /**
     * @test
     */
    public function shouldGetTransactionTotals(): void
    {
        $expectedResult = ['data' => ['total_transactions' => 900]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/transaction/totals')
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->totals());
    }

    /**
     * @test
     */
    public function shouldExportTransactions(): void
    {
        $expectedResult = ['data' => ['path' => 'https://example.com/file.csv']];
        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with('/transaction/export')
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->export());
    }

    /**
     * @test
     */
    public function shouldRequestReauthorization(): void
    {
        $input = [
            'authorization_code' => '7PVGX8MEk85tgeEpVDtD',
            'amount'             => 500000,
            'email'              => 'customer@email.com',
        ];

        $expectedResult = ['data' => ['reauthorization_url' => 'https://checkout.paystack.com/0peioxfhpn']];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/transaction/request_reauthorization', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->reauthorize($input));
    }

    /**
     * @test
     */
    public function shouldCheckAuthorization(): void
    {
        $input = [
            'authorization_code' => '7PVGX8MEk85tgeEpVDtD',
            'amount'             => 500000,
            'email'              => 'customer@email.com',
        ];

        $expectedResult = ['data' => ['amount' => 400]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with('/transaction/check_authorization', $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->checkAuthorization($input));
    }

    /**
     * @test
     */
    public function shouldGetTransactionsApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Transactions::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Transactions::class;
    }
}
