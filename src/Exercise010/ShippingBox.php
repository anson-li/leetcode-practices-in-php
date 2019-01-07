<?php

namespace Ansonli\LeetCode\Exercise010;

class ShippingBox 
{
    private float length;
    private float width;
    private float height;
    private float weight;

    private float remainingWidth;
    private float remainingHeight;
    private float remainingWeight;

    private float cost; 

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

        $this->remainingWidth = $width;
        $this->remainingHeight = $height;
        $this->remainingWeight = $weight;
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
    function fillBox(float $length, float $width, float $height) : bool
    {
        if ($this->length < $length || $this->remainingWidth < $width || $this->remainingHeight < $height) {
            return false;
        }
        $this->remainingWidth -= $width;
        $this->remainingHeight -= $height;
        return true;
    }

    function getVolume() : float
    { 
        return ($this->length * $this->width * $this->height);
    }

    function getRemainingVolume() : float 
    {
        return ($this->length * $this->remainingWidth * $this->height);
    }

    function getCost() : float 
    {
        return $this->cost;
    }

}