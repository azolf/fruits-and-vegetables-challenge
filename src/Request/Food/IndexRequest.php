<?php

namespace App\Request\Food;

use App\Request\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;


class IndexRequest extends BaseRequest
{
  public function toArray()
  {
    return [
      'name' => $this->name,
      'type' => $this->type,
      'minWeight' => $this->minWeight,
      'maxWeight' => $this->maxWeight,
    ];
  }

  public function getUnit()
  {
    return $this->unit;
  }

  #[Assert\Type('string')]
  protected $name;

  #[Assert\Choice(['vegetable', 'fruit'])]
  protected $type;

  #[Assert\Type('numeric')]
  protected $minWeight;
  
  #[Assert\Type('numeric')]
  protected $maxWeight;

  #[Assert\Choice(['kg', 'g'])]
  protected $unit = 'g';
}