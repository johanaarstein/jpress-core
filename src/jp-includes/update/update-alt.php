<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['save-image-details'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    $newAlt = htmlentities(trim($_POST['image-alt']), ENT_COMPAT, 'UTF-8');
    $newCredit = htmlentities(trim($_POST['photo-credit']), ENT_COMPAT, 'UTF-8');
    $newCaption = htmlentities(trim($_POST['image-caption']), ENT_COMPAT, 'UTF-8');
    $id = $_POST['image-id'];
    $update = $db -> query(
      "UPDATE `media`
      SET     `imageAlt` = '$newAlt',
              `photoCredit` = '$newCredit',
              `imageCaption` = '$newCaption'
      WHERE   `id` = '$id';"
    );
    if ($update) {
      http_response_code(200);
      $db -> close();
      exit();
    } elseif ($db -> error) {
      http_response_code(500);
      header('Content-Type: application/x-www-form-urlencoded');
      echo '(' . $db -> errno . '): ' . $db -> error;
      $db -> close();
      exit();
    } else {
      http_response_code(500);
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
