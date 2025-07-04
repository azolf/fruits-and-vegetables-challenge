<?php
namespace App\Service;

use App\Entity\Fruit;
use App\Entity\Vegetable;
use App\Factory\FoodFactory;
use App\Repository\FruitRepository;
use App\Repository\VegetableRepository;
use Doctrine\ORM\EntityManagerInterface;

class FoodService
{
  private $foodFactory;
  private $entityManager;

  private $vegetableRepository;

  private $fruitRepository;

  public function __construct(FoodFactory $foodFactory,
  EntityManagerInterface $entityManager,
  FruitRepository $fruitRepository,
  VegetableRepository $vegetableRepository)
  {
    $this->foodFactory = $foodFactory;
    $this->entityManager = $entityManager;
    $this->fruitRepository = $fruitRepository;
    $this->vegetableRepository = $vegetableRepository;
  }
  public function processRequest(array $data): array
  {
    foreach ($data as $item) {
      $food = $this->foodFactory->create($item['type']);
      $food->setName($item['name'])
        ->setQuantity($item['quantity'], $item['unit']);
      $this->entityManager->persist($food);
    }
    $this->entityManager->flush();

    return [
      'fruits' => $this->fruitRepository,
      'vegetables' => $this->vegetableRepository,
    ];
  }
}