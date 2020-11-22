<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update-core'])) {

    require_once APP_ROOT . '/jp-config/config.php';
    require APP_ROOT . '/jp-includes/app/functions.php';

    $repo = 'https://core.jpress.no/dist/JPress-';

    $version = get_siteInfo()[0]['version'];
    $versionArr = explode('.', $version);
    $major = $versionArr[0];
    $minor = $versionArr[1];
    $patch = $versionArr[2];

    $flag = false;
    $n = 0;

    $target = APP_ROOT . '/core/JPress.tar.gz';
    $response = 'HTTP/1.1 200 OK';
    $dist = '';
    $headers = get_headers($dist, 1);

    $download = file_put_contents($target, file_get_contents($dist));

    for ($i = 0; $i <= 51; $i++) {
      if (($n === 0 && ($patch + $i) === 50) || $i === 50) {
        $n += 1;
        $i = $patch = 0;
      }
      $dist = $repo . $major . '.' . ($minor + $n) . '.' . ($patch + $i) . '.tar.gz';
      if ($headers[0] === $response) {
        if ($i === 0) {
          http_response_code(200);
        } else {
          $version = $major . '.' . ($minor + $n) . '.' . ($patch + $i);
          if ($download) {
            $flag = true;
          }
        }
        break;
      }
      if ($n === 50) {
        http_response_code(302);
        echo 'Your JPress is old, and needs manual update';
        break;
      }
    }

    if ($version !== get_siteInfo()[0]['version']) {
      if ($flag) {
        try {
          $phar = new PharData($target);
          $phar -> extractTo(APP_ROOT, null, true);
          unlink($target);
          custom_copy(APP_ROOT . '/src', APP_ROOT);
          rrmdir(APP_ROOT . '/src');
        } catch (Exception $e) {
          http_response_code(500);
          if (!empty($e)) {
            echo $e;
          } else {
            echo 'Unknown Error';
          }
          $db -> close();
          exit();
        }

        $update = $db -> query(
          "UPDATE `siteInfo`
          SET     `version`   = '$version',
                  `created`   = Now();"
        );
        if (!$update) {
          http_response_code(500);
          if ($db -> error) {
            echo '(' . $db -> errno . '): ' . $db -> error;
          }
          $db -> close();
          exit();
        }
      } else {
        http_response_code(500);
        echo 'Permission Denied';
        exit();
      }
    }

  } else {
    http_response_code(400);
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
