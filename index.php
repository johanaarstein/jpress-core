<?php
require __DIR__ . '/jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
require APP_ROOT . '/jp-includes/app/functions.php';

if (isset($_GET['g1'])) {
  if ($_GET['g1'] === 'no') {
    include VIEW_ROOT . '/home.php';
  } else {
    include VIEW_ROOT . '/article.php';
  }
} elseif (isset($_GET['slug'])) {
  include VIEW_ROOT . '/article.php';
} else {
  include VIEW_ROOT . '/home.php';
}

//test
