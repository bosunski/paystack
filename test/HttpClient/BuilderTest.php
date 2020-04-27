<?php

namespace Xeviant\Paystack\Tests\HttpClient;

use Http\Client\Common\Plugin\HeaderAppendPlugin;
use PHPUnit\Framework\TestCase;
use Xeviant\Paystack\HttpClient\Builder;

final class BuilderTest extends TestCase
{
    /**
     * @test
     */
    public function shouldClearHeaders(): void
    {
        $builder = $this->getMockBuilder(Builder::class)
            ->setMethods(['addPlugin', 'removePlugin'])
            ->getMock();

        $builder->expects($this->once())
            ->method('removePlugin')
            ->with(HeaderAppendPlugin::class);

        $builder->clearHeaders();
    }

    /**
     * @test
     */
    public function shouldAddHeaders(): void
    {
        $headers = ['Header1', 'Header2'];

        $client = $this->getMockBuilder(Builder::class)
            ->setMethods(['addPlugin', 'removePlugin'])
            ->getMock();
        $client->expects($this->once())
            ->method('addPlugin')
            ->with($this->isInstanceOf(HeaderAppendPlugin::class));
        $client->expects($this->once())
            ->method('removePlugin')
            ->with(HeaderAppendPlugin::class);

        $client->addHeaders($headers);
    }

    /**
     * @test
     */
    public function appendingHeaderShouldAddAndRemovePlugin(): void
    {
        $expectedHeaders = [
            'Accept' => 'application/json',
        ];

        $client = $this->getMockBuilder(Builder::class)
                       ->setMethods(['removePlugin', 'addPlugin'])
                       ->getMock();

        $client->expects($this->once())
               ->method('removePlugin')
               ->with(HeaderAppendPlugin::class);

        $client->expects($this->once())
               ->method('addPlugin')
               ->with(new HeaderAppendPlugin($expectedHeaders));

        $client->addHeaderValue('Accept', 'application/json');
    }
}
