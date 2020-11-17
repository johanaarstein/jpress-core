<?php

if (count(get_siteInfo()) > 0) {
  $siteName = get_siteInfo()[0]['sitename'];
	if (isset($pageDesc)) {
		if (empty($pageDesc)) {
			$pageDesc = get_siteInfo()[0]['sitedesc'];
		}
	} else if (empty(get_siteInfo()[0]['sitedesc'])) {
		$pageDesc = 'Bare enda ei JPress-side';
	} else {
		$pageDesc = get_siteInfo()[0]['sitedesc'];
	}
	$logo = base64_decode(get_siteInfo()[0]['logo']);
	if (isset($featuredImage)) {
		if (empty($featuredImage)) {
			if (empty(get_siteInfo()[0]['featuredImage'])) {
				$featuredImage = '/assets/img/jpress.png';
			} else {
				$featuredImage = get_siteInfo()[0]['featuredImage'];
			}
		}
	} else {
		$featuredImage = get_siteInfo()[0]['featuredImage'];
	}
  $fbPageID = get_siteInfo()[0]['fbPageID'];
	$fbAppID = get_siteInfo()[0]['fbAppID'];
  $fbAppSecret = get_siteInfo()[0]['fbAppSecret'];
  $igAccountID = get_siteInfo()[0]['igAccountID'];
  $igUserID = get_siteInfo()[0]['igUserID'];
  $igAppID = get_siteInfo()[0]['igAppID'];
  $igAppSecret = get_siteInfo()[0]['igAppSecret'];
	$tags = get_siteInfo()[0]['tags'];
	$mainEmail = get_siteInfo()[0]['mainEmail'];
  $telephone = get_siteInfo()[0]['telephone'];
  $mailHeaderSwitch = get_siteInfo()[0]['mailHeaderSwitch'];
  $phoneHeaderSwitch = get_siteInfo()[0]['phoneHeaderSwitch'];
  $legalName = get_siteInfo()[0]['legalName'];
  $cfReceiptBody = get_siteInfo()[0]['cfReceiptBody'];
  $cfReceiptBodyAltLang = get_siteInfo()[0]['cfReceiptBodyAltLang'];
  $trackingHeadSwitch = get_siteInfo()[0]['trackingHeadSwitch'];
	$trackingHead = handleScript(get_siteInfo()[0]['trackingHead']);
  $trackingBodySwitch = get_siteInfo()[0]['trackingBodySwitch'];
	$trackingBody = handleScript(get_siteInfo()[0]['trackingBody']);
  $codeFooterSwitch = get_siteInfo()[0]['codeFooterSwitch'];
  $codeFooter = handleScript(get_siteInfo()[0]['codeFooter']);
  $customShortcodeSwitch = get_siteInfo()[0]['customShortcodeSwitch'];
  $customShortcodeFunction = handleScript(get_siteInfo()[0]['customShortcode']);
	$someShareSwitch = get_siteInfo()[0]['someShareSwitch'];
	$fbPage = get_siteInfo()[0]['fbPage'];
	$fbPageSwitch = get_siteInfo()[0]['fbPageSwitch'];
	$igPage = get_siteInfo()[0]['igPage'];
	$igPageSwitch = get_siteInfo()[0]['igPageSwitch'];
	$twitterPage = get_siteInfo()[0]['twitterPage'];
	$twitterPageSwitch = get_siteInfo()[0]['twitterPageSwitch'];
	$ytPage = get_siteInfo()[0]['ytPage'];
	$ytPageSwitch = get_siteInfo()[0]['ytPageSwitch'];
	$spotifyProfile = get_siteInfo()[0]['spotifyProfile'];
	$spotifySwitch = get_siteInfo()[0]['spotifySwitch'];
	$liPage = get_siteInfo()[0]['liPage'];
	$liPageSwitch = get_siteInfo()[0]['liPageSwitch'];
	$taSwitch = get_siteInfo()[0]['taSwitch'];
	$taPage = get_siteInfo()[0]['taPage'];
	$themeColor = '#' . get_siteInfo()[0]['themeColor'];
	$secondaryColor = '#' . get_siteInfo()[0]['secondaryColor'];
	$contrastColor = '#' . get_siteInfo()[0]['contrastColor'];
  $whiteColor = '#' . get_siteInfo()[0]['whiteColor'];
  $fontColor = json_decode(get_siteInfo()[0]['fontColor'], true);
  $nativeFont = get_siteInfo()[0]['nativeFont'];
	$gfSwitch = get_siteInfo()[0]['gfSwitch'];
	$fontHeading = get_siteInfo()[0]['fontHeading'];
	$fontBody = get_siteInfo()[0]['fontBody'];
  $fontFace = base64_decode(get_siteInfo()[0]['fontFace']);
	$tkSwitch = get_siteInfo()[0]['tkSwitch'];
	$tkStylesheet = base64_decode(get_siteInfo()[0]['tkStylesheet']);
	$tkFontFamily = base64_decode(get_siteInfo()[0]['tkFontFamily']);
	$tkFontFamilyHeader = base64_decode(get_siteInfo()[0]['tkFontFamilyHeader']);
  $customCursor = get_siteInfo()[0]['customCursor'];
  $robotsSwitch = get_siteInfo()[0]['robotsSwitch'];
	$scrollMenuSwitch = get_siteInfo()[0]['scrollMenuSwitch'];
	$mlSwitch = get_siteInfo()[0]['mlSwitch'];
	$altLangOne = get_siteInfo()[0]['altLangOne'];
  $reCAPTCHASwitch = get_siteInfo()[0]['reCAPTCHASwitch'];
	$reCAPTCHA_siteKey = get_siteInfo()[0]['reCAPTCHA_siteKey'];
	$reCAPTCHA_serverKey = get_siteInfo()[0]['reCAPTCHA_serverKey'];
  $googleAPIkey = get_siteInfo()[0]['googleAPIkey'];
  $sendgridSwitch = get_siteInfo()[0]['sendgridSwitch'];
  $sendgridAPIkey = get_siteInfo()[0]['sendgridAPIkey'];
  $gmSwitch = get_siteInfo()[0]['gmSwitch'];
  $gCal_clientId = get_siteInfo()[0]['gCalClientId'];
  $gCalProjectId = get_siteInfo()[0]['gCalProjectId'];
  $gCalClientSecret = get_siteInfo()[0]['gCalClientSecret'];
  $gCalSwitch = get_siteInfo()[0]['gCalSwitch'];
  $contestSwitch = get_siteInfo()[0]['contestSwitch'];
  $fbConnectSwitch = get_siteInfo()[0]['fbConnectSwitch'];
  $toTheTopSwitch = get_siteInfo()[0]['toTheTopSwitch'];
	if ($mlSwitch === 'checked') {
		if (!isset($lang)) {
			$lang = get_siteInfo()[0]['lang'];
		}
		$mainLang = get_siteInfo()[0]['lang'];
	} else {
		$lang = get_siteInfo()[0]['lang'];
	}
  $altLangOneDesc = get_altLangOneDesc();
	list($featuredImageWidth, $featuredImageHeight) = getimagesize(APP_ROOT . $featuredImage);
}
$metaPageTitle = strip_tags(str_replace('&shy;', '', str_replace('<br />', ' ', html_entity_decode($pageTitle))));

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
