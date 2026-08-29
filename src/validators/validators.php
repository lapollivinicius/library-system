<?php

namespace validators;

abstract class validators
{

  protected string $error = '';

  protected function required(string $value): bool
  {
    return trim($value) !== '';
  }

  protected function number(string $value): bool
  {
      return is_numeric(trim($value));
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
    return preg_match('/^[a-zA-Z. _-]+$/', $value) === 1;
  }

  protected function title(string $value): bool
  {
    return preg_match('/^[a-z0-9A-Z. _-]+$/', $value) === 1;
  }

  protected function date_valid(string $value): bool
  {
      return preg_match('/^\d{4}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/', $value) === 1;
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

  protected function terms(Array $data): bool
  {
    return ($data['terms'] ?? null) === '1';
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
