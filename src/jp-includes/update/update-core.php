<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update-core'])) {

    require_once APP_ROOT . '/jp-config/config.php';
    require APP_ROOT . '/jp-includes/app/functions.php';

    $repo = 'https://core.jpress.no/dist/JPress-';

    $version = get_siteInfo()[0]['version'];
    $versionArr = explode('.', $version);

    $flag = false;

    $target = APP_ROOT . '/core/JPress.tar.gz';
    $response = 'HTTP/1.1 200 OK';

    for ($i = 0; $i <= 10; $i++) {
      $dist = $repo . $versionArr[0] . '.' . $versionArr[1] . '.' . ($versionArr[2] + $i) . '.tar.gz';
      $headers = get_headers($dist, 1);
      if ($headers[0] === $response) {
        if ($i === 0) {
          http_response_code(200);
        } else {
          $version = $versionArr[0] . '.' . $versionArr[1] . '.' . ($versionArr[2] + $i);
          $download = file_put_contents($target, file_get_contents($dist));
          if ($download) {
            $flag = true;
          }
        }
        break;
      }
      if (($versionArr[2] + $i) === 10) {
        for ($e = 0; $e <= 10; $e++) {
          $dist = $repo . $versionArr[0] . '.' . ($versionArr[1] + 1) . '.' . $e . '.tar.gz';
          if ($headers[0] === $response) {
            $version = $versionArr[0] . '.' . ($versionArr[1] + 1) . '.' . $e;
            $download = file_put_contents($target, file_get_contents($dist));
            if ($download) {
              $flag = true;
            }
            break;
          }
          if ($e === 10) {
            for ($o = 0; $o <= 10; $o++) {
              $dist = $repo . $versionArr[0] . '.' . ($versionArr[1] + 2) . '.' . $o . '.tar.gz';
              if ($headers[0] === $response) {
                $version = $versionArr[0] . '.' . ($versionArr[1] + 1) . '.' . $o;
                $download = file_put_contents($target, file_get_contents($dist));
                if ($download) {
                  $flag = true;
                }
                break;
              }
              if ($o === 10) {
                http_response_code(302);
                echo 'Your JPress is old, and needs manual update';
                break;
              }
            }
          }
        }
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
