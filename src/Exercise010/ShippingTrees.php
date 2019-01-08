<?php

namespace Ansonli\LeetCode\Exercise010;

use AnsonLi\LeetCode\Exercise010;
use Exception;

class ShippingTrees
{

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
        $zipCode = $zipCodeProcessor->normalizeAndValidate($zipCode);
        if (!$zipCode) {
            throw new Exception('Invalid postal code, please try again.');
        }

        // Initialize variables here - future improvement would be to move this to the db to query.
        $boxes = [
            0 => new ShippingBox(10, 1.0, 1.0, 10, 10.00),
            1 => new ShippingBox(12, 1.5, 1.5, 15, 15.00),
            2 => new ShippingBox(13, 2.0, 2.0, 20, 18.00),
        ];
        $usedBoxes = [];

        // Sort boxes descending
        usort($boxes, [__CLASS__, 'boxComparison']);

        // Gets the largest box - reference: https://stackoverflow.com/a/41795859
        $largestBox = end($boxes); 
        reset($boxes);

        // Sample item array: 
        // [1 => 10, 2 => 2], meaning a quantity of 10 for item 1 and a quantity of 2 for item 2
        foreach ($items as $id => $quantity) {
            if ($quantity > 0) {
                $itemMass[$id] = $this->calculateSizeandWeight($id, $quantity, $largestBox->getVolume());
            }
        }

        // Restructure oversized items presented
        foreach ($itemMass as $id => $item)
        {
            // Break down box into multiple components
            while ($itemMass[$id]['size'] === 'oversized') 
            {
                $usedBox = $largestBox;
                $requiredQuantity = $item['item']->getMaxQuantityPerBox($usedBox->volume, $usedBox->weight);
                // Subtract quantity from the previous item bundle
                $subtractedVolume = $item['item']->calculateMultipleVolume($requiredQuantity);
                $subtractedWeight = $item['item']->calculateMultipleWeight($requiredQuantity);
                $itemMass[$id]['volume'] -= $subtractedVolume;
                $itemMass[$id]['weight'] -= $subtractedWeight;
                // Fill box with said quantity 
                $usedBox->fillBox($item['item'], $subtractedVolume, $subtractedWeight, 'large');
                $usedBoxes[] = $usedBox;
                // Recalculate remaining size
                $itemMass[$id]['size'] = $this->calculateItemCategory($itemMass[$id]['volume'], $largestBox->getVolume());
            }
        }

        // Sort itemMass by volume first - largest to smallest
        usort($itemMass, [__CLASS__, 'itemComparison']);
       
        // Allot a bin for each large item, ordered largest to smallest.
        foreach ($itemMass as $id => $item) 
        {
            if ($item['size'] === 'large')
            {
                $usedBox = $largestBox;
                if ($usedBox->canFit($item['volume'], $item['weight'])) 
                {
                    $usedBox->fillBox($item['item'], $item['volume'], $item['weight'], $item['size']);
                    unset($itemMass[$id]);
                    $usedBoxes[] = $usedBox;
                }
            }
        }
        
        // Proceed forward through the bins. On each: If the smallest remaining medium item does not fit, skip this bin. Otherwise, place the largest remaining medium item that fits.
        foreach ($usedBoxes as $usedBox)
        {
            for ($i = count($itemMass) - 1; $i >= 0; $i--) 
            {
                if ($itemMass[$i]['size'] === 'medium') 
                {
                    if ($usedBox->canFit($item['volume'], $item['weight']))
                    {
                        $usedBox->fillBox($item['item'], $item['volume'], $item['weight'], $item['size']);
                        unset($itemMass[$i]);
                    } 
                }
            }
        }
        
        // Proceed backward through those bins that do not contain a medium item. On each: If the two smallest remaining small items do not fit, skip this bin. Otherwise, place the smallest remaining small item and the largest remaining small item that fits.
        $smallItems = array_values(array_filter($itemMass, [__CLASS__, 'filterSmall']));
        for ($i = count($usedBoxes) - 1; $i >= 0; $i--) 
        {
            if (!$usedBox->hasMediumItem()) 
            {
                // Check that the two smallest remaining small items fit
                $minimumRequiredVolume = $smallItems[count($smallItems) - 1]['volume'] + $smallItems[count($smallItems) - 2]['volume'];
                $minimumRequiredWeight = $smallItems[count($smallItems) - 1]['weight'] + $smallItems[count($smallItems) - 2]['weight'];
                if ($usedBox->canFit($minimumRequiredVolume, $minimumRequiredWeight))
                {
                    for ($j = 0; $j < count($smallItems - 1); $j--) 
                    {
                        $volume = $smallItems[count($smallItems) - 1]['volume'] + $smallItems[$j]['volume'];
                        $weight = $smallItems[count($smallItems) - 1]['weight'] + $smallItems[$j]['weight'];
                        if ($usedBox->canFit($volume, $weight)) {
                            $usedBox->fillBox($smallItems[$j]['item'], $smallItems[$j]['volume'], $smallItems[$j]['weight'], $smallItems[$j]['size']);
                            $usedBox->fillBox($smallItems[count($smallItems) - 1]['item'], $smallItems[count($smallItems) - 1]['volume'], $smallItems[count($smallItems) - 1]['weight'], $smallItems[count($smallItems) - 1]['size']);
                            // Unset the variables from the smaller array
                            unset($smallItems[$j]);
                            unset($smallItems[count($smallItems) - 1]);
                            // Unset the variables from the larger array
                            $itemMass = $this->unsetByValue($itemMass, $smallItems[$j]['item'], $smallItems[$j]['volume']);
                            $itemMass = $this->unsetByValue($itemMass, $smallItems[count($smallItems) - 1]['item'], $smallItems[count($smallItems) - 1]['volume']);
                            break;
                        }
                    }
                } 
            }
        }

