<?php 

   session_start();

   require_once __DIR__ . '/database/config.php';

   $db = loadDatabase();
   $query = '
      SELECT username, password FROM admin;
   ';
   $stmt = $db->query($query);
   $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

   $user = $data[0];

   $username = $_POST['username'];
   $password = $_POST['password'];

   if($user['username'] === $username && $user['password'] === $password) {
      $_SESSION['role'] = $username;
      header('Location: resume.php');
   } else {
      $_SESSION['message'] = 'username or password invalid!!!';
      header('Location: index.php');
   }
   exit;

?>