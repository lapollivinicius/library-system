<?php

require_once "../../config/database.php";
require_once "../../config/utils.php";
require_once "../../entities/book.php";
require_once "../../models/book.php";

$db = config\database::connect();
$model = new \models\book($db);
$book = $model->get('clean code');

echo '<pre>';
print_r($book);
echo '</pre>';

?>
