<?php
require __DIR__ . '/../app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
require APP_ROOT . '/jp-includes/app/functions.php';
require APP_ROOT . '/jp-includes/app/siteinfo.php';
header('Content-type: text/css');

echo themeColors();
