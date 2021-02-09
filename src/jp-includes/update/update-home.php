<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once APP_ROOT . '/jp-config/config.php';
  require APP_ROOT . '/jp-includes/app/functions.php';

  $json = file_get_contents('php://input');
  $data = json_decode(urldecode($json), true);
  $count = count($data);

  for ($i = 0; $i < $count; $i++) {
    $bgImage = str_replace(BASE_URL, '', $data[$i]['background-image']);
    $lang = $data[$i]['content-lang'];
    $id = $data[$i]['section-id'];
    $class = $data[$i]['class'];
    $sectionText = cSHY($data[$i]['section-text']);
    $arrayIndex = $data[$i]['array-index'];

    $update = $db -> query(
      "UPDATE `home`
      SET    `sectionText` = '$sectionText',
             `class` = '$class',
             `backgroundImage` = '$bgImage',
             `arrayIndex` = '$arrayIndex',
             `created` = Now()
      WHERE  `id` = '$id';"
    );

    if ($db -> error) {
      http_response_code(500);
      header('Content-Type: application/x-www-form-urlencoded');
      echo '(' . $db -> errno . '): ' . $db -> error;
      $db -> close();
      exit();
    }

    if (!empty($sectionText)) {
      $insert = $db -> query(
        "INSERT INTO `home_revisions`
                    (`lang`,
                     `sectionText`,
                     `initialID`,
                     `created`)
        VALUES      ('$lang',
                     '$sectionText',
                     '$id',
                     Now());"
      );
    }
  }

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
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  // $db -> close();
  exit();
}
