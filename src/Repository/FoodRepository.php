<?php

namespace App\Repository;

use App\Entity\Food;
use App\Entity\Fruit;
use App\Entity\Vegetable;
use AppendIterator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityRepository;
use App\DTO\FoodFilter;

/**
 * @extends ServiceEntityRepository<Food>
 *
 * @method Food|null find($id, $lockMode = null, $lockVersion = null)
 * @method Food|null findOneBy(array $criteria, array $orderBy = null)
 * @method Food[]    findAll()
 * @method Food[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, entityClass: Food::class);
    }
    public function add(Food $food): void
    {
        $this->_em->persist($food);
        $this->_em->flush();
    }

    public function remove(Food $food): void
    {
        $this->_em->remove($food);
        $this->_em->flush();
    }

    public function list(): array
    {
        return $this->findAll();
    }

    public function findByFilter(FoodFilter $filter): array
    {
        $qb = $this->createQueryBuilder('f');

        if ($filter->name) {
            $qb->andWhere('f.name LIKE :name')
               ->setParameter('name', '%' . $filter->name . '%');
        }

        if ($filter->minWeight) {
            $qb->andWhere('f.quantity >= :minWeight')
               ->setParameter('minWeight', $filter->minWeight);
        }

        if ($filter->maxWeight) {
            $qb->andWhere('f.quantity <= :maxWeight')
               ->setParameter('maxWeight', $filter->maxWeight);
        }

        if ($filter->type === 'fruit') {
            $qb->andWhere('f INSTANCE OF App\Entity\Fruit');
        }

        if ($filter->type === 'vegetable') {
            $qb->andWhere('f INSTANCE OF App\Entity\Vegetable');
        }


        return $qb->getQuery()->getResult();
    }
}
