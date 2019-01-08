<?php

namespace Ansonli\LeetCode\Tests\Exercise010;

use Ansonli\LeetCode\Exercise010\ShippingTrees;
use Ansonli\LeetCode\Tests\TestCase;

class ShippingTreesTest extends TestCase
{

    public function parametersDataProvider() : array
    {
        return [
            [
                // Shipping one item id 1
                'zipcode' => '90210',
                'items' => [1 => 1],
                'expected' => 10.00,
            ],
            [
                'zipcode' => '90210',
                'items' => [1 => 1, 2 => 0],
                'expected' => 10.00,
            ],
        ];
    }

    /**
     * @dataProvider parametersDataProvider
     */
    public function testShippingTreesConversion(string $zipcode, array $items, float $expected)
    {
        $shippingTrees = new ShippingTrees();
        $this->assertSame($expected, $shippingTrees->solve($items, $zipcode));
    }

    public function badZipCodeDataProvider() : array
    {
        return [
            [
                'zipcode' => 'T6K 3S9',
                'items' => [1 => 1],
            ],
        ];
    }

    /**
     * @dataProvider badZipCodeDataProvider
     * @expectedException \Exception
     */
    public function testShippingTreesConversionShouldErrorIfBadZipCode(string $zipcode, array $items)
    {
        $shippingTrees = new ShippingTrees();
        $shippingTrees->solve($items, $zipcode);
    }
}
