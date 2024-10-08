<?php
require __DIR__ . '/app/variables.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['reset-password'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    require APP_ROOT . '/jp-includes/app/functions.php';
    include APP_ROOT . '/jp-includes/lang/lang.php';

    $selector = bin2hex(random_bytes(8));
    $token = random_bytes(32);

    $resetURL = BASE_URL . "/jp-login/create-new-password.php?selector=" . $selector . "&validator=" . bin2hex($token);

    $expires = date("U") + 1800;

    $userEmail = trim($_POST["email"]);
    $username = '';

    $select =
    "SELECT `id`,
            `username`
    FROM   `users`
    WHERE  `email` = ?;";
    $selectStmt = $db -> stmt_init();
    if (!$selectStmt -> prepare($select)) {
      echo $thereWasAnError_str;
      $db -> close();
      exit();
    } else {
      $selectStmt -> bind_param('s', $userEmail);
      if ($selectStmt -> execute()) {
        $result = $selectStmt -> get_result();
        if (empty($userEmail)) {
          header('Location: /jp-login/reset.php?error=empty');
          $db -> close();
          exit();
        } elseif ($result -> num_rows !== 1) {
          header('Location: /jp-login/reset.php?error=nomatch');
          $db -> close();
          exit();
        } else {
          $delete =
          "DELETE FROM `pwdReset`
          WHERE  `pwdResetEmail` = ?;";
          $deleteStmt = $db -> stmt_init();
          if (!$deleteStmt -> prepare($delete)) {
            echo $thereWasAnError_str;
            $db -> close();
            exit();
          } else {
            while ($row = $result -> fetch_assoc()) {
              $username = $row['username'];
            }
          }

          $insert =
          "INSERT INTO `pwdReset`
                      (`pwdResetEmail`,
                       `pwdResetSelector`,
                       `pwdResetToken`,
                       `pwdResetExpires`)
          VALUES      (?,
                       ?,
                       ?,
                       ?);";
          $insertStmt = $db -> stmt_init();
          if (!$insertStmt -> prepare($insert)) {
            echo $thereWasAnError_str;
            $db -> close();
            exit();
          } else {
            $hashedToken = password_hash($token, PASSWORD_DEFAULT);
            $insertStmt -> bind_param('ssss', $userEmail, $selector, $hashedToken, $expires);
            $insertStmt -> execute();
          }

          $adminEmailDomain = str_replace(['https', 'http', '://', 'www.'], '', BASE_URL);
          if ((bool)ip2long(trim($adminEmailDomain)) !== false) {
            $adminEmailDomain = 'sendgrid.net';
          }
          $resetMessage = '<p>' . $pwdRequest_str . ': <a href="' . $resetURL . '">' . $resetURL . '</a></p>';
          $resetMessage = html_entity_decode($resetMessage);
          $siteName = getOption('sitename');

          if (getOption('sendgridSwitch') === 'checked') {
            require APP_ROOT . '/vendor/autoload.php';
            $API_KEY = getOption('sendgridAPIkey');
            $email = new \SendGrid\Mail\Mail();
            $email -> setFrom('noreply@' . $adminEmailDomain, $siteName);
            $email -> setSubject($setNewPwd_str . ' – ' . $siteName);
            $email -> addTo($userEmail, $username);
            $email -> addContent(
              "text/html", $resetMessage . '<p><em>' . $regards_str . '<strong> ' . $siteName . '</strong></em></p>'
            );
            $sendgrid = new \SendGrid($API_KEY);
            try {
              $response = $sendgrid -> send($email);
            } catch (Exception $e) {
              echo 'Caught exception: ',  $e -> getMessage(), "\n";
            } finally {
              header("Location: /jp-login/reset.php?reset=success");
              $insertStmt -> close();
              $db -> close();
              exit();
            }
          } else {
            $subject = $setNewPwd_str . ' – ' . $siteName;

            $headers = "From: $siteName <noreply@" . $adminEmailDomain . ">\r\n";
            $headers .= "Content-type: text/html\r\n";

            mail($userEmail, $subject, $resetMessage . '<p><em>' . $regards_str . '<strong> ' . $siteName . '</strong></em></p>', $headers);

            header('Location: /jp-login/reset.php?reset=success');
            $db -> close();
            exit();
          }
        }
      }
    }

  } else {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
    include APP_ROOT . '/404.php';
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
