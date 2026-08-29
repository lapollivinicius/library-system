<?php

namespace validators;

class loan extends validators
{

  public function loan(Array $data) {

    # book, member, loan (date), return (date)
    foreach ($data as $key => $value) {

      if (!is_string($value)) {
        return $this->setError('invalid form');
      }

      if(!in_array($key, ['loan', 'return'])) {
        if (!$this->required($value)) {
          return $this->setError('All field are required.');
        }
      }
      
      if($key == 'book') {
        if(!$this->minLength($value, 2) || !$this->maxLength($value, 64)) {
          return $this->setError('The book field must be between 3 and 64 characters long.');
        };
        if(!$this->title($value)) {
          return $this->setError('The book field can only contain letters');
        };
      }

      if($key == 'member') {
        if(!$this->minLength($value, 2) || !$this->maxLength($value, 64)) {
          return $this->setError('The member field must be between 3 and 64 characters long.');
        };
        if(!$this->name($value)) {
          return $this->setError('The member field can only contain letters');
        };
      }

      if($key == 'loan' || $key == 'return') {
        if(!$this->date_valid($value)) {
          return $this->setError('The loan or return field contain a invalid date');
        };
      }

      $loan = \DateTime::createFromFormat('!Y-m-d', $data['loan']); 
      $return = \DateTime::createFromFormat('!Y-m-d', $data['return']); 

      if ($loan >= $return) { 
        return $this->setError('The loan date must be before the return date'); 
      }
      
    }
    
    return true;
  }

}
