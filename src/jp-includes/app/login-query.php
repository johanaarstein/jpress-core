<?php
$credentials = $password = $username = $email = '';

if (!function_exists('isPageSpeed')) {
  function isPageSpeed() {
    $output = false;
    $headers = apache_response_headers();
    if (isset($headers['X-Mod-Pagespeed']) || isset($headers['X-Page-Speed'])) {
      $output = true;
    }
    return $output;
  }
}

$ip = $_SERVER["REMOTE_ADDR"];
$insert = $db -> query(
  "INSERT INTO `ip`
              (`address`,
               `timestamp`)
  VALUES      ('$ip',
               CURRENT_TIMESTAMP);"
);

if (!$insert) {
  if ($db -> error) {
    printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
  } else {
    printf($thereWasAnError_str);
  }
  $db -> close();
  exit();
}

$select =
"SELECT Count(`address`)
FROM   `ip`
WHERE  `address` LIKE '$ip'
       AND TIMESTAMP > ( Now() - INTERVAL 10 minute );";
$count = $db -> query($select) -> fetch_array(MYSQLI_NUM);

if (!$select) {
  if ($db -> error) {
    printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
  } else {
    printf($thereWasAnError_str);
  }
  $db -> close();
  exit();
}

if ($count[0] > 3) {
  $bruteforce_err = $bruteforce_str;
}

if (empty(trim($_POST["username"]))) {
  $username_err = $noUsername_str;
} else {
  $credentials = trim($_POST["username"]);
}

if (filter_var($credentials, FILTER_VALIDATE_EMAIL)) {
  $email = $credentials;
} else {
  $username = $credentials;
}

if (empty(trim($_POST["password"]))) {
  $password_err = $noPass_str;
} else {
  $password = trim($_POST["password"]);
}

if (empty($username_err) && empty($password_err) && empty($bruteforce_err)) {
  $select =
  "SELECT `id`,
         `username`,
         `email`,
         `password`
  FROM   `users`
  WHERE  `username` = ?
          OR `email` = ?
  LIMIT  1;";

  if (!$select) {
    if ($db -> error) {
      printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
    } else {
      printf($thereWasAnError_str);
    }
    $db -> close();
    exit();
  }

  $stmt = $db -> stmt_init();
  if ($stmt -> prepare($select)) {
    $stmt -> bind_param("ss", $param_username, $param_email);
    $param_username = $username;
    $param_email = $email;
    if ($stmt -> execute()) {
      $stmt -> store_result();
      if ($stmt -> num_rows === 1) {
        $stmt -> bind_result($id, $username, $email, $hashed_password);
        if ($stmt -> fetch()) {
          if (password_verify($password, $hashed_password)) {

            $_SESSION['loggedin'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            $date = new DateTime("now", new DateTimeZone('Europe/Oslo') );
            $dateNo = $date -> format('Y-m-d H:i:s');

            $update =
            "UPDATE `users`
            SET    `lastlogin` = ?
            WHERE  `username` = ?;";
            $stmt = $db -> stmt_init();
            if (!$stmt -> prepare($update)) {
              if ($db -> error) {
                printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
              } else {
                printf($thereWasAnError_str);
              }
              $stmt -> close();
              exit();
            } else {
              $stmt -> bind_param('ss', $dateNo, $username);
              $stmt -> execute();
            }
            if (isPageSpeed()) {
              header("Location: /?ModPagespeed=off");
            } else {
              header("Location: /");
            }
            $stmt -> close();
            $db -> close();
            exit();
          } else {
            $password_err = $wrongPass_str;
            $stmt -> close();
          }
        }
      } else {
        $username_err = $unknownUser_str;
        $stmt -> close();
      }
    } else {
      if ($db -> error) {
        printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
      } else {
        printf($thereWasAnError_str);
      }
      $stmt -> close();
      exit();
    }
  } else {
    if ($db -> error) {
      printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
    } else {
      printf($thereWasAnError_str);
    }
    $stmt -> close();
    $db -> close();
    exit();
  }
}
