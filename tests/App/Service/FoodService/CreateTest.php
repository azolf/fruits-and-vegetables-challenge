<?php

namespace App\Tests\App\Service\FoodService;

use App\Entity\Food;
use App\Service\FoodService;

class CreateTest extends BaseTest
{
	public function testCreate(): void
	{
		$item = [
			'id' => 1,
			'name' => 'Carrot',
			'type' => 'vegetable',
			'quantity' => 500,
			'unit' => 'g'
		];

		$result = $this->foodService->create($item);

		$this->assertGreaterThan(0, $result->getId());
		$this->assertInstanceOf(Food::class, $result);
	}
}
