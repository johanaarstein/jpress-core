<?php

$version = '3.3.5';

if (null !== NONCE && '' !== NONCE) {
	if (isLoggedIn()) {
		header("Content-Security-Policy: script-src 'strict-dynamic' 'nonce-" . NONCE . "' 'self' *.tiny.cloud *.google.com *.googleapis.com;object-src 'none';base-uri 'none';");
	} else {
		header("Content-Security-Policy: script-src 'strict-dynamic' 'nonce-" . NONCE . "' 'self' *.google.com *.gstatic.com *.instagram.com *.hsforms.com *.hs-banner.com *.usemessages.com *.hsadpixel.net *.hs-analytics.net *.googletagmanager.com *.googleapis.com;object-src 'none';base-uri 'none';");
	}
}

require APP_ROOT . '/jp-includes/app/siteinfo.php'; ?>
<!DOCTYPE html>
<!--[if lt IE 9]>
<html lang="<?php echo $lang; ?>" prefix="og: http://ogp.me/ns#" class="lt-ie9">
	<script nonce="<?php echo NONCE; ?>">if(window.location.href !== "<?php echo BASE_URL ?>/oldbrowsers.php"){window.location = "<?php echo BASE_URL ?>/oldbrowsers.php";}</script>
<![endif]-->
<!--[if IE 9]>
<html lang="<?php echo $lang; ?>" prefix="og: http://ogp.me/ns#" class="ie9">
<script src="/jp-includes/js/polyfills/classlist-polyfill.min.js" nonce="<?php echo NONCE; ?>"></script>
<![endif]-->
<!--[if gt IE 9]><!-->
<html lang="<?php echo $lang; ?>" prefix="og: http://ogp.me/ns#">
<!--<![endif]-->
<head>

	<!--


	                                ,▄▄▄▓▓█████████████▓▄▄▄,
	                           ▄▄▓█████▀▀▀▀▀^└¬¬¬¬└└▀▀▀▀▀██████▓▄
	                       ▄▓████▀▀`      ,,▄▄▄▄▄▄▄▄╓,      ¬▀▀████▓▄
	                    ▄████▀└        ¬¬└"▀▀▀████████████▓▄▄    ¬▀▀███▄,
	                 ▄████▀   ,⌐                ▀▀██████████████▄,   └▀███▄
	               ▄███▀   ,▄█,▓██████▄▄           ▀███████████████▀    ^███▓
	             ▄███▀   ▄███ ███████████▓▄          ▀███████████▀        '▀██▓
	           ╓███▀  ,▓████▌ ╙█████████████▄,         ▀████████"      ▄▓▄   ███▄
	          ▓██▀   ▓██████⌐      ^▀██████████▄▄         ▀▀███   ,▄▄██████µ  ╙███
	         ███^  ▄████████▌         ╙█████████████▓▓▓▓▓▓▓▀`  ╒████████████▓   ███▄
	        ███   ▓██████████▌        ┌██████████████████▀     ███████████████   ▀██▄
	       ███   ██████████████▄µ   ,▄█████████████████└      ]████████████████µ  ▀██▄
	      ███   █████████████████████████████████████▀        ▐█████████████████   ███⌐
	     ▐██▌  ▐████████████████████████████████████          ███████████████████   ███
	     ███  ]████████████████████████████████████           ███████████████████▌  ▐██▌
	    ▐██▌  ▓█████████████████████████▀▀▀▀▀▀▀▀▀▀            ⌠┐┐┌,,,,▄███████████   ███
	    ▓██   ███████████████████████████████████▌           █████████████████████µ  ███
	    ███   ███████████████████████████████████           ▐█████████████████████▌  ▐██
	    ███   ██████████████████████████████████▌           ██████████████████████▌  ▐██
	    ███   ██████████████████████████████████           ▐██████████████████████▌  ╟██
	    ▐██   █████████████████████████████████▌           ███████████████████████   ███
	     ██▌  ▐████████████████████████████████           ▓███████████████████████  ]██▌
	     ███   ███████████████████████████████b          ]███████████████████████─  ███
	      ███   ██████████████████████████████           ███████████████████████▌  ▐██▌
	      ▐██▌  ╙████████████████████████████¬          ███████████████████████▌  ┌███
	       ▀██▌  "██████████████████████████▌          ▓██████████████████████▀  ,███
	        ▀██▌   ████████▀▀▀██████████████          ▓██████████████████████▀  ╓███
	         ^███   ▀███"       ▀██████████▌         ██████████████████████▀   ▄██▀
	           ▀██▄   ▀          ▐████████▌        ▄██████████████████████`  ╓███`
	            ╙███▄            █████████       ▄█████████████████████▀`  ,███▀
	              ▀███▄         ▓████████      ▄█████████████████████▀   ▄███▀
	                ^███▓▄    ╙████████▀   ,▄████████████████████▀▀   ,▄███▀
	                   ▀███▓▄    `▀▀▀,▄▄▓████████████████████▀▀¬   ,▄███▀└
	                     '▀████▓▄     ¬└▀▀▀▀████████▀▀▀▀▀└     ▄▄████▀`
	                         └▀█████▓▄▄▄,               ,▄▄▓█████▀▀
	                              └▀▀██████████████████████▀▀▀¬

                                        POWERED BY JPRESS!


	-->

	<meta data-language-branch="<?php echo $lang; ?>" charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<?php
	if (isLoggedIn()) {
		echo '<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />' . "\r\n";
		echo '<meta http-equiv="Pragma" content="no-cache" />' . "\r\n";
		echo '<meta http-equiv="Expires" content="0" />' . "\r\n";
	} ?>
	<meta name="robots" content="<?php echo $robots; ?>" />
	<link rel="apple-touch-icon" sizes="180x180" href="/assets/img/site/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/site/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/assets/img/site/favicon-16x16.png">
	<link rel="manifest" href="/site.webmanifest">
	<link rel="mask-icon" href="/assets/img/site/safari-pinned-tab.svg" color="<?php echo $themeColor; ?>">
	<meta name="msapplication-TileColor" content="<?php echo $themeColor; ?>">
	<meta name="theme-color" content="<?php echo $secondaryColor; ?>">
	<meta name="keywords" content="<?php echo $tags; ?>" />
	<title><?php echo $metaPageTitle, $OutputSiteName; ?></title>
	<meta name="google" content="notranslate" />
	<meta name="description" content="<?php echo strip_tags($pageDesc); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="canonical" href="<?php echo CURRENT_URL; ?>" />
	<link rel="image_src" href="<?php echo BASE_URL . $featuredImage; ?>" />
	<?php
	if (!isNoIndex()) {
		if ($mlSwitch === 'checked') {
			if ($lang === $altLangOne) { ?>
	<link rel="alternate" href="<?php echo BASE_URL . $translatedSlug; ?>" hreflang="<?php echo $mainLang; ?>" />
	<?php
			} else { ?>
	<link rel="alternate" href="<?php echo BASE_URL . '/' . $altLangOne . $translatedSlug; ?>" hreflang="<?php echo $altLangOne; ?>" />
	<?php
			}
		} ?>
		<?php
		if (!empty($fbAppID)) { ?>
	<meta property="fb:app_id" content="<?php echo $fbAppID; ?>"/>
		<?php
		} ?>
	<meta property="og:title" content="<?php echo $metaPageTitle; ?>" />
	<meta property="og:url" content="<?php echo CURRENT_URL; ?>" />
	<meta property="og:description" content="<?php echo strip_tags($pageDesc); ?>" />
	<meta property="og:type" content="website" />
	<meta property="og:locale" content="<?php echo $lang; ?>" />
	<meta property="og:image" content="<?php echo BASE_URL . $featuredImage; ?>" />
	<meta property="og:image:width" content="<?php echo $featuredImageWidth; ?>" />
	<meta property="og:image:height" content="<?php echo $featuredImageHeight; ?>" />
	<meta property="og:image:alt" content="<?php echo $metaPageTitle; ?>" />
		<?php
		if (!empty($twitterPage)) { ?>
	<meta name="twitter:site" content="@<?php echo str_replace(['https://twitter.com/', 'twitter.com'], '', $twitterPage); ?>" />
		<?php
		} ?>
	<meta name="twitter:card" content="summary" />
	<meta name="twitter:description" content="<?php echo strip_tags($pageDesc); ?>" />
	<meta name="twitter:title" content="<?php echo $metaPageTitle; ?>" />
	<meta name="twitter:image" content="<?php echo BASE_URL . $featuredImage; ?>" />
	<?php
	} ?>
	<meta name="Generator" content="JPress" />
	<link rel="stylesheet" href="/assets/fonts/jpress/css/style.min.css?ver=<?php echo $version; ?>" type="text/css" media="all" />
	<?php
	if (isLoggedIn()) {
		echo '<link rel="dns-prefetch" href="https://cdn.tiny.cloud" />'. "\r\n";
	} else if ($gmSwitch === 'checked') {
		echo '<link rel="dns-prefetch" href="https://maps.googleapis.com" />' . "\r\n";
		echo '<link rel="dns-prefetch" href="https://www.google.com" />' . "\r\n";
	}
	if ($gfSwitch === 'checked') {
		echo '	<link rel="dns-prefetch" href="https://fonts.gstatic.com" />' . "\r\n";
	} else if ($tkSwitch === 'checked' && !empty($tkStylesheet)) {
		echo '	<link rel="dns-prefetch" href="https://use.typekit.net" />' . "\r\n";
		echo $tkStylesheet . "\r\n";
	} ?>
	<?php
	echo '<style>' . "\r\n";
	echo themeColors();
	echo '</style>'  . "\r\n"; ?>
	<link rel="stylesheet" href="/css/style.min.css?ver=<?php echo $version; ?>" type="text/css" media="screen" />
	<?php
	if (isLoggedIn()) { ?>
		<link rel="stylesheet" href="/jp-includes/css/admin.min.css?ver=<?php echo $version; ?>" type="text/css" media="screen" />
	<?php
} else if (!empty($trackingHead) && $trackingHeadSwitch === 'checked' && !isNoIndex()) {
		echo $trackingHead . "\r\n"; ?>
	<link rel="stylesheet" href="/cookie-warning/cookie-warning.min.css?ver=<?php echo $version; ?>" type="text/css" media="screen" />
	<script src="/cookie-warning/cookie-warning.min.js?ver=<?php echo $version; ?>" nonce="<?php echo NONCE; ?>"></script>
	<script nonce="<?php echo NONCE; ?>">
	document.addEventListener('DOMContentLoaded', function () {
		var cookieSettings = document.getElementById('cookie-settings');
		if (cookieSettings) {
			document.getElementById('cookie-settings').onclick = function () {
		    window.jpressCookieWarning.open().readMore();
				return false;
		  };
		}
	}, true);
	</script>
	<?php
	} ?>
