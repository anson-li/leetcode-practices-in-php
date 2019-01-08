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
                // Shiping one item id 1 and one item id 2
                'zipcode' => '90210',
                'items' => [1 => 1],
                'expected' => 10.00,
            ],
        ];
    }

    /**
     * @dataProvider parametersDataProvider
     */
    public function testShippingTreesConversion(string $zipcode, array $items, string $expected)
    {
        $shippingTrees = new ShippingTrees();
        $this->assertSame($expected, $shippingTrees->solve($items, $zipcode));
    }
}
