<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['section-to-delete'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    $toDelete = $_POST['section-to-delete'];

    $delete = $db -> query("DELETE FROM `home` WHERE `id` = '$toDelete';");
    if (!$delete) {
      http_response_code(500);
      $db -> close();
      exit();
    } else {
      http_response_code(200);
      $db -> close();
      exit();
    }
  } else {
    http_response_code(400);
    // $db -> close();
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  // $db -> close();
  exit();
}
