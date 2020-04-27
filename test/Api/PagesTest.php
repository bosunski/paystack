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
use Xeviant\Paystack\Api\Pages;

class PagesTest extends ApiTestCase
{
    const PATH = '/page';

    /**
     * @test
     */
    public function shouldGetPaymentPage(): void
    {
        $expectedResult = ['data' => ['integration' => 900713]];
        $id = 'xb2der';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/'.$id)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->fetch($id));
    }

    /**
     * @test
     */
    public function shouldCheckSlugAvailability(): void
    {
        $expectedResult = ['data' => ['message' => 'Slug is available']];
        $slug = 'xb2der';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('get')
            ->with(self::PATH.'/check_slug_availability/'.$slug)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->checkSlugAvailability($slug));
    }

    /**
     * @test
     */
    public function shouldGetPaymentPages(): void
    {
        $attributes = ['integration' => 900713];

        $finalResult = Collection::make([
            $this->createApplication()->makeModel('page', ['attributes' => $attributes]),
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
    public function shouldCreatePage(): void
    {
        $expectedResult = ['data' => ['integration' => 90713]];
        $input = [
            'name'        => 'Name',
            'amount'      => 5000,
            'description' => 'Description',
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
    public function shouldUpdatePage(): void
    {
        $input = ['name' => 'Example Name 2'];
        $expectedResult = ['data' => ['name' => 'Example Name 2']];
        $pageId = '3x_x123';

        $api = $this->getApiMock();
        $api->expects($this->once())
            ->method('put')
            ->with(self::PATH."/$pageId", $input)
            ->willReturn($expectedResult);

        $this->assertEquals($expectedResult, $api->update($pageId, $input));
    }

    /**
     * @test
     */
    public function shouldGetTransactionsApiObject(): void
    {
        $api = $this->getApiMock();

        $this->assertInstanceOf(Pages::class, $api);
    }

    /**
     * @return string
     */
    protected function getApiClass(): string
    {
        return Pages::class;
    }
}
