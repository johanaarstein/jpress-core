<?php
require __DIR__ . '/../app/variables.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['add-user'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    require APP_ROOT . '/jp-includes/app/functions.php';
    include APP_ROOT . '/jp-includes/lang/lang.php';

    // Validate username
    if (empty(trim($_POST['username']))) {
      http_response_code(406);
      echo $noUsername_str;
      $db -> close();
    } else {
      $select =
      "SELECT `id`
      FROM   `users`
      WHERE  `username` = ?;";
      $stmt = $db -> stmt_init();
      if ($stmt -> prepare($select)) {
        $stmt -> bind_param('s', $param_username);
        $param_username = trim($_POST['username']);
        if ($stmt -> execute()) {
          $stmt -> store_result();
          if ($stmt -> num_rows == 1) {
            http_response_code(406);
            echo $takenUsername_str;
            $db -> close();
          } else {
            $username = trim($_POST['username']);
          }
        } else {
          http_response_code(500);
          echo $oops_str;
          $db -> close();
          exit;
        }
      }
      $stmt -> close();
    }

    // Validate email
    if (empty(trim($_POST['email']))) {
      http_response_code(406);
      echo $writeEmail_str;
      $db -> close();
      exit;
    } else {
      $select =
      "SELECT `id`
      FROM   `users`
      WHERE  `email` = ?;";
      $stmt = $db -> stmt_init();
      if ($stmt -> prepare($select)) {
        $stmt -> bind_param('s', $param_email);
        $param_email = trim($_POST['email']);
        if ($stmt -> execute()) {
          $stmt -> store_result();
          if ($stmt -> num_rows == 1) {
            http_response_code(406);
            echo $takenEmail_str;
            $db -> close();
            exit;
          } else {
            $userEmail = trim($_POST['email']);
          }
        } else {
          http_response_code(500);
          echo $oops_str;
          $db -> close();
          exit;
        }
      }
      $stmt -> close();
    }

    // Validate password
    if (empty(trim($_POST['password']))) {
      http_response_code(406);
      echo $noPass_str;
      $db -> close();
      exit;
    } elseif (strlen(trim($_POST['password'])) < 6) {
      http_response_code(406);
      echo $shortPwd_str;
      $db -> close();
      exit;
    } else {
      $password = trim($_POST['password']);
    }

    // Validate confirm password
    if (empty(trim($_POST['confirm_password']))) {
      http_response_code(406);
      echo $newPasswordConfirm_str;
      $db -> close();
      exit;
    } else {
      $confirm_password = trim($_POST['confirm_password']);
      if ($password != $confirm_password) {
        http_response_code(406);
        echo $pwdNoMatch_str;
        $db -> close();
        exit;
      }
    }

    if ($_POST['user_role'] === 'admin') {
      $userRole = 'admin';
    } else {
      $userRole = 'editor';
    }

    $insert =
    "INSERT INTO  `users`
                  (`username`,
                  `email`,
                  `password`,
                  `role`,
                  `lastlogin`)
    VALUES        (?,
                  ?,
                  ?,
                  '$userRole',
                  NULL);";
    $stmt = $db -> stmt_init();
    if ($stmt -> prepare($insert)) {
      $stmt -> bind_param("sss", $param_username, $param_email, $param_password);
      $param_username = $username;
      $param_email = $userEmail;
      $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
      if ($stmt -> execute()) {
        $domain = $protocol . $_SERVER['SERVER_NAME'];
        $resetUrl = $domain . '/jp-login/reset.php';
        $loginUrl = $domain . '/jp-login/';
        if (strpos($domain, '//www.') !== false) {
          $adminEmailDomain = str_replace($protocol . 'www.', '', $domain);
        } else {
          $adminEmailDomain = $_SERVER['SERVER_NAME'];
        }

        if ((bool)ip2long(trim($adminEmailDomain)) !== false) {
          $adminEmailDomain = 'sendgrid.net';
        }

        $regMessage = '<p>' . $yourLoginUrl_str . ': <a href="' . $loginUrl . '">' . $loginUrl . '</a></p>';
        $regMessage .= '<p>' . $yourUserName_str . ': ' . $username . '<br>';
        $regMessage .= $yourPassword_str . ': ' . $password . '</p>';
        $regMessage .= '<p>' . $toSetNewPwd_str . '<br>';
        $regMessage .= '<a href="' . $resetUrl . '">' . $resetUrl . '</a></p>';

        $regMessage = html_entity_decode($regMessage);

        $siteName = html_entity_decode(getOption()['sitename']);

        if (getOption()['sendgridSwitch'] === 'checked') {
          require APP_ROOT . '/jp-includes/plugins/sendgrid/vendor/autoload.php';
          $API_KEY = getOption()['sendgridAPIkey'];
          $email = new \SendGrid\Mail\Mail();
          $email -> setFrom('noreply@' . $adminEmailDomain, $siteName);
          $email -> setSubject($newUser_str . ' – ' . $siteName);
          $email -> addTo($userEmail, $username);
          $email -> addContent(
            "text/html", $regMessage . '<p><em>' . $regards_str . '<strong> ' . $siteName . '</strong></em></p>'
          );
          $sendgrid = new \SendGrid($API_KEY);
          try {
            $response = $sendgrid -> send($email);
          } catch (Exception $e) {
            http_response_code(406);
            echo 'Caught exception: ',  $e -> getMessage(), "\n";
            $db -> close();
            exit;
          } finally {
            // header("Location: /jp-admin/users.php?newuser=success");
            http_response_code(200);
            $stmt -> close();
            $db -> close();
            exit();
          }
        } else {
          $subject = $newUser_str . ' – ' . $siteName;

          $headers = "From: " . $siteName . " <noreply@" . $adminEmailDomain . ">\r\n";
          $headers .= "Content-type: text/html\r\n";

          mail($userEmail, $subject, $regMessage, $headers);

          header("Location: /jp-admin/users.php?newuser=success");
          exit();
        }
      } else {
        http_response_code(500);
        if ($db -> error) {
          echo '(' . $db -> errno . '): ' . $db -> error;
        } else {
          echo $thereWasAnError_str . ' – Statement Excecute';
        }
        $db -> close();
        exit();
      }
    } else {
      http_response_code(500);
      if ($db -> error) {
        echo '(' . $db -> errno . '): ' . $db -> error;
      } else {
        echo $thereWasAnError_str . ' – Statement Prepare';
      }
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
  exit();
}
