<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_FILES['file'])) {

    $allowed = 'png';
    $targetDir = APP_ROOT . '/assets/img/site/';
    $targetFile = $targetDir . 'favicon.png';
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $fileError = $_FILES['file']['error'][0];
    if ($imageFileType === $allowed) {
      if ($fileError === 0) {
        if ($fileSize > 2000000) {
          http_response_code(413);
          exit();
        } else {
          move_uploaded_file($_FILES['file']['tmp_name'][0], $targetFile);
          http_response_code(200);
          exit();
        }
      } else {
        http_response_code(400);
        echo 'Error: ' . $fileError;
        exit();
      }
    } else {
      http_response_code(415);
      exit();
    }
  } else {
    http_response_code(400);
    echo 'Missing file';
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
