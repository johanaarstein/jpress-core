<?php
require __DIR__ . '/../jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';

$password = $password_err = $confirm_password = $confirm_password_err = "";

require APP_ROOT . '/jp-includes/app/functions.php';
include APP_ROOT . '/jp-includes/lang/lang.php';

$pageTitle = $setNewPwd_str;
$bodyClass = 'login theme-background noindex';

include APP_ROOT . '/views/templates/header.php';

?>
<div id="main-content">
  <div class="wrapper">
    <?php
      $selector = $_GET['selector'];
      $validator = $_GET['validator'];

      if (empty($selector) || empty($validator)) {
        if (isset($_GET['error'])) {
          if ($_GET['error'] == 'empty') {
            echo '<p class="verify-failure">' . $didntWritePassword_str . ' <a href="javascript:history.back()">' . $tryAgain_str . '</a></p>';
          } elseif ($_GET['error'] == 'mismatch') {
            echo '<p class="verify-failure">' . $pwdNoMatch_str . ' <a href="javascript:history.back()">' . $tryAgain_str . '</a></p>';
          }
        } else {
          echo '<p class="verify-failure">' . $cantVerifyRequest_str . '</p>';
        }
      } elseif (ctype_xdigit($selector) !== false && ctype_xdigit($validator) !== false) {
        ?>
        <form action="/jp-includes/reset-password.php" method="post">
          <input type="hidden" name="selector" value="<?php echo $selector; ?>">
          <input type="hidden" name="validator" value="<?php echo $validator; ?>">
          <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label><?php echo $newPassword_str; ?></label>
            <input autocomplete="new-password" type="password" name="password" class="form-control" value="<?php echo $password; ?>">
            <span class="help-block"><?php echo $password_err; ?></span>
          </div>
          <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label><?php echo $newPasswordConfirm_str; ?></label>
            <input autocomplete="new-password" type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
          </div>
          <div class="form-group">
            <input name="reset-password-submit" type="submit" class="btn semi-link theme-background background-hover" value="<?php echo $setNewPwd_str; ?>">
          </div>
        </form>
        <?php
      } else {
        '<p class="verify-failure">' . $cantVerifyRequest_str . '</p>';
      }
    ?>
  </div>
</div>
<?php
include APP_ROOT . '/views/templates/footer.php';
?>
