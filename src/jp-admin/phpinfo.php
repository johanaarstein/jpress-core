<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require __DIR__ . '/../jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
include APP_ROOT . '/jp-includes/app/session-timeout.php';
require APP_ROOT . '/jp-includes/app/functions.php';

if (isLoggedIn()) {
  if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header('Location: /jp-login/login.php?inactive');
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}

$_SESSION['LAST_ACTIVITY'] = $time;

phpinfo();
