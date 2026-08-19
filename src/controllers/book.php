<?php

namespace controllers;

class book extends controller {

  public function index()
  {
    $this->render('app/books');
  }

  # add
  public function createBook() {
    print_r($_POST);
  }

  # search
  public function findBook() {
    print_r($_POST);
  }

  # get all books with limit and page
  public function getAll() {
    print_r($_POST);
  }

}