<?php

namespace App\Tests\App\Service\FoodService;

use App\Service\FoodService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class BaseTest extends KernelTestCase
{
	protected $foodFactory;
	protected $foodRepository;
	protected $entityManager;
	protected FoodService $foodService;

	protected function setUp(): void
	{
		self::bootKernel();
		$container = static::getContainer();

		$this->foodFactory = $container->get(\App\Factory\FoodFactory::class);
		$this->foodRepository = $container->get(\App\Repository\FoodRepository::class);
		$this->entityManager = $container->get(\Doctrine\ORM\EntityManagerInterface::class);

		$this->foodService = new FoodService(
			$this->foodFactory,
			$this->foodRepository,
			$this->entityManager
		);
	}

	protected function tearDown(): void
	{
		$this->entityManager->createQuery('DELETE FROM App\Entity\Food')->execute();
		$this->entityManager->clear();

	}
}
