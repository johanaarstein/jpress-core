<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['filename'])) {
    require_once APP_ROOT . '/jp-config/config.php';

    $fileNames = $_POST['filename'];
    $removeSpaces = str_replace(' ', '', $fileNames);
    $allFileNames = explode(',', $removeSpaces);

    for ($i = 0; $i < count($allFileNames); $i++) {
      $delete = $db -> query(
        "DELETE FROM `media`
        WHERE  `name` = '$allFileNames[$i]';"
      );
      $path = APP_ROOT . '/uploads/' . $allFileNames[$i];
      if ($delete) {
        if (!file_exists($path)) {
          http_response_code(404);
          $db -> close();
          exit();
        } elseif (!unlink($path)) {
          http_response_code(500);
          $db -> close();
          exit();
        }
      } else {
        http_response_code(500);
        if ($db -> error) {
          echo '(' . $db -> errno . '): ' . $db -> error;
        }
        $db -> close();
        exit();
      }
    }
    http_response_code(200);
    $db -> close();
    exit();
  } else {
    http_response_code(400);
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
