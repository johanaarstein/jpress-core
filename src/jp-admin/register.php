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
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}

$bodyClass = 'admin secondary-background noindex';

include APP_ROOT . '/jp-includes/lang/lang.php';

$pageTitle = $newUser_str;

$_SESSION['LAST_ACTIVITY'] = $time;

include VIEW_ROOT . '/templates/header.php';
?>
<main id="main-content">
  <div class="wrapper">
    <h2><span class="icon-userjpress"></span> <?php echo $pageTitle; ?></h2>
    <hr class="divide"/>
    <form id="add-user-form" action="" method="post">
      <div class="form-group">
        <label><?php echo $newUserName_str; ?></label>
        <input type="text" name="username" id="username" class="form-control white-background">
        <span class="help-block"></span>
      </div>
      <div class="form-group">
        <label><?php echo $email_str; ?></label>
        <input type="text" name="email" id="email" class="form-control white-background">
        <span class="help-block"></span>
      </div>
      <div class="form-group">
        <label><?php echo $newPassword_str; ?></label>
        <input autocomplete="new-password" type="password" id="password" name="password" class="form-control white-background">
        <span class="help-block"></span>
      </div>
      <div class="form-group">
        <label><?php echo $newPasswordConfirm_str; ?></label>
        <input autocomplete="new-password" type="password" id="confirm_password" name="confirm_password" class="form-control white-background">
        <span class="help-block"></span>
      </div>
      <?php
      if (isAdmin()) { ?>
      <div class="form-group">
        <label><?php echo $userRole_str; ?></label>
        <select id="user-role" name="user-role" class="theme-background">
          <option "selected" value="editor"><?php echo $editor_str; ?></option>
          <option value="admin">Admin</option>
        </select>
      </div>
      <?php
    } else { ?>
      <input id="user-role" value="editor" type="hidden">
      <?php
    } ?>
      <div class="form-group">
        <input type="submit" class="btn semi-link theme-background background-contrast-hover" value="<?php echo $add_str; ?>">
      </div>
    </form>
  </div>
</main>
<?php include VIEW_ROOT . '/templates/footer.php';
