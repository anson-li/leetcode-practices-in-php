<?php

namespace Ansonli\LeetCode\Exercise010;

use AnsonLi\LeetCode\Exercise010\ShippingBox;
use Ansonli\LeetCode\Exercise010\USAZipCode;
use Ansonli\LeetCode\Exercise010\USAZipCodeValidator;

class ShippingTrees
{

    private zipCode = null;

    public boxes = [
        // needs to be sorted largest to smallest
        1 => new ShippingBox(1.0, 1.0, 1.0, 10, 10.00);
        2 => new ShippingBox();
    ];

    public itemInformation = [
        1 => new ShippingItem(10, 0.1, 0.2, 4, 4, 0.4, 2.5);
        2 => new ShippingItem(8, 0.3, 0.1, 5, 5, 0.4, 2.5);
        3 => new ShippingItem(9, 0.1, 0.1, 3, 3, 0.4, 2.5);
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
            // Sort itemMass by volume first, and mass second - largest to smallest
            // Then, use a metric to decide what's a 'large item', 'medium item' and 'small item' by identifying volume percentage to the largest box volume
            // Proceed forward through the bins. On each: If the smallest remaining medium item does not fit, skip this bin. Otherwise, place the largest remaining medium item that fits.
            // Proceed backward through those bins that do not contain a medium item. On each: If the two smallest remaining small items do not fit, skip this bin. Otherwise, place the smallest remaining small item and the largest remaining small item that fits.
            // Proceed forward through all bins. If the smallest remaining item of any size class does not fit, skip this bin. Otherwise, place the largest item that fits and stay on this bin.
            // Use FFD to pack the remaining items into new bins.
            // Find the 'best match box' for each bin, retrofitting smaller boxes if required
        }

    }

    /**
     * Calculate the size and weight of an item given its quantity. 
     * TODO: Add DB getter using PDO.
     *
     * @return array An array containing the volume and mass.
     */
    protected function calculateSizeandWeight(int $id, int $quantity) : array
    {
        $values = [];
        foreach ($itemInformation as $key => $item) 
        {
            if ($itemInformation[$key] === $id)
            {
                if ($quantity === 1)
                {
                    $values['valume'] = $item=>calculateSingleVolume();
                    $values['weight'] = $item->calculateSingleWeight();
                } 
                else
                {
                    $values['volume'] = $item->calculateMultipleVolume($quantity);
                    $values['weight'] = $item->calculateMultipleWeight($quantity);
                }
            } 
        }

        return $values;
    }
 
}