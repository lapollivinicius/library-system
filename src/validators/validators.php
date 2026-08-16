<?php

namespace validators;

class validators
{

  protected string $error = '';

  protected function required(string $value): bool
  {
    return trim($value) !== '';
  }

  protected function minLength(string $value, int $min): bool
  {
    return mb_strlen($value) >= $min;
  }

  protected function maxLength(string $value, int $max): bool
  {
    return mb_strlen($value) <= $max;
  }

  protected function name(string $value): bool
  {
    return preg_match('/^[a-zA-Z_]+$/', $value) === 1;
  }

  protected function email(string $value): bool
  {
    return preg_match(
      '/^[a-zA-Z0-9._%+-]+@(gmail|yahoo|outlook|hotmail)\.com$/',
      $value
    ) === 1;
  }

  protected function password(string $value): bool
  {
    return preg_match(
      '/^[a-zA-Z0-9@#$!_]+$/',
      $value
    ) === 1;
  }

  protected function setError(string $value)
  {
    $this->error = $value;
    return false;
  }

  public function getError()
  {
    return $this->error;
  }
}
