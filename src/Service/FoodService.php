<?php
namespace App\Service;

use App\DTO\FoodFilter;
use App\Entity\Food;
use App\Entity\Fruit;
use App\Entity\Vegetable;
use App\Factory\FoodFactory;
use App\Repository\FoodRepository;
use App\Repository\FruitRepository;
use App\Repository\VegetableRepository;

use Doctrine\ORM\EntityManagerInterface;

class FoodService
{
  private $foodFactory;
  private $foodRepository;

  private $entityManager;

  public function __construct(FoodFactory $foodFactory,
    FoodRepository $foodRepository,
    EntityManagerInterface $entityManager)
  {
    $this->foodFactory = $foodFactory;
    $this->foodRepository = $foodRepository;
    $this->entityManager = $entityManager;
  }

  public function getFilteredFoods($filters): array
  {
    return $this->foodRepository->findByFilter(new FoodFilter($filters));
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