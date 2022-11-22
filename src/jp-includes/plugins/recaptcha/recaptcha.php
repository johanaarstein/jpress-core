<?php
require __DIR__ . '/../../../jp-includes/app/variables.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['recaptcha_response'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    require APP_ROOT . '/jp-includes/app/functions.php';
    include APP_ROOT . '/jp-includes/lang/lang.php';

    $reCAPTCHA_serverKey = getOption('reCAPTCHA_serverKey');

    $reCAPTCHA_url = 'https://www.google.com/recaptcha/api/siteverify';
    $reCAPTCHA_response = filter_input(INPUT_POST, 'recaptcha_response', FILTER_SANITIZE_STRING);

    $reCAPTCHA = file_get_contents($reCAPTCHA_url . '?secret=' . $reCAPTCHA_serverKey . '&response=' . $reCAPTCHA_response);
    $reCAPTCHA = json_decode($reCAPTCHA);

    if ($reCAPTCHA -> score >= 0.5) {
      http_response_code(200);
      $db -> close();
      exit();
    } else {
      http_response_code(400);
      echo $reCAPTCHAError_str;
      $db -> close();
      exit();
    }
  } else {
    http_response_code(400);
    echo $thereWasAnError_str;
    exit();
  }
} else {
  header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found', true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
