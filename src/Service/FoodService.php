<?php
namespace App\Service;

use App\DTO\FoodFilter;
use App\Entity\Food;
use App\Factory\FoodFactory;
use App\Repository\FoodRepository;


use Doctrine\ORM\EntityManagerInterface;

class FoodService
{
  private $foodFactory;
  private $foodRepository;

  private $entityManager;

  public function __construct(
    FoodFactory $foodFactory,
    FoodRepository $foodRepository,
    EntityManagerInterface $entityManager
  ) {
    $this->foodFactory = $foodFactory;
    $this->foodRepository = $foodRepository;
    $this->entityManager = $entityManager;
  }

  public function getFilteredFoods($filters): array
  {
    return $this->foodRepository->findByFilter(new FoodFilter($filters));
  }

  public function create(array $data): Food
  {
    return $this->foodRepository->addFromArray($data);
  }
}