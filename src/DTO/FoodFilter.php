<?php
namespace App\DTO;

class FoodFilter
{
    public function __construct(array $filters)
    {
        $this->name = $filters['name'] ?? null;
        $this->minWeight = $filters['minWeight'] ?? null;
        $this->maxWeight = $filters['maxWeight'] ?? null;
        $this->type = $filters['type'] ?? null;
    }
    public ?string $name = null;
    public ?int $minWeight = null;
    public ?int $maxWeight = null;
    public ?string $type = null; // e.g. 'fruit' or 'vegetable'
}