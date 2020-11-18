<?php
require_once __DIR__ . '/jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$pageTitle = '404';
$bodyClass = 'notfound noindex theme-background';

require_once APP_ROOT . '/jp-includes/app/functions.php';
include_once APP_ROOT . '/jp-includes/lang/lang.php';
include_once VIEW_ROOT . '/templates/header.php';
?>
<main id="main-content">
  <div class="content">
    <div class="notfound-message">
      <h1>404</h1>
      <p><?php echo $notFoundMessage; ?></p>
    </div>
  </div>
</main>
<?php
include_once APP_ROOT . '/views/templates/footer.php';
