<?php
require __DIR__ . '/jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
require APP_ROOT . '/jp-includes/app/functions.php';

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include APP_ROOT . '/jp-includes/app/session-timeout.php';

$siteName = get_siteInfo()['sitename'];
$altLangOne = get_siteInfo()['altLangOne'];
if (isset($_GET['g1']) && $_GET['g1'] == $altLangOne) {
  $lang = $altLangOne;
} else {
  $lang = get_siteInfo()['lang'];
}

include APP_ROOT . '/jp-includes/lang/lang.php';

$pageTitle = $siteName;
$bodyClass = 'old-browsers theme-background noindex ' . strtolower($lang);

if (isLoggedIn()) {
  if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header('Location: /');
    exit();
  }

  $_SESSION['LAST_ACTIVITY'] = $time;
}

include VIEW_ROOT . '/templates/header.php';
?>
<style>body.module-open{overflow:initial;}#spinner-global{opacity:0;display:none;}#main-content{opacity: 1;}</style>
<div id="main-content">
  <div class="section" style="background-color: <?php echo $secondaryColor; ?>">
    <div class="content">
      <div class="textarea">
        <h1><?php echo $pageTitle; ?></h1>
        <img src="<?php echo $featuredImage; ?>" class="aligncenter" />
        <p><?php echo $oldBrowser_str; ?></p>
      </div>
    </div>
  </div>
</div>
<div id="footer" style="background-color: <?php echo $secondaryColor; ?>">
  <div id="footer-bottom">
    <div class="legal">
      <p><span class="current-year"></span> &copy; <?php echo $siteName ?><br><a id="privacy-link" href="/<?php if (!empty($altLangOne) && $lang === $altLangOne) { echo $altLangOne . '/'; } echo strtolower($privacy_str); ?>/"><?php echo $privacyLink_str; ?></a></p>
    </div>
  </div>
</div>
