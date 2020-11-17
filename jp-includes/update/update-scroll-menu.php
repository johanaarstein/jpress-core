<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once APP_ROOT . '/jp-config/config.php';
  require APP_ROOT . '/jp-includes/app/functions.php';
  if (isset($_POST['update-scrollmenu'])) {

    function cSHY($text) {
      $text = preg_replace("/'/", "\&#39;", str_replace('&shy;&shy;', '&shy;', $text));
      return $text;
    }
    $lang = $_POST['lang'];
    $scrollMenuText = cSHY($_POST['scroll-menu-text']);

    $select =
    "SELECT `id`
    FROM    `scrollMenu`;";
    $result = $db -> query($select);
    if ($result && $result -> num_rows > 0) {
      $update = $db -> query(
        "UPDATE `scrollMenu`
        SET    `content` = '$scrollMenuText',
               `created` = Now()
        WHERE  `lang` = '$lang';"
      );
      if (!$update) {
        http_response_code(500);
        if ($db -> error) {
          echo '(' . $db -> errno . '): ' . $db -> error;
        }
        $db -> close();
        exit();
      } else {
        http_response_code(200);
        $db -> close();
        exit();
      }
    } else {
      $insert = $db -> query(
        "INSERT INTO  `scrollMenu`
                      (`lang`,
                      `content`,
                      `created`)
        VALUES        ('$lang',
                      '$scrollMenuText',
                      Now());"
      );
      if (!$insert) {
        http_response_code(500);
        if ($db -> error) {
          echo '(' . $db -> errno . ') ' . $db -> error;
        }
        $db -> close();
        exit();
      } else {
        http_response_code(200);
        $db -> close();
        exit();
      }
    }
  } else {
    http_response_code(400);
    $db -> close();
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
