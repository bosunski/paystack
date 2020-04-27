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

use Xeviant\Paystack\Api\Invoices;

class InvoicesTest extends ApiTestCase
{
    const PATH = '/paymentrequest';

    /**
     * @test
     */
    public function shouldGetInvoice(): void
    {
        $expectedResult = ['data' => ['integration' => 900713]];
        $invoiceId = 'xb2der';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/'.$invoiceId)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->fetch($invoiceId));
    }

    /**
     * @test
     */
    public function shouldGetInvoiceTotals(): void
    {
        $expectedResult = ['data' => ['totals' => 900713]];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/totals')
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->totals());
    }

    /**
     * @test
     */
    public function shouldVerifyInvoice(): void
    {
        $expectedResult = ['data' => ['transactions' => []]];
        $invoiceId = 'xb2der';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/verify/'.$invoiceId)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->verify($invoiceId));
    }

    /**
     * @test
     */
    public function shouldNotify(): void
    {
        $expectedResult = ['data' => ['integration' => 900713]];
        $invoiceId = 'xb2der';
        $input = [];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/notify/'.$invoiceId, $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->notify($invoiceId, $input));
    }

    /**
     * @test
     */
    public function shouldFinalizeInvoice(): void
    {
        $expectedResult = ['data' => ['integration' => 900713]];
        $invoiceId = 'xb2der';
        $input = [];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/finalize/'.$invoiceId, $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->finalize($invoiceId, $input));
    }

    /**
     * @test
     */
    public function shouldArchiveInvoice(): void
    {
        $expectedResult = [];
        $invoiceId = 'xb2der';
        $input = [];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/archive/'.$invoiceId, $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->archive($invoiceId, $input));
    }

    /**
     * @test
     */
    public function shouldInvoiceAsPaid(): void
    {
        $expectedResult = ['message' => 'Payment request marked as paid'];
        $invoiceId = 'xb2der';
        $input = [
            'amount_paid'    => 5000,
            'paid_by'        => 'email@example.com',
            'payment_date'   => '12-12-2012',
            'payment_method' => 'Cash',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH.'/mark_as_paid/'.$invoiceId, $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->markAsPaid($invoiceId, $input));
    }

    /**
     * @test
     */
    public function shouldGetInvoices(): void
    {
        $expectedResult = collect(['data' => [['id' => 900713]]]);

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->list());
    }

    /**
     * @test
     */
    public function shouldCreateInvoice(): void
    {
        $expectedResult = ['data' => ['id' => 90713]];
        $input = [
            'tax'         => [],
            'customer'    => 'CUS_x123',
            'due_date'    => '2017-05-08',
            'line_items'  => [],
            'amount'      => 5000,
            'description' => 'An Invoice',
        ];

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('post')
            ->with(self::PATH, $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->create($input));
    }

    /**
     * @test
     */
    public function shouldUpdateInvoice(): void
    {
        $input = ['description' => 'Example description'];
        $expectedResult = ['data' => ['description' => 'Example description']];
        $invoiceId = '3x_x123';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with(self::PATH."/$invoiceId", $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->update($invoiceId, $input));
    }

    /**
     * @test
     */
    public function shouldGetTransactionsApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Invoices::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Invoices::class;
    }
}