<script nonce="<?php echo NONCE; ?>">var themeColor='<?php echo $themeColor; ?>';var secondaryColor='<?php echo $secondaryColor; ?>';var contrastColor='<?php echo $contrastColor; ?>';var whiteColor='<?php echo $whiteColor; ?>';</script>
</head>
<body class="<?php echo bodyClass(); ?>">
<?php
if (isLoggedIn() && $trackingBodySwitch === 'checked' && !empty($trackingBody)) {
  echo $trackingBody . "\r\n";
} ?>
<noscript><style>body.module-open{overflow:initial;}#spinner-global{opacity:0;display:none;}#main-content{opacity: 1;}#main-content section#booking-section .content{transform:translateY(0);opacity:1;}</style></noscript>
<?php
if ($customCursor === 'checked') { ?>
	<div id="cursor">
		<div id="cursor_point">
		</div>
	</div>
<?php
} ?>
<div id="spinner-global" class="loading-container module">
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
	<div class="module-backdrop">
	</div>
</div>
  <?php
  if (isLoggedIn()) { ?>
    <div class="logged-in-message <?php if (strpos($bodyClass, 'admin') !== false) { echo 'theme-background';} else { echo 'black-background'; } ?>">
			<div id="jp-mce-toolbar">
			</div>
      <div class="logged-in-message-text">
				<?php
				$activeUser = $_SESSION['username'];
				$activeEmail = $_SESSION['email'];
				$activeGravatarURL = '//www.gravatar.com/avatar/' . md5(strtolower(trim($activeEmail)));
				$activeGgravatarImage = '<img class="theme-color-border gravatar-img" src="' . $activeGravatarURL . '" />'; ?>
				<ul class="user-menu contrast-background">
					<li class="logout-link">
						<a href="/jp-login/logout.php?origin=<?php echo $_SERVER['REQUEST_URI']; ?>"><?php echo $clickToLogout_str; ?> <span class="icon-logoutjpress"></span></a>
					</li>
				</ul>
				<span class="hide-on-tablet"><?php echo $hello_str . ', ' . $activeUser . '!'; ?></span><a href="/jp-login/logout.php?origin=<?php echo $_SERVER['REQUEST_URI']; ?>"><?php echo $activeGgravatarImage; ?></a>
			</div>
      <div class="admin-panel">
				<a class="hide" id="adminpanelbutton" href="#">
					<div class="hamburger">
				  	<div></div>
					</div>
				</a>
      </div>
    </div>
	<?php
  } ?>
	<header class="">
		<div class="container<?php if (isArticle()) { echo ' theme-background';} ?>">
			<div id="logo-container">
				<a href="<?php echo BASE_URL; if ($lang === $altLangOne) { echo '/' . $altLangOne . '/'; } ?>" title="<?php echo $siteName; ?>">
          <?php echo $logo; ?>
				</a>
			</div>
			<?php if (($mailHeaderSwitch === 'checked' || $phoneHeaderSwitch) && (!empty($mainEmail) || !empty($telephone))) { ?>
			<div class="contact-info-header">
				<?php
				if ($mailHeaderSwitch === 'checked' && !empty($mainEmail)) { ?>
				<span class="mail-adress"><span class="icon-mail4jpress"></span> <a href="mailto:<?php echo $mainEmail; ?>" target="_blank" rel="noopener"><?php echo $mainEmail; ?></a></span>
					<?php
				}
				if ($phoneHeaderSwitch === 'checked' && !empty($telephone)) { ?>
				<span class="phone-number"><span class="icon-phonejpress"></span> <a href="tel:<?php echo str_replace('+', '00', str_replace(' ', '', $telephone)); ?>"><?php echo str_replace(' ', '&nbsp;', $telephone); ?></a></span>
					<?php
				} ?>
			</div>
				<?php
			} ?>
			<?php
			if (get_articles() !== false || $scrollMenuSwitch === 'checked') { ?>
			<a class="hide" id="mobile-menu-button" href="#">
				<div class="hamburger">
					<div></div>
				</div>
			</a>
				<?php
				if (get_articles() !== false) { ?>
			<ul id="header-menu">
					<?php
					echo get_articles(); ?>
					<?php
					if ($mlSwitch === 'checked') { ?>
				<li id="language">
						<?php
						if ($lang === $mainLang) { ?>
					<a title="Norsk språk" href="<?php echo '/' . $altLangOne . $translatedSlug; ?>">
						<svg alt="Norwegian Flag" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 75 50" width="75" height="50" xml:space="preserve">
						  <style>
						    .red{fill:#Ef2B2D}.white{fill:#FFF}.blue{fill:#002868}
						  </style>
						  <path d="M30 28v0z" fill="none"></path>
						  <path class="red" d="M33 0h42v19H33zM0 31h21v19H0zM33 50h42V31H33zM0 0h21v19H0z"></path>
						  <path class="white" d="M30 50h3V31h42v-3H30v22zM33 0h-3v22h45v-3H33zM0 28v3h21v19h3V28zM24 0h-3v19H0v3h24z"></path>
						  <path class="blue" d="M30 22V0h-6v22H0v6h24v22h6V28h45v-6H30z"></path>
						</svg>
					</a>
							<?php
						} elseif ($lang === $altLangOne) { ?>
					<a title="English language" href="<?php echo $translatedSlug; ?>">
						<svg alt="Union Jack" version="1.1" xmlns="http://www.w3.org/2000/svg" x="0" y="0" viewBox="0 0 74.9 50" width="74.9" height="50" xml:space="preserve">
						  <style>
						    .blue{fill:#012169}.white{fill:#f4f4f4}.red{fill:#C8102E}
						  </style>
						  <path class="blue" d="M74.9 33.3H59.1l15.8 10.5zM31.3 0h-22l22 14.6zM65.7 0h-22v14.7zM0 6.2v10.5h15.8zM9.3 50h22V35.3zM43.7 50h22l-22-14.7zM74.9 16.7V6.2L59.1 16.7zM0 33.3v10.5l15.8-10.5z"></path>
						  <path class="white" d="M0 30.1v3.1h15.8L0 43.8v3.9l21.6-14.4h6.9L3.5 50h5.7l22-14.7V50h2.3V30.1H0zM41.3 50h2.4V35.3l22 14.7h5.6l-25-16.7h7l21.6 14.4v-3.9L59.1 33.3h15.8v-3.2H41.3zM46.4 16.7L71.5 0h-5.8l-22 14.7V0h-2.4v19.8h33.6v-3.1H59.1L74.9 6.2V2.3L53.3 16.7zM33.6 0h-2.3v14.7L9.3 0H3.5l25.1 16.7h-7L0 2.3v3.9l15.8 10.5H0v3.1h33.6z"></path>
						  <path class="red" d="M41.3 0h-7.7v19.8H0v10.3h33.6V50h7.7V30.1h33.6V19.8H41.3z"></path>
						  <path class="red" d="M71.5 0L46.4 16.7h6.9L74.9 2.3V0zM21.6 33.3L0 47.7V50h3.5l25-16.7zM28.6 16.7L3.5 0H0v2.3l21.6 14.4zM46.3 33.3l25 16.7h3.6v-2.3L53.3 33.3z"></path>
						</svg>
					</a>
							<?php
						} ?>
				</li>
						<?php
					} ?>
			</ul>
					<?php
				}
			}
			if ($scrollMenuSwitch === 'checked') { ?>
		<div id="scroll-menu" class="white-background translucent hide">
				<?php
				if (isLoggedIn()) {
		      echo '<form id="update-scrollmenu" method="post" action="">';
		    } ?>
			<div class="content">
				<div class="textarea" id="scroll-menu-text">
					<?php echo get_scrollMenu(); ?>
				</div>
				<ul class="so-me">
					<?php
					if (!empty($fbPageSwitch) && !empty($fbPage)) { ?>
						<li class="facebook theme-background">
							<a id="facebook-profile" href="<?php echo $fbPage; ?>" target="_blank" rel="noreferrer nofollow" title="<?php echo $followOn_str; ?> Facebook!"><span class="icon-facebookjpress"></span></a>
						</li>
						<?php
					} ?>
					<?php
					if (!empty($twitterPageSwitch) && !empty($twitterPage)) { ?>
						<li class="twitter theme-background">
							<a id="twitter-profile" href="<?php echo $twitterPage; ?>" target="_blank" rel="noreferrer nofollow" title="<?php echo $followOn_str; ?> Twitter!"><span class="icon-twitterjpress"></span></a>
						</li>
						<?php
					} ?>
					<?php
					if (!empty($igPageSwitch) && !empty($igPage)) { ?>
						<li class="instagram theme-background">
							<a id="instagram-profile" href="<?php echo $igPage; ?>" target="_blank" rel="noreferrer nofollow" title="<?php echo $followOn_str; ?> Instagram!"><span class="icon-instagramjpress"></span></a>
						</li>
						<?php
					} ?>
					<?php
					if (!empty($ytPageSwitch) && !empty($ytPage)) { ?>
						<li class="youtube theme-background">
							<a id="youtube-profile" href="<?php echo $ytPage; ?>" target="_blank" rel="noreferrer nofollow" title="<?php echo $followOn_str; ?> YouTube!"><span class="icon-youtubejpress"></span></a>
						</li>
						<?php
					} ?>
					<?php
					if (!empty($spotifySwitch) && !empty($spotifyProfile)) { ?>
						<li class="spotify theme-background">
							<a id="spotify-profile" href="<?php echo $spotifyProfile; ?>" target="_blank" rel="noreferrer nofollow" title="<?php echo $followOn_str; ?> Spotify!"><span class="icon-spotifyjpress"></span></a>
						</li>
						<?php
					} ?>
					<?php
					if (!empty($liPageSwitch) && !empty($liPage)) { ?>
						<li class="linkedin theme-background">
							<a id="linkedin-profile" href="<?php echo $liPage; ?>" target="_blank" rel="noreferrer nofollow"><span class="icon-linkedinjpress"></span></a>
						</li>
						<?php
					} ?>
					<?php
					if (!empty($taSwitch) && !empty($taPage)) { ?>
						<li class="tripadvisor-some theme-background">
							<a id="tripadvisor-profile" href="<?php echo $taPage; ?>" target="_blank" rel="noreferrer nofollow"><span class="icon-tripadvisor-iconjpress"></span></a>
						</li>
						<?php
					} ?>
				</ul>
			</div>
			<?php
			if (isLoggedIn()) { ?>
				<button style="display:none;" class="jp-save-changes" type="submit" name="save-changes">
	      </button>
	    </form>
		    <?php
			} ?>
		</div>
			<?php
		} ?>
		</div>
	</header>
		<?php
	  if (isLoggedIn()) {
			?>
		<div id="admin-menu-wrapper" class="hide theme-background translucent">
			<ul class="admin-menu">
				<li class="<?php if (strpos(CURRENT_URL, 'settings.php') == !false) {
					echo 'current-menu-item';
				} ?>">
				<a href="/jp-admin/settings.php"><span class="icon icon-settingsjpress"></span> <?php echo $settings_str; ?></a></li>
				<li class="<?php if (strpos(CURRENT_URL, 'upload.php') == !false) {
					echo 'current-menu-item';
				} ?>">
				<a href="/jp-admin/upload.php"><span class="icon icon-mediajpress"></span> <?php echo $media_str; ?></a></li>
				<li class="<?php if (strpos(CURRENT_URL, 'users.php') == !false) {
					echo 'current-menu-item';
				} ?>">
				<a href="/jp-admin/users.php"><span class="icon icon-usersjpress"></span> <?php echo $users_str; ?></a></li>
				<?php
				if ($gmSwitch === 'checked') { ?>
				<li class="<?php if (strpos(CURRENT_URL, 'googlemaps.php') == !false) {
					echo 'current-menu-item';
				} ?>">
				<a href="/plugins/googlemaps/googlemaps.php"><span class="icon icon-google-mapsjpress"></span> Google Maps</a></li>
				<?php
				}
				if ($contestSwitch === 'checked') {
					if (isAdmin()) { ?>
						<li class="<?php if (strpos(CURRENT_URL, 'contest/settings.php') == !false) {
							echo 'current-menu-item';
						} ?>">
						<a href="/plugins/contest/settings.php"><span class="icon icon-settingsjpress"></span> Konkurranse&shy;innstillinger</a></li>
						<?php
					} ?>
					<li class="<?php if (strpos(CURRENT_URL, 'results.php') == !false) {
						echo 'current-menu-item';
					} ?>">
					<a href="/plugins/contest/results.php"><span class="icon icon-medaljpress"></span> Riktige svar</a></li>
				<?php
				} ?>
			</ul>
			<ul class="admin-menu">
				<li class="<?php if (CURRENT_URL === BASE_URL . '/') {
					echo 'current-menu-item';
				} ?>"><a href="/"><span class="icon icon-frontpagejpress"></span> <?php echo $frontPage_str; ?></a></li>
        <?php echo get_adminArticles(); ?>
				<form method="post" action="/jp-includes/insert/add-article.php">
					<input type="hidden" name="lang" value="<?php echo $lang; ?>">
					<?php if ($mlSwitch === 'checked') { ?>
						<input type="hidden" name="main-lang" value="<?php echo $mainLang; ?>">
						<input type="hidden" name="alt-lang-one" value="<?php echo $altLangOne; ?>">
					<?php } ?>
					<li><button type="submit" name="new-article" class="theme-background background-hover"><span class="icon-newdocumentjpress"></span> <?php echo $newPage_str; ?></button></li>
				</form>
			</ul>
			<?php
			if (isArticle()) { ?>
      <div class="article-context-menu">
  			<div class="form-group article-label">
  				<label><?php echo $shortTitle_str; ?>:</label>
  				<input id="article-label" value="<?php echo $pageLabel; ?>">
  			</div>
  			<?php
				if (isset($published)) { ?>
  			<div class="form-group">
  				<?php
					if ($published == '0') { ?>
  				<label><?php echo $savedAsDraft_str; ?> </label>
  				<span><?php echo $publish_str; ?>:</span>
		  			<?php
					} elseif ($published == '1') { ?>
  				<label><?php echo $published_str; ?></label><br>
  				<span><?php echo $depublish_str; ?>:</span>
		  			<?php
					} ?>
  				<label class="switch">
  					<input type="checkbox" id="publish" <?php if ($published == '1') { echo 'checked'; } ?>>
  					<span class="slider round theme-background"></span>
  				</label>
  			</div>
				<div class="form-group">
					<?php
					if (empty($displayInMenu)) { ?>
					<span><?php echo $displayInMenu_str; ?>:</span>
						<?php
					} elseif ($displayInMenu == 'checked') { ?>
					<span><?php echo $hideFromMenu_str; ?>:</span>
						<?php
					} ?>
					<label class="switch">
						<input type="checkbox" id="display-in-menu-switch" <?php echo $displayInMenu; ?>>
						<span class="slider round theme-background"></span>
					</label>
				</div>
		  		<?php
				} ?>
  		<div class="form-group">
  			<button id="save-article-details" class="theme-background background-contrast-hover"><?php echo $saveChanges_str; ?></button>
  		</div>
    </div>
				<?php
			} ?>
			<div class="jpress-logo">
				<p><span class="icon-johanpressjpress"></span></p>
				<p>Powered by JPress!</p>
			</div>
		</div>
			<?php
		}
