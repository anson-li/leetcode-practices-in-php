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
                // Testing a 0 quantity item
                'zipcode' => '90210',
                'items' => [1 => 1, 2 => 0],
                'expected' => 10.00,
            ],
            [
                // Testing multiple items
                'zipcode' => '90210',
                'items' => [1 => 1, 2 => 1],
                'expected' => 10.00,
            ],
            [
                // Testing an oversized single item
                'zipcode' => '90210',
                'items' => [1 => 200],
                'expected' => 10.00,
            ],
            [
                // Testing multiple large items
                'zipcode' => '90210',
                'items' => [0 => 20, 1 => 20, 2 => 20],
                'expected' => 38.00,
            ],
        ];
    }

    /**
     * @dataProvider parametersDataProvider
     */
    public function testShippingTrees(string $zipcode, array $items, float $expected)
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
    public function testShippingTreesShouldErrorIfBadZipCode(string $zipcode, array $items)
    {
        $shippingTrees = new ShippingTrees();
        $shippingTrees->solve($items, $zipcode);
    }
}
