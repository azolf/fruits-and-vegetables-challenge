<?php

namespace App\Tests\App\Service\FoodService;

use App\Entity\Food;
use App\Service\FoodService;

class CreateBatchTest extends BaseTest
{
	public function testCreateBatch(): void
	{
		$items = [
			[
				'id' => 1,
				'name' => 'Apple',
				'type' => 'fruit',
				'quantity' => 1000,
				'unit' => 'g'
			],
			[
				'id' => 2,
				'name' => 'Beetroot',
				'type' => 'vegetable',
				'quantity' => 200,
				'unit' => 'g'
			]
		];

		$result = $this->foodService->createBatch($items);
		$this->assertCount(2, $result);
		$this->assertGreaterThan(0, $result[0]->getId());
		$this->assertGreaterThan(0, $result[1]->getId());
	}
}
