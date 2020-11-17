<?php
require __DIR__ . '/../app/variables.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['user-to-delete'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    $toDelete = $_POST['user-to-delete'];

    $delete = $db -> query("DELETE FROM `users` WHERE `username` = '$toDelete';");
    if (!$delete) {
      http_response_code(500);
      if ($db -> error) {
        echo '(' . $db -> errno . '): ' . $db -> error;
      }
      $db -> close();
      exit();
    } else {
      http_response_code(200);
      $db -> close();
      exit();
    }
  } else {
    http_response_code(400);
    $db -> close();
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  $db -> close();
  exit();
}
