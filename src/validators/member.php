<?php

namespace validators;

class member extends validators
{

  public function member(Array $data) 
  {
    foreach ($data as $key => $value) {

      if (!is_string($value)) {
        return $this->setError('invalid form');
      }

      if(!in_array($key, ['phone', 'document'])) {
        if (!$this->required($value)) {
          return $this->setError('All field are required.');
        }
      }
      
      if($key == 'name') {
        if(!$this->minLength($value, 2) || !$this->maxLength($value, 64)) {
          return $this->setError('The name field must be between 3 and 64 characters long.');
        };
        if(!$this->name($value)) {
          return $this->setError('The name field can only contain letters');
        };
      }

      if ($key == 'email') {
        if (!$this->minLength($value, 5) || !$this->maxLength($value, 64)) {
          return $this->setError('The Email field must be between 3 and 64 characters long.');
        }
        if (!$this->email($value)) {
          return $this->setError('email invalid, must be @ (gmail, yahoo, outlook, hotmail)');
        }
      }

      if($key == 'phone' || $key == 'document') {
        $value = $value == '' ? 0 : $value;
        if(!$this->maxLength($value, 35)) {
          return $this->setError('The phone or document field must not exceed 35 characters');
        };
        if(!$this->number($value)) {
          return $this->setError('The phone or document field can only contain numbers');
        };
      }
      
    }
    return true;
  }
}
