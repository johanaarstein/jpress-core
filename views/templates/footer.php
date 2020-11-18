<?php
$footerOne = get_footer()[0]['columnOne'];
$footerTwo = get_footer()[0]['columnTwo'];
$footerThree = get_footer()[0]['columnThree'];
$footerClass = get_footer()[0]['footerClass'];
$footerBackgroundImageId = get_footer()[0]['footerBackgroundImageId'];
$footerBackgroundImage = get_footer()[0]['footerBackgroundImage'];

if (isLoggedIn()) {
  if (isSettings() || isArticle() || isHome() || strpos($bodyClass, 'googlemaps-settings') !== false) { ?>
    <div class="module choose-featured-image">
      <div class="module-inner theme-background">
        <button id="close-module" class="semi-link"><span>+</span></button>
        <?php
        echo get_media('image');

        $ftArr = explode('/', $featuredImage);
        $featuredFileName = end($ftArr);
        $featuredImagePath = APP_ROOT . '/uploads/' . $featuredFileName;
        $fileSizeInBytes = filesize($featuredImagePath) / 1024;
        $fileSize = number_format($fileSizeInBytes, 0) . ' kB'; ?>

        <div class="module-sidepanel">
          <div id="choose-image">
            <h3><?php echo $chooseImage_str; ?></h3>
          </div>
          <div id="image-details" class="theme-background">
            <h3><?php echo $chosenImage_str; ?>:</h3>
            <div id="selected-media-container" class="black-background">
              <span id="selected-media"><img src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" /></span>
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
              <div class="arrows">
                <span class="icon-jpress icon-arrowleftjpress"></span>
                <span class="icon-jpress icon-arrowrightjpress"></span>
              </div>
            </div>
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
            <div class="form-group">
              <label><strong id="copy-tooltip"><?php echo $copyLink_str ?></strong></label>
              <input id="copyurl" value="" type="text" readonly="">
            </div>
            <div class="form-group image-alt">
              <label><strong><?php echo $altText_str; ?>:</strong></label>
              <input type="text" name="image-alt" id="module-image-alt" value="">
            </div>
            <div class="form-group photo-credit">
              <label><strong><?php echo $photoCredit_str; ?>:</strong></label>
              <input type="text" name="photo-credit" id="module-photo-credit" value="">
            </div>
            <div class="form-group caption-group">
              <p><?php echo $useCaption_str; ?>:
              <label class="switch">
                <input type="checkbox" id="caption-switch">
                <span class="slider round theme-background"></span>
              </label></p>
              <textarea id="caption-input" class="hidden"></textarea>
            </div>
          </div>
          <button type="button" name="save-image-details" id="save-image-details" class="btn semi-link secondary-background">OK</button>
        </div>
      </div>
      <div class="module-backdrop">
      </div>
    </div>
    <div id="embed-youtube" class="module">
      <div class="module-inner theme-background">
        <div class="wrapper theme-background">
          <h4 class="aligncenter"><span class="icon-youtubejpress"></span> <?php echo $embed_str; ?> YouTube-video</h4>
          <form method="post" action="">
            <div class="form-group">
              <input type="text" id="youtube-url" placeholder="https://www.youtube.com/embed/">
              <input type="text" id="youtube-title" placeholder="<?php echo $title_str; ?>">
              <ul class="radio-list">
                <li>
                  <input type="radio" id="yt-featured" name="yt-size" value="feature" checked>
                  <label class="semi-link" for="yt-featured"><?php echo $large_str; ?></label>
                  <div class="check"><div class="inside"></div></div>
                </li>
                <li>
                  <input type="radio" id="yt-small" name="yt-size" value="small">
                  <label class="semi-link" for="yt-small"><?php echo $small_str; ?></label>
                  <div class="check"><div class="inside"></div></div>
                </li>
              </ul>
            </div>
            <input class="btn secondary-background background-hover semi-link" type="text" id="close-yt" value="<?php echo $cancel_str; ?>">
            <button class="btn secondary-background background-hover semi-link"><?php echo $add_str; ?></button>
          </form>
        </div>
      </div>
      <div class="module-backdrop">
      </div>
    </div>
  <?php
  } ?>
  <div id="module-login" class="module">
    <div class="module-inner theme-background">
      <div class="wrapper theme-background">
        <div class="jpress-logo">
          <p class="aligncenter"><span class="icon-johanpressjpress"></span></p>
  			</div>
        <p class="aligncenter"><?php echo $inactive_str; ?><br><a href="/jp-login/"><?php echo $clickHere_str; ?></a></p>
      </div>
    </div>
    <div class="module-backdrop">
    </div>
  </div>
  <div id="module-message" class="module">
    <div class="module-inner">
      <p class="aligncenter"><span id="success" class="icon icon-successjpress"></span><span id="failure" class="icon icon-failurejpress"></span><span id="deleted" class="icon icon-deletejpress"></span><span id="message"></span></p>
    </div>
    <div class="module-backdrop">
    </div>
  </div>
  <?php
} else {
  $footerOne = filterContent($footerOne);
  $footerTwo = filterContent($footerTwo);
  $footerThree = filterContent($footerThree);
} ?>

