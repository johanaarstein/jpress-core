<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['save'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    require APP_ROOT . '/jp-includes/app/functions.php';

    $siteName = htmlentities(trim($_POST['sitename']), ENT_COMPAT, 'UTF-8');
    $legalName = htmlentities(trim($_POST['legal-name']), ENT_COMPAT, 'UTF-8');
    $pageDesc = htmlentities(trim($_POST['site-desc']), ENT_COMPAT, 'UTF-8');
    if (!empty($_POST['main-email'])) {
      $mainEmail = test_input($_POST['main-email']);
      if (!filter_var($mainEmail, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        $db -> close();
        exit();
      }
    }
    if (!empty($_POST['telephone'])) {
      if (test_input($_POST['telephone'])) {
        $telephone = trim($_POST['telephone']);
      }
    }
    $mainEmail = trim($_POST['main-email']);
    $mailHeaderSwitch = $_POST['mail-header-switch'];
    $phoneHeaderSwitch = $_POST['phone-header-switch'];
    $cfReceiptBody = cSHY(trim($_POST['cf-receipt-body']));
    $cfReceiptBodyAltLang = cSHY(trim($_POST['cf-receipt-body-alt-lang']));
    $logo = base64_encode($_POST['logo']);
    $featuredImage = trim(str_replace(BASE_URL, '', $_POST['featured-image-site']));
    $nativeFont = $_POST['native-font'];
    $gfSwitch = $_POST['gf-switch'];
    $fontColor = $_POST['font-color'];
    $robotsSwitch = $_POST['robots-switch'];
    $fontHeading = $_POST['font-heading'];
    $fontBody = $_POST['font-body'];
    $fontFace = base64_encode($_POST['font-face']);
    $tkSwitch = $_POST['tk-switch'];
    $tkStylesheet = base64_encode($_POST['tk-stylesheet']);
    $tkFontFamily = base64_encode(str_replace(array('font-family:',';'), '', $_POST['tk-font-family']));
    $tkFontFamilyHeader = base64_encode(str_replace(';', '', $_POST['tk-font-family-header']));
    $lang = $_POST['lang'];
    $backendLang = $_POST['backend-lang'];
    $mlSwitch = $_POST['ml-switch'];
    $altLangOne = $_POST['alt-lang-1'];
    $someShareSwitch = $_POST['some-share-switch'];
    $scrollMenuSwitch = $_POST['sm-switch'];
    $customCursor = $_POST['custom-cursor'];
    $reCAPTCHASwitch = $_POST['recaptcha-switch'];
    $gCalSwitch = $_POST['gcal-switch'];
    $gmSwitch = $_POST['gm-switch'];
    $contestSwitch = $_POST['contest-switch'];
    $fbConnectSwitch = $_POST['fb-connect-switch'];
    $toTheTopSwitch = $_POST['to-the-top-switch'];
    $trackingHeadSwitch = $_POST['tracking-head-switch'];
    $trackingBodySwitch = $_POST['tracking-body-switch'];
    $codeFooterSwitch = $_POST['code-footer-switch'];
    $customShortcodeSwitch = $_POST['custom-shortcode-switch'];
    $nonceSwitch = $_POST['nonce-switch'];
    $csp = $_POST['csp'];
    if (empty(trim($_POST['theme-color']))) {
      $themeColor = '#48dfc2';
    } else {
      $themeColor = trim($_POST['theme-color']);
    }
    if (empty(trim($_POST['secondary-color']))) {
      $secondaryColor = '#34E0A1';
    } else {
      $secondaryColor = trim($_POST['secondary-color']);
    }
    if (empty(trim($_POST['theme-color-contrast']))) {
      $contrastColor = '#E8453C';
    } else {
      $contrastColor = trim($_POST['theme-color-contrast']);
    }
    if (empty(trim($_POST['white-color']))) {
      $whiteColor = '#F2F2F2';
    } else {
      $whiteColor = trim($_POST['white-color']);
    }
    if (!empty(trim($_POST['tags']))) {
      $tags = htmlentities(strtolower(trim($_POST['tags'])), ENT_COMPAT, 'UTF-8');
    }
    if (!empty($_POST['tracking-head'])) {
      $trackingHead = base64_encode($_POST['tracking-head']);
    }
    if (!empty($_POST['tracking-body'])) {
      $trackingBody = base64_encode($_POST['tracking-body']);
    }
    if (!empty($_POST['code-footer'])) {
      $codeFooter = base64_encode($_POST['code-footer']);
    }
    if (!empty($_POST['custom-shortcode'])) {
      $customShortcodeFunction = base64_encode($_POST['custom-shortcode']);
    }
    if (!empty(trim($_POST['fb-page-id'])) && !is_numeric(trim($_POST['fb-page-id']))) {
      http_response_code(400);
      $db -> close();
      exit();
    } else {
      $fbPageID = trim($_POST['fb-page-id']);
    }
    if (!empty(trim($_POST['fb-app-id'])) && !is_numeric(trim($_POST['fb-app-id']))) {
      http_response_code(400);
      $db -> close();
      exit();
    } else {
      $fbAppID = trim($_POST['fb-app-id']);
    }
    if (!empty(trim($_POST['fb-app-secret']))) {
      $fbAppSecret = trim($_POST['fb-app-secret']);
    }
    if (!empty(trim($_POST['ig-account-id'])) && !is_numeric(trim($_POST['ig-account-id']))) {
      http_response_code(400);
      $db -> close();
      exit();
    } else {
      $igAccountID = trim($_POST['ig-account-id']);
    }
    if (!empty(trim($_POST['ig-user-id'])) && !is_numeric(trim($_POST['ig-user-id']))) {
      http_response_code(400);
      $db -> close();
      exit();
    } else {
      $igUserID = trim($_POST['ig-user-id']);
    }
    if (!empty(trim($_POST['ig-app-id'])) && !is_numeric(trim($_POST['ig-app-id']))) {
      http_response_code(400);
      $db -> close();
      exit();
    } else {
      $igAppID = trim($_POST['ig-app-id']);
    }
    if (!empty(trim($_POST['ig-app-secret']))) {
      $igAppSecret = trim($_POST['ig-app-secret']);
    }
    if (!empty(trim($_POST['fb-page']))) {
      if (strpos($_POST['fb-page'], 'www.facebook.com') == false) {
        http_response_code(406);
        $db -> close();
        exit();
      } else {
        $fbPage = trim($_POST['fb-page']);
        $fbPageSwitch = $_POST['fb-page-switch'];
      }
    }
    if (!empty(trim($_POST['twitter-page']))) {
      if (strpos($_POST['twitter-page'], 'twitter.com') == false) {
        http_response_code(406);
        $db -> close();
        exit();
      } else {
        $twitterPage = trim($_POST['twitter-page']);
        $twitterPageSwitch = $_POST['twitter-page-switch'];
      }
    }
    if (!empty(trim($_POST['ig-page']))) {
      if (strpos($_POST['ig-page'], 'www.instagram.com') == false) {
        http_response_code(406);
        $db -> close();
        exit();
      } else {
        $igPage = trim($_POST['ig-page']);
        $igPageSwitch = $_POST['ig-page-switch'];
      }
    }
    if (!empty(trim($_POST['li-page']))) {
      if (strpos($_POST['li-page'], 'www.linkedin.com') == false) {
        http_response_code(406);
        $db -> close();
        exit();
      } else {
        $liPage = trim($_POST['li-page']);
        $liPageSwitch = $_POST['li-page-switch'];
      }
    }
    if (!empty(trim($_POST['yt-page']))) {
      if (strpos($_POST['yt-page'], 'www.youtube.com') == false) {
        http_response_code(406);
        $db -> close();
        exit();
      } else {
        $ytPage = trim($_POST['yt-page']);
        $ytPageSwitch = $_POST['yt-page-switch'];
      }
    }
    if (!empty(trim($_POST['spotify-profile']))) {
      if (strpos($_POST['spotify-profile'], 'spotify.com') == false) {
        http_response_code(406);
        $db -> close();
        exit();
      } else {
        $spotifyProfile = trim($_POST['spotify-profile']);
        $spotifySwitch = $_POST['spotify-switch'];
      }
    }
    if (!empty(trim($_POST['ta-page']))) {
      if (strpos($_POST['ta-page'], 'tripadvisor.com') == false) {
        http_response_code(406);
        $db -> close();
        exit();
      } else {
        $taPage = trim($_POST['ta-page']);
        $taSwitch = $_POST['ta-switch'];
      }
    }
    if (!empty(trim($_POST['reCAPTCHA-siteKey']))) {
      $reCAPTCHA_siteKey = trim($_POST['reCAPTCHA-siteKey']);
    }
    if (!empty(trim($_POST['reCAPTCHA-serverKey']))) {
      $reCAPTCHA_serverKey = trim($_POST['reCAPTCHA-serverKey']);
    }
    if (!empty(trim($_POST['gcal-project-id']))) {
      $gCalProjectId = trim($_POST['gcal-project-id']);
    }
    if (!empty(trim($_POST['gcal-client-id']))) {
      $gCal_clientId = trim($_POST['gcal-client-id']);
    }
    if (!empty(trim($_POST['gcal-client-secret']))) {
      $gCalClientSecret = trim($_POST['gcal-client-secret']);
    }
    if (!empty(trim($_POST['google-api-key']))) {
      $googleAPIkey = trim($_POST['google-api-key']);
    }
    $sendgridSwitch = $_POST['sendgrid-switch'];
    if (!empty(trim($_POST['sendgrid-api-key']))) {
      $sendgridAPIkey = trim($_POST['sendgrid-api-key']);
    }

    if (!empty(trim($_POST['alt-lang-1-sitedesc']))) {
      $altLangOneDesc = htmlentities(trim($_POST['alt-lang-1-sitedesc']), ENT_COMPAT, 'UTF-8');
      $select =
      "SELECT `id`
      FROM    `siteInfo_altLang`;";
      $result = $db -> query($select);
      if ($result && $result -> num_rows > 0) {
        $update = $db -> query(
          "UPDATE `siteInfo_altLang`
          SET     `sitedesc`  = '$altLangOneDesc',
                  `created`   = Now();"
        );
      } else {
        $insert = $db -> query(
          "INSERT INTO  `siteInfo_altLang`
                        (`sitedesc`,
                        `created`)
          VALUES        ('$altLangOneDesc',
                        Now());"
        );
      }
      if (!$update && !$insert) {
        http_response_code(500);
        if ($db -> error) {
          echo '(' . $db -> errno . '): ' . $db -> error;
        }
        $db -> close();
        exit();
      }
    }

    $select =
    "SELECT `id`
    FROM   `siteInfo`;";
    $result = $db -> query($select);
    if ($result && $result -> num_rows > 0) {
      $update = $db -> query(
        "UPDATE `siteInfo`
        SET    `sitename`               = '$siteName',
               `legalName`              = '$legalName',
               `sitedesc`               = '$pageDesc',
               `mainEmail`              = '$mainEmail',
               `telephone`              = '$telephone',
               `mailHeaderSwitch`       = '$mailHeaderSwitch',
               `phoneHeaderSwitch`      = '$phoneHeaderSwitch',
               `cfReceiptBody`          = '$cfReceiptBody',
               `cfReceiptBodyAltLang`   = '$cfReceiptBodyAltLang',
               `logo`                   = '$logo',
               `featuredImage`          = '$featuredImage',
               `themeColor`             = '$themeColor',
               `secondaryColor`         = '$secondaryColor',
               `contrastColor`          = '$contrastColor',
               `whiteColor`             = '$whiteColor',
               `fontColor`              = '$fontColor',
               `nativeFont`             = '$nativeFont',
               `fontHeading`            = '$fontHeading',
               `fontBody`               = '$fontBody',
               `fontFace`               = '$fontFace',
               `tkSwitch`               = '$tkSwitch',
               `tkStylesheet`           = '$tkStylesheet',
               `tkFontFamily`           = '$tkFontFamily',
               `tkFontFamilyHeader`     = '$tkFontFamilyHeader',
               `someShareSwitch`        = '$someShareSwitch',
               `fbConnectSwitch`        = '$fbConnectSwitch',
               `fbPageID`               = '$fbPageID',
               `fbAppID`                = '$fbAppID',
               `fbAppSecret`            = '$fbAppSecret',
               `igAccountID`            = '$igAccountID',
               `igUserID`               = '$igUserID',
               `igAppID`                = '$igAppID',
               `igAppSecret`            = '$igAppSecret',
               `gmSwitch`               = '$gmSwitch',
               `contestSwitch`          = '$contestSwitch',
               `tags`                   = '$tags',
               `trackingHeadSwitch`     = '$trackingHeadSwitch',
               `trackingHead`           = '$trackingHead',
               `trackingBodySwitch`     = '$trackingBodySwitch',
               `trackingBody`           = '$trackingBody',
               `codeFooterSwitch`       = '$codeFooterSwitch',
               `codeFooter`             = '$codeFooter',
               `customShortcodeSwitch`  = '$customShortcodeSwitch',
               `customShortcode`        = '$customShortcodeFunction',
               `fbPage`                 = '$fbPage',
               `fbPageSwitch`           = '$fbPageSwitch',
               `twitterPage`            = '$twitterPage',
               `twitterPageSwitch`      = '$twitterPageSwitch',
               `igPage`                 = '$igPage',
               `igPageSwitch`           = '$igPageSwitch',
               `liPage`                 = '$liPage',
               `liPageSwitch`           = '$liPageSwitch',
               `ytPage`                 = '$ytPage',
               `ytPageSwitch`           = '$ytPageSwitch',
               `spotifyProfile`         = '$spotifyProfile',
               `spotifySwitch`          = '$spotifySwitch',
               `taPage`                 = '$taPage',
               `taSwitch`               = '$taSwitch',
               `gfSwitch`               = '$gfSwitch',
               `robotsSwitch`           = '$robotsSwitch',
               `customCursor`           = '$customCursor',
               `toTheTopSwitch`         = '$toTheTopSwitch',
               `lang`                   = '$lang',
               `backendLang`            = '$backendLang',
               `mlSwitch`               = '$mlSwitch',
               `altLangOne`             = '$altLangOne',
               `scrollMenuSwitch`       = '$scrollMenuSwitch',
               `reCAPTCHASwitch`        = '$reCAPTCHASwitch',
               `reCAPTCHA_siteKey`      = '$reCAPTCHA_siteKey',
               `reCAPTCHA_serverKey`    = '$reCAPTCHA_serverKey',
               `gCalSwitch`             = '$gCalSwitch',
               `gCalClientId`           = '$gCal_clientId',
               `gCalProjectId`          = '$gCalProjectId',
               `gCalClientSecret`       = '$gCalClientSecret',
               `googleAPIkey`           = '$googleAPIkey',
               `sendgridSwitch`         = '$sendgridSwitch',
               `sendgridAPIkey`         = '$sendgridAPIkey',
               `nonceSwitch`            = '$nonceSwitch',
               `csp`                    = '$csp',
               `created`                = Now();"
      );
    } else {
      $insert = $db -> query(
        "INSERT INTO `siteInfo`
                    (`sitename`,
                     `legalName`,
                     `sitedesc`,
                     `mainEmail`,
                     `telephone`,
                     `mailHeaderSwitch`,
                     `phoneHeaderSwitch`,
                     `cfReceiptBody`,
                     `cfReceiptBodyAltLang`,
                     `logo`,
                     `featuredImage`,
                     `themeColor`,
                     `secondaryColor`,
                     `contrastColor`,
                     `whiteColor`,
                     `fontColor`,
                     `nativeFont`,
                     `fontHeading`,
                     `fontBody`,
                     `fontFace`,
                     `tkSwitch`,
                     `tkStylesheet`,
                     `tkFontFamily`,
                     `tkFontFamilyHeader`,
                     `someShareSwitch`,
                     `fbConnectSwitch`,
                     `fbPageID`,
                     `fbAppID`,
                     `fbAppSecret`,
                     `igAccountID`,
                     `igUserID`,
                     `igAppID`,
                     `igAppSecret`,
                     `gmSwitch`,
                     `contestSwitch`,
                     `tags`,
                     `trackingHeadSwitch`,
                     `trackingHead`,
                     `trackingBodySwitch`,
                     `trackingBody`,
                     `codeFooterSwitch`,
                     `codeFooter`,
                     `customShortcodeSwitch`,
                     `customShortcode`,
                     `fbPage`,
                     `fbPageSwitch`,
                     `twitterPage`,
                     `twitterPageSwitch`,
                     `igPage`,
                     `igPageSwitch`,
                     `liPage`,
                     `liPageSwitch`,
                     `ytPage`,
                     `ytPageSwitch`,
                     `spotifyProfile`,
                     `spotifySwitch`,
                     `taPage`,
                     `taSwitch`,
                     `gfSwitch`,
                     `robotsSwitch`,
                     `customCursor`,
                     `toTheTopSwitch`,
                     `lang`,
                     `backendLang`,
                     `mlSwitch`,
                     `altLangOne`,
                     `scrollMenuSwitch`,
                     `reCAPTCHASwitch`,
                     `reCAPTCHA_siteKey`,
                     `reCAPTCHA_serverKey`,
                     `gCalSwitch`,
                     `gCalClientId`,
                     `gCalProjectId`,
                     `gCalClientSecret`,
                     `googleAPIkey`,
                     `sendgridSwitch`,
                     `sendgridAPIkey`,
                     `nonceSwitch`,
                     `csp`,
                     `created`)
        VALUES      ('$siteName',
                     '$legalName',
                     '$pageDesc',
                     '$mainEmail',
                     '$telephone',
                     '$mailHeaderSwitch',
                     '$phoneHeaderSwitch',
                     '$cfReceiptBody',
                     '$cfReceiptBodyAltLang',
                     '$logo',
                     '$featuredImage',
                     '$themeColor',
                     '$secondaryColor',
                     '$contrastColor',
                     '$whiteColor',
                     '$fontColor',
                     '$nativeFont',
                     '$fontHeading',
                     '$fontBody',
                     '$fontFace',
                     '$tkSwitch',
                     '$tkStylesheet',
                     '$tkFontFamily',
                     '$tkFontFamilyHeader',
                     '$someShareSwitch',
                     '$fbConnectSwitch',
                     '$fbPageID',
                     '$fbAppID',
                     '$fbAppSecret',
                     '$igAccountID',
                     '$igUserID',
                     '$igAppID',
                     '$igAppSecret',
                     '$gmSwitch',
                     '$contestSwitch',
                     '$tags',
                     '$trackingHeadSwitch',
                     '$trackingHead',
                     '$trackingBodySwitch',
                     '$trackingBody',
                     '$codeFooterSwitch',
                     '$codeFooter',
                     '$customShortcodeSwitch',
                     '$customShortcodeFunction',
                     '$fbPage',
                     '$fbPageSwitch',
                     '$twitterPage',
                     '$twitterPageSwitch',
                     '$igPage',
                     '$igPageSwitch',
                     '$liPage',
                     '$liPageSwitch',
                     '$ytPage',
                     '$ytPageSwitch',
                     '$spotifyProfile',
                     '$spotifySwitch',
                     '$taPage',
                     '$taSwitch',
                     '$gfSwitch',
                     '$robotsSwitch',
                     '$customCursor',
                     '$toTheTopSwitch',
                     '$lang',
                     '$backendLang',
                     '$mlSwitch',
                     '$altLangOne',
                     '$scrollMenuSwitch',
                     '$reCAPTCHASwitch',
                     '$reCAPTCHA_siteKey',
                     '$reCAPTCHA_serverKey',
                     '$gCalSwitch',
                     '$gCalClientId',
                     '$gCalProjectId',
                     '$gCalClientSecret',
                     '$googleAPIkey',
                     '$sendgridSwitch',
                     '$sendgridAPIkey',
                     '$nonceSwitch',
                     '$csp',
                     Now());"
      );
    }

    if ($update || $insert) {
      http_response_code(200);
      $db -> close();
      exit();
    } elseif ($db -> error) {
      http_response_code(500);
      header('Content-Type: application/x-www-form-urlencoded');
      echo '(' . $db -> errno . '): ' . $db -> error;
      $db -> close();
      exit();
    } else {
      http_response_code(500);
      $db -> close();
      exit();
    }
  } else {
    http_response_code(400);
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
