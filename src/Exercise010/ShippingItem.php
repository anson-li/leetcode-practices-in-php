<?php

namespace Ansonli\LeetCode\Exercise010;

use AnsonLi\LeetCode\Exercise010\ShippingBox;

class ShippingItem 
{
  public $length, $width, $height, $weight, $boxWidth, $boxHeight, $dirtBulk, $dirtBox;

  /** 
   * Constructs an item object for placing into boxes
   *
   * @param float $length     The length of the item (when placed horizontally).
   * @param float $width      The width of the item.
   * @param float $height     The height of the item.
   * @param float $weight     The weight of the item, singular.
   * @param float $boxWidth   The width of the box, if packaged as a single item.
   * @param float $boxHeight  The height of the box, if packaged as a single item.
   * @param float $dirtBulk   The weight of the dirt, if packaged as part of a bulk set.
   * @param float $dirlBox    The weight of the dirt & box if packaged as a single item.
   */
  public function __construct(float $length, float $width, float $height, float $weight, float $boxWidth, float $boxHeight, float $dirtBulk, float $dirtBox)
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

  /**
   * Returns the volume of an item by treating it as a cube (thereby using l*w*h calculations).
   * We use boxWidth and boxHeight as it takes more space than the seedling (see reference image 3).
   * Future improvements would be to use a more accurate calculation, such as treating the seedling as a cylinder.
   */
  public function calculateSingleVolume() : float
  {
    $volume = $this->length * $this->boxWidth * $this->boxHeight;
    return $volume;
  }

  /**
   * Returns the weight of a single item, including the box and the dirt.
   */
  public function calculateSingleWeight() : float
  {
    $weight = $this->weight * $this->dirtBox;
    return $weight;
  }

  /**
   * Returns the volume of a group of items by treating it as a cube (thereby using l*w*h calculations).
   * Future improvements would be to use a more accurate calculation, such as treating the seedling as a cylinder.
   */
  public function calculateMultipleVolume(int $quantity) : float
  {
    $volume = ($this->length * $this->width * $this->height) * $quantity;
    return $volume;
  }

  /**
   * Returns the weight of multiple items, including the dirt (no box attached).
   */
  public function calculateMultipleWeight(int $quantity) : float
  {
    $weight = ($this->weight + $this->dirtBulk) * $quantity;
    return $weight;
  }

  /**
   * Given an ideal volume or weight for a box, provide a value that fills it to the least of either limit (either using all of the available volume, or all of the available weight).
   * We use the multiple item calculation, as we already know this will be a bulk order.
   */
  public function getMaxQuantityPerBox(float $volume, float $weight) : int
  {
    return min(floor($volume / $this->calculateMultipleVolume(1)), floor($weight / $this->calculateMultipleWeight(1)));
  }
}