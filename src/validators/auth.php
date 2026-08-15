<?php

  namespace validators;

  class auth extends validators {

      public function register($data) {

        # validate based on the defined fields (!!!)
        # name, email, password, library_name, terms

        foreach($data as $key => $value) {

          if(!is_string($value)) {
            return $this->setError('invalid form');
          }
          
          if(!$this->required($value)) {
            return $this->setError('All field are required.');
          }
          
          if($key == 'name') {
            if(!$this->name($value)) {
              return $this->setError('The Name field can only contain letters and (_)');
            }
            
            if(!$this->minLength($value, 3) || !$this->maxLength($value, 64)) {
              return $this->setError('The Name field must be between 3 and 64 characters long.');
            }
          }

          if($key == 'email') {
            if(!$this->minLength($value, 5) || !$this->maxLength($value, 64)) {
                return $this->setError('The Email field must be between 3 and 64 characters long.');
            }
            if (!$this->email($value)) {
                return $this->setError('email invalid, must be @ (gmail, yahoo, outlook, hotmail)');
            }
          }

          if($key == 'password') {
            # is a password strong?
            if(!$this->password($value)) {
              return $this->setError('The Password field can only contain letters, numbers and @, #, $, !, _ or -.');
            }
            if(!$this->minLength($value, 8) || !$this->maxLength($value, 64)) {
              return $this->setError('The Password field must be between 8 and 64 characters long.');
            }
          }

          if($key == 'library_name') {
            if(!$this->name($value)) {
              return $this->setError('The Library field can only contain letters and (_)');
            }
            if(!$this->minLength($value, 5) || !$this->maxLength($value, 64)) {
              return $this->setError('The Library field must be between 5 and 64 characters long.');
            }
          }

          if($key == 'terms' && $value !== '1') {
              return $this->setError('The terms field is required');
          }
          
        }

        return true;
      }

  }