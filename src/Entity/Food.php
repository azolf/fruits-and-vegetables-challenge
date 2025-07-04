<?php

namespace App\Entity;

use App\Repository\FoodRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FoodRepository::class)]
#[ORM\InheritanceType('SINGLE_TABLE')]
#[ORM\DiscriminatorColumn(name: 'type', type: 'string')]
#[ORM\DiscriminatorMap(['vegetable' => Vegetable::class, 'fruit' => Fruit::class])]
abstract class Food
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?float $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getQuantity(string $unit = 'g'): ?float
    {
        return $unit === 'kg' ? $this->quantity / 1000 : $this->quantity;
    }

    public function setQuantity(float $quantity, string $unit = 'g'): static
    {
        if ($unit === 'kg') {
            $quantity = $quantity * 1000;
        }

        $this->quantity = $quantity;

        return $this;
    }
}
