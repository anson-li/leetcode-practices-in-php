<?php

namespace Ansonli\LeetCode\Exercise010;

class ShippingBox 
{
    private $length, $width, $height, $remainingWeight, $remainingVolume, $storedItems;
    public $usedVolume = 0, $usedWeight = 0, $volume, $weight, $cost;

    /** 
     * Constructs a box object for calculating used size, remaining size, and cost.
     *
     * @param float $length The length of the box.
     * @param float $width  The width of the box.
     * @param float $height The height of the box.
     * @param float $weight The maximum weight the box can carry.
     * @param float $cost   The cost of the box for shipping. Will be replaced by CanadaPost cost calculations once adapted. 
     */
    function __construct(float $length, float $width, float $height, float $weight, float $cost)
    {
        $this->length = $length;
        $this->width = $width;
        $this->height = $height; 
        $this->cost = $cost;
        $this->weight = $weight;

        $this->volume = $length * $width * $height;
        $this->remainingVolume = $this->volume;
        $this->remainingWeight = $weight;

        $this->storedItems = [];
    }

    /**
     * Resizes the box according to a new box's specifications.
     * Used when swapping from the largest box to a smaller box after MFFD calculations.
     *
     * @param ShippingBox $box The reference box to pull the new values from.
     */
    function resizeBox(ShippingBox $box) 
    {
        $this->length = $box->length;
        $this->width = $box->width;
        $this->height = $box->height; 
        $this->cost = $box->cost;
        $this->weight = $box->weight;

        $this->volume = $box->length * $box->width * $box->height;
        $this->remainingVolume = $box->volume - $this->usedVolume;
        $this->remainingWeight = $box->weight - $this->usedWeight;
    } 

    /** 
     * Fills each box with the volume and weight of each item. Returns a boolean identifying whether or 
     * not the 'fill' was successful.
     *
     * @param float $length
     * @param float $width
     * @param float $height
     *
     * @return bool 
     */
    function fillBox(ShippingItem $item, float $volume, float $weight, string $size) : bool
    {
        $this->storedItems[] = [
            'item' => $item,
            'size' => $size,
        ];
        $this->remainingVolume -= $volume;
        $this->usedVolume += $volume;

        $this->remainingWeight -= $weight;
        $this->usedWeight += $weight;
        return true;
    }

    /** 
     * Checks whether or not the box can fit the volume and the weight requested.
     *
     * @param float $volume
     * @param float $weight
     *
     * @return bool 
     */
    function canFit(float $volume, float $weight) : bool
    {
        return ($this->remainingVolume >= $volume && $this->remainingWeight >= $weight);
    }

    /** 
     * Checks whether or not the box currently contains an item that is of 'medium' size.
     *
     * @return bool 
     */
    function hasMediumItem() : bool
    {
        foreach ($this->storedItems as $item) {
            if ($item['size'] === 'medium') {
                return true;
            }
        }
        return false;
    }

}