<?php

require_once "../../config/database.php";
require_once "../../config/utils.php";
require_once "../../entities/book.php";
require_once "../../models/book.php";

$db = config\database::connect();
$model = new \models\book($db);
$user_id = 'ff0c5469-2e64-4d85-a3d3-db14bf9602f5';

$book = new \entities\book(
  \config\utils::UUID(),
  $user_id,
  '',
  'CRONICAS DE NARNIA',
  'CS LEWIS',
  '000',
  '1960',
  10,
  true
);


echo '<pre>';
print_r('123');
echo '</pre>';
?>

<form action="/api/books/create" method="POST">
  <label for="title">Title</label>
  <input
    type="text"
    id="title"
    name="title"
    placeholder="Book title" />
  <label for="author"> Author </label>
  <input
    type="text"
    id="author"
    name="author"
    placeholder="Author name" />
  <label for="year"> Year </label>
  <input
    type="number"
    id="year"
    name="year"
    placeholder="2026"
    min="0" />
  <label for="genre"> Genre </label>
  <input
    type="text"
    id="genre"
    name="genre"
    placeholder="Genre" />
  <label for="quantity"> Quantity </label>
  <input
    type="number"
    id="quantity"
    name="quantity"
    placeholder="0"
    min="1" />
  <label for="isbn"> ISBN </label>
  <input
    type="text"
    id="isbn"
    name="isbn"
    placeholder="ISBN" />
  <button type="submit">
    Register Book
  </button>
  </div>
</form>