<?php if(isLoggedIn()) { ?>
<form id="update-footer" method="post" action="">
  <?php
} ?>
  <footer class="<?php echo $footerClass; ?>">
    <?php if (isLoggedIn()) { ?>
    <input type="hidden" name="footer-class" id="footer-class" value="<?php echo $footerClass; ?>">
    <input type="hidden" name="footer-background-image" id="footer-background-image" value="<?php echo $footerBackgroundImage; ?>">
    <input type="hidden" name="footer-background-image-id" id="footer-background-image-id" value="<?php echo $footerBackgroundImageId; ?>">
    <div id="edit-footer" class="edit-section">
      <div class="edit-section-button">
        <span class="button-text"><?php echo $editSection_str; ?></span>
        <span class="icon-settingsjpress"></span>
        <ul class="section-menu">
          <li>
            <a id="edit-background-footer">
              <span class="icon-paintbucketjpress"></span> <?php echo $editBackground_str; ?>
            </a>
          </li>
          <ul class="edit-background-options radio-list">
            <li>
              <input type="radio" id="footer-theme-background" name="footer-background-options" <?php echo strpos($footerClass, 'theme-background') !== false ? 'checked ' : ''; ?>value="theme-background">
              <label class="semi-link" for="footer-theme-background"></label>
              <div class="check"><div class="inside"></div></div>
            </li>
            <li>
              <input type="radio" id="footer-secondary-background" name="footer-background-options" <?php echo strpos($footerClass, 'secondary-background') !== false ? 'checked ' : ''; ?>value="secondary-background">
              <label class="semi-link" for="footer-secondary-background"></label>
              <div class="check"><div class="inside"></div></div>
            </li>
            <li>
              <input type="radio" id="footer-white-background" name="footer-background-options" <?php echo strpos($footerClass, 'white-background') !== false ? 'checked ' : ''; ?>value="white-background">
              <label class="semi-link" for="footer-white-background"></label>
              <div class="check"><div class="inside"></div></div>
            </li>
            <li>
              <input type="radio" id="footer-black-background" name="footer-background-options" <?php echo strpos($footerClass, 'black-background') !== false ? 'checked ' : ''; ?>value="black-background">
              <label class="semi-link" for="footer-black-background"><?php echo $black_str; ?></label>
              <div class="check"><div class="inside"></div></div>
            </li>
            <li>
              <input type="radio" id="footer-image-background" name="footer-background-options" <?php echo $footerClass === 'parallax-background-css' ? 'checked ' : ''; ?>value="parallax-background-css">
              <label class="semi-link module-link" for="footer-image-background"><?php echo $bgImage_str; ?> <span class="icon-imagesjpress"></span></label>
              <div class="check"><div class="inside"></div></div>
            </li>
            <li><?php echo $translucence_str; ?>:
              <label class="switch">
                <input type="checkbox" id="footer-translucence-switch" <?php echo strpos($footerClass, 'translucent') !== false ? 'checked' : ''; ?>>
                <span class="slider round theme-background"></span>
              </label>
            </li>
          </ul>
        </ul>
      </div>
    </div>
    <?php
    } ?>
    <div class="content">
      <div class="column column-1">
        <div id="footer-1" class="textarea">
          <?php echo $footerOne; ?>
        </div>
      </div>
      <div class="column column-2">
        <div id="footer-2" class="textarea">
          <?php echo $footerTwo; ?>
        </div>
      </div>
      <div class="column column-3">
        <div id="footer-3" class="textarea">
          <?php echo $footerThree; ?>
        </div>
        <?php
        if ($scrollMenuSwitch !== 'checked') { ?>
        <ul class="so-me">
          <?php
          if(!empty($fbPageSwitch) && !empty($fbPage)) { ?>
            <li class="facebook white-background">
              <a id="facebook-profile" href="<?php echo $fbPage; ?>" target="_blank" rel="noreferrer nofollow" title="<?php echo $followOn_str; ?> Facebook!"><span class="icon-facebookjpress"></span></a>
            </li>
          <?php
          } ?>
          <?php
          if(!empty($twitterPageSwitch) && !empty($twitterPage)) { ?>
            <li class="twitter white-background">
              <a id="twitter-profile" href="<?php echo $twitterPage; ?>" target="_blank" rel="noreferrer nofollow" title="<?php echo $followOn_str; ?> Twitter!"><span class="icon-twitterjpress"></span></a>
            </li>
          <?php
          } ?>
          <?php
          if(!empty($igPageSwitch) && !empty($igPage)) { ?>
            <li class="instagram white-background">
              <a id="instagram-profile" href="<?php echo $igPage; ?>" target="_blank" rel="noreferrer nofollow" title="<?php echo $followOn_str; ?> Instagram!"><span class="icon-instagramjpress"></span></a>
            </li>
          <?php
          } ?>
          <?php
          if(!empty($ytPageSwitch) && !empty($ytPage)) { ?>
            <li class="youtube white-background">
              <a id="youtube-profile" href="<?php echo $ytPage; ?>" target="_blank" rel="noreferrer nofollow" title="<?php echo $followOn_str; ?> YouTube!"><span class="icon-youtubejpress"></span></a>
            </li>
          <?php
          } ?>
          <?php
          if(!empty($spotifySwitch) && !empty($spotifyProfile)) { ?>
            <li class="spotify white-background">
              <a id="spotify-profile" href="<?php echo $spotifyProfile; ?>" target="_blank" rel="noreferrer nofollow" title="<?php echo $followOn_str; ?> Spotify!"><span class="icon-spotifyjpress"></span></a>
            </li>
          <?php
          } ?>
          <?php
          if(!empty($liPageSwitch) && !empty($liPage)) { ?>
            <li class="linkedin white-background">
              <a id="linkedin-profile" href="<?php echo $liPage; ?>" target="_blank" rel="noreferrer nofollow"><span class="icon-linkedinjpress"></span></a>
            </li>
          <?php
          } ?>
          <?php
          if(!empty($taSwitch) && !empty($taPage)) { ?>
            <li class="tripadvisor-some white-background">
              <a id="tripadvisor-profile" href="<?php echo $taPage; ?>" target="_blank" rel="noreferrer nofollow"><span class="icon-tripadvisor-iconjpress"></span></a>
            </li>
          <?php
          } ?>
        </ul>
        <?php
        } ?>
      </div>
    </div>
    <div id="footer-bottom" class="theme-background">
      <div class="legal">
        <p><span class="current-year"></span> &copy; <?php echo !empty($legalName) ? $legalName : $siteName; ?><br>
        <?php
        if ($pageSlug !== strtolower($privacy_str)) {
          if (!empty($trackingHead) && !isLoggedIn()) { ?>
            <a id="cookie-settings" href="#"><?php echo $cookieSettings_str; ?></a>&nbsp;|&nbsp;
          <?php
        } ?><a id="privacy-link" href="/<?php echo !empty($altLangOne) && $lang === $altLangOne ? $altLangOne . '/' : ''; echo strtolower($privacy_str); ?>/"><?php echo $privacyLink_str; ?></a>
        <?php
        } ?></p>
      </div>
    </div>
  </footer>
  <?php
  if(isLoggedIn()) { ?>
  <button style="display:none;" class="jp-save-changes" type="submit" name="save-changes">
  </button>
</form>
    <?php
  } else {
    if ($toTheTopSwitch === 'checked') { ?>
<div id="toTheTop" class="theme-background background-hover circle semi-link">
  <span class="icon-arrowupjpress"></span>
</div>
    <?php
    }
  }
