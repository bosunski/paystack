<?php

namespace Xeviant\Paystack\Test\HttpClient;

use Http\Client\Common\Plugin\HeaderAppendPlugin;
use PHPUnit\Framework\TestCase;
use Xeviant\Paystack\HttpClient\Builder;

final class BuilderTest extends TestCase
{
	/**
	 * @test
	 */
	public function shouldClearHeaders()
	{
		$builder = $this->getMockBuilder(Builder::class)
			->setMethods(['addPlugin', 'removePlugin'])
			->getMock();

		$builder->expects(self::once())
			->method('removePlugin')
			->with( HeaderAppendPlugin::class);

		$builder->clearHeaders();
	}

	/**
	 * @test
	 */
	public function shouldAddHeaders()
	{
		$headers = ['Header1', 'Header2'];

		$client = $this->getMockBuilder(Builder::class)
			->setMethods(['addPlugin', 'removePlugin'])
			->getMock();
		$client->expects(self::once())
			->method('addPlugin')
			->with(self::isInstanceOf(HeaderAppendPlugin::class));
		$client->expects(self::once())
			->method('removePlugin')
			->with(HeaderAppendPlugin::class);

		$client->addHeaders($headers);
	}

	/**
	 * @test
	 */
	public function appendingHeaderShouldAddAndRemovePlugin()
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