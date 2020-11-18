<?php
require __DIR__ . '/app/variables.php';

if (isset($_POST['reset-password-submit'])) {
  require_once APP_ROOT . '/jp-config/config.php';
  $selector = $_POST['selector'];
  $validator = $_POST['validator'];
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];

  $currentDate = date('U');

  if (empty($password)) {
    header('Location: /jp-login/create-new-password.php?error=empty');
    $db -> close();
    exit();
  } elseif ($password !== $confirmPassword) {
    header('Location: /jp-login/create-new-password.php?error=mismatch');
    $db -> close();
    exit();
  } else {
    $select =
    "SELECT `pwdResetEmail`,
           `pwdResetToken`
    FROM   `pwdReset`
    WHERE  `pwdResetSelector` = ?
           AND `pwdResetExpires` >= ?;";
    $stmt = $db -> stmt_init();
    if (!$stmt -> prepare($select)) {
      echo $thereWasAnError_str;
      $db -> close();
      exit();
    } else {
      $stmt -> bind_param('ss', $selector, $currentDate);
      $stmt -> execute();

      $result = $stmt -> get_result();
      if (!$row = $result -> fetch_assoc()) {
        echo $tryAgain_str;
        $db -> close();
        exit();
      } else {
        $tokenBin = hex2bin($validator);
        $tokenCheck = password_verify($tokenBin, $row['pwdResetToken']);

        if ($tokenCheck === false) {
          echo $tryAgain_str;
          $db -> close();
          exit();
        } elseif ($tokenCheck === true) {
          $tokenEmail = $row['pwdResetEmail'];

          $select = //debug needed
          "SELECT `password`
          FROM `users`
          WHERE `email` = ?;";
          $stmt = $db -> stmt_init();
          if (!$stmt -> prepare($select)) {
            echo $thereWasAnError_str;
            $db -> close();
            exit();
          } else {
            $stmt -> bind_param('s', $tokenEmail);
            $stmt -> execute();
            $result = $stmt -> get_result();
            if (!$row = $result -> fetch_assoc()) {
              echo $thereWasAnError_str;
              $db -> close();
              exit();
            } else {
              $select =
              "UPDATE `users`
              SET `password` = ?
              WHERE `email` = ?;";
              $stmt = $db -> stmt_init();
              if (!$stmt -> prepare($select)) {
                echo $thereWasAnError_str;
                $db -> close();
                exit();
              } else {
                $newPwdHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt -> bind_param('ss', $newPwdHash, $tokenEmail);
                $stmt -> execute();

                $select =
                "DELETE FROM `pwdReset`
                WHERE  `pwdResetEmail` = ?;";
                $stmt = $db -> stmt_init();
                if (!$stmt -> prepare($select)) {
                  echo $thereWasAnError_str;
                  $db -> close();
                  exit();
                } else {
                  $stmt -> bind_param('s', $tokenEmail);
                  $stmt -> execute();
                  header('Location: /jp-login/login.php?newpwd=passwordupdated');
                  $db -> close();
                  exit();
                }
              }
            }
          }
        }
      }
    }
  }

} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  // $db -> close();
  exit();
}
