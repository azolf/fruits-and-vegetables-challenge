<?php
namespace App\Serializer;

use App\Entity\Food;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class FoodNormalizer implements NormalizerInterface
{
  private const SUPPORTED_UNITS = ['g', 'kg'];

  public function __construct(
    private ObjectNormalizer $normalizer,

  ) {
  }
  public function supportsNormalization($data, string $format = null, array $context = []): bool
  {
    return $data instanceof Food;
  }

  public function normalize($object, string $format = null, array $context = []): array
  {
    $unit = $context['unit'] ?? 'g';

    if (!in_array($unit, self::SUPPORTED_UNITS)) {
      throw new \InvalidArgumentException("Unsupported unit: $unit");
    }

    $data = $this->normalizer->normalize($object, $format, $context);
    $data['quantity'] = $object->getQuantity($unit);
    $data['unit'] = $unit;

    return $data;
  }
}