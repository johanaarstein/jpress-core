<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

require __DIR__ . '/../jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
include APP_ROOT . '/jp-includes/app/session-timeout.php';
require APP_ROOT . '/jp-includes/app/functions.php';

if (isLoggedIn()) {
  if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header('Location: /jp-login/login.php?inactive');
    $db -> close();
    exit();
  } else {
    header("Location: /");
    $db -> close();
    exit();
  }
  $_SESSION['LAST_ACTIVITY'] = $time;
}

$username = $password = "";
$username_err = $password_err = $bruteforce_err = "";

include APP_ROOT . '/jp-includes/lang/lang.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  require APP_ROOT . '/jp-includes/app/login-query.php';
}

$pageTitle = $login_str;
$bodyClass = 'login black-background noindex';

include VIEW_ROOT . '/templates/header.php';
?>
<div id="main-content">
  <div class="wrapper">
    <div class="logo-container">
      <a href="<?php echo BASE_URL; ?>" title="<?php echo $siteName; ?>"><?php echo $logo; ?></a>
    </div>
    <span id="error-message" class="aligncenter"></span>
    <?php
    if (isset($_GET['inactive'])) {
      echo '<p class="aligncenter">' . $inactive_str . '</p>';
    }
    if (!empty($bruteforce_err)) {
      echo '<p class="aligncenter">' . $bruteforce_err . '</p>';
    } else {
      if (isset($_GET['newpwd'])) {
        if ($_GET['newpwd'] == "passwordupdated") {
          echo '<p class="signup-success aligncenter">' . $passowrdUpdated_str . '!</p>';
        }
      }
      ?>
      <form id="login-form" action="" method="post">
        <?php if ($reCAPTCHASwitch === 'checked') { ?>
        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
        <?php } ?>
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
          <input type="text" name="username" id="login-user" class="form-control" placeholder="<?php echo $userOrEmail_str; ?>">
          <span class="help-block<?php echo (!empty($username_err)) ? ' has-error' : ''; ?>"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
          <input type="password" name="password" id="login-password" class="form-control" autocapitalize="off" placeholder="<?php echo $password_str; ?>">
          <span class="help-block<?php echo (!empty($password_err)) ? ' has-error' : ''; ?>"><?php echo $password_err; ?></span>
          <span id="toggle-password" class="input-group-addon theme-background background-hover"><span class="icon-eyejpress"></span></span>
        </div>
        <div class="form-group">
          <input type="button" id="login-button" class="btn theme-background background-hover semi-link" value="<?php echo $login_str; ?>">
          <?php if ($reCAPTCHASwitch === 'checked') { ?>
          <div class="recaptcha-privacy"><p><?php echo $recaptchaLogin_str; ?></p></div>
          <?php } ?>
          <?php
          if (!isset($_GET['newpwd'])) {
            echo '<a class="forgotten-password" href="/jp-login/reset.php">' . $forgottenPwd_str . '?</a>';
          }
          ?>
        </div>
      </form>
      <?php if ($reCAPTCHASwitch === 'checked') { ?>
      <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&explicit&hl=<?php echo $lang; ?>&render=<?php echo $reCAPTCHA_siteKey; ?>" nonce="<?php echo NONCE ?>" async defer></script>
      <script nonce="<?php echo NONCE; ?>">var reCAPTCHA_siteKey="<?php echo $reCAPTCHA_siteKey; ?>";var error_str="<?php echo $thereWasAnError_str; ?>";<?php include APP_ROOT . '/plugins/recaptcha/js/login.min.js'; ?></script>
    <?php } else { ?>
      <script nonce="<?php echo NONCE; ?>">
      var loginForm=document.getElementById("login-form");loginBtn=document.getElementById("login-button"),loginForm&&loginBtn.addEventListener("click",function(){loginForm.submit()},!1);
      </script>
    <?php } ?>
      <script nonce="<?php echo NONCE; ?>">
        if(!!navigator.userAgent.match(/Trident/g) || !!navigator.userAgent.match(/MSIE/g)){var message = document.createElement('p');var wrapper = document.getElementsByClassName('wrapper')[0];loginForm.style.display = 'none';message.innerText = '<?php echo $browserError; ?>';wrapper.insertBefore(message);}
      </script>
      <?php } ?>
  </div>
</div>
<?php include APP_ROOT . '/views/templates/footer.php';
