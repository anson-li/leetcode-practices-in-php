<?php

namespace Ansonli\LeetCode\Exercise010;

class ShippingBox 
{
    private $length, $width, $height, $weight, $remainingWidth, $remainingHeight, $remainingWeight, $remainingVolume, $storedItems;
    public $usedVolume = 0, $usedWeight = 0, $volume, $cost;

    /** 
     * Constructs a box object for calculating used size, remaining size, and cost.
     *
     * @param float $length The length of the box.
     * @param float $width  The width of the box.
     * @param float $height The height of the box.
     * @param float $weight The maximum weight the box can carry.
     * @param float $cost   The cost of the box for shipping. Not really useful for an E2E project but using for standalone purposes. 
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

        $this->remainingWidth = $width;
        $this->remainingHeight = $height;
        $this->remainingWeight = $weight;

        $this->storedItems = [];
    }

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
     * Fills each box with the width and height (treated as a 2d fill component). Returns a boolean identifying whether or 
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
        return true;
    }

    function canFit($volume, $weight) : bool
    {
        if ($this->remainingVolume < $volume || $this->remainingWeight < $weight) {
            return false;
        }
        return true;
    }

    function hasMediumItem() : bool
    {
        foreach ($this->storedItems as $item) {
            if ($item['size'] === 'medium') {
                return true;
            }
        }
        return false;
    }

    function getVolume() : float
    { 
        return ($this->length * $this->width * $this->height);
    }

}