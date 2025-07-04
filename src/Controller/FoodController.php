<?php

namespace App\Controller;

use App\Request\Food\CreateRequest;
use App\Request\Food\IndexRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

use App\Service\FoodService;

class FoodController extends AbstractController
{
  #[Route('/foods', name: 'list_foods', methods: ['GET', 'HEAD'])]
  public function index(
    IndexRequest $request,
    FoodService $foodService,
    SerializerInterface $serializer
  ): JsonResponse {
    $errors = $request->validate();
    if (count($errors['errors']) > 0) {
      return JsonResponse::fromJsonString(json_encode($errors));
    }
    $result = $foodService->getFilteredFoods($request->toArray());
    $jsonContent = $serializer->serialize($result, format: 'json', context: ['unit' => $request->getUnit()]);
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
