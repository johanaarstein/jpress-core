<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update-core'])) {
    copy('https://raw.githubusercontent.com/johanaarstein/jpress-core/master/index.php', APP_ROOT . '/index.php');
  } else {
    http_response_code(400);
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
