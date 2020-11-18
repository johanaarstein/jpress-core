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

$_SESSION['LAST_ACTIVITY'] = $time;

include APP_ROOT . '/jp-includes/lang/lang.php';

$pageTitle = $users_str;
$bodyClass = 'admin admin-users secondary-background noindex';

include VIEW_ROOT . '/templates/header.php';
?>
<main id="main-content">
  <div class="wrapper">
    <?php
    if (isset($_GET['newuser'])) {
      if ($_GET['newuser'] = 'success') {
        echo '<p class="aligncenter">' . $userAdded_str . '!</p>';
      }
    }
    ?>
    <h2><span class="icon-usersjpress"></span> <?php echo $pageTitle; ?></h2>
    <hr class="divide"/>
    <form id="delete-user" method="post" action="/jp-includes/delete/delete-users.php">
      <table class="list-of-users">
        <thead class="hide-on-mobile">
          <tr>
            <th class="delete-user"></th>
            <th class="username"><p><?php echo $userName_str; ?></p></th>
            <th class="email"><p><?php echo $email_str; ?></p></th>
            <th class="lastlogin hide-on-mobile"><p><?php echo $lastLogin_str ?></p></th>
          </tr>
        </thead>
        <tbody id="the-list">
          <?php echo get_users(); ?>
        </tbody>
      </table>
    </form>
    <a class="theme-background background-hover new-user-btn" href="/jp-admin/register.php"><span><?php echo $addUser_str; ?></span></a>
  </div>
</main>
<?php include VIEW_ROOT . '/templates/footer.php';
