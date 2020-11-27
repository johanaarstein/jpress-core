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
  header("Location: /jp-login/login.php");
  exit();
}

$_SESSION['LAST_ACTIVITY'] = $time;

$bodyClass = 'admin seo-panel secondary-background noindex';

include APP_ROOT . '/jp-includes/lang/lang.php';

$pageTitle = $settings_str;

include VIEW_ROOT . '/templates/header.php';

?>
<main id="main-content">
  <div class="wrapper">
    <h2><span class="icon-settingsjpress"></span> <?php echo $pageTitle; ?></h2>
    <hr class="divide"/>
    <ul id="settings-main-menu">
      <li class="current"><a href="#seo-wrapper" title="<?php echo $seoSettings_str; ?>" class="white-background-before"><span class="icon-bullhornjpress"></span></a></li>
      <li><a href="#layout-wrapper" title="<?php echo $layoutSettings_str; ?>" class="white-background-before"><span class="icon-paint-formatjpress"></span></a></li>
      <li><a href="#language-wrapper" title="<?php echo $languageSettings_str; ?>" class="white-background-before"><span class="icon-bubbles2jpress"></span></a></li>
      <li><a href="#plugins-wrapper" title="<?php echo $plugins_str; ?>" class="white-background-before"><span class="icon-pluginjpress"></span></a></li>
      <li><a href="#api-key-wrapper" title="<?php echo $apiKey_str; ?>" class="white-background-before"><span class="icon-keyjpress"></span></a></li>
      <li><a href="#email-wrapper" title="<?php echo $emailSettings_str; ?>" class="white-background-before"><span class="icon-mail4jpress"></span></a></li>
      <li><a href="#some-wrapper" title="<?php echo $someSettings_str; ?>" class="white-background-before"><span class="icon-share2jpress"></span></a></li>
      <?php if (get_articles() !== false && isAdmin()) { ?>
      <li><a href="#navigation-wrapper" title="<?php echo $navSettings_str; ?>" class="white-background-before"><span class="icon-compass2jpress"></span></a></li>
      <?php } ?>
      <li><a href="#updates-wrapper" title="<?php echo $updates_str; ?>" class="white-background-before"><span class="icon-loopjpress"></span></a></li>
    </ul>
    <form id="siteinfo" method="post" enctype="application/x-www-form-urlencoded" action="">
      <div id="seo-wrapper" class="form-wrapper">
        <div class="form-group clearfix">
          <label class="theme-background headline"><?php echo $siteName_str; ?></label>
          <input type="text" id="sitename" name="sitename" class="form-control white-background" value="<?php echo $siteName; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label class="theme-background headline"><?php echo $legalName_str; ?></label>
          <input type="text" id="legal-name" name="legal-name" class="form-control white-background" value="<?php echo $legalName; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix form-group-expandable">
          <label class="theme-background headline"><?php echo $siteDescription_str; ?></label>
          <textarea name="site-desc" id="site-desc" class="form-control white-background"><?php echo $pageDesc; ?></textarea>
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix form-group-expandable">
          <label class="theme-background headline"><?php echo $metaTags_str; ?> <small>(<?php echo $divideByComma_str; ?>)</small></label>
          <input name="tags" id="tags" class="form-control white-background" value="<?php echo $tags; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix inline-switch">
          <label style="margin-bottom:10px;"><?php echo $robots_str; ?></label>
          <label class="switch">
            <input type="checkbox" id="robots-switch" <?php echo $robotsSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <p><small>(<?php echo $forDevelopment_str; ?>)</small></p>
        </div>
        <div class="form-group clearfix inline-switch code-switch">
          <label class="switch">
            <input type="checkbox" name="tracking-head-switch" id="tracking-head-switch" <?php echo $trackingHeadSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix form-group-expandable">
          <script src="/jp-includes/plugins/codemirror/js/codemirror.js" <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>></script>
          <link rel="stylesheet" href="/jp-includes/plugins/codemirror/css/codemirror.min.css?ver=1.0.2" type="text/css" media="screen" />
          <script src="/jp-includes/plugins/codemirror/js/javascript.js" <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>></script>
          <script src="/jp-includes/plugins/codemirror/js/htmlmixed.js" <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>></script>
          <script src="/jp-includes/plugins/codemirror/js/multiplex.js" <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>></script>
          <script src="/jp-includes/plugins/codemirror/js/htmlembedded.js" <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>></script>
          <script src="/jp-includes/plugins/codemirror/js/xml.js" <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>></script>
          <script src="/jp-includes/plugins/codemirror/js/autorefresh.js" <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>></script>
          <label class="theme-background headline"><?php echo $addCodeHead_str; ?></label>
          <textarea id="code-input-head" name="code-input-head"><?php echo $trackingHead; ?></textarea>
          <script <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>>
          const codeInputHead = document.getElementById('code-input-head');
          const codeEditorHead = CodeMirror(function(elt) {
            codeInputHead.parentNode.replaceChild(elt, codeInputHead);
            elt.classList.add('outline');
          }, {
            value: codeInputHead.value,
            mode: 'application/x-ejs',
            indentUnit: 2,
            indentWithTabs: true,
            lineNumbers: true,
            lineWrapping: true,
            matchBrackets: true
          });
          </script>
        </div>
        <div class="form-group clearfix inline-switch code-switch">
          <label class="switch">
            <input type="checkbox" name="tracking-body-switch" id="tracking-body-switch" <?php echo $trackingBodySwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix form-group-expandable">
          <label class="theme-background headline"><?php echo $addCodeBody_str; ?></label>
          <textarea id="code-input-body" name="code-input-body"><?php echo $trackingBody; ?></textarea>
          <script <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>>
          const codeInputBody = document.getElementById('code-input-body');
          const codeEditorBody = CodeMirror(function(elt) {
            codeInputBody.parentNode.replaceChild(elt, codeInputBody);
            elt.classList.add('outline');
          }, {
            value: codeInputBody.value,
            mode: 'application/x-ejs',
            indentUnit: 2,
            indentWithTabs: true,
            lineNumbers: true,
            lineWrapping: true,
            matchBrackets: true
          });
          </script>
        </div>
        <div class="form-group clearfix inline-switch code-switch">
          <label class="switch">
            <input type="checkbox" name="code-footer-switch" id="code-footer-switch" <?php echo $codeFooterSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix form-group-expandable">
          <label class="theme-background headline"><?php echo $addCodeFooter_str; ?></label>
          <textarea id="code-input-footer" name="code-input-footer"><?php echo $codeFooter; ?></textarea>
          <script <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>>
          const codeInputFooter = document.getElementById('code-input-footer');
          const codeEditorFooter = CodeMirror(function(elt) {
            codeInputFooter.parentNode.replaceChild(elt, codeInputFooter);
            elt.classList.add('outline');
          }, {
            value: codeInputFooter.value,
            mode: 'application/x-ejs',
            indentUnit: 2,
            indentWithTabs: true,
            lineNumbers: true,
            lineWrapping: true,
            matchBrackets: true
          });
          </script>
        </div>
        <div class="form-group clearfix inline-switch code-switch">
          <label class="switch">
            <input type="checkbox" name="custom-shortcode-switch" id="custom-shortcode-switch" <?php echo $customShortcodeSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix form-group-expandable">
          <label class="theme-background headline"><?php echo $addCustomShortcode_str; ?></label>
          <textarea id="custom-shortcode-input" name="custom-shortcode-input"><?php echo $customShortcodeFunction; ?></textarea>
          <script <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>>
          const customShortcodeInput = document.getElementById('custom-shortcode-input');
          const codeEditorShortcode = CodeMirror(function(elt) {
            customShortcodeInput.parentNode.replaceChild(elt, customShortcodeInput);
            elt.classList.add('outline');
          }, {
            value: customShortcodeInput.value,
            mode: 'application/x-ejs',
            indentUnit: 2,
            indentWithTabs: true,
            lineNumbers: true,
            lineWrapping: true,
            matchBrackets: true
          });
          </script>
        </div>
        <div class="form-group clearfix inline-switch">
          <label>Nonce</label>
          <?php echo null !== NONCE && '' !== NONCE ? '' : printf($nonceNotEnabled_str . '. ' . $contactAdmin_str); ?>
          <label class="switch">
            <input type="checkbox" name="nonce-switch" id="nonce-switch" <?php echo nonce() ? 'checked' : ''; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix form-group-expandable">
          <label class="theme-background headline">CSP-<?php echo $exceptions_str; ?> <a href="https://developer.mozilla.org/en-US/docs/Web/HTTP/CSP" target="_blank" title="<?php echo $whatIs_str; ?> CSP" rel="noreferrer nofollow"><sup><span class="icon-questionjpress"></span></sup></a></label>
          <input type="hidden" id="csp" value="<?php echo $csp; ?>">
          <span contenteditable="true" class="white-background input" id="csp-dummy"><?php echo $csp; ?></span>
        </div>
      </div>
      <div id="language-wrapper" class="form-wrapper">
        <div class="form-group clearfix form-group-select clearfix">
          <label class="theme-background headline"><?php echo $lang_str; ?></label>
          <div class="custom-select white-background">
            <span class="input-group-addon"><span class="icon-bubbles2jpress"></span></span>
            <select id="jp-lang" name="jp-lang">
              <option value="<?php echo $choose_str; ?>…"></option>
              <option <?php echo $frontendLang === 'no' ? 'selected' : ''; ?> value="no" lang="no">Norsk</option>
              <option <?php echo $frontendLang === 'en' ? 'selected' : ''; ?> value="en" lang="en">English</option>
            </select>
          </div>
        </div>
        <div class="form-group clearfix form-group-select clearfix">
          <label class="theme-background headline"><?php echo $backendLang_str; ?></label>
          <div class="custom-select white-background">
            <span class="input-group-addon"><span class="icon-bubbles2jpress"></span></span>
            <select id="backend-lang" name="backend-lang">
              <option value="<?php echo $choose_str; ?>…"></option>
              <option <?php if ($backendLang === 'no') { echo 'selected'; } ?> value="no" lang="no">Norsk</option>
              <option <?php if ($backendLang === 'en') { echo 'selected'; } ?> value="en" lang="en">English</option>
            </select>
          </div>
        </div>
        <div class="form-group clearfix inline-switch">
          <label><?php echo $altLang_str; ?></label>
          <label class="switch">
            <input type="checkbox" id="ml-switch" name="ml-switch" <?php echo $mlSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <div id="ml-wrapper" class="input-wrapper<?php if ($mlSwitch === 'checked') { echo ' active'; } ?>">
            <label class="theme-background headline" for="alt-lang-1"><?php echo $altLangOne_str; ?> 1</label>
            <div class="custom-select white-background">
              <span class="input-group-addon"><span class="icon-bubbles2jpress"></span></span>
              <select id="alt-lang-1" name="alt-lang-1" class="theme-background">
                <option disabled selected value><?php echo $chooseAltLanguage_str; ?>…</option>
                <option <?php if ($altLangOne === 'no') { echo 'selected'; } ?> value="no" lang="no">Norsk</option>
                <option <?php if ($altLangOne === 'en') { echo 'selected'; } ?> value="en" lang="en">English</option>
              </select>
            </div>
            <hr class="transparent" />
            <label class="theme-background headline" for="alt-site-desc"><?php echo $altSiteDescription_str; ?> 1</label>
            <textarea name="alt-lang-1-sitedesc" id="alt-lang-1-sitedesc" class="form-control white-background" lang="<?php echo $altLangOne; ?>"><?php echo $altLangOneDesc; ?></textarea>
            <span class="help-block"></span>
          </div>
        </div>
      </div>
      <div id="plugins-wrapper" class="form-wrapper">
        <div class="form-group clearfix inline-switch">
          <label><span class="icon-google-mapsjpress"></span> Google Maps</label>
          <label class="switch">
            <input type="checkbox" name="gm-switch" id="gm-switch" <?php echo $gmSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix inline-switch">
          <label><span class="icon-calendarjpress"></span> Google Calendar</label>
          <label class="switch">
            <input type="checkbox" name="gcal-switch" id="gcal-switch" <?php echo $gCalSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <div id="gcal-wrapper" class="input-wrapper<?php echo ($gCalSwitch === 'checked') ? ' active' : ''; ?>">
            <input type="text" name="gCal-clientId" placeholder="Google Calendar Client ID" id="gCal-clientId" class="form-control white-background" value="<?php echo $gCal_clientId; ?>">
            <input type="text" name="gCal-projectId" placeholder="Google Calendar Project ID" id="gCal-projectId" class="form-control white-background" value="<?php echo $gCalProjectId; ?>">
            <input type="text" name="gCal-clientSecret" placeholder="Google Calendar Client Secret" id="gCal-clientSecret" class="form-control white-background" value="<?php echo $gCalClientSecret; ?>">
            <span class="help-block"></span>
          </div>
        </div>
        <div class="form-group clearfix inline-switch">
          <label><span class="icon-medaljpress"></span> Konkurranse</label>
          <label class="switch">
            <input type="checkbox" name="contest-switch" id="contest-switch" <?php echo $contestSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix inline-switch">
          <label><span class="icon-recaptchajpress"></span> Google reCAPTCHA: <a href="https://www.google.com/recaptcha/intro/v3.html" target="_blank" title="<?php echo $whatIs_str; ?> Google reCAPTCHA?" rel="noreferrer nofollow"><sup><span class="icon-questionjpress"></span></sup></a></label>
          <label class="switch">
            <input type="checkbox" id="recaptcha-switch" <?php echo $reCAPTCHASwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <div id="recaptcha-wrapper" class="input-wrapper<?php echo ($reCAPTCHASwitch === 'checked') ? ' active' : ''; ?>">
            <input type="text" name="reCAPTCHA-siteKey" placeholder="reCAPTCHA Site Key" id="reCAPTCHA-siteKey" class="form-control white-background" value="<?php echo $reCAPTCHA_siteKey; ?>">
            <input type="text" name="reCAPTCHA-serverKey" placeholder="reCAPTCHA Server Key" id="reCAPTCHA-serverKey" class="form-control white-background" value="<?php echo $reCAPTCHA_serverKey; ?>">
            <span class="help-block"></span>
          </div>
        </div>
        <div class="form-group clearfix inline-switch form-group-expandable">
          <label><span class="icon-sendgrid-logojpress"></span>&nbsp;SendGrid:&nbsp;<a href="https://sendgrid.com/" target="_blank" title="<?php echo $whatIs_str; ?> Sendgrid?" rel="noreferrer nofollow"><sup><span class="icon-questionjpress"></span></sup></a></label>
          <label class="switch">
            <input type="checkbox" id="sendgrid-switch" <?php echo $sendgridSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <input type="text" name="sendgrid-api-key" id="sendgrid-api-key" placeholder="Sendgrid API Key" class="form-control white-background input-wrapper<?php echo ($sendgridSwitch === 'checked') ? ' active' : ''; ?>" value="<?php echo $sendgridAPIkey; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix inline-switch">
          <label><span class="icon-facebookjpress"></span> Facebook Connect: <a href="https://developers.facebook.com/" target="_blank" title="<?php echo $whatIs_str; ?> Facebook Connect?" rel="noreferrer nofollow"><sup><span class="icon-questionjpress"></span></sup></a></label>
          <label class="switch">
            <input type="checkbox" id="fb-connect-switch" <?php echo $fbConnectSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
      </div>
      <div id="api-key-wrapper" class="form-wrapper">
        <div class="form-group clearfix">
          <label class="theme-background headline"><span class="icon-google3jpress"></span>&nbsp;<?php echo $googleAPIkey_str; ?>: <a href="https://console.developers.google.com/" target="_blank" title="<?php echo $whatIs_str . ' ' . $googleAPIkey_str; ?>?" rel="noreferrer nofollow"><sup class="theme-background"><span class="icon-questionjpress"></span></sup></a></label>
          <input type="text" name="google-api-key" placeholder="<?php echo $googleAPIkey_str; ?>" id="google-api-key" class="form-control white-background" value="<?php echo $googleAPIkey; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label class="theme-background headline"><span class="icon-facebookjpress"></span>&nbsp;Facebook Page ID: <a href="https://findmyfbid.com/" target="_blank" title="<?php echo $whatIs_str; ?> Facebook Page ID?" rel="noreferrer nofollow"><sup class="theme-background"><span class="icon-questionjpress"></span></sup></a></label>
          <input type="text" name="fb-page-id" id="fb-page-id" class="form-control white-background" value="<?php echo $fbPageID; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label class="theme-background headline"><span class="icon-facebookjpress"></span>&nbsp;Facebook App ID: <a href="https://developers.facebook.com/docs/apps/" target="_blank" title="<?php echo $whatIs_str; ?> Facebook App ID?" rel="noreferrer nofollow"><sup class="theme-background"><span class="icon-questionjpress"></span></sup></a></label>
          <input type="text" name="fb-app-id" id="fb-app-id" class="form-control white-background" value="<?php echo $fbAppID; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label class="theme-background headline"><span class="icon-facebookjpress"></span>&nbsp;Facebook App Secret: <a href="https://developers.facebook.com/docs/apps/" target="_blank" title="<?php echo $whatIs_str; ?> Facebook App Secret?" rel="noreferrer nofollow"><sup class="theme-background"><span class="icon-questionjpress"></span></sup></a></label>
          <input type="text" name="fb-app-secret" id="fb-app-secret" class="form-control white-background" value="<?php echo $fbAppSecret; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label class="theme-background headline"><span class="icon-instagramjpress"></span>&nbsp;Instagram Account ID: <a href="https://www.instafollowers.co/find-instagram-user-id" target="_blank" title="<?php echo $whatIs_str; ?> Instagram Account ID?" rel="noreferrer nofollow"><sup class="theme-background"><span class="icon-questionjpress"></span></sup></a></label>
          <input type="text" name="ig-account-id" id="ig-account-id" class="form-control white-background" value="<?php echo $igAccountID; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label class="theme-background headline"><span class="icon-instagramjpress"></span>&nbsp;Instagram User ID: <a href="https://www.instafollowers.co/find-instagram-user-id" target="_blank" title="<?php echo $whatIs_str; ?> Instagram User ID?" rel="noreferrer nofollow"><sup class="theme-background"><span class="icon-questionjpress"></span></sup></a></label>
          <input type="text" name="ig-user-id" id="ig-user-id" class="form-control white-background" value="<?php echo $igUserID; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label class="theme-background headline"><span class="icon-instagramjpress"></span>&nbsp;Instagram App ID: <a href="https://developers.facebook.com/docs/apps/" target="_blank" title="<?php echo $whatIs_str; ?> Instagram App ID?" rel="noreferrer nofollow"><sup class="theme-background"><span class="icon-questionjpress"></span></sup></a></label>
          <input type="text" name="ig-app-id" id="ig-app-id" class="form-control white-background" value="<?php echo $igAppID; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label class="theme-background headline"><span class="icon-instagramjpress"></span>&nbsp;Instagram App Secret: <a href="https://developers.facebook.com/docs/apps/" target="_blank" title="<?php echo $whatIs_str; ?> Instagram App Secret?" rel="noreferrer nofollow"><sup class="theme-background"><span class="icon-questionjpress"></span></sup></a></label>
          <input type="text" name="ig-app-secret" id="ig-app-secret" class="form-control white-background" value="<?php echo $igAppSecret; ?>">
          <span class="help-block"></span>
        </div>
      </div>
      <div id="layout-wrapper" class="form-wrapper">
        <div class="form-group clearfix form-group-expandable" id="logo-input">
          <label class="theme-background headline"><?php echo $logo_str; ?></label>
          <div class="logo-container">
            <div id="logo-preview" class="white-background transparent-background"></div>
            <svg class="code-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 124.13 61.34" width="124.13" height="61.34"><path d="M0 30.02v-3.6L33.62 5.54l4.1 6.48-26.2 15.84 26.21 15.48-4.1 6.48L0 30.02zM71.5 0l7.06 3.17-25.7 58.18-7.06-3.31L71.5 0zM90.5 49.82l-4.1-6.48 26.21-15.48L86.4 12.02l4.1-6.48 33.62 20.88v3.6L90.5 49.82z"></path></svg>
          </div>
          <div class="input-fields">
            <div class="code-input-field hidden">
              <textarea id="code-input-logo" name="code-input-logo"><?php echo $logo; ?></textarea>
              <script <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>>
              const codeInputLogo = document.getElementById('code-input-logo');
              const codeEditorLogo = CodeMirror(function(elt) {
                codeInputLogo.parentNode.replaceChild(elt, codeInputLogo);
                elt.classList.add('outline');
              }, {
                value: codeInputLogo.value,
                mode: 'xml',
                autoRefresh: true,
                indentUnit: 2,
                indentWithTabs: true,
                lineNumbers: true,
                lineWrapping: true,
                matchBrackets: true
              });
              </script>
            </div>
          </div>
        </div>
        <div class="form-group clearfix form-group-expandable">
          <label class="theme-background headline"><?php echo $featuredImage_str; ?></label>
          <a href="#" class="module-link choose-featured-image btn theme-background background-hover"><?php echo $chooseFeaturedImage_str; ?></a>
          <a href="/jp-admin/upload.php?action=upload" class="upload-featured-image btn theme-background background-hover"><?php echo $uploadImage_str; ?></a>
          <?php if (!empty($featuredImage)) { ?>
          <img id="featured-image-element" class="white-background" src="<?php echo $featuredImage; ?>" /><?php } else { ?>
          <span id="featured-image-element" class="white-background"><?php echo $chooseFeaturedImage_str; ?></span>
          <?php } ?>
          <input id="featured-image-input" name="featured-image-input" type="hidden" class="form-control" value="<?php echo $featuredImage; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label class="theme-background headline">Favicon</label>
          <div class="form-group-wrapper theme-background" style="float: left;">
            <div id="favicon-preview"><img id="favicon-preview-image" src="/assets/img/site/favicon.png?ver=<?php echo $version; ?>" /><span><?php echo $siteName; ?></span></div>
            <div id="favicon-image-wrapper">
              <img id="favicon-image" class="white-background semi-link transparent-background" src="/assets/img/site/favicon.png?ver=<?php echo $version; ?>" />
              <span class="icon-uploadjpress"></span>
            </div>
            <p><small><?php echo $faviconSpecs_str; ?></small></p>
            <input class="inputfile" type="file" accept="image/png" name="file" id="upload-favicon">
          </div>
        </div>
        <div class="form-group clearfix">
          <label id="theme-color-label" class="theme-background headline"><?php echo $themeColor_str; ?></label>
          <input name="theme-color" id="theme-color" class="form-control jscolor theme-background" value="<?php echo $themeColor; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label id="secondary-color-label" class="theme-background headline"><?php echo $secondaryColor_str; ?></label>
          <input name="secondary-color" id="secondary-color" class="form-control jscolor secondary-background" value="<?php echo $secondaryColor; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label id="theme-color-contrast-label" class="theme-background headline"><?php echo $contrastColor_str; ?></label>
          <input name="theme-color-contrast" id="theme-color-contrast" class="form-control jscolor contrast-background" value="<?php echo $contrastColor; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix">
          <label id="white-color-label" class="theme-background headline"><?php echo $whiteColor_str; ?></label>
          <input name="white-color" id="white-color" class="form-control jscolor white-background" value="<?php echo $whiteColor; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix inline-switch form-group-expandable" style="padding-left: 0;">
          <input type="hidden" id="font-heading-input" value="<?php echo $fontHeading; ?>">
          <input type="hidden" id="font-body-input" value="<?php echo $fontBody; ?>">
          <label class="theme-background headline"><span class="icon-ligatures-iconjpress"></span>&nbsp;<span><?php echo $typography_str; ?></span></label>
          <div class="form-group-wrapper theme-background">
            <p><?php echo $useGoogleFonts_str; ?>:
              <label class="switch">
                <input type="checkbox" id="gf-switch" <?php echo $gfSwitch; ?>>
                <span class="slider round secondary-background"></span>
              </label>
            </p>
            <div id="google-fonts-wrapper" class="input-wrapper<?php if ($gfSwitch === 'checked') { echo ' active'; } ?>">
              <div class="apply-font apply-font-headings">
                <h3><?php echo $heading_str; ?></h3>
              </div>
              <div id="font-picker-headings" class="font-picker secondary-background"></div>
              <div class="apply-font apply-font-main">
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
              </div>
              <div id="font-picker-main" class="font-picker secondary-background"></div>
            </div>
            <p><?php echo $useTypekit_str; ?>:
              <label class="switch">
                <input type="checkbox" id="tk-switch" <?php echo $tkSwitch; ?>>
                <span class="slider round secondary-background"></span>
              </label>
            </p>
            <div id="typekit-wrapper" class="input-wrapper<?php if ($tkSwitch === 'checked') { echo ' active'; } ?>">
              <label class="secondary-background headline"><?php echo $tkStylesheet_str; ?></label>
              <textarea id="tk-stylesheet" name="tk-stylesheet"><?php echo $tkStylesheet; ?></textarea>
              <script <?php echo nonce() ? 'nonce="' . NONCE . '"' : ''; ?>>
              const tkStylesheet = document.getElementById('tk-stylesheet');
              const tkStylesheetEditor = CodeMirror(function(elt) {
                tkStylesheet.parentNode.replaceChild(elt, tkStylesheet);
                elt.classList.add('outline');
              }, {
                value: tkStylesheet.value,
                mode: 'xml',
                indentUnit: 2,
                indentWithTabs: true,
                autoRefresh:true,
                lineNumbers: true,
                lineWrapping: true,
                matchBrackets: true
              });
              </script>
              <label class="secondary-background headline"><?php echo $fontFamily_str; ?></label>
              <input type="text" id="tk-font-family" class="white-background" name="tk-font-family" value="<?php echo $tkFontFamily; ?>">
              <label class="secondary-background headline"><?php echo $fontFamilyHeader_str; ?></label>
              <input type="text" id="tk-font-family-header" class="white-background" name="tk-font-family-header" value="<?php echo $tkFontFamilyHeader; ?>">
            </div>
            <?php
            if ($tkSwitch !== 'checked' && $gfSwitch !== 'checked') { ?>
            <div id="native-font-wrapper" class="input-wrapper active">
              <label class="white-background headline" for="alt-lang-1"><small><?php echo $nativeFont_str; ?></small></label>
              <div class="custom-select white-background">
                <select id="native-font" name="native-font">
                  <option disabled selected value><?php echo $choose_str; ?>…</option>
                  <option <?php if ($nativeFont === 'sans-serif') { echo 'selected'; } ?> value="sans-serif">Sans Serif</option>
                  <option <?php if ($nativeFont === 'serif') { echo 'selected'; } ?> value="serif">Serif</option>
                </select>
              </div>
            </div>
            <?php
            }
            ?>
          </div>
        </div>
        <div class="form-group clearfix inline-switch">
          <label><?php echo $customCursor_str; ?></label>
          <label class="switch">
            <input type="checkbox" id="custom-cursor" <?php echo $customCursor; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix inline-switch">
          <label><?php echo $toTheTop_str; ?></label>
          <label class="switch">
            <input type="checkbox" id="to-the-top-switch" <?php echo $toTheTopSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix inline-switch">
          <label><?php echo $scrollMenu_str; ?></label>
          <label class="switch">
            <input type="checkbox" id="sm-switch" <?php echo $scrollMenuSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
      </div>
      <div id="email-wrapper" class="form-wrapper">
        <div class="form-group clearfix inline-switch">
          <label><?php echo $showPhoneHeader_str; ?></label>
          <label class="switch">
            <input type="checkbox" name="phone-header-switch" id="phone-header-switch" <?php echo $phoneHeaderSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix">
          <label class="theme-background headline"><span class="icon-phonejpress"></span>&nbsp;<?php echo $phoneNumber_str; ?></label>
          <input type="text" name="telephone" id="telephone" class="form-control white-background" value="<?php echo $telephone; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix inline-switch">
          <label><?php echo $showMailHeader_str; ?></label>
          <label class="switch">
            <input type="checkbox" name="mail-header-switch" id="mail-header-switch" <?php echo $mailHeaderSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix">
          <label class="theme-background headline"><span class="icon-mail4jpress"></span>&nbsp;<?php echo $contactInfo_str; ?></label>
          <input type="email" name="main-email" id="main-email" class="form-control white-background" value="<?php echo $mainEmail; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix form-group-expandable">
          <label class="theme-background headline"><?php echo $cfReceiptBody_str; ?></label>
          <div id="cf-receipt-body" class="form-control textarea white-background"><?php echo $cfReceiptBody; ?></div>
          <span class="help-block"></span>
        </div>
        <?php if ($mlSwitch === 'checked') { ?>
        <div class="form-group clearfix form-group-expandable">
          <label class="theme-background headline"><?php echo $cfReceiptBodyAltLang_str; ?></label>
          <div id="cf-receipt-body-alt-lang" class="form-control textarea white-background"><?php echo $cfReceiptBodyAltLang; ?></div>
          <span class="help-block"></span>
        </div>
        <?php } ?>
      </div>
      <div id="some-wrapper" class="form-wrapper">
        <div class="form-group clearfix inline-switch">
          <label><?php echo $showShareIcons_str; ?></label>
          <label class="switch">
            <input type="checkbox" name="some-share-switch" id="some-share-switch" <?php echo $someShareSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
        </div>
        <div class="form-group clearfix inline-switch form-group-expandable">
          <label><span class="icon-facebookjpress"></span>&nbsp;Facebook</label>
          <label class="switch" title="<?php echo $chooseFooterLink_str; ?>">
            <input type="checkbox" id="fb-page-switch" <?php echo $fbPageSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <input type="text" name="fb-page" id="fb-page" class="form-control white-background input-wrapper<?php echo ($fbPageSwitch === 'checked') ? ' active' : ''; ?>" value="<?php echo $fbPage; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix inline-switch form-group-expandable">
          <label><span class="icon-twitterjpress"></span>&nbsp;Twitter</label>
          <label class="switch" title="<?php echo $chooseFooterLink_str; ?>">
            <input type="checkbox" id="twitter-page-switch" <?php echo $twitterPageSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <input type="text" name="twitter-page" id="twitter-page" class="form-control white-background input-wrapper<?php echo ($twitterPageSwitch === 'checked') ? ' active' : ''; ?>" value="<?php echo $twitterPage; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix inline-switch form-group-expandable">
          <label><span class="icon-instagramjpress"></span>&nbsp;Instagram</label>
          <label class="switch" title="<?php echo $chooseFooterLink_str; ?>">
            <input type="checkbox" id="ig-page-switch" <?php echo $igPageSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <input type="text" name="ig-page" id="ig-page" class="form-control white-background input-wrapper<?php echo ($igPageSwitch === 'checked') ? ' active' : ''; ?>" value="<?php echo $igPage; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix inline-switch form-group-expandable">
          <label><span class="icon-youtubejpress"></span>&nbsp;YouTube</label>
          <label class="switch" title="<?php echo $chooseFooterLink_str; ?>">
            <input type="checkbox" id="yt-page-switch" <?php echo $ytPageSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <input type="text" name="yt-page" id="yt-page" class="form-control white-background input-wrapper<?php echo ($ytPageSwitch === 'checked') ? ' active' : ''; ?>" value="<?php echo $ytPage; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix inline-switch form-group-expandable">
          <label><span class="icon-spotifyjpress"></span>&nbsp;Spotify</label>
          <label class="switch" title="<?php echo $chooseFooterLink_str; ?>">
            <input type="checkbox" id="spotify-switch" <?php echo $spotifySwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <input type="text" name="spotify-profile" id="spotify-profile" class="form-control white-background input-wrapper<?php echo ($spotifySwitch === 'checked') ? ' active' : ''; ?>" value="<?php echo $spotifyProfile; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix inline-switch form-group-expandable">
          <label><span class="icon-linkedinjpress"></span>&nbsp;LinkedIn</label>
          <label class="switch" title="<?php echo $chooseFooterLink_str; ?>">
            <input type="checkbox" id="li-page-switch" <?php echo $liPageSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <input type="text" name="li-page" id="li-page" class="form-control white-background input-wrapper<?php echo ($liPageSwitch === 'checked') ? ' active' : ''; ?>" value="<?php echo $liPage; ?>">
          <span class="help-block"></span>
        </div>
        <div class="form-group clearfix inline-switch form-group-expandable">
          <label><span class="icon-tripadvisor-iconjpress"></span>&nbsp;TripAdvisor</label>
          <label class="switch" title="<?php echo $chooseFooterLink_str; ?>">
            <input type="checkbox" id="ta-switch" <?php echo $taSwitch; ?>>
            <span class="slider round theme-background"></span>
          </label>
          <input type="text" name="ta-page" id="ta-page" class="form-control white-background input-wrapper<?php echo ($taSwitch === 'checked') ? ' active' : ''; ?>" value="<?php echo $taPage; ?>">
          <span class="help-block"></span>
        </div>
      </div>
      <div id="navigation-wrapper" class="form-wrapper">
        <div class="form-group clearfix navigation">
          <label class="theme-background headline"><?php echo $mainMenu_str; ?></label>
          <p>(<?php echo $underConstruction_str; ?>)</p>
          <?php echo get_menuEdit(); ?>
        </div>
      </div>
      <div id="updates-wrapper" class="form-wrapper">
        <div class="form-group clearfix">
          <?php
          //isFolderWritable([name of folder], [number of files to be excluded])
          if (!isFolderWritable('/', 2) || !isFolderWritable('/uploads', 0) || !isFolderWritable('/cookie-warning', 0) || !isFolderWritable('/jp-includes', 0) || !isFolderWritable('/jp-login', 0) || !isFolderWritable('/core', 0)) { ?>
            <ul>
            <?php
            echo isFolderWritable('/', 2) ? '' : '<li><span class="icon-infojpress"></span> ' . $notWritable_str . ': /</li>' . "\n";
            echo isFolderWritable('/uploads', 0) ? '' : '<li><span class="icon-infojpress"></span> ' . $notWritable_str . ': /uploads</li>' . "\n";
            echo isFolderWritable('/cookie-warning', 0) ? '' : '<li><span class="icon-infojpress"></span> ' . $notWritable_str . ': /cookie-warning</li>' . "\n";
            echo isFolderWritable('/jp-includes', 0) ? '' : '<li><span class="icon-infojpress"></span> ' . $notWritable_str . ': /jp-includes</li>' . "\n";
            echo isFolderWritable('/jp-login', 0) ? '' : '<li><span class="icon-infojpress"></span> ' . $notWritable_str . ': /jp-login</li>' . "\n";
            echo isFolderWritable('/core', 0) ? '' : '<li><span class="icon-infojpress"></span> ' . $notWritable_str . ': /core</li>' . "\n";
            echo isFolderWritable('/assets/img/site', 0) ? '' : '<li><span class="icon-infojpress"></span> ' . $notWritable_str . ': /assets/img/site</li>' . "\n"; ?>
            </ul>
            <p><?php echo $contactAdmin_str; ?></p>
            <?php
          } ?>
          <label class="theme-background headline"><span class="icon-johanpressjpress"></span> <?php echo $updates_str; ?> <small style="float: right">v.<?php echo $version; ?></small></label>
          <label class="aligncenter"><?php echo $checkForUpdates_str; ?></label>
          <hr class="transparent">
          <input type="button" id="get-updates" class="btn icon-button theme-background background-hover semi-link" value="">
        </div>
      </div>
      <div class="form-group clearfix">
        <input type="submit" name="save" class="theme-background background-hover btn semi-link" value="<?php echo $saveChanges_str; ?>">
      </div>
    </form>
    <a class="aligncenter" id="phpinfo" href="/jp-admin/phpinfo.php"><?php echo $see_str; ?> <span class="icon-phpjpress"></span> Info</a>
  </div>
</main>
<?php include VIEW_ROOT . '/templates/footer.php';
