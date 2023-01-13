<?php
require __DIR__ . '/../app/variables.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once APP_ROOT . '/jp-config/config.php';
  require APP_ROOT . '/jp-includes/app/functions.php';
  include APP_ROOT . '/jp-includes/lang/lang.php';

  if (getOption('reCAPTCHASwitch') === 'checked') {
    if (!isset($_POST['recaptcha_response'])) {
      http_response_code(400);
      echo $thereWasAnError_str;
      $db -> close();
      exit();
    }
  }

  $mainEmail = $siteName = $reCAPTCHA_serverKey = $sendgridAPIkey = $cfRB = '';

  $mainEmail = getOption('mainEmail');
  $siteName = html_entity_decode(getOption('sitename'));
  $reCAPTCHA_serverKey = getOption('reCAPTCHA_serverKey');
  $sendgridAPIkey = getOption('sendgridAPIkey');

  if (!empty($mainEmail)) {

    if (getOption('reCAPTCHASwitch') === 'checked') {
      $reCAPTCHA_url = 'https://www.google.com/recaptcha/api/siteverify';
      $reCAPTCHA_response = filter_input(INPUT_POST, 'recaptcha_response', FILTER_SANITIZE_STRING);
      $reCAPTCHA = file_get_contents($reCAPTCHA_url . '?secret=' . $reCAPTCHA_serverKey . '&response=' . $reCAPTCHA_response);
      $reCAPTCHA = json_decode($reCAPTCHA);

      if (!isset($reCAPTCHA -> score) || $reCAPTCHA -> score < 0.5) {
        http_response_code(400);
        echo $reCAPTCHAError_str;
        $db -> close();
        exit();
      }
    }

    if (!empty($_POST['cf-name'])) {
      $cfName = test_input($_POST['cf-name']);
    } else {
      http_response_code(400);
      echo $emptyName_str;
      exit();
    }
    if (!empty($_POST['cf-email'])) {
      $cfEmail = test_input($_POST['cf-email']);
      if (!filter_var($cfEmail, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo $invalidEmail_str . ' (' . $cfEmail . ')';
        exit();
      }
    } else {
      http_response_code(400);
      echo $emptyEmail_str;
      exit();
    }
    if (!empty($_POST['cf-message'])) {
      $cfMessage = test_input($_POST['cf-message']);
    } else {
      http_response_code(400);
      echo $emptyMessage_str;
      exit();
    }

    if ($_POST['site-lang'] === getOption('altLangOne')) {
      $cfRB = getOption('cfReceiptBodyAltLang');
    } else {
      $cfRB = getOption('cfReceiptBody');
    }

    $adminEmailDomain = str_replace(['https', 'http', '://', 'www.'], '', BASE_URL);

    if (getOption('sendgridSwitch') === 'checked') {
      if ((bool)ip2long(trim($adminEmailDomain)) !== false) {
        $adminEmailDomain = 'sendgrid.net';
      }
      require APP_ROOT . '/jp-includes/plugins/sendgrid/vendor/autoload.php';
      $email = new \SendGrid\Mail\Mail();
      $email -> setFrom(strtolower($contact_str) . '@' . $adminEmailDomain, $contactForm_str . ' – ' . $siteName);
      $email -> setSubject($newMessageFrom_str . ' ' . $cfName);
      $email -> addTo($mainEmail, $siteName);
      $email -> addContent(
        "text/html", $cfMessage . '<br><em>' . $regards_str . ' <strong>' . $cfName . '</strong></em><br>' . $cfEmail
      );

      $sendgrid = new \SendGrid($sendgridAPIkey);
      if (empty($cfRB)) {
        try {
          $response = $sendgrid -> send($email);
          print $response -> statusCode() . "\n";
          print_r($response -> headers());
          print $response -> body() . "\n";
          http_response_code(200);
        } catch (Exception $e) {
          http_response_code(400);
          echo 'Caught exception: ',  $e -> getMessage(), "\n";
        } finally {
          $db -> close();
          exit();
        }
      } else {
        $receiptMail = new \SendGrid\Mail\Mail();
        $receiptMail -> setFrom('noreply@' . $adminEmailDomain, $contactForm_str . ' – ' . $siteName);
        $receiptMail -> setSubject($cfReceipt_str . ' ' . $siteName);
        $receiptMail -> addTo($cfEmail, $cfName);
        $receiptMail -> addContent("text/html", $cfRB);
        try {
          $response = $sendgrid -> send($email);
          print $response -> statusCode() . "\n";
          print_r($response -> headers());
          print $response -> body() . "\n";
          http_response_code(200);
        } catch (Exception $e) {
          http_response_code(400);
          echo 'Caught exception: ',  $e -> getMessage(), "\n";
        }
        try {
          $response = $sendgrid -> send($receiptMail);
          print $response -> statusCode() . "\n";
          print_r($response -> headers());
          print $response -> body() . "\n";
          http_response_code(200);
        } catch (Exception $e) {
          http_response_code(400);
          echo 'Caught exception: ',  $e -> getMessage(), "\n";
        } finally {
          $db -> close();
          exit();
        }
      }
    } else {
      $subject = $newMessageFrom_str . ' ' . $cfName;

      $headers = "From: $siteName <noreply@" . $adminEmailDomain . ">\r\n";
      $headers .= "Content-type: text/html; charset=utf-8\r\n";

      $emailBody = $cfMessage . '<br><em>' . $regards_str . ' <strong>' . $cfName . '</strong></em><br>' . $cfEmail;

      mail($mainEmail, $subject, $emailBody, $headers);

      if (!empty($cfRB)) {
        mail($cfEmail, preg_replace("/\r\n|\r|\n/", '<br>', $cfReceipt_str), $cfRB, $headers);
      }

      http_response_code(200);
      $db -> close();
      exit();
    }
  } else {
    http_response_code(400);
    echo $missingAdminMail_str;
    $db -> close();
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