if(isLoggedIn()){
  if (isSettings()) { ?>
    <!-- FontPicker -->
    <script src="/plugins/fontpicker/js/fontpicker.min.js" nonce="<?php echo NONCE; ?>"></script>
    <script nonce="<?php echo NONCE; ?>">
    const fontHeadingInput = document.getElementById('font-heading-input');
    const fontBodyInput = document.getElementById('font-body-input');
    const fontPickerHeading = new FontPicker(
      '<?php echo $googleAPIkey; ?>',
      "<?php  echo !empty($fontHeading) ? $fontHeading : 'Open Sans'; ?>",
      { limit: 30, pickerId: 'headings', variants: ['300', '500'] },
      function () {
        fontHeadingInput.value = fontPickerHeading.getActiveFont().family;
      },
    );
    const fontPickerMain = new FontPicker(
      '<?php echo $googleAPIkey; ?>',
      "<?php echo !empty($fontBody) ? $fontBody : 'Open Sans'; ?>",
      { limit: 30, pickerId: 'main', variants: ['300', '500'] },
      function () {
        fontBodyInput.value = fontPickerMain.getActiveFont().family;
      },
    );
    </script>
    <!-- jsColor -->
    <script src="/plugins/jscolor/jscolor.min.js" nonce="<?php echo NONCE; ?>"></script>
    <!-- End jsColor -->
  <?php
  }
  if (isHome() || isArticle() || isSettings()) { ?>
  <!-- Name That Color -->
  <script src="/plugins/ntc/ntc-<?php echo $lang; ?>.min.js" nonce="<?php echo NONCE; ?>"></script>
  <!-- End Name That Color -->
  <!-- TinyMCE -->
  <script src="https://cdn.tiny.cloud/1/ej6jpsmxzppeh50wvdflm9u0x3mbepr9o87226f3y8pwbzq4/tinymce/5/tinymce.min.js" referrerpolicy="origin" nonce="<?php echo NONCE; ?>"></script>
  <script src="/plugins/tinymce/js/init-tinymce.min.js?ver=<?php echo $version; ?>" nonce="<?php echo NONCE; ?>"></script>
  <script nonce="<?php echo NONCE; ?>">
    //TinyMCE prompt on exit without save
    if (document.getElementsByClassName('textarea').length > 0) {
      window.addEventListener('beforeunload', (e) => {
        if (tinymce.activeEditor !== null) {
          let myPageIsDirty = tinymce.activeEditor.isDirty();
          if (myPageIsDirty) {
            e.preventDefault();
            e.returnValue = '';
          }
        }
      });
    }
  </script>
  <!-- End TinyMCE -->
  <?php
  }
} else {
  echo $codeFooterSwitch === 'checked' && !empty($codeFooter) && !isNoIndex() ? $codeFooter : '';
} ?>
<!-- Website functions -->
<script src="/js/frontend.min.js?ver=<?php echo $version; ?>" nonce="<?php echo NONCE; ?>"></script>
<!-- End Website functions -->

<?php
if (!isLoggedIn() && $fbConnectSwitch === 'checked' && !empty($fbAppID)) { ?>
<!-- Facebook functions -->
<script nonce="<?php echo NONCE; ?>">
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '<?php echo $fbAppID; ?>',
      cookie     : true,
      xfbml      : true,
      version    : "v7.0"
    });
    FB.AppEvents.logPageView();
  };

  (function(d, s, id, nonce){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "https://connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, "script", "facebook-jssdk", "<?php echo NONCE; ?>"));
</script>
<!-- End Facebook functions -->
<?php
} ?>
<?php
if(isLoggedIn()){ ?>
  <!-- Backend functions -->
  <script src="/jp-includes/js/admin.min.js?ver=<?php echo $version; ?>" nonce="<?php echo NONCE; ?>"></script>
  <!-- End Backend functions -->
<?php
} ?>
</body>
</html>
