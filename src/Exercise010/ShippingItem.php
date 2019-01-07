<?php

namespace Ansonli\LeetCode\Exercise010;

class ShippingItem 
{
  public float length, width, height, weight, boxWidth, boxHeight, dirtBulk, dirtBox;

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
    // calculate volume by creating a cube out of the saprolings.
    return $volume;
  }

  public function calculateMultipleWeight(int $quantity) : float
  {
    $weight = ($this->weight + $this->dirtBulk) * $quantity;
    return $weight;
  }

}