<?php
namespace App\Service;

use App\Factory\FoodFactory;
use Doctrine\ORM\EntityManagerInterface;

class FoodService
{
  private $foodFactory;
  private $entityManager;

  public function __construct(FoodFactory $foodFactory, EntityManagerInterface $entityManager)
  {
    $this->foodFactory = $foodFactory;
    $this->entityManager = $entityManager;
  }
  public function processRequest(array $data): array
  {
    $result = [];
    foreach ($data as $item) {
      $food = $this->foodFactory->create($item['type']);
      $food->setName($item['name'])
        ->setQuantity($item['quantity'], $item['unit']);
      $this->entityManager->persist($food);
      $result[] = $food;
    }
    $this->entityManager->flush();
    
    return $result;
  }
}