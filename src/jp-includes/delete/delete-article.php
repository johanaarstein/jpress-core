<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['article-to-delete'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    require_once APP_ROOT . '/jp-includes/app/functions.php';
    include APP_ROOT . '/jp-includes/lang/lang.php';
    $toDelete = $_POST['article-to-delete'];

    $delete = $db -> query("DELETE FROM `articles` WHERE `slug` = '$toDelete';");
    if (!$delete) {
      http_response_code(500);
      if ($db -> error) {
        echo $thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error;
      } else {
        echo $thereWasAnError_str;
      }
      $db -> close();
      exit();
    } else {
      http_response_code(200);
      $db -> close();
      exit();
    }
  } else {
    http_response_code(404);
    // $db -> close();
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  // $db -> close();
  exit();
}
