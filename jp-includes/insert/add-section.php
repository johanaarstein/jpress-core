<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['new-section'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    include APP_ROOT . '/jp-includes/lang/lang.php';

    $lang = $_POST['content-lang'];
    $arrayIndex = $_POST['array-index'];

    $insert = $db -> query(
      "INSERT INTO `home`
                  (`arrayIndex`,
                   `lang`,
                   `sectionText`,
                   `backgroundSVG`,
                   `created`)
      VALUES      ('$arrayIndex',
                   '$lang',
                   '',
                   '',
                   Now());"
    );

    if (!$insert) {
      if ($db -> error) {
        http_response_code(500);
        echo '(' . $db -> errno . '): ' . $db -> error;
        $db -> close();
        exit();
      }
    }

    $select =
    "SELECT `id`
    FROM   `home`
    ORDER  BY `id` DESC
    LIMIT  1;";
    $result = $db -> query($select);
    if ($result && $result -> num_rows > 0) {
      while ($row = $result -> fetch_assoc()) {
        $id = $row['id'];
      }
    }

    if ($select) {
      if (isset($id)) {
        $data = ['id' => $id];
        http_response_code(201);
        header('Content-Type: application/json');
        echo json_encode($data, JSON_NUMERIC_CHECK);
        $db -> close();
        exit();
      } else {
        http_response_code(200);
        $db -> close();
        exit();
      }
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
    http_response_code(400);
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  // $db -> close();
  exit();
}
