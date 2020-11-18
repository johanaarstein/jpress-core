<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update-footer'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    require APP_ROOT . '/jp-includes/app/functions.php';

    $lang = $_POST['lang'];
    $columnOne = cSHY($_POST['column-one']);
    $columnTwo = cSHY($_POST['column-two']);
    $columnThree = cSHY($_POST['column-three']);

    $footerClass = $_POST['footer-class'];
    if (!empty($_POST['footer-background-image-id'])) {
      $footerBackgroundImageId = $_POST['footer-background-image-id'];
    } else {
      $footerBackgroundImageId = 0;
    }
    $footerBackgroundImage = $_POST['footer-background-image'];

    $select =
    "SELECT `id`
    FROM    `footer`;";
    $result = $db -> query($select);
    if ($result && $result -> num_rows > 0) {
      $update = $db -> query(
        "UPDATE `footer`
        SET    `columnOne`                = '$columnOne',
               `columnTwo`                = '$columnTwo',
               `columnThree`              = '$columnThree',
               `footerClass`              = '$footerClass',
               `footerBackgroundImageId`  = '$footerBackgroundImageId',
               `footerBackgroundImage`    = '$footerBackgroundImage',
               `created`                  = Now()
        WHERE  `lang`                     = '$lang';"
      );
      if ($update) {
        http_response_code(200);
        $db -> close();
        exit();
      } elseif ($db -> error) {
        http_response_code(500);
        echo '(' . $db -> errno . '): ' . $db -> error;
        $db -> close();
        exit();
      } else {
        http_response_code(500);
        $db -> close();
        exit();
      }
    } else {
      $insert = $db -> query(
        "INSERT INTO  `footer`
                      (`lang`,
                      `columnOne`,
                      `columnTwo`,
                      `columnThree`,
                      `footerClass`,
                      `footerBackgroundImageId`,
                      `footerBackgroundImage`,
                      `created`)
        VALUES        ('$lang',
                      '$columnOne',
                      '$columnTwo',
                      '$columnThree',
                      '$footerClass',
                      '$footerBackgroundImageId',
                      '$footerBackgroundImage',
                      Now());"
      );
      if ($insert) {
        http_response_code(200);
        $db -> close();
        exit();
      } elseif ($db -> error) {
        http_response_code(500);
        echo '(' . $db -> errno . '): ' . $db -> error;
        $db -> close();
        exit();
      } else {
        http_response_code(500);
        $db -> close();
        exit();
      }
    }
  } else {
    http_response_code(400);
    // $db -> close();
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  // $db -> close();
  exit();
}
