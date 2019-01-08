<?php

namespace Ansonli\LeetCode\Exercise010;

use AnsonLi\LeetCode\Exercise010\ShippingBox;

class ShippingItem 
{
  public $length, $width, $height, $weight, $boxWidth, $boxHeight, $dirtBulk, $dirtBox;

  public function __construct(float $length, float $width, float $height, float $weight, float $boxWidth, float $boxHeight, float $dirtBulk, $dirtBox)
  {
    $this->length = $length;
    $this->width = $width;
    $this->height = $height;
    $this->weight = $weight;
    $this->boxWidth = $boxWidth;
    $this->boxHeight = $boxHeight;
    $this->dirtBulk = $dirtBulk;
    $this->dirtBox = $dirtBox;
  }

  public function calculateSingleVolume() : float
  {
    $volume = $this->length * $this->boxWidth * $this->boxHeight;
    return $volume;
  }

  public function calculateSingleWeight() : float
  {
    $weight = $this->weight * $this->dirtBox;
    return $weight;
  }

  public function calculateMultipleVolume(int $quantity) : float
  {
    $volume = ($this->length * $this->width * $this->height) * $quantity;
    return $volume;
  }

  /**
   * Given an ideal volume or weight for a box, provide a value that fills it to the least of either limit (either using all of the available volume, or all of the available weight).
   * We use the multiple item calculation, as we already know this will be a bulk order.
   */
  public function getMaxQuantityPerBox(float $volume, float $weight) : int
  {
    return min(floor($volume / $this->calculateMultipleVolume(1)), floor($weight / $this->calculateMultipleWeight(1)));
  }

  public function calculateMultipleWeight(int $quantity) : float
  {
    $weight = ($this->weight + $this->dirtBulk) * $quantity;
    return $weight;
  }

}