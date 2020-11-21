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
  include APP_ROOT. '/404.php';
  exit();
}

$_SESSION['LAST_ACTIVITY'] = $time;

$bodyClass = 'media-library admin secondary-background noindex';

include APP_ROOT . '/jp-includes/lang/lang.php';

$pageTitle = $mediaLibrary_str;

include VIEW_ROOT . '/templates/header.php';
?>
<main id="main-content">
  <div class="content">
    <h2><span class="icon-mediajpress"></span> <?php echo $pageTitle; ?></h2>
    <hr class="divide"/>
    <div class="wrapper">
      <form id="upload-form" action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <input class="inputfile" type="file" accept="image/*,application/pdf,video/mp4" name="file[]" id="fileToUpload" data-multiple-caption="{count} <?php echo $filesSelected_str; ?>" multiple>
          <label class="btn theme-background background-contrast-hover" id="fileToUpload-label" for="fileToUpload"><span class="icon-uploadjpress"></span> <span class="upload-label"><?php echo $uploadImage_str; ?></span></label>
        </div>
        <div class="form-group">
          <input id="upload" class="btn theme-background background-contrast-hover semi-link" type="submit" value="<?php echo $upload_str; ?>" name="upload">
        </div>
      </form>
    </div>
    <?php echo get_media(false); ?>
  </div>
</div>
<div id="edit-single-image" class="module">
  <div class="module-inner theme-background">
    <button id="close-module" class="semi-link"><span>+</span></button>
    <div id="selected-media-container" class="black-background">
      <div id="spinner-image" class="loading-container module">
      	<div class="loading">
      		<div>
      		</div>
      		<div>
      		</div>
      		<div>
      		</div>
      		<div>
      		</div>
      	</div>
      </div>
      <span id="selected-media"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" /></span>
      <div id="fullscreen-button">
        <span class="fullscreen-button open">
          <span class="icon-fullscreenjpress"></span>
        </span>
        <span class="fullscreen-button close">
          <span class="icon-close-fullscreenjpress"></span>
        </span>
      </div>
      <div class="arrows">
        <span class="icon-jpress icon-arrowleftjpress black-background"></span>
        <span class="icon-jpress icon-arrowrightjpress black-background"></span>
      </div>
    </div>
    <div class="module-sidepanel">
      <div id="image-details" class="theme-background">
        <h3><?php echo $imageDetails_str; ?></h3>
        <table>
          <thead>
            <tr>
              <th><?php echo $fileName_str; ?>:</th>
              <th><?php echo $fileSize_str; ?>:</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td><span id="filename"></span></td>
              <td><span id="filesize"></span></td>
            </tr>
          </tbody>
        </table>
        <form id="image-details-form" action="" method="post">
          <input id="filename-input" name="filename-input" type="hidden" value="">
          <div class="form-group hide-on-mobile">
            <label for="copyurl"><strong id="copy-tooltip"><?php echo $copyLink_str ?>:</strong></label>
            <input id="copyurl" value="" type="text" readonly="">
          </div>
          <div class="form-group">
            <label><strong><?php echo $altText_str; ?>:</strong></label>
            <input type="text" name="image-alt" id="module-image-alt" class="input-field" value="">
          </div>
          <div class="form-group">
            <label><strong><?php echo $photoCredit_str; ?>:</strong></label>
            <input type="text" name="photo-credit" id="module-photo-credit" class="input-field" value="">
          </div>
          <div class="form-group">
            <label><strong><?php echo $useCaption_str; ?>:</strong></label>
            <textarea id="caption-input" class="input-field"></textarea>
          </div>
          <button type="button" name="save-image-details" id="save-image-details" class="btn semi-link secondary-background">OK</button>
        </form>
        <form action="" method="post" id="delete-file">
          <label class="semi-link" for="delete-file-input"><span class="icon-deletejpress"></span> <?php echo $deleteFile_str; ?></label>
          <input name="filename" type="submit" value="" id="delete-file-input">
        </form>
      </div>
    </div>
  </div>
  <div class="module-backdrop">
  </div>
</main>
<?php if (isset($_GET['action']) && $_GET['action'] == 'upload') {
  echo '<script nonce="' . NONCE . '">document.onload=function(){document.getElementById("fileToUpload").click();};</script>';
}
include VIEW_ROOT . '/templates/footer.php';
