<?php

namespace Ansonli\LeetCode\Exercise010;

use AnsonLi\LeetCode\Exercise010\ShippingBox;
use Ansonli\LeetCode\Exercise010\USAZipCode;
use Ansonli\LeetCode\Exercise010\USAZipCodeValidator;

class ShippingTrees
{

    private zipCode = null;

    $boxes = [
        1 => new ShippingBox(1.0, 1.0, 1.0, 10, 10.00);
        2 => new ShippingBox();
    ];

    /**
     * Calculates the shipping cost of trees provided with iDs and a postal code.
     *
     * @param  array    $items          A list of items and their quantities to be calculated.
     * @param  string   $zipCode        A zip code to be validated and processed.
     * 
     * @return int        The cost to ship the package containing the items.
     * @throws Exception  When the postal code is invalid, when the item array is empty, or if an excessive amount of items are presented.
     */
    public function solve(array $items, string $zipCode) : int
    {
        $zipCodeProcessor = new USAZipCode();
        $this->zipCode = zipCodeProcessor->validateAndProcess($zipCode);
        if (!$this->zipCode) {
            throw new Exception('Invalid postal code, please try again.');
        }

        // Sample item array: 
        // [1 => 10, 2 => 2], meaning a quantity of 10 for item 1 and a quantity of 2 for item 2
        foreach ($items as $id => $quantity) {
            $itemMass[$id] = $this->calculateSizeandWeight($id, $quantity);
        }

    }

    /**
     * Calculate 
     */
    protected function calculateSizeandWeight(int $id, int $quantity) : array
    {

    }
 
}