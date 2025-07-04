<?php

namespace App\Request\Food;

use App\Request\BaseRequest;
use App\Request\Food\CreateRequest;
use Symfony\Component\Validator\Constraints as Assert;


class CreateBatchRequest extends BaseRequest
{
  public function toArray()
  {
    return $this->items;
  }

  protected function populate(): void
  {
    if (!empty($this->getRequest()->getContent())) {
      $this->items = json_decode($this->getRequest()->getContent(), true);
    }
  }

  #[Assert\Collection(
    [
      new Assert\Collection(
        fields: [
          'name' => new Assert\NotBlank(),
          'type' => [
            new Assert\NotBlank(),
            new Assert\Choice(choices: ['vegetable', 'fruit'])
          ],
          'quantity' => [
            new Assert\NotBlank(),
            new Assert\Positive()
          ],
          'unit' => [
            new Assert\NotBlank(),
            new Assert\Choice(choices: ['kg', 'g'])
          ]
        ],
        allowMissingFields: false,
        allowExtraFields: true
      )
    ],
    allowMissingFields: false,
    allowExtraFields: true
  )]

  protected array $items = [];
}