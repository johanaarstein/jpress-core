<?php

if (count(getOption()) > 0) {
  $siteName = getOption('sitename');
	if (isset($pageDesc)) {
		if (empty($pageDesc)) {
			$pageDesc = getOption('sitedesc');
		}
	} else if (empty(getOption('sitedesc'))) {
		$pageDesc = 'Bare enda ei JPress-side';
	} else {
		$pageDesc = getOption('sitedesc');
	}
	$logo = base64_decode(getOption('logo'));
	if (isset($featuredImage)) {
		if (empty($featuredImage)) {
			if (empty(getOption('featuredImage'))) {
				$featuredImage = '/assets/img/jpress.png';
			} else {
				$featuredImage = getOption('featuredImage');
			}
		}
	} else {
		$featuredImage = getOption('featuredImage');
	}
  $fbPageID = getOption('fbPageID');
	$fbAppID = getOption('fbAppID');
  $fbAppSecret = getOption('fbAppSecret');
  $igAccountID = getOption('igAccountID');
  $igUserID = getOption('igUserID');
  $igAppID = getOption('igAppID');
  $igAppSecret = getOption('igAppSecret');
	$tags = getOption('tags');
	$mainEmail = getOption('mainEmail');
  $telephone = getOption('telephone');
  $mailHeaderSwitch = getOption('mailHeaderSwitch');
  $phoneHeaderSwitch = getOption('phoneHeaderSwitch');
  $legalName = getOption('legalName');
  $cfReceiptBody = getOption('cfReceiptBody');
  $cfReceiptBodyAltLang = getOption('cfReceiptBodyAltLang');
  $trackingHeadSwitch = getOption('trackingHeadSwitch');
	$trackingHead = handleScript(getOption('trackingHead'));
  $trackingBodySwitch = getOption('trackingBodySwitch');
	$trackingBody = handleScript(getOption('trackingBody'));
  $codeFooterSwitch = getOption('codeFooterSwitch');
  $codeFooter = handleScript(getOption('codeFooter'));
  $customShortcodeSwitch = getOption('customShortcodeSwitch');
  $customShortcodeFunction = handleScript(getOption('customShortcode'));
	$someShareSwitch = getOption('someShareSwitch');
	$fbPage = getOption('fbPage');
	$fbPageSwitch = getOption('fbPageSwitch');
	$igPage = getOption('igPage');
	$igPageSwitch = getOption('igPageSwitch');
	$twitterPage = getOption('twitterPage');
	$twitterPageSwitch = getOption('twitterPageSwitch');
	$ytPage = getOption('ytPage');
	$ytPageSwitch = getOption('ytPageSwitch');
	$spotifyProfile = getOption('spotifyProfile');
	$spotifySwitch = getOption('spotifySwitch');
	$liPage = getOption('liPage');
	$liPageSwitch = getOption('liPageSwitch');
	$taSwitch = getOption('taSwitch');
	$taPage = getOption('taPage');
	$themeColor = '#' . getOption('themeColor');
	$secondaryColor = '#' . getOption('secondaryColor');
	$contrastColor = '#' . getOption('contrastColor');
  $whiteColor = '#' . getOption('whiteColor');
  $fontColor = json_decode(getOption('fontColor'), true);
  $nativeFont = getOption('nativeFont');
	$gfSwitch = getOption('gfSwitch');
	$fontHeading = getOption('fontHeading');
	$fontBody = getOption('fontBody');
  $fontFace = base64_decode(getOption('fontFace'));
	$tkSwitch = getOption('tkSwitch');
	$tkStylesheet = base64_decode(getOption('tkStylesheet'));
	$tkFontFamily = base64_decode(getOption('tkFontFamily'));
	$tkFontFamilyHeader = base64_decode(getOption('tkFontFamilyHeader'));
  $customCursor = getOption('customCursor');
  $robotsSwitch = getOption('robotsSwitch');
	$scrollMenuSwitch = getOption('scrollMenuSwitch');
	$mlSwitch = getOption('mlSwitch');
	$altLangOne = getOption('altLangOne');
  if (JP_ENV !== 'development') {
    $reCAPTCHASwitch = getOption('reCAPTCHASwitch');
  }
	$reCAPTCHA_siteKey = getOption('reCAPTCHA_siteKey');
	$reCAPTCHA_serverKey = getOption('reCAPTCHA_serverKey');
  $googleAPIkey = getOption('googleAPIkey');
  $sendgridSwitch = getOption('sendgridSwitch');
  $sendgridAPIkey = getOption('sendgridAPIkey');
  $gmSwitch = getOption('gmSwitch');
  $gCal_clientId = getOption('gCalClientId');
  $gCalProjectId = getOption('gCalProjectId');
  $gCalClientSecret = getOption('gCalClientSecret');
  $gCalSwitch = getOption('gCalSwitch');
  $contestSwitch = getOption('contestSwitch');
  $fbConnectSwitch = getOption('fbConnectSwitch');
  $toTheTopSwitch = getOption('toTheTopSwitch');
  $version = getOption('version');
  $csp = getOption('csp');
  $siteCreated = getOption('created');
	$mainLang = $frontendLang = getOption('lang');
	if ($mlSwitch === 'checked') {
		if (!isset($lang)) {
			$lang = $frontendLang = getOption('lang');
		}
		// $mainLang = $frontendLang = getOption('lang');
	} else {
		$lang = $frontendLang = getOption('lang');
	}
	$altLangOneTitle = get_altLangOneTitle();
  $altLangOneDesc = get_altLangOneDesc();
	list($featuredImageWidth, $featuredImageHeight) = getimagesize(APP_ROOT . $featuredImage);
}
if (!empty(getOption('backendLang'))) {
  $backendLang = getOption('backendLang');
} else {
  $backendLang = $lang;
}
// if (isBackend()) {
//   $lang = $backendLang;
// }

$currentpage = $_SERVER['REQUEST_URI'];
$isHome = $currentpage === "/" || $currentpage === "/$altLangOne";

$metaPageTitle = $pageTitle || '';
if (isset($pageTitle)) {
	if ($isHome && $lang !== $mainLang && !empty($altLangOneTitle)) {
		$metaPageTitle = $altLangOneTitle;
	} else {
		$metaPageTitle = strip_tags(str_replace('&shy;', '', str_replace('<br />', ' ', html_entity_decode($pageTitle))));
	}
}

if (isset($robotsSwitch) && $robotsSwitch === 'checked' || (isset($bodyClass) && strpos($bodyClass, 'noindex') !== false) || isset($published) && $published == '0') {
  $robots = 'NOINDEX, NOFOLLOW';
} else {
  $robots = 'INDEX, FOLLOW';
}

if ($mlSwitch === 'checked' && $lang !== $mainLang) {
  if (isset($bodyClass) && strpos($bodyClass, 'home') !== false && !empty($altLangOneDesc)) {
		$pageDesc = $altLangOneDesc;
  }

	if (!empty($altLangOneTitle) && !str_contains($currentpage, '/jp-admin')) {
		$siteName = $outputSiteName = $altLangOneTitle;
	}
}

if ((isset($pageTitle) && $pageTitle === $siteName) || $isHome) {
	$outputSiteName = '';
} else {
	$outputSiteName = ' | ' . $siteName;
}
