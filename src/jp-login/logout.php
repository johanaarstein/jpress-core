<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
$_SESSION = array();
session_destroy();
if (isset($_GET['origin'])) {
  $location = str_replace('?ModPagespeed=off', '', $_GET['origin']);
  if (strpos($location, 'jp-admin') || strpos($location, '?draft') || strpos($location, 'plugins')) {
    header("Location: /");
    exit();
  } else {
    header('Location: ' . $location);
    exit();
  }
} else {
  header("Location: /");
  exit();
}