        // Proceed forward through all bins. If the smallest remaining item of any size class does not fit, skip this bin. Otherwise, place the largest item that fits and stay on this bin.
        foreach ($usedBoxes as $usedBox)
        {
            if ($usedBox->canFit($itemMass[count($itemMass) - 1]['volume'], $itemMass[count($itemMass) - 1]['weight'])) 
            {
                foreach ($itemMass as $id => $item) 
                {
                    if ($usedBox->canFit($item['volume'], $item['weight']))
                    {
                        $usedBox->fillBox($item['item'], $item['volume'], $item['weight'], $item['size']);
                        unset($itemMass[$id]);
                    }
                }
            }
        }

        // Use FFD to pack the remaining items into new bins.
        foreach ($itemMass as $id => $item) 
        {
            $isFilled = false;
            foreach ($usedBoxes as $usedBox)
            {
                if ($usedBox->canFit($item['volume'], $item['weight']))
                {
                    $usedBox->fillBox($item['item'], $item['volume'], $item['weight'], $item['size']);
                    unset($itemMass[$id]);
                    $isFilled = true;
                    break;
                }
            }
            // If remaining items are available, then add into new boxes
            if (!$isFilled)
            {
                $usedBox = $largestBox;
                $usedBox->fillBox($item['item'], $item['volume'], $item['weight'], $item['size']);
                unset($itemMass[$id]);
                $usedBoxes[] = $usedBox;
            }
        }

        // Find the 'best match box' for each bin, retrofitting smaller boxes if required
        foreach ($usedBoxes as $key => $usedBox)
        {
            foreach ($boxes as $boxTemplate)
            {
                if ($boxTemplate->canFit($usedBox->usedVolume, $usedBox->usedWeight)) 
                {
                    $usedBox->resizeBox($boxTemplate);
                    $usedBoxes[$key] = $usedBox;
                }
            }
        }

        // Calculate the sum total of all boxes used
        $sumCost = 0;
        foreach ($usedBoxes as $usedBox)
        {
            $sumCost += $usedBox->cost;
        }

        return $sumCost;
    }

    public function unsetByValue(array $items, ShippingItem $itemToRemove, float $volume) : array
    {
        foreach ($items as $key => $value)
        {
            if ($value['item'] === $itemToRemove && $value['volume'] === $volume)
            {
                unset($items[$key]);
                return true;
            }
        }
        return false;
    }

    private static function filterSmall($item)
    {
        return ($item['size'] === 'small');
    }

    /**
     * Compares items according to volume, descending. 
     */
    private static function itemComparison($a, $b) 
    {
        return $a['volume'] < $b['volume'];
    }

    /**
     * Compares box according to volume, ascending. 
     */
    private static function boxComparison($a, $b) 
    {
        return $a->getVolume() > $b->getVolume();
    }

    /**
     * Calculate the size and weight of an item given its quantity. 
     * Use a metric to decide what's a 'large item', 'medium item' and 'small item' by identifying volume percentage to the largest box volume
     * TODO: Add DB getter using PDO, add check to see if ID is in the set of itemInformation (currently assumed)
     *
     * @return array An array containing the volume and mass.
     */
    protected function calculateSizeandWeight(int $id, int $quantity, float $maxBoxVolume) : array
    {
        $values = [];
        $itemInformation = [
            0 => new ShippingItem(10, 0.1, 0.2, 0.1, 4, 4, 0.4, 2.5),
            1 => new ShippingItem(8, 0.3, 0.1, 0.1, 5, 5, 0.4, 2.5),
            2 => new ShippingItem(9, 0.1, 0.1, 0.1, 3, 3, 0.4, 2.5),
        ];
        foreach ($itemInformation as $key => $item) 
        {
            if ($key === $id)
            {
                $values['item'] = $itemInformation[$key];
                if ($quantity === 1)
                {
                    $values['volume'] = $item->calculateSingleVolume();
                    $values['weight'] = $item->calculateSingleWeight();
                } 
                else
                {
                    $values['volume'] = $item->calculateMultipleVolume($quantity);
                    $values['weight'] = $item->calculateMultipleWeight($quantity);
                }
            }
        }
        $values['size'] = $this->calculateItemCategory($values['volume'], $maxBoxVolume);
        return $values;
    }

    function calculateItemCategory(float $volume, float $maxBoxVolume) : string
    {
        $percentageVolume = $volume / $maxBoxVolume;
        if ($percentageVolume > 1) {
            $category = 'oversized';
        } else if ($percentageVolume > 0.5) {
            $category = 'large';
        } else if ($percentageVolume > 0.333) {
            $category = 'medium';
        } else if ($percentageVolume > 0.166) {
            $category = 'small';
        } else {
            $category = 'tiny';
        }

        return $category;
    }
 
}