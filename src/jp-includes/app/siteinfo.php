<?php

if (count(get_siteInfo()) > 0) {
  $siteName = get_siteInfo()['sitename'];
	if (isset($pageDesc)) {
		if (empty($pageDesc)) {
			$pageDesc = get_siteInfo()['sitedesc'];
		}
	} else if (empty(get_siteInfo()['sitedesc'])) {
		$pageDesc = 'Bare enda ei JPress-side';
	} else {
		$pageDesc = get_siteInfo()['sitedesc'];
	}
	$logo = base64_decode(get_siteInfo()['logo']);
	if (isset($featuredImage)) {
		if (empty($featuredImage)) {
			if (empty(get_siteInfo()['featuredImage'])) {
				$featuredImage = '/assets/img/jpress.png';
			} else {
				$featuredImage = get_siteInfo()['featuredImage'];
			}
		}
	} else {
		$featuredImage = get_siteInfo()['featuredImage'];
	}
  $fbPageID = get_siteInfo()['fbPageID'];
	$fbAppID = get_siteInfo()['fbAppID'];
  $fbAppSecret = get_siteInfo()['fbAppSecret'];
  $igAccountID = get_siteInfo()['igAccountID'];
  $igUserID = get_siteInfo()['igUserID'];
  $igAppID = get_siteInfo()['igAppID'];
  $igAppSecret = get_siteInfo()['igAppSecret'];
	$tags = get_siteInfo()['tags'];
	$mainEmail = get_siteInfo()['mainEmail'];
  $telephone = get_siteInfo()['telephone'];
  $mailHeaderSwitch = get_siteInfo()['mailHeaderSwitch'];
  $phoneHeaderSwitch = get_siteInfo()['phoneHeaderSwitch'];
  $legalName = get_siteInfo()['legalName'];
  $cfReceiptBody = get_siteInfo()['cfReceiptBody'];
  $cfReceiptBodyAltLang = get_siteInfo()['cfReceiptBodyAltLang'];
  $trackingHeadSwitch = get_siteInfo()['trackingHeadSwitch'];
	$trackingHead = handleScript(get_siteInfo()['trackingHead']);
  $trackingBodySwitch = get_siteInfo()['trackingBodySwitch'];
	$trackingBody = handleScript(get_siteInfo()['trackingBody']);
  $codeFooterSwitch = get_siteInfo()['codeFooterSwitch'];
  $codeFooter = handleScript(get_siteInfo()['codeFooter']);
  $customShortcodeSwitch = get_siteInfo()['customShortcodeSwitch'];
  $customShortcodeFunction = handleScript(get_siteInfo()['customShortcode']);
	$someShareSwitch = get_siteInfo()['someShareSwitch'];
	$fbPage = get_siteInfo()['fbPage'];
	$fbPageSwitch = get_siteInfo()['fbPageSwitch'];
	$igPage = get_siteInfo()['igPage'];
	$igPageSwitch = get_siteInfo()['igPageSwitch'];
	$twitterPage = get_siteInfo()['twitterPage'];
	$twitterPageSwitch = get_siteInfo()['twitterPageSwitch'];
	$ytPage = get_siteInfo()['ytPage'];
	$ytPageSwitch = get_siteInfo()['ytPageSwitch'];
	$spotifyProfile = get_siteInfo()['spotifyProfile'];
	$spotifySwitch = get_siteInfo()['spotifySwitch'];
	$liPage = get_siteInfo()['liPage'];
	$liPageSwitch = get_siteInfo()['liPageSwitch'];
	$taSwitch = get_siteInfo()['taSwitch'];
	$taPage = get_siteInfo()['taPage'];
	$themeColor = '#' . get_siteInfo()['themeColor'];
	$secondaryColor = '#' . get_siteInfo()['secondaryColor'];
	$contrastColor = '#' . get_siteInfo()['contrastColor'];
  $whiteColor = '#' . get_siteInfo()['whiteColor'];
  $fontColor = json_decode(get_siteInfo()['fontColor'], true);
  $nativeFont = get_siteInfo()['nativeFont'];
	$gfSwitch = get_siteInfo()['gfSwitch'];
	$fontHeading = get_siteInfo()['fontHeading'];
	$fontBody = get_siteInfo()['fontBody'];
  $fontFace = base64_decode(get_siteInfo()['fontFace']);
	$tkSwitch = get_siteInfo()['tkSwitch'];
	$tkStylesheet = base64_decode(get_siteInfo()['tkStylesheet']);
	$tkFontFamily = base64_decode(get_siteInfo()['tkFontFamily']);
	$tkFontFamilyHeader = base64_decode(get_siteInfo()['tkFontFamilyHeader']);
  $customCursor = get_siteInfo()['customCursor'];
  $robotsSwitch = get_siteInfo()['robotsSwitch'];
	$scrollMenuSwitch = get_siteInfo()['scrollMenuSwitch'];
	$mlSwitch = get_siteInfo()['mlSwitch'];
	$altLangOne = get_siteInfo()['altLangOne'];
  if ($_SERVER['SERVER_ADDR'] !== '::1') {
    $reCAPTCHASwitch = get_siteInfo()['reCAPTCHASwitch'];
  }
	$reCAPTCHA_siteKey = get_siteInfo()['reCAPTCHA_siteKey'];
	$reCAPTCHA_serverKey = get_siteInfo()['reCAPTCHA_serverKey'];
  $googleAPIkey = get_siteInfo()['googleAPIkey'];
  $sendgridSwitch = get_siteInfo()['sendgridSwitch'];
  $sendgridAPIkey = get_siteInfo()['sendgridAPIkey'];
  $gmSwitch = get_siteInfo()['gmSwitch'];
  $gCal_clientId = get_siteInfo()['gCalClientId'];
  $gCalProjectId = get_siteInfo()['gCalProjectId'];
  $gCalClientSecret = get_siteInfo()['gCalClientSecret'];
  $gCalSwitch = get_siteInfo()['gCalSwitch'];
  $contestSwitch = get_siteInfo()['contestSwitch'];
  $fbConnectSwitch = get_siteInfo()['fbConnectSwitch'];
  $toTheTopSwitch = get_siteInfo()['toTheTopSwitch'];
  $version = get_siteInfo()['version'];
  $csp = get_siteInfo()['csp'];
  $siteCreated = get_siteInfo()['created'];
	if ($mlSwitch === 'checked') {
		if (!isset($lang)) {
			$lang = $frontendLang = get_siteInfo()['lang'];
		}
		$mainLang = $frontendLang = get_siteInfo()['lang'];
	} else {
		$lang = $frontendLang = get_siteInfo()['lang'];
	}
  $altLangOneDesc = get_altLangOneDesc();
	list($featuredImageWidth, $featuredImageHeight) = getimagesize(APP_ROOT . $featuredImage);
}
if (!empty(get_siteInfo()['backendLang'])) {
  $backendLang = get_siteInfo()['backendLang'];
} else {
  $backendLang = $lang;
}
// if (isBackend()) {
//   $lang = $backendLang;
// }
if (isset($pageTitle)) {
  $metaPageTitle = strip_tags(str_replace('&shy;', '', str_replace('<br />', ' ', html_entity_decode($pageTitle))));
}

$currentpage = $_SERVER['REQUEST_URI'];
if (isset($pageTitle) && $pageTitle === $siteName) {
	$OutputSiteName = '';
} else {
	$OutputSiteName = ' | ' . $siteName;
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
}
