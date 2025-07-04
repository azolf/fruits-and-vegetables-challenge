<?php

namespace App\Controller;

use App\DTO\FoodFilter;
use App\Repository\FoodRepository;
use App\Repository\FruitRepository;
use App\Request\Food\CreateRequest;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

use App\Service\FoodService;

class FoodController extends AbstractController
{
  #[Route('/foods', name: 'list_foods', methods: ['GET', 'HEAD'])]
  public function index(
    Request $request,
    FoodService $foodService,
    SerializerInterface $serializer
  ): JsonResponse {
    $filters = $request->query->all('filters');
    $result = $foodService->getFilteredFoods($filters);
    $jsonContent = $serializer->serialize($result, format: 'json');
    return JsonResponse::fromJsonString($jsonContent);
  }

  #[Route('/foods', name: 'create_food', methods: ['POST'])]
  public function create(
    CreateRequest $request,
    FoodService $foodService,
    SerializerInterface $serializer
  ): JsonResponse {

    $errors = $request->validate();
    if (count($errors['errors']) > 0) {
      return JsonResponse::fromJsonString(json_encode($errors));
    }

    $result = $foodService->create($request->toArray());
    $jsonContent = $serializer->serialize($result, format: 'json');
    return JsonResponse::fromJsonString($jsonContent);
  }
}
