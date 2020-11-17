<?php
if (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') {
  $protocol = 'https://';
} else {
	$protocol = 'http://';
}

DEFINE('APP_ROOT', $_SERVER['DOCUMENT_ROOT']);
DEFINE('VIEW_ROOT', APP_ROOT . '/views');
DEFINE('BASE_URL', $protocol . $_SERVER['SERVER_NAME']);
DEFINE('CURRENT_URL', BASE_URL . $_SERVER['REQUEST_URI']);
if (isset($_SERVER['UNIQUE_ID'])) {
  DEFINE('NONCE', base64_encode($_SERVER['UNIQUE_ID']));
} else {
  DEFINE('NONCE',   '');
}
