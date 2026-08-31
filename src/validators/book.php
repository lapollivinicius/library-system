<?php

namespace validators;

class book extends validators
{

  public function book(Array $data) 
  {
    foreach ($data as $key => $value) {

      if (!is_string($value)) {
        return $this->setError('invalid form');
      }

      if($key != 'isbn') {
        if (!$this->required($value)) {
          return $this->setError('All field are required.');
        }
      }

      if ($key == 'title') {
        if(!$this->minLength($value, 2) || !$this->maxLength($value, 64)) {
          return $this->setError('The title field must be between 3 and 64 characters long.');
        };
        if(!$this->title($value)) {
          return $this->setError('The title field can only contain letters and numbers');
        };
      }

      if($key == 'author') {
        if(!$this->minLength($value, 2) || !$this->maxLength($value, 64)) {
          return $this->setError('The Author field must be between 2 and 4 characters long.');
        };
        if(!$this->name($value)) {
          return $this->setError('The Author field can only contain letters');
        };
      }

      if($key == 'genre') {
        if(!$this->minLength($value, 2) || !$this->maxLength($value, 64)) {
          return $this->setError('The Genre field must be between 2 and 4 characters long.');
        };
        if(!$this->name($value)) {
          return $this->setError('The Genre field can only contain letters');
        };
      }

      if($key == 'year') {
        if(!$this->minLength($value, 4) || !$this->maxLength($value, 4)) {
          return $this->setError('The Year field must contain exactly 4 characters');
        };
        if(!$this->number($value)) {
          return $this->setError('The Year field can only contain numbers');
        };
      }

      if($key == 'quantity') {
        if(!$this->maxLength($value, 5)) {
          return $this->setError('The Quantity field must not exceed 4 characters');
        };
        if(!$this->number($value)) {
          return $this->setError('The Quantity field can only contain numbers');
        };
      }

      if($key == 'isbn') {
        $value = $value == '' ? 0 : $value;
        if(!$this->maxLength($value, 13)) {
          return $this->setError('The ISBN field must not exceed 13 characters');
        };
        if(!$this->number($value)) {
          return $this->setError('The ISBN field can only contain numbers');
        };
      }
      
    }
    return true;
  }
}
