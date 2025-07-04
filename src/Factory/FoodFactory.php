<?php

namespace App\Factory;

use App\Entity\Vegetable;
use App\Entity\Fruit;

class FoodFactory
{
  public function create(string $type)
  {
    switch ($type) {
      case 'vegetable':
        return new Vegetable();
      case 'fruit':
        return new Fruit();
      default:
      throw new \InvalidArgumentException(sprintf('Unknown type: %s', $type));
    }
  }
}