<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
  public function __construct(protected ValidatorInterface $validator)
  {
    $this->populate();
  }

  public function validate(): array
  {
    $errors = $this->validator->validate($this);

    $messages = ['errors' => []];

    foreach ($errors as $message) {
      $messages['errors'][] = [
        'property' => $message->getPropertyPath(),
        'value' => $message->getInvalidValue(),
        'message' => $message->getMessage(),
      ];
    }

    return $messages;
  }

  public function getRequest(): Request
  {
    return Request::createFromGlobals();
  }

  protected function populate(): void
  {
    if (!empty($this->getRequest()->getContent())) {
      $this->setProperties($this->getRequest()->toArray());
    }
    if ($this->getRequest()->query->count() > 0) {
      $this->setProperties($this->getRequest()->query->all());
    }
  }

  protected function setProperties(array $properties): void
  {
    foreach ($properties as $property => $value) {
      if (property_exists($this, $property)) {
        $this->{$property} = $value;
      }
    }
  }
}