<?php

namespace App\Tests\App\Service\FoodService;

use App\DTO\FoodFilter;
use App\Entity\Food;
use App\Service\FoodService;

class FilterTest extends BaseTest
{
	public function	setUp(): void
	{
		parent::setUp();
		$items = json_decode(file_get_contents('request.json'), true);
		$this->foodService->createBatch($items);		
	}
	public function testFilterByName(): void
	{
		$filter = [
			'name'=> 'Apple',
		];

		$result = $this->foodService->getFilteredFoods($filter);
		$this->assertCount(1, $result);
		$this->assertEquals('Apples', $result[0]->getName());
	}

	public function testFilterByType(): void
	{
		$filter = [
			'type'=> 'fruit',
		];

		$result = $this->foodService->getFilteredFoods($filter);
		$this->assertCount(10, $result);
	}

	public function testMinWeight(): void
	{
		$filter = [
			'minWeight'=> 100000,
		];

		$result = $this->foodService->getFilteredFoods($filter);
		$this->assertCount(4, $result);
		$expectedItems = [
			'Cabbage',
			'Melons',
			'Bananas',
			'Pepper',
		];
		foreach($result as $item) {
			$this->assertContains($item->getName(), $expectedItems);
		}
	}
	public function testMaxWeight(): void
	{
		$filter = [
			'maxWeight'=> 1000,
		];

		$result = $this->foodService->getFilteredFoods($filter);
		$this->assertCount(1, $result);
		$this->assertEquals('Beetroot', $result[0]->getName());
	}

	public function testCombineAllFilters(): void
	{
		$filter = [
			'name'=> 'A',
			'minWeight'=> 1000,
			'maxWeight'=> 10000,
			'type' => 'fruit',
		];
		$result = $this->foodService->getFilteredFoods($filter);
		
		$this->assertCount(2, $result);
		$this->assertEquals('Pears', $result[0]->getName());
		$this->assertEquals('Avocado', $result[1]->getName());
	}
}
