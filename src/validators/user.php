<?php

namespace validators;

class user extends validators {

  public function update(Array $data) 
  {
    foreach ($data as $key => $value) {

      if (!is_string($value)) {
        return $this->setError('invalid form');
      }

      if(!in_array($key, ['loan', 'return'])) {
        if (!$this->required($value)) {
          return $this->setError('All field are required.');
        }
      }

      if ($key == 'library_name') {
        if (!$this->name($value)) {
          return $this->setError('The Library name field can only contain letters');
        }
        if (!$this->minLength($value, 5) || !$this->maxLength($value, 64)) {
          return $this->setError('The Library name field must be between 5 and 64 characters long.');
        }
      }

    }
    return true;
  }

}