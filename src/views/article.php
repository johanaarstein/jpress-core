<?php

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include APP_ROOT . '/jp-includes/app/session-timeout.php';

if (!isset($_GET['slug']) && !isset($_GET['g1'])) {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
} else {
  if (isset($_GET['slug'])) {
    $pageSlug = $_GET['slug'];
    if (isset($_GET['lang'])) {
      if (!empty(get_siteInfo()[0]['altLangOne']) && $_GET['lang'] === get_siteInfo()[0]['altLangOne']) {
        $lang = get_siteInfo()[0]['altLangOne'];
      } else {
        $lang = get_siteInfo()[0]['lang'];
      }
    } else {
      $lang = get_siteInfo()[0]['lang'];
    }
  } elseif (isset($_GET['g1'])) {
    $pageSlug = $_GET['g1'];
  }

  include APP_ROOT . '/jp-includes/lang/lang.php';

  if (empty(get_articleContent())) {
    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
    include APP_ROOT . '/404.php';
    exit();
  } else {

    $pageTitle = str_replace(['<h1>', '</h1>'], '', get_articleContent()[0]['title']);
    $pageLabel = get_articleContent()[0]['label'];
    $pageId = get_articleContent()[0]['id'];
    $bodyClass = 'article article-' . $pageId . ' white-background ' . strtolower($lang);
    $pageDesc = get_articleContent()[0]['excerpt'];
    $pageType = get_articleContent()[0]['type'];
    $pageContent = get_articleContent()[0]['body'];
    $created = get_articleContent()[0]['created'];
    $featuredImage = get_articleContent()[0]['featured-image'];
    $featuredImageId = get_articleContent()[0]['featuredImageId'];
    $imagePosition = get_articleContent()[0]['image-position'];
    $translatedSlug = get_articleContent()[0]['translatedSlug'];
    if (get_articleContent()[0]['published'] === 0) {
      $published = false;
    } else {
      $published = true;
    }
    $displayInMenu = get_articleContent()[0]['displayInMenu'];
    if (empty(get_articleContent()[0]['updated'])) {
      $time = $created;
    } else {
      $time = get_articleContent()[0]['updated'];
    }
    $timeParse = DateTime::createFromFormat('Y-m-d H:i:s', $time);
    setlocale(LC_TIME, $lang);
    if ($lang === 'no') {
      $timeFormat = strtolower(date('j. M, Y, H:i', strftime($timeParse->getTimestamp())));
    } else {
      $timeFormat = date('M j<\s\up>S</\s\up>, Y, g:i a', strftime($timeParse->getTimestamp()));
    }

    if (isLoggedIn()) {

    } elseif ($published === false) {
      header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
      include APP_ROOT . '/404.php';
      exit();
    }

    include APP_ROOT . '/views/templates/header.php';
    ?>
    <main id="main-content">
      <?php
      if (isLoggedIn()) { ?>
        <form id="update-article" method="post" action="">
          <input type="hidden" id="created" value="<?php echo $created; ?>">
          <input type="hidden" id="page-type" value="<?php echo $pageType; ?>">
          <input type="hidden" id="page-id" value="<?php echo $pageId; ?>">
          <input type="hidden" id="published" value="<?php echo $published; ?>">
          <input type="hidden" id="display-in-menu" value="<?php echo $displayInMenu; ?>">
          <div id="article-slug" class="hide-on-mobile white-color">
            <p><?php echo $permaLink_str; ?>: <?php echo BASE_URL; echo !empty($altLangOne) && $lang === $altLangOne ? '/' . $altLangOne : ''; ?>/<input type="hidden" name="article-slug" value="<?php echo $pageSlug; ?>"><span id="slug-output"><?php echo $pageSlug; ?></span>
              <span id="edit-slug-button">
                <button type="button" class="theme-background" aria-label="Rediger permalenke"><?php echo $edit_str ?></button>
              </span>
            </p>
          </div>
      <?php } ?>
    	<div class="content">
        <div id="article-title" class="textarea">
          <h1><?php echo $pageTitle ?></h1>
        </div>
        <div id="article-summary" class="textarea">
          <?php
          echo $pageDesc;
          ?>
        </div>
        <?php if ($pageSlug !== strtolower($privacy_str) && $pageSlug !== strtolower($contact_str)) { ?>
        <div id="featured-image-container" class="theme-background">
          <figure class="theme-background">
            <img id="featured-image-element" alt="<?php echo $pageTitle; ?>" src="<?php echo $featuredImage; ?>" style="transform: translateY(<?php echo $imagePosition; ?>%)" data-id="<?php echo $featuredImageId; ?>" />
            <figcaption<?php echo !empty(get_photoCredit()) ? ' class="theme-background"' :  ''; ?>><?php echo !empty(get_photoCredit()) ? '<span class="icon-camerajpress"></span> <strong>' . get_photoCredit() . '</strong>' : ''; ?></figcaption>
          </figure>
          <?php if (isLoggedIn()) { ?>
            <input type="hidden" id="image-position-input" name="image-position" value="<?php echo $imagePosition; ?>" data-value="<?php echo $imagePosition; ?>" data-edited="false">
            <input type="hidden" id="featured-image-input" name="featured-image-input" value="<?php echo $featuredImage; ?>">
            <input type="hidden" id="original-featured-image" value="<?php echo $featuredImage; ?>">
            <input type="hidden" id="featured-image-id" value="<?php echo $featuredImageId; ?>">
            <div class="instructions theme-background"></div>
            <div id="edit-featured-image">
              <div id="edit-featured-image-button" class="">
                <span class="button-text"><?php echo $editImage_str; ?></span>
                <span class="icon-camerajpress"></span>
                <ul class="image-menu">
                  <li>
                    <a id="image-choose" class="module-link"><span class="icon-imagesjpress"></span> <?php echo $chooseImage_str; ?></a>
                  </li>
                  <li>
                    <a id="image-upload" href="/jp-admin/upload.php"><span class="icon-uploadjpress"></span> <?php echo $uploadImage_str; ?></a>
                  </li>
                  <li class="hide-on-mobile">
                    <a id="image-position"><span class="icon-movejpress"></span> <?php echo $reposition_str; ?></a>
                  </li>
                </ul>
              </div>
            </div>
            <div id="image-buttons">
              <button id="image-cancel" class="theme-background"><?php echo $cancel_str; ?></button>
              <button id="image-save" class="theme-background">OK</button>
            </div>
          <?php } ?>
        </div>
      <?php } if ($someShareSwitch === 'checked') {
        if ($pageSlug !== strtolower($privacy_str) && $pageSlug !== strtolower($contact_str)) {
          echo get_someShare();
        }
      } ?>
        <div id="article-content" class="textarea">
          <?php
          if (!isLoggedIn()) {
            $pageContent = filterContent($pageContent);
          }
          echo $pageContent;
          ?>
        </div>
        <?php
        if (isset($pageSlug)) {
          if ($pageSlug === strtolower($privacy_str)) {
            echo '<p><em>' . $lastEdited_str . ' ' . $timeFormat . '.</em></p>';
          }
        } ?>
      </div>
      <?php
    	if(isLoggedIn()) { ?>
    		<button style="display:none;" class="jp-save-changes" type="submit" name="save-changes">
  			</button>
  		</form>
  		<?php
  		}
  		?>
    </main>
    <?php
  }
  include APP_ROOT . '/views/templates/footer.php';
}
