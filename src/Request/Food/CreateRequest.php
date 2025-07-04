<?php

namespace App\Request\Food;

use App\Request\BaseRequest;
use Symfony\Component\Validator\Constraints as Assert;


class CreateRequest extends BaseRequest
{
  public function toArray()
  {
    return [
      'name' => $this->name,
      'type' => $this->type,
      'quantity' => $this->quantity,
      'unit' => $this->unit,
    ];
  }

  #[Assert\NotBlank([])]
  #[Assert\Type('string')]
  protected $name;

  #[Assert\NotBlank([])]
  #[Assert\Choice(['vegetable', 'fruit'])]
  protected $type;

  #[Assert\NotBlank([])]
  #[Assert\Type('numeric')]
  protected $quantity;
  
  #[Assert\NotBlank([])]
  #[Assert\Choice(['g', 'kg'])]
  protected $unit;
}