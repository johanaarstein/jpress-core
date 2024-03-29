<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

include APP_ROOT . '/jp-includes/app/session-timeout.php';

$siteName = getOption('sitename');
$altLangOne = getOption('altLangOne');
if (isset($_GET['g1']) && $_GET['g1'] === $altLangOne) {
  $lang = $altLangOne;
} else {
  $lang = getOption('lang');
}

$bodyClass = 'home theme-background ' . strtolower($lang);

include APP_ROOT . '/jp-includes/lang/lang.php';

$pageTitle = $siteName;

if (isLoggedIn()) {
  if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    session_unset();
    session_destroy();
    header('Location: /');
    exit();
  }

  // if (isPageSpeed() && !isset($_GET['ModPagespeed'])) {
  //   header('Location: /?ModPagespeed=off');
  // }

  $_SESSION['LAST_ACTIVITY'] = $time;
}

include VIEW_ROOT . '/templates/header.php';

if (isLoggedIn()) { ?>
<form id="update-frontpage" method="post" action="">
<?php
} ?>
<main id="main-content">
<?php
if (!empty(get_homeContent())) {
  $i = 0;
  $count = count(get_homeContent());
  $revFormat = new \IntlDateFormatter($lang, IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Europe/Oslo');
  while ($i < $count) {
    $closingDivs = true;
    $id = get_homeContent()[$i]['id'];
    $sectionText = get_homeContent()[$i]['sectionText'];
    $class = get_homeContent()[$i]['class'];
    $cssId = get_homeContent()[$i]['cssId'];
    $backgroundImage = get_homeContent()[$i]['backgroundImage'];
    $backgroundSVG = get_homeContent()[$i]['backgroundSVG'];
    $photoCredit = get_homeContent()[$i]['photoCredit'];
    $arrayIndex = get_homeContent()[$i]['arrayIndex'];
    if (($i + 1) !== 1 && !empty($sectionText) && (strpos($class, 'parallax-background-css') === false) && (strpos($class, 'text') === false)) {
      $class .= ' text';
    } ?>
    <section <?php echo !empty($cssId) ? 'id="' . $cssId . '" ' : ''; ?>class="section-<?php echo $i + 1; echo !empty($class) ? ' ' . $class : ''; ?>" <?php
    echo strpos($class, 'parallax-background-css') !== false && !empty($backgroundImage) ? 'data-background="' . $backgroundImage . '"' : ''; ?>>
      <?php
      if (isLoggedIn()) { ?>
        <input type="hidden" name="content-id[]" class="content-id" value="<?php echo $id; ?>">
        <input type="hidden" name="content-lang[]" class="content-lang" value="<?php echo $lang; ?>">
        <input type="hidden" name="class[]" class="class" value="<?php echo $class; ?>">
        <input type="hidden" name="background-image[]" class="background-image" value="<?php echo $backgroundImage; ?>">
        <input type="hidden" name="array-index[]" class="array-index" value="<?php echo $arrayIndex; ?>">
        <div class="edit-section" data-id="<?php echo $id; ?>">
          <div class="edit-section-button">
            <span class="button-text"><?php echo $editSection_str; ?></span>
            <span class="icon-settingsjpress"></span>
            <ul class="section-menu">
              <li>
                <a id="edit-background-<?php echo $i + 1; ?>" class="edit-background" href="#">
                  <span class="icon-paintbucketjpress"></span> <?php echo $editBackground_str; ?>
                </a>
              </li>
              <ul class="edit-background-options radio-list">
                <li>
                  <input type="radio" class="theme-background" id="theme-background-<?php echo $i + 1; ?>" name="background-options-<?php echo $i + 1; ?>" <?php echo strpos($class, 'theme-background') !== false ? 'checked ' : ''; ?>value="theme-background">
                  <label class="semi-link" for="theme-background-<?php echo $i + 1; ?>"></label>
                  <div class="check"><div class="inside"></div></div>
                </li>
                <li>
                  <input type="radio" class="secondary-background" id="secondary-background-<?php echo $i + 1; ?>" name="background-options-<?php echo $i + 1; ?>" <?php echo strpos($class, 'secondary-background') !== false ? 'checked ' : ''; ?>value="secondary-background">
                  <label class="semi-link" for="secondary-background-<?php echo $i + 1; ?>"></label>
                  <div class="check"><div class="inside"></div></div>
                </li>
                <li>
                  <input type="radio" class="white-background" id="white-background-<?php echo $i + 1; ?>" name="background-options-<?php echo $i + 1; ?>" <?php echo strpos($class, 'white-background') !== false ? 'checked ' : ''; ?>value="white-background">
                  <label class="semi-link" for="white-background-<?php echo $i + 1; ?>"></label>
                  <div class="check"><div class="inside"></div></div>
                </li>
                <li>
                  <input type="radio" class="black-background" id="black-background-<?php echo $i + 1; ?>" name="background-options-<?php echo $i + 1; ?>" <?php echo strpos($class, 'black-background') !== false ? 'checked ' : ''; ?>value="black-background">
                  <label class="semi-link" for="black-background-<?php echo $i + 1; ?>"><?php echo $black_str; ?></label>
                  <div class="check"><div class="inside"></div></div>
                </li>
                <li>
                  <input type="radio" class="image-background" id="image-background-<?php echo $i + 1; ?>" name="background-options-<?php echo $i + 1; ?>" <?php echo $class === 'parallax-background-css' ? 'checked ' : ''; ?>value="parallax-background-css">
                  <label class="semi-link module-link" for="image-background-<?php echo $i + 1; ?>"><?php echo $bgImage_str; ?> <span class="icon-imagesjpress"></span></label>
                  <div class="check"><div class="inside"></div></div>
                </li>
                <li><?php echo $translucence_str; ?>:
                  <label class="switch">
                    <input type="checkbox" class="translucence-switch" id="translucence-switch-<?php echo $i + 1; ?>" <?php echo strpos($class, 'translucent') !== false ? 'checked' : ''; ?>>
                    <span class="slider round theme-background"></span>
                  </label>
                </li>
              </ul>
              <?php
              $flag = false; // Turn off revisions, for testing
              if ($flag && isAdmin() && homeRevisionsDate($i + 1)) {
                $countHomeRevisions = count(homeRevisionsDate($i + 1)); ?>
              <li>
                <a id="rewind-<?php echo $i + 1; ?>" href="#">
                  <span class="icon-loopjpress"></span> <?php echo $rewind_str; ?>
                </a>
                <input type="range" class="rewind-range" id="rewind-range-<?php echo $i + 1; ?>" name="rewind-range-<?php echo $i + 1; ?>" min="0" max="<?php echo $countHomeRevisions; ?>" value="<?php echo $countHomeRevisions; ?>">
                <div class="tickmarks">
                  <?php
                  for ($x = 0; $x < $countHomeRevisions; $x++) {
                    $timestamp = strtotime(homeRevisionsDate($i + 1)[$x]['created']);
                    if (date('Ymd') == date('Ymd', $timestamp)) {
                      if ($lang === 'no') {
                        $revFormat -> setPattern('HH:mm');
                      } else {
                        $revFormat -> setPattern('h:mm a');
                      }
                    } else {
                      if ($lang === 'no') {
                        $revFormat -> setPattern('d. MMM');
                      } else {
                        $revFormat -> setPattern('MMM d');
                      }
                    }
                    echo '<p>' . $revFormat -> format($timestamp) . '</p>';
                  } ?>
                </div>
              </li>
              <?php } ?>
              <li>
                <a id="delete-section-<?php echo $i + 1; ?>" class="delete-section">
                  <span class="icon-deletejpress"></span> <?php echo $deleteSection_str; ?>
                </a>
              </li>
            </ul>
          </div>
        </div>
      <?php
      } ?>
      <?php
      if (strpos($class, 'video-background') !== false) { ?>
        <div class="video-container fullscreen-video">
          <video muted="" autoplay="" playsinline="" loop="" width="1080" height="1080">
    			</video>
    		</div>
      <?php
      } ?>
      <div class="content">
        <div id="textarea-<?php echo $i + 1; ?>" class="textarea">
          <?php
          if (!isLoggedIn()) {
            $sectionText = filterContent($sectionText);
          } ?>
          <?php
          echo $sectionText; ?>
        </div>
      </div>
      <?php
      if ($i === 0 && !isLoggedIn()) { ?>
        <div class="scroll-wrapper">
          <div class="scroll-container">
      			<div class="chevron-container">
      				<div class="chevron">
      				</div>
      				<div class="chevron">
      				</div>
      				<div class="chevron">
      				</div>
      			</div>
      			<div class="scroll-instruction">
      				<p>SCROLL</p>
      			</div>
      		</div>
        </div>
      <?php
      }
      if (!empty($backgroundImage) || !empty($backgroundSVG)) {
        if (strpos($class, 'parallax-background-js') !== false) {
          if (!empty($backgroundImage)) { ?>
          <style>
          <?php
            if (strpos($backgroundImage, '.svg') === false) {
              echo '.no-webp-support .background-js-' . ($i + 1) . '{background-image: url(\'' . $backgroundImage . '\');}';
              echo '.webp-support .background-js-' . ($i + 1) . '{background-image: url(\'' . '/uploads/' . replace_extension($backgroundImage, 'webp') . '\');}';
            } else {
              echo '.background-js-' . ($i + 1) . '{background-image: url(\'' . $backgroundImage . '\');}';
            } ?>
          </style>
          <?php
          } ?>
        <div class="background-js background-js-<?php echo $i + 1; ?>">
          <?php
          echo !empty($backgroundSVG) ? base64_decode($backgroundSVG) : ''; ?>
        </div>
        <?php
        }
      } ?>
    </section>
    <?php
    if (isLoggedIn()) { ?>
    <div class="add-section" data-order="<?php echo $i + 1; ?>">
    </div>
    <?php
    }
    $i++;
  }
} else {
  printf($noContent_str);
} ?>
</main>
<?php
if (isLoggedIn()) { ?>
  <button style="display:none;" class="jp-save-changes" type="submit" name="save-changes">
  </button>
</form>
<?php
}

include VIEW_ROOT . '/templates/footer.php';
