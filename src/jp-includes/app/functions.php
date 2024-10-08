<?php
$siteName = $pageDesc = $logo = $featuredImage = $featuredImageWidth = $featuredImageHeight = $fbPageID = $fbAppID = $fbAppSecret = $igAccountID = $igUserID = $igAppID = $igAppSecret = $fbPage = $trackingHead = $trackingBody = $igPage = $gfSwitch = $robotsSwitch = $mlSwitch = $altLangOneDesc = $contrastColor = $fontHeading = $fontBody = $customCursor = $scrollMenuSwitch = $mainEmail = $cfReceiptBody = $cfReceiptBodyAltLang = $reCAPTCHASwitch = $reCAPTCHA_siteKey = $reCAPTCHA_serverKey = $fbPageSwitch = $twitterPage = $twitterPageSwitch = $igPage = $igPageSwitch = $liPage = $liPageSwitch = $ytPage = $ytPageSwitch = $tags = $themeColor = $nativeFont = $gfSwitch = $gmSwitch = $tkSwitch = $whiteColor = $fontFace = $tkStylesheet = $tkFontFamily = $tkFontFamilyHeader = $lang = $taSwitch = $taPage = $spotifySwitch = $spotifyProfile = $scrollMenuSwitch = $googleAPIkey = $sendgridAPIkey = $sendgridSwitch = $legalName = $contestSwitch = $fontColor = $fbConnectSwitch = $toTheTopSwitch = $codeFooter = $customShortcodeFunction = $telephone = $phoneHeaderSwitch = $mailHeaderSwitch = $trackingHeadSwitch = $trackingBodySwitch = $codeFooterSwitch = $customShortcodeSwitch = $contestShortcode = $gCalSwitch = $gCal_clientId = $gCalProjectId = $gCalClientSecret = $backendLang = $frontendLang = $translatedSlug = $csp = $nonceSwitch = $siteCreated = '';

function getOption($key = null) {
	global $db;
	global $thereWasAnError_str;
	global $noContent_str;
	$output = false;
	$select =
	"SELECT `sitename`,
				 `sitedesc`,
				 `logo`,
				 `featuredImage`,
				 `fbConnectSwitch`,
				 `fbPageID`,
				 `fbAppID`,
				 `fbAppSecret`,
				 `igAccountID`,
				 `igUserID`,
				 `igAppID`,
				 `igAppSecret`,
				 `tags`,
				 `mainEmail`,
				 `telephone`,
				 `mailHeaderSwitch`,
				 `phoneHeaderSwitch`,
				 `legalName`,
				 `cfReceiptBody`,
				 `cfReceiptBodyAltLang`,
				 `trackingHeadSwitch`,
				 `trackingHead`,
				 `trackingBodySwitch`,
				 `trackingBody`,
				 `codeFooterSwitch`,
				 `codeFooter`,
				 `customShortcodeSwitch`,
				 `customShortcode`,
				 `someShareSwitch`,
				 `fbPage`,
				 `fbPageSwitch`,
				 `igPage`,
				 `igPageSwitch`,
				 `twitterPage`,
				 `twitterPageSwitch`,
				 `ytPage`,
				 `ytPageSwitch`,
				 `spotifyProfile`,
				 `spotifySwitch`,
				 `liPage`,
				 `liPageSwitch`,
				 `taSwitch`,
				 `taPage`,
				 `themeColor`,
				 `secondaryColor`,
				 `contrastColor`,
				 `whiteColor`,
				 `fontColor`,
				 `nativeFont`,
				 `gfSwitch`,
				 `fontHeading`,
				 `fontBody`,
				 `fontFace`,
				 `tkSwitch`,
				 `tkStylesheet`,
				 `tkFontFamily`,
				 `tkFontFamilyHeader`,
				 `customCursor`,
				 `robotsSwitch`,
				 `mlSwitch`,
				 `altLangOne`,
				 `lang`,
				 `scrollMenuSwitch`,
				 `reCAPTCHASwitch`,
				 `reCAPTCHA_siteKey`,
				 `reCAPTCHA_serverKey`,
				 `googleAPIkey`,
				 `sendgridSwitch`,
				 `sendgridAPIkey`,
				 `gmSwitch`,
				 `gCalSwitch`,
				 `gCalClientId`,
				 `gCalProjectId`,
				 `gCalClientSecret`,
				 `contestSwitch`,
				 `toTheTopSwitch`,
				 `version`,
				 `backendLang`,
				 `csp`,
				 `nonceSwitch`,
				 `created`
	FROM   `siteInfo`
	LIMIT  1;";

	if (!$select) {
		if ($db -> error) {
			http_response_code(500);
			echo $thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error;
		} else {
			echo $noContent_str;
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		$siteInfoArray = [];
		if ($result && $result -> num_rows > 0) {
			while ($row = $result -> fetch_assoc()) {
				$siteInfoArray += $row;
			}
			$output = $key ? $siteInfoArray[$key] : $siteInfoArray;
		}
	}
	return $output;
}

function homeRevisionsDate($id) {
	global $db;
	global $lang;
	global $thereWasAnError_str;
	global $noContent_str;
	$output = false;
	$select =
	"SELECT `created`
	FROM    `home_revisions`
	WHERE   `lang` = '$lang'
					AND `initialID` = '$id'
	LIMIT   20;";
	if (!$select) {
		if ($db -> error) {
			http_response_code(500);
			echo $thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error;
		} else {
			echo $noContent_str;
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		$output = array();
		if ($result && $result -> num_rows > 0) {
			while ($row = $result -> fetch_assoc()) {
				$output[] = $row;
			}
		}
	}
	return $output;
}

function get_homeRevisions($id, $offset) {
	global $db;
	global $lang;
	global $thereWasAnError_str;
	global $noContent_str;
	$output = false;
	$select =
	"SELECT `sectionText`
	FROM    `home_revisions`
	WHERE   `lang` = '$lang'
					-- AND `initialID` = '$id'
	ORDER   BY `created` DESC
	LIMIT   1 OFFSET '$offset';";

	if (!$select) {
		if ($db -> error) {
			http_response_code(500);
			echo $thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error;
		} else {
			echo $noContent_str;
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		$output = array();
		if ($result && $result -> num_rows > 0) {
			while ($row = $result -> fetch_assoc()) {
				$output[] = $row;
			}
		}
	}
	return $output;
}

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

function isFolderWritable($folder, $x) {
	$flag = true;
	$count = 0;
	$dir = new DirectoryIterator(APP_ROOT . $folder);
	foreach ($dir as $file) {
		if ($file -> isDot() || !is_writable($file)) {
			continue;
		} else {
			$count += 1;
		}
	}
	if ($count > $x) {
		$flag = false;
	}
	return $flag;
}

function get_altLangOneDesc() {
	global $db;
	global $altLangOne;
	global $thereWasAnError_str;
	global $noContent_str;
	$output = false;
	$select =
	"SELECT `sitedesc`
	FROM    `siteInfo_altLang`
	WHERE   `lang` = '$altLangOne'
	LIMIT  1;";

	$desc = '';

	if (!$select) {
		if ($db -> error) {
			http_response_code(500);
			echo $thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error;
		} else {
			echo $noContent_str;
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		if ($result && $result -> num_rows > 0) {
			while ($row = $result -> fetch_assoc()) {
				$desc .= $row['sitedesc'];
			}
		}
		$output = $desc;
	}
	return $output;
}

function isHome() {
	global $bodyClass;
	$class = $bodyClass ?? '';
	return strpos($class, 'home') !== false;
}

function isArticle() {
	global $bodyClass;
	$class = $bodyClass ?? '';
	return strpos($class, 'article') !== false;
}

function isPrivacy() {
	global $slug;
	global $privacy_str;
	return $slug === strtolower($privacy_str);
}

function isSettings() {
	global $bodyClass;
	$class = $bodyClass ?? '';
	return strpos($class, 'seo-panel') !== false;
}

function isNoIndex() {
	global $bodyClass;
	$class = $bodyClass ?? '';
	return strpos($class, 'noindex') !== false;
}

function isLoggedIn() {
	return isset($_SESSION["loggedin"]) && $_SESSION["loggedin"];
}

function isBackend() {
	global $bodyClass;
	$class = $bodyClass ?? '';
	return strpos($class, 'admin') !== false;
}

function isAdmin() {
	$flag = false;
	if (isLoggedIn()) {
		global $db;
		global $thereWasAnError_str;
		$select =
		"SELECT `username`
		FROM    `users`
		WHERE   `role` = 'admin';";
		if (!$select) {
			http_response_code(500);
			if ($db -> error) {
				printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
			} else {
				printf($thereWasAnError_str);
			}
			$db -> close();
			exit();
		} else {
			$result = $db -> query($select);
			if ($result && $result -> num_rows > 0) {
				while ($row = $result -> fetch_assoc()) {
					if ($_SESSION['username'] === $row['username']) {
						$flag = true;
					}
				}
			}
		}
	}
	return $flag;
}

function nonce() {
	$flag = false;
	if (getOption('nonceSwitch') === 'checked') {
		$flag = true;
	}
	return $flag;
}

function custom_copy($src, $dst) {
	// open the source directory
	$dir = opendir($src);
	// Make the destination directory if not exist
	@mkdir($dst);
	// Loop through the files in source directory
	while($file = readdir($dir)) {
		if (($file != '.') && ($file != '..')) {
			if (is_dir($src . '/' . $file)) {
				// Recursively calling custom copy function for sub directory
				custom_copy($src . '/' . $file, $dst . '/' . $file);
			} else {
				copy($src . '/' . $file, $dst . '/' . $file);
			}
		}
	}
	closedir($dir);
}

function get_articles() {
	global $db;
	global $published;
	global $displayInMenu;
	global $lang;
	global $privacy_str;
	global $altLangOne;
	global $slug;
	global $thereWasAnError_str;

	$articlesList = '';
	$output = false;

	$select =
	"SELECT `slug`,
					`label`
	FROM    `articles`
	WHERE   `lang` = '$lang'
					AND `published` = '1'
					AND `displayInMenu` = 'checked'
	ORDER   BY `order` ASC;";
	if (!$select) {
		http_response_code(500);
		if ($db -> error) {
			printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
		} else {
			printf($thereWasAnError_str);
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		if ($result && $result -> num_rows > 0) {
			while ($row = $result -> fetch_assoc()) {
				$currentMenuItem = '';
				if (isset($slug) && $slug == $row['slug']) {
					$currentMenuItem = 'current-menu-item';
				}
				$langDash = '';
				if (isset($altLangOne) && $altLangOne === $lang) {
					$langDash = $altLangOne . '/';
				}
				$articlesList .= '<li class="' . $currentMenuItem . '"><a href="/' . $langDash . $row['slug'] . '/' . (isLoggedIn() && isPageSpeed() ? '?ModPagespeed=off' : '') . '">' . $row['label'] . '</a></li>' . "\r\n";
			}
			$output = $articlesList;
		}
	}
	return $output;
}

function get_adminArticles() {
	global $db;
	global $published;
	global $lang;
	global $articles_str;
	global $draft_str;
	global $altLangOne;
	global $slug;
	global $thereWasAnError_str;

	$output = false;

	$select =
	"SELECT `slug`,
				 `label`,
				 `published`
	FROM   `articles`
	WHERE  `lang` = '$lang'
	ORDER  BY `order` DESC;";
	if (!$select) {
		http_response_code(500);
		if ($db -> error) {
			printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
		} else {
			printf($thereWasAnError_str);
		}
		$db -> close();
		exit();
	} else {
		$altLangUrl = '';
		if ($lang === $altLangOne) {
			$altLangUrl = $altLangOne . '/';
		}
		$adminArticles = '';
		$result = $db -> query($select);
		if ($result && $result -> num_rows > 0) {
			$adminArticles .= '<li><a id="admin-articles-toggle" href="#"><span class="icon icon-articlestackjpress"></span>' . $articles_str . '<span class="icon-arrowdownjpress"></span></a></li>' . "\r\n";
			$adminArticles .= '<ul id="admin-articles-list">' . "\r\n";
			$adminArticles .= '<form id="delete-article-form" method="post" action="/jp-includes/delete/delete-article.php">' . "\r\n";
			while ($row = $result -> fetch_assoc()) {
				$currentMenuItem = '';
				if (isset($slug) && $slug == $row['slug']) {
					$currentMenuItem = 'current-menu-item';
				}
				$draftUrl = $draftLabel = '';
				$modPageSpeed = '?ModPagespeed=off';
				if ($row['published'] === '0') {
					$draftLabel = '&nbsp;[' . $draft_str . ']';
					$draftUrl = '?draft';
					$modPageSpeed = '&ModPagespeed=off';
				}
				$adminArticles .= '<li class="' . $currentMenuItem . '">' . "\r\n";
				$adminArticles .= '<button type="submit" name="' . $row['slug'] . '" class="background-hover">' . "\r\n";
				$adminArticles .= '<span class="icon-deletejpress"></span>' . "\r\n";
				$adminArticles .= '</button>' . "\r\n";
				$adminArticles .= '<a href="/' . $altLangUrl . $row['slug'] . '/' . $draftUrl . (isPageSpeed() ? $modPageSpeed : '') . '"><span class="icon icon-articlejpress"></span>&nbsp;' . $row['label'] . $draftLabel . '</a>' . "\r\n";
				$adminArticles .= '</li>' . "\r\n";
			}
			$adminArticles .= '</form>' . "\n";
			$adminArticles .= '</ul>' . "\n";

			$output = $adminArticles;
		}
	}
	return $output;
}

function get_media($format) {
	global $db;
	global $thereWasAnError_str;
	global $pageTitle;
	global $mediaLibrary_str;

	$output = false;

	$select =
	"SELECT `mimeType`,
					`thumbnail`,
					`guid`,
					`imageAlt`,
					`name`,
					`id`,
					`photoCredit`,
					`imageCaption`
	FROM    `media`
	ORDER  BY `created` DESC;";
	if (!$select) {
		http_response_code(500);
		if ($db -> error) {
			printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
		} else {
			printf($thereWasAnError_str);
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		if ($result && $result -> num_rows > 0) {
			$pushUp = '';
			if (isset($pageTitle) && $pageTitle === $mediaLibrary_str) {
				$pushUp = 'push-up';
			}
			$mediaLibrary = '<ul id="media-library-view" class="' . $pushUp . '">';
			while ($row = $result -> fetch_assoc()) {
				$mimeType = $row['mimeType'];
				if ($mimeType === 'video/mp4') {
					$mimeTypeIcon = '<span class="mimetype-icon icon-film-camerajpress"></span>';
				} elseif ($mimeType === 'application/pdf') {
					$mimeTypeIcon = '<span class="mimetype-icon icon-articlejpress"></span>';
				} else {
					$mimeTypeIcon = '';
				}
				$alt = $row['imageAlt'];
				if ($format === 'video') {
					if ($mimeType !== 'video/mp4') {
						continue;
					}
				} elseif ($format === 'image') {
					if ($mimeType === 'video/mp4') {
						continue;
					}
				}
				if ($mimeType === 'image/jpeg' || $mimeType === 'image/webp' || $mimeType === 'application/pdf' || $mimeType === 'video/mp4') {
					$src = $row['thumbnail'];
				} else {
					$src = $row['guid'];
				}
				$mediaElement = $mimeTypeIcon . '<img src="' . $src . '" alt="' . $alt . '" />';
				$href = $row['guid'];
				$fileName = $row['name'];
				$imageId = $row['id'];
				$photoCredit = $row['photoCredit'];
				$imageCaption = $row['imageCaption'];
				$full_href = APP_ROOT . '/uploads/' . $fileName;
				$class = '';
				if ($mimeType === 'video/mp4') {
					$class = ' video';
				}
				if (file_exists($full_href)) {
					$fileSize = filesize($full_href);
				} else {
					$fileSize = 0;
				}
				$mediaLibrary .=
				'<li>
					<div class="preview-holder">
						<a role="checkbox" tabindex="0" class="module-link" data-alt="' . $alt . '" data-name="' . $fileName . '" data-id="' . $imageId . '" data-size="' . $fileSize . '" data-credit="' . $photoCredit . '" data-caption="' . $imageCaption . '" href="' . $href . '">
							<div class="centered' . $class . '">' . $mediaElement . '
							</div>
						</a>
					</div>
				</li>';
			}
			$mediaLibrary .= '</ul>';
		}
		$output = $mediaLibrary;
	}
	return $output;
}

function get_scrollMenu() {
	global $db;
	global $lang;
	global $thereWasAnError_str;
	$output = false;
	$scrollMenuText = '';
	$select =
	"SELECT `content`
	FROM    `scrollMenu`
	WHERE   `lang` = '$lang'
	LIMIT   1;";
	if (!$select) {
		http_response_code(500);
		if ($db -> error) {
			printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
		} else {
			printf($thereWasAnError_str);
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		if ($result && $result -> num_rows > 0) {
			while ($row = $result -> fetch_assoc()) {
				$scrollMenuText = preg_replace("/(<img[^>]*)src=/", "$1data-src=", $row['content']);
			}
		}
		$output = $scrollMenuText;
	}
	return $output;
}

function handleScript($script) {
	$output = base64_decode($script);
	if (nonce()) {
		$output = preg_replace("/nonce='(.*?)'/", "nonce='" . NONCE . "'", base64_decode($script));
	}
	return $output;
}

function get_footer() {
	global $db;
	global $lang;
	global $thereWasAnError_str;
	$output = false;
	$footerArray = array();
	$select =
	"SELECT `columnOne`,
					`columnTwo`,
					`columnThree`,
					`footerClass`,
					`footerBackgroundImage`,
					`footerBackgroundImageId`
	FROM    `footer`
	WHERE   `lang` = '$lang'
	LIMIT  1;";
	if (!$select) {
		http_response_code(500);
		if ($db -> error) {
			printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
		} else {
			printf($thereWasAnError_str);
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		if ($result && $result -> num_rows > 0) {
			while ($row = $result -> fetch_assoc()) {
				array_push($footerArray, $row);
			}
		}
		$output = $footerArray;
	}
	return $output;
}

function rrmdir($dir) {
	if (is_dir($dir)) {
		$objects = scandir($dir);
		foreach ($objects as $object) {
			if ($object != "." && $object != "..") {
				if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
			}
		}
		reset($objects);
		rmdir($dir);
	}
}

if (!function_exists('apache_response_headers')) {
	function apache_response_headers() {
		$output = array();
		$headers = headers_list();
		foreach ($headers as $header) {
			$header = explode(":", $header);
			$output[array_shift($header)] = trim(implode(":", $header));
		}
		return $output;
	}
}

function isPageSpeed() {
	$output = false;
	if (isset($_GET['ModPagespeed']) && $_GET['ModPagespeed'] === 'off') {
		$output = true;
	} else {
		$headers = apache_response_headers();
		if (isset($headers['X-Mod-Pagespeed']) || isset($headers['X-Page-Speed'])) {
			$output = true;
		}
	}
	return $output;
}

function hex2RGB($hexStr, $returnAsString = false, $seperator = ',') {
	$hexStr = preg_replace("/[^0-9A-Fa-f]/", '', $hexStr); // Gets a proper hex string
	$rgbArray = array();
	if (strlen($hexStr) == 6) { //If a proper hex code, convert using bitwise operation. No overhead... faster
		$colorVal = hexdec($hexStr);
		$rgbArray['red'] = 0xFF & ($colorVal >> 0x10);
		$rgbArray['green'] = 0xFF & ($colorVal >> 0x8);
		$rgbArray['blue'] = 0xFF & $colorVal;
	} elseif (strlen($hexStr) == 3) { //if shorthand notation, need some string manipulations
		$rgbArray['red'] = hexdec(str_repeat(substr($hexStr, 0, 1), 2));
		$rgbArray['green'] = hexdec(str_repeat(substr($hexStr, 1, 1), 2));
		$rgbArray['blue'] = hexdec(str_repeat(substr($hexStr, 2, 1), 2));
	} else {
		return false; //Invalid hex color code
	}
	return $returnAsString ? implode($seperator, $rgbArray) : $rgbArray; // returns the rgb string or the associative array
}

function strposa($haystack, $needle, $offset = 0) {
	$flag = false;
	if (!is_array($needle)) $needle = array($needle);
	foreach($needle as $query) {
		if (strrpos($haystack, $query, $offset) !== false) {
			$flag = true; // stop on first true result
		}
	}
	return $flag;
}

function get_contactForm() {
	global $name_str;
	global $email_str;
	global $message_str;
	global $send_str;
	global $recaptchaContact_str;
	global $mainEmail;
	global $lang;
	global $reCAPTCHA_siteKey;
	global $reCAPTCHASwitch;

	$reCAPTCHASignature = '';
	$reCAPTCHAResonse = '';
	$cfScript = '';
	if ($reCAPTCHASwitch === 'checked') {
		$reCAPTCHAResonse = '<input type="hidden" name="recaptcha_response" id="recaptchaResponse">';
		$cfScript = '<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&explicit&hl=' . $lang . '&render=' . $reCAPTCHA_siteKey . '" ' . (nonce() ? 'nonce="' . NONCE . '" ' : '') . 'async defer></script>' .
		'<script ' . (nonce() ? 'nonce="' . NONCE . '" ' : '') . '>var request=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");var requestString,contactForm=document.getElementById("contact-form"),spinnerContact=document.getElementById("spinner-contact-form"),recaptchaResponse=document.getElementById("recaptchaResponse"),cfName=document.getElementById("cf-name"),cfEmail=document.getElementById("cf-email"),cfMessage=document.getElementById("cf-message");if(contactForm){var onloadCallback=function(){grecaptcha.execute("' . $reCAPTCHA_siteKey . '",{action:"contact"}).then(function(a){recaptchaResponse.value=a})};contactForm.addEventListener("submit",function(a){a.preventDefault(),requestString="recaptcha_response="+recaptchaResponse.value+"&cf-name="+cfName.value+"&cf-email="+cfEmail.value+"&cf-message="+cfMessage.value+"&site-lang="+siteLang,spinnerContact.style.display="block",spinnerContact.style.opacity="1",request.onreadystatechange=function(){spinnerContact.style.display="none",spinnerContact.style.opacity="0";4===this.readyState&&(contactForm.style.maxHeight="0",contactForm.style.opacity="0",200<=this.status&&300>this.status?(contactForm.insertAdjacentHTML("beforeBegin","<p class=\"aligncenter cf-message cf-success-message\">"+emailSuccess_str+"</p>"),cfName.value=cfEmail.value=cfMessage.value=""):400<=this.status&&600>this.status&&(contactForm.insertAdjacentHTML("beforeBegin","<p class=\"aligncenter cf-message cf-error-message\">"+emailFailure_str+": <a href=\"mailto:"+contactForm.getAttribute("data-mail")+"\" target=\"_blank\" rel=\"nofollow noreferrer\">"+contactForm.getAttribute("data-mail")+"</a></p>"),console.log(this.responseText)))},request.open("POST","/jp-includes/mail/contact-form-handler.php",!0),request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8"),request.send(requestString)},!1)}</script>';
		$reCAPTCHASignature = '<div class="recaptcha-privacy"><p>' . $recaptchaContact_str . '</p></div>';
	} else {
		$cfScript = '<script ' . (nonce() ? 'nonce="' . NONCE . '"' : '') . '>"use strict";var request=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");var requestString,contactForm=document.getElementById("contact-form"),spinnerContact=document.getElementById("spinner-contact-form"),cfName=document.getElementById("cf-name"),cfEmail=document.getElementById("cf-email"),cfMessage=document.getElementById("cf-message");contactForm.addEventListener("submit",function(a){a.preventDefault(),requestString="&cf-name="+cfName.value+"&cf-email="+cfEmail.value+"&cf-message="+cfMessage.value+"&site-lang="+siteLang,spinnerContact.style.display="block",spinnerContact.style.opacity="1",request.open("POST","/jp-includes/mail/contact-form-handler.php",!1),request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8"),request.onreadystatechange=function(){spinnerContact.style.display="none",spinnerContact.style.opacity="0",4===this.readyState&&(contactForm.style.maxHeight="0",contactForm.style.opacity="0",200<=this.status&&300>this.status?(contactForm.insertAdjacentHTML("beforeBegin","<p class=\"aligncenter cf-message cf-success-message\">"+emailSuccess_str+"</p>"),cfName.value=cfEmail.value=cfMessage.value=""):400<=this.status&&600>this.status&&(contactForm.insertAdjacentHTML("beforeBegin","<p class=\"aligncenter cf-message cf-error-message\">"+emailFailure_str+": <a href=\"mailto:"+contactForm.getAttribute("data-mail")+"\" target=\"_blank\" rel=\"nofollow noreferrer\">"+contactForm.getAttribute("data-mail")+"</a></p>"),console.log(this.responseText)))},request.send(requestString)},!1);</script>';
	}
	$contactForm =
	'<div class="front-end-form">
	<form id="contact-form" method="post" name="contact-form" action="/jp-includes/mail/contact-form-handler.php" data-mail="' . $mainEmail . '">
		<input type="hidden" id="original-url" name="frontend-contact-form" value="' . $_SERVER['REQUEST_URI'] . '">'
		. $reCAPTCHAResonse .
		'<div class="form-group">
			<input type="text" id="cf-name" name="cf-name" placeholder="' . $name_str . '">
		</div>
		<div class="form-group">
			<input type="text" id="cf-email" name="cf-email" placeholder="' . $email_str . '">
		</div>
		<div class="form-group">
			<textarea id="cf-message" name="cf-message" placeholder="' . $message_str . '"></textarea>
		</div>
		<div class="form-group">
			<input class="btn theme-background background-hover semi-link" type="submit" value="' . $send_str . '">'
			. $reCAPTCHASignature .
		'</div>
		<div id="spinner-contact-form" class="loading-container module">
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
	</form>
	</div>' . $cfScript;

	return $contactForm;
}

function get_contactForm2() {
	global $phoneNumber_str;
	global $email_str;
	global $message_str;
	global $send_str;
	global $recaptchaContact_str;
	global $mainEmail;
	global $lang;
	global $reCAPTCHA_siteKey;
	global $reCAPTCHASwitch;

	$reCAPTCHASignature = '';
	$reCAPTCHAResonse = '';
	$cfScript = '';
	if ($reCAPTCHASwitch === 'checked') {
		$reCAPTCHAResonse = '<input type="hidden" name="recaptcha_response" id="recaptchaResponse">';
		$cfScript = '<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&explicit&hl=' . $lang . '&render=' . $reCAPTCHA_siteKey . '" ' . (nonce() ? 'nonce="' . NONCE . '" ' : '') . 'async defer></script>' .
		'<script ' . (nonce() ? 'nonce="' . NONCE . '"' : '') . '>var request=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");var requestString,contactForm=document.getElementById("contact-form"),spinnerContact=document.getElementById("spinner-contact-form"),recaptchaResponse=document.getElementById("recaptchaResponse"),cfPhone=document.getElementById("cf-phone"),cfEmail=document.getElementById("cf-email");if(contactForm){var onloadCallback=function(){grecaptcha.execute("' . $reCAPTCHA_siteKey . '",{action:"contact"}).then(function(a){recaptchaResponse.value=a})};contactForm.addEventListener("submit",function(a){a.preventDefault(),requestString="recaptcha_response="+recaptchaResponse.value+"&cf-phone="+cfPhone.value+"&cf-email="+cfEmail.value,spinnerContact.style.display="block",spinnerContact.style.opacity="1",request.onreadystatechange=function(){spinnerContact.style.display="none",spinnerContact.style.opacity="0";4===this.readyState&&(contactForm.style.maxHeight="0",contactForm.style.opacity="0",200<=this.status&&300>this.status?(contactForm.insertAdjacentHTML("beforeBegin","<p class=\"aligncenter cf-message cf-success-message\">"+emailSuccess_str+"</p>"),cfPhone.value=cfEmail.value=""):400<=this.status&&600>this.status&&(contactForm.insertAdjacentHTML("beforeBegin","<p class=\"aligncenter cf-message cf-error-message\">"+emailFailure_str+": <a href=\"mailto:"+contactForm.getAttribute("data-mail")+"\" target=\"_blank\" rel=\"nofollow noreferrer\">"+contactForm.getAttribute("data-mail")+"</a></p>"),console.log(this.responseText)))},request.open("POST","/jp-includes/mail/contact-form-handler-2.php",!0),request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8"),request.send(requestString)},!1)}</script>';
		$reCAPTCHASignature = '<div class="recaptcha-privacy"><p>' . $recaptchaContact_str . '</p></div>';
	} else {
		$cfScript = '<script ' . (nonce() ? 'nonce="' . NONCE . '"' : '') . '>"use strict";var request=window.XMLHttpRequest?new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");var requestString,contactForm=document.getElementById("contact-form"),spinnerContact=document.getElementById("spinner-contact-form"),cfPhone=document.getElementById("cf-phone"),cfEmail=document.getElementById("cf-email");contactForm.addEventListener("submit",function(a){a.preventDefault(),requestString="&cf-phone="+cfPhone.value+"&cf-email="+cfEmail.value,spinnerContact.style.display="block",spinnerContact.style.opacity="1",request.open("POST","/jp-includes/mail/contact-form-handler-2.php",!1),request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8"),request.onreadystatechange=function(){spinnerContact.style.display="none",spinnerContact.style.opacity="0",4===this.readyState&&(contactForm.style.maxHeight="0",contactForm.style.opacity="0",200<=this.status&&300>this.status?(contactForm.insertAdjacentHTML("beforeBegin","<p class=\"aligncenter cf-message cf-success-message\">"+emailSuccess_str+"</p>"),cfPhone.value=cfEmail.value=""):400<=this.status&&600>this.status&&(contactForm.insertAdjacentHTML("beforeBegin","<p class=\"aligncenter cf-message cf-error-message\">"+emailFailure_str+": <a href=\"mailto:"+contactForm.getAttribute("data-mail")+"\" target=\"_blank\" rel=\"nofollow noreferrer\">"+contactForm.getAttribute("data-mail")+"</a></p>"),console.log(this.responseText)))},request.send(requestString)},!1);</script>';
	}
	$contactForm =
	'<div class="front-end-form">
	<form id="contact-form" method="post" name="contact-form" action="/jp-includes/mail/contact-form-handler-2.php" data-mail="' . $mainEmail . '">
		<input type="hidden" id="original-url" name="frontend-contact-form" value="' . $_SERVER['REQUEST_URI'] . '">'
		. $reCAPTCHAResonse .
		'<div class="form-group">
			<input type="text" id="cf-phone" name="cf-phone" placeholder="' . $phoneNumber_str . '">
		</div>
		<div class="form-group">
			<input type="text" id="cf-email" name="cf-email" placeholder="' . $email_str . '">
		</div>
		<div class="form-group">
			<input class="btn theme-background background-hover semi-link" type="submit" value="' . $send_str . '">'
			. $reCAPTCHASignature .
		'</div>
		<div id="spinner-contact-form" class="loading-container module">
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
	</form>
	</div>' . $cfScript;

	return $contactForm;
}

function replace_extension($filename, $new_extension) {
	$info = pathinfo($filename);
	return $info['filename'] . '.' . $new_extension;
}

function get_someShare() {
	global $metaPageTitle;
	global $share_str;
	global $on_str;
	global $featuredImage;
	global $pageDesc;
	$someShareHTML =
	'<div class="so-me-container">
		<ul class="so-me share">
			<li class="facebook white-background">
				<a id="facebook-share" href="https://www.facebook.com/sharer/sharer.php?u=' . CURRENT_URL . '&t=' . rawurlencode($metaPageTitle) . '" target="_blank" title="' . $share_str . ' ' . $on_str . ' Facebook" rel="noreferrer nofollow"><span class="icon-facebookjpress"></span></a>
			</li>
			<li class="twitter white-background">
				<a id="twitter-share" href="https://twitter.com/intent/tweet?url=' . CURRENT_URL . '&text=' . rawurlencode($metaPageTitle) . '" target="_blank" title="' . $share_str . ' ' . $on_str . ' Twitter" rel="noreferrer nofollow"><span class="icon-twitterjpress"></span></a>
			</li>
			<li class="pinterest white-background">
				<a id="pinterest-share" href="https://pinterest.com/pin/create/button/?url=' . CURRENT_URL . '&media=' . BASE_URL . $featuredImage . '&description=' . rawurlencode(strip_tags($pageDesc)) . '"><span class="icon-pinterestjpress"></span></a>
			</li>
		</ul>
	</div>';
	return $someShareHTML;
}

function get_igFeed() {
	global $db;
	global $version;
	global $igAppID;
	global $igAccountID;
	global $igUserID;
	global $igAppSecret;
	global $thereWasAnError_str;

	$accessToken = $output = '';
	$igArr = array();
	$scrape = false;

	$create =
	"CREATE TABLE IF NOT EXISTS `igFeed` (
		`id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
		`postID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
		`fileName` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
		`guid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
		`permalink` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
		`mimeType` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
		`thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
		`children` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
		`username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
		`caption` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
		`created` timestamp NOT NULL DEFAULT current_timestamp(),
		`scraped` timestamp NOT NULL DEFAULT current_timestamp(),
		PRIMARY KEY  (`id`)
	);";

	$result = $db -> query($create);

	if (!$result) {
		http_response_code(500);
		if ($db -> error) {
			printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
		} else {
			printf('Unknown error, line 916');
		}
		$db -> close();
		exit();
	}

	$select =
	"SELECT `id`,
					`postID`,
					`fileName`,
					`mimeType`,
					`guid`,
					`permalink`,
					`thumbnail`,
					`children`,
					`username`,
					`caption`,
					`created`,
					`scraped`
	FROM    `igFeed`;";

	$result = $db -> query($select);

	if (!$result) {
		if ($db -> error) {
			http_response_code(500);
			printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
			$db -> close();
			exit();
		} else {

		}
	} else {
		$latestPost = 0;
		if ($result -> num_rows > 0) {
			while ($row = $result -> fetch_assoc()) {
				array_push($igArr, $row);
				if (strtotime(end($igArr)['scraped']) < strtotime("-10 days")) {
					$scrape = true;
					$latestPost = end($igArr)['created'];
				}
			}
		}
		if ($result -> num_rows === 0 || $scrape) {
			require_once(APP_ROOT . '/plugins/instagram/inc/instagram_basic_display_api.php');

			if (!defined('INSTAGRAM_APP_ID')) {
				define('INSTAGRAM_APP_ID', $igAppID);
			}
			if (!defined('INSTAGRAM_APP_SECRET')) {
				define('INSTAGRAM_APP_SECRET', $igAppSecret);
			}
			if (!defined('INSTAGRAM_APP_REDIRECT_URI')) {
				define('INSTAGRAM_APP_REDIRECT_URI', BASE_URL);
			}

			$tokenPath = APP_ROOT . '/plugins/instagram/token.json';
			if (file_exists($tokenPath)) {
				$accessTokenArray = json_decode(file_get_contents($tokenPath), true);
				$accessToken = $accessTokenArray['access_token'];
			}

			$params = array(
				'get_code' => isset($_GET['code']) ? $_GET['code'] : '',
				'access_token' => $accessToken,
				'user_id' => $igUserID
			);

			$ig = new instagram_basic_display_api($params);
			$usersMedia = $ig -> getUsersMedia();
		}
		if (!empty($usersMedia) && isset($usersMedia['data'])) {
			foreach ($usersMedia['data'] as $post) {
				if (strtotime($post['timestamp']) > strtotime($latestPost)) {
					$postID = $post['id'];
					$guid = $post['media_url'];
					$fileName = basename($guid);
					$permalink = $post['permalink'];
					$mimeType = strtolower($post['media_type']);
					$thumbnail = $post['thumbnail_url'];
					$username = $post['username'];
					$caption = $post['caption'];
					$created = strtotime($post['timestamp']);
					$children = '';
					if ($mimeType === 'carousel_album') {
						$c = $ig -> getMediaChildren($postID);
						$children = json_encode($c['data']);
					}

					$insert = $db -> query(
						"INSERT INTO `igFeed`
												(`postID`,
												 `fileName`,
												 `guid`,
												 `permalink`,
												 `mimeType`,
												 `thumbnail`,
												 `children`,
												 `username`,
												 `caption`,
												 `created`,
												 `scraped`)
						VALUES      ('$postID',
												 '$fileName',
												 '$guid',
												 '$permalink',
												 '$mimeType',
												 '$thumbnail',
												 '$children',
												 '$username',
												 '$caption',
												 '$created',
												 Now());"
					);

					if (!$insert) {
						http_response_code(500);
						if ($db -> error) {
							printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
						} else {
							printf('Unknown Error, line 1010');
						}
						$db -> close();
						exit();
					}
				}
			}
		}
	}

	$i = 0;

	if (count($igArr) > 0) {
		$output .= '<h2>INSTAGRAM <span class="icon-instagramjpress"></span></h2>';
		$output .= '<p class="aligncenter"><a href="https://www.instagram.com/' . $igArr[0]['username'] . '" target="_blank" rel="nofollow noopener">@' . $igArr[0]['username'] . '</a></p>';
		$output .= '<div id="instafeed">';
		foreach ($igArr as $post) {
			$mType = strtolower($post[$i]['mimeType']);
			$mSRC = $mHref = $post[$i]['guid'];
			$mCaption = $post[$i]['caption'];
			$mLink = $post[$i]['permalink'];
			$mUser = $post[$i]['username'];
			$mTime = strtotime($post[$i]['created']);

			$mCarousel = '';

			if ($mType === 'video') {
				$mSRC = $post[$i]['thumbnail_url'];
			} elseif ($mType === 'carousel_album') {
				$mCarousel = ' data-carousel="';
				$it = 1;
				$length = count($mediaChildren['data']);
				foreach (json_decode($post[$i]['children']) as $child) {
					if ($it <> 1) {
						$mCarousel .= $child['media_url'];
						if ($it < $length) {
							$mCarousel .= ',';
						}
					}
					$it++;
				}
				$mCarousel .= '"';
			}

			$output .= '<a class="instalink instagram-' . $mType . ' fade-in" data-src="' . $mSRC . '" data-caption="' . $mCaption . '" data-username="' . $mUser . '" data-href="' . $mHref . '" data-timestamp="' . $mTime . '" data-background="' . $mSRC . ')" href="' . $mLink . '" target="_blank" rel="nofollow noopener"' . $mCarousel .'>';
			if ($mType === 'video') {
				$output .= '<span class="icon-film-camerajpress"></span>';
			} elseif ($mType === 'carousel_album') {
				$output .= '<span class="icon-imagesjpress"></span>';
			}
			// $output .= '<div class="hover-layer"><span class="likes-comments"><span class="likes">{{likes}}</span><span class="comments">{{comments}}</span></span></div>';
			$output .= '</a>';

			if (++$i == 9) {
				break;
			}
		}
		$output .= '</div>';
		$output .= '<script src="/plugins/instagram/js/lightbox.min.js?ver=' . $version . '" ' . (nonce() ? 'nonce="' . NONCE . '"' : '') . '></script>';
	}

	return $output;
}

function get_photoCredit() {
	global $db;
	global $featuredImageId;
	global $thereWasAnError_str;
	$featuredPhotoCredit = '';
	$select =
	"SELECT `photoCredit`
	FROM   `media`
	WHERE  `id` = '$featuredImageId'
	LIMIT  1;";
	$result = $db -> query($select);
	if ($result && $result -> num_rows > 0) {
		while ($row = $result -> fetch_assoc()) {
			$featuredPhotoCredit = $row['photoCredit'];
		}
	}
	if (!$select) {
		if ($db -> error) {
			http_response_code(500);
			printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
			$db -> close();
			exit();
		}
	}
	return $featuredPhotoCredit;
}

function filter_ptags_on_images($content) {
	return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

function filter_src($content) {
	return preg_replace('/(<iframe[^>]*)src=/', '$1src="about:blank" data-src=', preg_replace('/(<img[^>]*)src=/', '$1src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" data-src=', $content));
}

function getArticle($key, $slug, $lang = 'no') {
	if (!$key || !$slug) return false;

	$output = [];

	global $db;

	$select =
	"SELECT `title`,
				 `label`,
				 `id`,
				 `excerpt`,
				 `type`,
				 `body`,
				 `created`,
				 `featured-image`,
				 `featuredImageId`,
				 `displayImage`,
				 `image-position`,
				 `published`,
				 `displayInMenu`,
				 `updated`,
				 `translatedSlug`
	FROM   `articles`
	WHERE  `slug` = ?
				 AND `lang` = ?
	ORDER  BY `updated` DESC
	LIMIT  1;";
	if (!$select) {
		if ($db -> error) {
			echo $db -> errno . ' ' . $db -> error;
			http_response_code(500);
			$db -> close();
		} else {
			echo 'Unknown error';
		}
		exit();
	} else {

		$stmt = $db -> stmt_init();
		
		if (!$stmt -> prepare($select)) {
			echo 'Unknown error';
			$db -> close();
			exit();
		}

		$stmt -> bind_param('ss', $slug, $lang);
		$stmt -> execute();

		$result = $stmt -> get_result();

		$articleArray = [];
		if ($result && !!$result -> num_rows) {
			while ($row = $result -> fetch_assoc()) {
				$articleArray += $row;
			}
			$output = $articleArray[$key];
		}

		// var_dump($articleArray);

		return $output;
	}
}

function get_homeContent() {
	global $db;
	global $lang;
	global $thereWasAnError_str;
	$select =
	"SELECT `id`,
				 `sectionText`,
				 `class`,
				 `cssId`,
				 `backgroundImage`,
				 `backgroundSVG`,
				 `photoCredit`,
				 `arrayIndex`
	FROM   `home`
	WHERE  `lang` = '$lang'
	ORDER  BY `arrayIndex` ASC;";
	if (!$select) {
		if ($db -> error) {
			echo $thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error;
		} else {
			echo $thereWasAnError_str;
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		$callback = array();
		if ($result && $result -> num_rows > 0) {
			while ($row = $result -> fetch_assoc()) {
				$callback[] = $row;
			}
		}
		return $callback;
		// $db -> close();
		// exit();
	}
}

function getClient() {
	$client = new Google_Client();
	$client -> setApplicationName('Google Calendar API PHP Quickstart');
	$client -> setScopes(Google_Service_Calendar::CALENDAR_READONLY);
	$client -> setAuthConfig(APP_ROOT . '/plugins/calendar/credentials.json');
	$client -> setAccessType('offline');
	$client -> setPrompt('select_account consent');

	// Load previously authorized token from a file, if it exists.
	// The file token.json stores the user's access and refresh tokens, and is
	// created automatically when the authorization flow completes for the first
	// time.
	$tokenPath = APP_ROOT . '/plugins/calendar/token.json';
	if (file_exists($tokenPath)) {
		$accessToken = json_decode(file_get_contents($tokenPath), true);
		$client -> setAccessToken($accessToken);
	}

	// If there is no previous token or it's expired.
	if ($client -> isAccessTokenExpired()) {
		// Refresh the token if possible, else fetch a new one.
		if ($client -> getRefreshToken()) {
			$client -> fetchAccessTokenWithRefreshToken($client -> getRefreshToken());
		} else {
			// Request authorization from the user.
			$authUrl = $client -> createAuthUrl();
			printf("Open the following link in your browser:\n%s\n", $authUrl);
			print 'Enter verification code: ';
			$authCode = trim(fgets(STDIN));

			// Exchange authorization code for an access token.
			$accessToken = $client -> fetchAccessTokenWithAuthCode($authCode);
			$client -> setAccessToken($accessToken);

			// Check to see if there was an error.
			if (array_key_exists('error', $accessToken)) {
				throw new Exception(join(', ', $accessToken));
			}
		}
		// Save the token to a file.
		if (!file_exists(dirname($tokenPath))) {
			mkdir(dirname($tokenPath), 0700, true);
		}
		file_put_contents($tokenPath, json_encode($client -> getAccessToken()));
	}
	return $client;
}

function get_eventList() {
	require_once APP_ROOT . '/vendor/autoload.php';
	$client = new Google_Client();
	$client->setApplicationName("Client_Library_Examples");
	$client->setAuthConfig(APP_ROOT . '/plugins/calendar/credentials.json');

	// Get the API client and construct the service object.
	$client = getClient();
	$service = new Google_Service_Calendar($client);

	// $dateFormat = 'j. M';
	// $timeFormat = 'H:i';

	// Print the next 10 events on the user's calendar.
	$calendarId = 'primary';
	$optParams = array(
		'maxResults' => 10,
		'orderBy' => 'startTime',
		'singleEvents' => true,
		'timeMin' => date('c'),
		// 'timeZone' => 'Europe/Oslo'
	);
	$results = $service -> events -> listEvents($calendarId, $optParams);
	$events = $results -> getItems();
	$eventItems = '<ul class="events">' . "\r\n";
	if (empty($events)) {
		$eventItems .= '<li class="no-events">Vi har ingen planlagte konserter.</li>' . "\r\n";
	} else {
		foreach ($events as $event) {
			$start = new DateTime(($event -> start -> dateTime), new DateTimeZone('Europe/Oslo'));
			// $start = $event -> start -> dateTime;
			// $start -> setTimeZone('Europe/Oslo');
			$fmt = new \IntlDateFormatter('nb-NO', IntlDateFormatter::FULL, IntlDateFormatter::FULL, 'Europe/Oslo');
			$fmt -> setPattern('d. MMM');
			$outputDate = $fmt -> format($start);
			$outputTime = $start -> format('H:i');
			$eventColor = $event -> getColorId();

			preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $event -> getDescription(), $match);
			$link = $match[0][0];

			$ticketDiv = '';
			if (strpos($event -> getDescription(), 'http') !== false) {
				$ticketDiv = '<div class="tickets"><a class="theme-background" target="_blank" rel="noreferrer nofollow" href="' . $link . '">KJØP BILLETT</a>' . "\r\n";
				// $a = new SimpleXMLElement($event -> getDescription());
				// $link = $a['href'];
			}

			// $image = $event -> attachments[0] -> fileUrl;
			if (empty($start)) {
				$start = $event -> start -> date;
			}
			// $outputDate = date($dateFormat, strtotime($start));
			// $outputTime = date($timeFormat, strtotime($start));
			$eventItems .= '<li class="' . $eventColor . '">' . "\r\n";
			$eventItems .= '<div class="event-field time"><span class="date"><strong>' . strtoupper($outputDate) . '</strong></span><span class="hour"><small>kl. ' . $outputTime . '</small></span>' . "\r\n";
			$eventItems .= '</div>' . "\r\n";
			$eventItems .= '<div class="event-field description"><h3>' . $event -> getSummary() . '</h3><p>' . str_replace(', Norge', '', $event -> getLocation()) . '</p>' . "\r\n";
			$eventItems .= $ticketDiv;
			$eventItems .= '</div>' . "\r\n";
			$eventItems .= '</div>' . "\r\n";
			$eventItems .= '</li>' . "\r\n";
		}
	}
	$eventItems .= '</ul>';
	return $eventItems;
}

function get_menuEdit() {
	global $db;
	global $lang;
	global $privacy_str;
	global $thereWasAnError_str;
	$select =
	"SELECT `slug`,
				 `label`,
				 `published`,
				 `order`,
				 `id`
	FROM   `articles`
	WHERE  `lang` = '$lang'
	ORDER  BY `order` ASC;";
	if (!$select) {
		http_response_code(500);
		if ($db -> error) {
			echo $thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error;
		} else {
			echo $thereWasAnError_str;
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		if ($result && $result -> num_rows > 0) {
			$menuEdit = '<ul id="header-menu-edit">' . "\r\n";
			while ($row = $result -> fetch_assoc()) {
				if ($row['published'] !== '0' && $row['slug'] !== strtolower($privacy_str)) {
					$menuEdit .= '<li>' . "\r\n";
					$menuEdit .= '<input type="hidden" name="menu-order[]" class="menu-order" value="' . $row['order'] . '">' . "\r\n";
					$menuEdit .= '<input type="hidden" name="menu-item-id[]" class="menu-item" value="' . $row['id'] . '">' . "\r\n";
					$menuEdit .= '<div class="menu-item-handle white-background-hover" draggable="true">' . "\r\n";
					$menuEdit .= '<span class="item-title">' . $row['label'] . '</span>' . "\r\n";
					$menuEdit .= '</div>' . "\r\n";
					$menuEdit .= '</li>' . "\r\n";
				}
			}
			$menuEdit .= '</ul>' . "\r\n";
		}
		return $menuEdit;
		// $db -> close();
		// exit();
	}
}

function returnOutput($file) {
	ob_start();
	include $file;
	return ob_get_clean();
}

function get_users() {
	global $db;
	global $lang;
	global $thereWasAnError_str;
	$output = false;
	$select =
	"SELECT `username`,
				 `email`,
				 `role`,
				 `lastlogin`
	FROM   `users`
	ORDER  BY `created` ASC;";
	if (!$select) {
		http_response_code(500);
		if ($db -> error) {
			echo $thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error;
		} else {
			echo $thereWasAnError_str;
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		if ($result && $result -> num_rows > 0) {
			$usersList = '';
			while ($row = $result -> fetch_assoc()) {
				$username = $row['username'];
				$email = $row['email'];
				$role = $row['role'];
				if (($row['lastlogin']) > 0) {
					$lastLogin = $row['lastlogin'];
					$timeFormat = new \IntlDateFormatter($lang, IntlDateFormatter::FULL, IntlDateFormatter::FULL);
					if ($lang === 'no') {
						$timeFormat -> setPattern('d. MMM yyyy HH:mm');
					} else {
						$timeFormat -> setPattern('MMM d yyyy h:mm a');
					}
					$lastLoginFormat = $timeFormat -> format(strtotime($lastLogin));
				} else {
					$lastLogin = $lastLoginFormat = 'N/A';
				}
				$gravatarURL = 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($email)));
				$gravatarImage = '<img src="' . $gravatarURL . '" />';
				$loggedIn = '';
				if ($username === $_SESSION['username']) {
					$loggedIn = ' logged-in';
				}

				$usersList .= '<tr>' . "\r\n";
				$usersList .= '<td class="delete-user">' . "\r\n";
				if ($role !== 'admin' && $username !== $_SESSION['username']) {
				$usersList .= '<button type="submit" class="semi-link theme-background background-hover" name="' . $username . '"><span class="icon-deletejpress"></span></button>' . "\r\n";
				}
				$usersList .= '</td>' . "\r\n";
				$usersList .= '<td class="username' . $loggedIn . '">' . "\r\n";
				$usersList .= '<p><a href="mailto:' . $email . '">' . $gravatarImage . '</a>' . $username . '</p>' . "\r\n";
				$usersList .= '</td>' . "\r\n";
				$usersList .= '<td class="email">' . "\r\n";
				$usersList .= '<p><a href="mailto:'. $email . '">' . $email . '</a></p>' . "\r\n";
				$usersList .= '</td>' . "\r\n";
				$usersList .= '<td class="lastlogin hide-on-mobile">' . "\r\n";
				$usersList .= '<p>' . $lastLoginFormat . '</p>' . "\r\n";
				$usersList .= '</td>' . "\r\n";
				$usersList .= '</tr>' . "\r\n";
			}
		}
		$output = $usersList;
		// $db -> close();
		// exit();
	}
	return $output;
}

function cSHY($text) {
	$text = preg_replace("/'/", "\&#39;", str_replace('&shy;&shy;', '&shy;', $text));
	return $text;
}

function slugify($text) {
	$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
	return strtolower(preg_replace('/[^A-Za-z0-9-]+/', '-', $text));
}

function toAlpha($data) {
	$alphabet = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	$alpha_flip = array_flip($alphabet);

	if ($data <= 25) {
		return $alphabet[$data];
	} elseif ($data > 25) {
		$dividend = ($data + 1);
		$alpha = '';
		while ($dividend > 0) {
			$modulo = ($dividend - 1) % 26;
			$alpha = $alphabet[$modulo] . $alpha;
			$dividend = floor((($dividend - $modulo) / 26));
		}
		return $alpha;
	}
}

function get_timetable() {
	global $db;
	global $lang;
	global $thereWasAnError_str;
	$output = false;
	$select =
	"SELECT `sectionText`
	FROM    `home`
	WHERE   `cssId` = 'timetable'
	AND     `lang`  = '$lang'
	LIMIT   1;";

	if (!$select) {
		http_response_code(500);
		if ($db -> error) {
			echo $thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error;
		} else {
			echo $thereWasAnError_str;
		}
		$db -> close();
		exit();
	} else {
		$timeTable = '';
		$result = $db -> query($select);
		if ($result && $result -> num_rows > 0) {
			while ($row = $result -> fetch_assoc()) {
				$timeTable .= $row['sectionText'];
			}
		}
		$output = $timeTable;
	}
	return $output;
}

function bodyClass() {
	global $bodyClass;
	global $scrollMenuSwitch;
	global $customCursor;
	global $contestSwitch;
	$WebPServerSupport = 'no-webp-server-support';
	if (extension_loaded('imagick') && in_array('WEBP', \Imagick::queryformats()) || imagetypes() & IMG_WEBP) {
		$WebPServerSupport = 'webp-server-support';
	}
	$bodyClass .= ' module-open';
	$bodyClass .= ' ' . $WebPServerSupport;
	if (isLoggedIn()) {
		$bodyClass .= ' logged-in';
	}
	if (isset($scrollMenuSwitch) && $scrollMenuSwitch === 'checked') {
		$bodyClass .= ' scroll-menu';
	}
	if (isset($customCursor) && $customCursor === 'checked') {
		$bodyClass .= ' custom-cursor';
	}
	if (isset($contestSwitch) && $contestSwitch === 'checked') {
		$bodyClass .= ' contest';
	}

	return $bodyClass;
}

function get_contactInfo() {
	global $db;
	global $thereWasAnError_str;
	$output = false;
	$select =
	"SELECT `mainEmail`,
					`telephone`
	FROM    `siteInfo`
	LIMIT   1;";

	if (!$select) {
		http_response_code(500);
		if ($db -> error) {
			echo $thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error;
		} else {
			echo $thereWasAnError_str;
		}
		$db -> close();
		exit();
	} else {
		$result = $db -> query($select);
		if ($result && $result -> num_rows > 0) {
			while ($row = $result -> fetch_assoc()) {
				if (!empty($row['telephone']) && !empty($row['mainEmail'])) {
					$output = '<span class="icon-phonejpress"></span> <a href="tel:' . str_replace('+', '00', str_replace(' ', '', $row['telephone'])) . '">' . str_replace(' ', '&nbsp;', $row['telephone']) . '</a><br>';
					$output .= '<span class="icon-mail4jpress"></span> <a href="mailto:' . $row['mainEmail'] . '" target="_blank" rel="noopener">' . $row['mainEmail'] . '</a>';
				} else {
					if (!empty($row['telephone'])) {
						$output = '<span class="icon-phonejpress"></span> <a href="tel:' . str_replace('+', '00', str_replace(' ', '', $row['telephone'])) . '" target="_blank" rel="noopener">' . $row['telephone'] . '</a>';
					} elseif (!empty($row['mainEmail'])) {
						$output = '<span class="icon-mail4jpress"></span> <a href="mailto:' . $row['mainEmail'] . '" target="_blank" rel="noopener">' . $row['mainEmail'] . '</a>';
					}
				}
			}
		}
	}
	return $output;
}

function get_googleMaps() {
	global $version;
	global $googleAPIkey;
	global $lang;
	$map = '<div id="map"></div>' . "\r\n";
	$map .= '<script src="/plugins/googlemaps/googlemaps-json.js?ver=' . $version . '" ' . (nonce() ? 'nonce="' . NONCE . '"' : '') . '></script>' . "\r\n";
	$map .= '<script src="/plugins/googlemaps/js/init-googlemaps.min.js?ver=' . $version . '" ' . (nonce() ? 'nonce="' . NONCE . '"' : '') . '></script>' . "\r\n";
	$map .= '<script async defer src="https://maps.googleapis.com/maps/api/js?key=' . $googleAPIkey . '&language=' . $lang . '&region=' . strtoupper($lang) . '&callback=initMap" ' . (nonce() ? 'nonce="' . NONCE . '"' : '') . '></script>' . "\r\n";
	return $map;
}

function get_fbEvents() {
	global $fbPageID;
	global $fbAppSecret;
	global $fbAppID;



	$tokenPath = APP_ROOT . '/plugins/facebook/token.json';
	if (file_exists($tokenPath)) {
		$accessTokenArray = json_decode(file_get_contents($tokenPath), true);
		$accessToken = $accessTokenArray['access_token'];
	}

	require_once APP_ROOT . '/plugins/facebook/vendor/autoload.php';

	$fb = new \Facebook\Facebook([
		'app_id' => $fbAppID,
		'app_secret' => $fbAppSecret,
		'default_graph_version' => 'v7.0',
		'default_access_token' => $accessToken
	]);

	try {
		// Get the \Facebook\GraphNodes\GraphUser object for the current user.
		// If you provided a 'default_access_token', the '{access-token}' is optional.
		$response = $fb -> get('/me');
	} catch(\Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e -> getMessage();
		exit;
	} catch(\Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e -> getMessage();
		exit;
	}

	$me = $response -> getGraphUser();
	return 'Logged in as ' . $me -> getName();

	// $request = new \Facebook\FacebookRequest(
	//   $session,
	//   'GET',
	//   '/' . $fbPageID . '/events'
	// );
	//
	// $response = $request -> execute();
	// $graphObject = $response -> getGraphObject();
	// return $graphObject;
}

function get_fbLogin() {
	global $fbAppID;
	global $lang;
	// if ($)
	return '<div id="fb-root"></div><script ' . (nonce() ? 'nonce="' . NONCE . '"' : '') . ' async defer crossorigin="anonymous" src="https://connect.facebook.net/' . $lang . '/sdk.js#xfbml=1&version=v7.0&appId=' . $fbAppID . '&autoLogAppEvents=1"></script><div class="fb-login-button" data-size="large" data-button-type="continue_with" data-layout="rounded" data-auto-logout-link="false" data-use-continue-as="true" data-width=""></div>'; //nonce="vBODvoVG"
}

function themeColors() {
	global $fontColor;
	global $gfSwitch;
	global $tkSwitch;
	global $fontFace;
	global $fontHeading;
	global $tkFontFamily;
	global $nativeFont;
	global $tkFontFamilyHeader;

	global $themeColor;
	global $contrastColor;
	global $secondaryColor;
	global $whiteColor;

	global $featuredImage;

	$css = 'body {';
	if ($gfSwitch === 'checked' && !empty($fontFace) && !empty($fontBody)) {
		$css .= 'font-family: ' . $fontBody . ';';
	} else if ($tkSwitch === 'checked' && !empty($tkFontFamily)) {
		$css .= 'font-family: ' . $tkFontFamily . ';';
	} else {
		if ($nativeFont === 'serif') {
			$css .=
			'font-family: Garamond, Georgia, Times, "Times New Roman";
			font-weight: normal;' . "\r\n";
		} else {
			$css .=
			'font-family: "Helvetica Neue", Helvetica, sans-serif;
			font-weight: normal;' . "\r\n";
		}
	}
	$css .= '}' . "\r\n";

	if ($gfSwitch === 'checked' && !empty($fontFace) && !empty($fontHeading)) {
		$css .=
		'h1,h2,h3,h4,h5,h6{font-family:' . $fontHeading . ';}' . "\r\n";
	} elseif ($tkSwitch === 'checked' && !empty($tkFontFamilyHeader)) {
		$css .=
		'h1,h2,h3,h4,h5,h6{font-family:' . $tkFontFamilyHeader . ';}' . "\r\n";
	}

	$css .=
	':root{--theme-color:' . $themeColor . ';--secondary-color:' . $secondaryColor . ';--contrast-color:' . $contrastColor . ';--white-color:' . $whiteColor . ';}

	html.blend,.parallax-background-css.translucent::before{background-color:' . $themeColor . ';}

	.theme-background *::-moz-selection, .theme-background > *::-moz-selection{background-color:' . $contrastColor . ';}
	.theme-background *::selection,.theme-background > *::selection{background-color:' . $contrastColor . ';}
	.white-background *::-moz-selection,.white-background > *::-moz-selection,.secondary-background *::-moz-selection,.secondary-background > *::-moz-selection{background-color:' . $themeColor . ';}
	.white-background *::selection,.white-background > *::selection,.secondary-background *::selection,.secondary-background > *::selection{background-color:' . $themeColor . ';}
	aside *::-moz-selection,aside::-moz-selection{background-color:' . $contrastColor . '!important;}
	aside *::selection,aside::selection{background-color:' . $contrastColor . '!important;}

	.theme-gradient{background-image:linear-gradient(to bottom,rgba(' . hex2RGB($themeColor, true) . ',0)0%,' . $themeColor . ' 50%);}

	.theme-background,.theme-background-before::before,.theme-background-after::after,#featured-image-container:hover #edit-featured-image-button{background-color:' . $themeColor . ';}
	.theme-background,.theme-background a:hover,.theme-background > *,.theme-background > a:hover{color:#' . $fontColor['themeBackground']['body'] . ';}
	.theme-background .radio-list input[type="radio"]:checked ~ .check::before,.theme-background > .edit-section-button .radio-list input[type="radio"]:checked ~ .check::before{background-color:#' . $fontColor['themeBackground']['body'] . ';}
	.theme-background *{border-color:#' . $fontColor['themeBackground']['body'] . ';}
	.theme-background *{outline-color:#' . $fontColor['themeBackground']['body'] . ';}
	.theme-background *:-webkit-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['themeBackground']['headline'] . ';}
	.theme-background *:-moz-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['themeBackground']['headline'] . ';}
	.theme-background *:matches(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['themeBackground']['headline'] . ';}
	.theme-background *:is(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['themeBackground']['headline'] . ';}
	.theme-background > *:-webkit-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['themeBackground']['headline'] . '!important;}
	.theme-background > *:-moz-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['themeBackground']['headline'] . '!important;}
	.theme-background > *:matches(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['themeBackground']['headline'] . '!important;}
	.theme-background > *:is(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['themeBackground']['headline'] . '!important;}
	.theme-background *:-webkit-any(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['themeBackground']['headline'] . ';}
	.theme-background *:-moz-any(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['themeBackground']['headline'] . ';}
	.theme-background *:matches(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['themeBackground']['headline'] . ';}
	.theme-background *:is(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['themeBackground']['headline'] . ';}
	.theme-background blockquote::before{color:#' . $fontColor['themeBackground']['headline'] . ';}
	.theme-background .edit-section path,.theme-background.edit-section svg path{fill:#' . $fontColor['themeBackground']['body'] . ';}
	.theme-background a:not(.secondary-background):not(.white-background),.theme-background > a:not(.secondary-background):not(.white-background),a.theme-background,#header-menu a{color:#' . $fontColor['themeBackground']['link'] . ';}
	.theme-background .link-color-path{fill:#' . $fontColor['themeBackground']['link'] . ';}
	.theme-background hr{background-color:#' . $fontColor['themeBackground']['headline'] . ';}
	.theme-background figure.image{background-color:' . $secondaryColor . ';}
	.theme-background figure.image figcaption,.theme-background figure.image figcaption a{color:#' . $fontColor['secondaryBackground']['body'] . '!important;}
	.theme-background.translucent{background-color:rgba(' . hex2RGB($themeColor, true) . ', .7);}
	.theme-background aside{background-color:' . $secondaryColor . ';}

	.theme-color-path{fill:' . $themeColor . '!important;}
	.theme-color,#settings-main-menu li.current a, #settings-main-menu li:hover a{color:' . $themeColor . ';}

	.white-gradient{background-image:linear-gradient(to bottom,rgba(' . hex2RGB($whiteColor, true) . ',0)0%,' . $whiteColor . ' 50%);}

	.white-background,.white-background-before::before,.white-background-after::after,.white-background-hover:hover{background-color:' . $whiteColor . ';}
	.white-background,.white-background a:hover,.white-background > *,.white-background > a:hover,.contrast-background{color:#' . $fontColor['whiteBackground']['body'] . ';}
	.white-background .radio-list input[type="radio"]:checked ~ .check::before,.white-background > .edit-section-button .radio-list input[type="radio"]:checked ~ .check::before{background-color:#' . $fontColor['whiteBackground']['body'] . ';}
	.white-background *{border-color:#' . $fontColor['whiteBackground']['body'] . ';}
	.white-background *{outline-color:#' . $fontColor['whiteBackground']['body'] . ';}
	.white-background *:-webkit-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['whiteBackground']['headline'] . ';}
	.white-background *:-moz-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['whiteBackground']['headline'] . ';}
	.white-background *:matches(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['whiteBackground']['headline'] . ';}
	.white-background *:is(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['whiteBackground']['headline'] . ';}
	.white-background > *:-webkit-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['whiteBackground']['headline'] . '!important;}
	.white-background > *:-moz-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['whiteBackground']['headline'] . '!important;}
	.white-background > *:matches(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['whiteBackground']['headline'] . '!important;}
	.white-background > *:is(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['whiteBackground']['headline'] . '!important;}
	.white-background *:-webkit-any(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['whiteBackground']['headline'] . ';}
	.white-background *:-moz-any(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['whiteBackground']['headline'] . ';}
	.white-background *:matches(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['whiteBackground']['headline'] . ';}
	.white-background *:is(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['whiteBackground']['headline'] . ';}
	.white-background blockquote::before{color:#' . $fontColor['whiteBackground']['headline'] . ';}
	.white-background .edit-section path,.white-background.edit-section svg path{fill:#' . $fontColor['whiteBackground']['body'] . ';}
	.white-background a:not(.theme-background):not(.secondary-background),.white-background > a:not(.theme-background):not(.secondary-background),a.white-background{color:#' . $fontColor['whiteBackground']['link'] . ';}
	.white-background .link-color-path{fill:#' . $fontColor['whiteBackground']['link'] . ';}
	.white-background hr{background-color:#' . $fontColor['whiteBackground']['headline'] . ';}
	.white-background figure.image{background-color:' . $themeColor . ';}
	.white-background figure.image figcaption,.white-background figure.image figcaption a,.white-background aside,.secondary-background aside{color:#' . $fontColor['themeBackground']['body'] . '!important;}
	.white-background.translucent{background-color:rgba(' . hex2RGB($whiteColor, true) . ', .7);}
	.white-background aside,.secondary-background aside{background-color:' . $themeColor . ';}

	.white-color-path{fill:' . $whiteColor . '!important;}
	.white-color{color:' . $whiteColor . ';}

	.secondary-gradient{background-image:linear-gradient(to bottom,rgba(' . hex2RGB($secondaryColor, true) . ',0)0%,' . $secondaryColor . ' 50%);}

	.secondary-background,.secondary-background-before::before,.secondary-background-after::after,.secondary-background-hover:hover{background-color:' . $secondaryColor . ';}
	.secondary-background,.secondary-background a:hover,.secondary-background > *,.secondary-background > a:hover,.theme-background aside{color:#' . $fontColor['secondaryBackground']['body'] . ';}
	.secondary-background .radio-list input[type="radio"]:checked ~ .check::before,.secondary-background > .edit-section-button .radio-list input[type="radio"]:checked ~ .check::before{background-color:#' . $fontColor['secondaryBackground']['body'] . ';}
	.secondary-background *{border-color:#' . $fontColor['secondaryBackground']['body'] . ';}
	.secondary-background *{outline-color:#' . $fontColor['secondaryBackground']['body'] . ';}
	.secondary-background *:-webkit-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['secondaryBackground']['headline'] . ';}
	.secondary-background *:-moz-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['secondaryBackground']['headline'] . ';}
	.secondary-background *:matches(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['secondaryBackground']['headline'] . ';}
	.secondary-background *:is(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['secondaryBackground']['headline'] . ';}
	.secondary-background > *:-webkit-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['secondaryBackground']['headline'] . '!important;}
	.secondary-background > *:-moz-any(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['secondaryBackground']['headline'] . '!important;}
	.secondary-background > *:matches(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['secondaryBackground']['headline'] . '!important;}
	.secondary-background > *:is(h1,h2,h3,h4,h5,h6){color:#' . $fontColor['secondaryBackground']['headline'] . '!important;}
	.secondary-background *:-webkit-any(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['secondaryBackground']['headline'] . ';}
	.secondary-background *:-moz-any(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['secondaryBackground']['headline'] . ';}
	.secondary-background *:matches(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['secondaryBackground']['headline'] . ';}
	.secondary-background *:is(h1,h2,h3,h4,h5,h6) path:not(.contrast-color-path){fill:#' . $fontColor['secondaryBackground']['headline'] . ';}
	.secondary-background blockquote::before{color:#' . $fontColor['secondaryBackground']['headline'] . ';}
	.secondary-background .edit-section path,.secondary-background.edit-section svg path{fill:#' . $fontColor['secondaryBackground']['body'] . ';}
	.secondary-background a:not(.theme-background):not(.white-background),.secondary-background > a:not(.theme-background):not(.white-background),a.secondary-background{color:#' . $fontColor['secondaryBackground']['link'] . ';}
	.secondary-background .link-color-path{fill:#' . $fontColor['secondaryBackground']['link'] . ';}
	.secondary-background hr{background-color:#' . $fontColor['secondaryBackground']['headline'] . ';}
	.secondary-background figure.image{background-color:' . $themeColor  . ';}
	.secondary-background figure.image figcaption,.secondary-background figure.image figcaption a{color:#' . $fontColor['themeBackground']['body'] . '!important;}
	.secondary-background.translucent{background-color:rgba(' . hex2RGB($secondaryColor, true) . ', .7);}

	.secondary-color-path{fill:' . $secondaryColor . '!important;}
	.secondary-color{color:' . $secondaryColor . ';}

	.contrast-background,.contrast-background-before::before,.contrast-background-after::after,.background-hover:hover,input:checked + .theme-background,input:checked + .secondary-background{background-color:' . $contrastColor . ';}
	.background-hover:hover{color:#' . $fontColor['themeBackground']['body'] . ';}
	.contrast-background a:not(.theme-background):not(.secondary-background):not(.white-background),.contrast-background > *{color:#' . $fontColor['themeBackground']['body'] . ';}
	.contrast-color-path{fill:' . $contrastColor . ';}
	.contrast-color{color:' . $contrastColor . ';}

	.black-background{color:' . $whiteColor . ';}

	@media only screen and (max-width: 767px) {
		#header-menu{background-color:rgba(' . hex2RGB($themeColor, true) . ', .7);}
		.background-hover{background-color:' . $contrastColor . ';}
		.white-background.background-hover{color:#' . $fontColor['themeBackground']['body'] . ';}
	}' . "\r\n";

	if ($gfSwitch === 'checked') {
		$css .= $fontFace;
	}

	if (!empty($featuredImage)) {
		$css .=
		'.notfound.no-webp-support::before,.login.no-webp-support::before,.admin.no-webp-support::before{background-image:url(' . $featuredImage . ');}
		.notfound.webp-support::before,.login.webp-support::before,admin.webp-support::before{background-image:url(\'/uploads/' . replace_extension($featuredImage, 'webp') . '\');}' . "\r\n";
	} else {
		$css .=
		'.notfound.no-webp-support::before,.login.no-webp-support::before,.admin-no-webp-support::before{background-image:url(\'/assets/img/sunrise.jpg\');}
		.notfound.webp-support::before,.login.webp-support::before,.admin-webp-support::before{background-image:url(\'/assets/img/sunrise.webp\');}' . "\r\n";
	}

	return $css;
}

//Contest plugin
if (getOption('contestSwitch') === 'checked') {
	include APP_ROOT . '/plugins/contest/functions.php';
}

function do_shortcodes($content) {
	global $legalName;
	global $mainEmail;

	global $fbConnectSwitch;
	global $customShortcodeSwitch;
	global $customShortcodeFunction;
	global $gmSwitch;
	global $contestSwitch;
	global $gCalSwitch;

	//Google Calendar
	$calendarShortcode = array();
	if ($gCalSwitch === 'checked') {
		$calendarShortcode = array('string' => array('<p>[calendar]</p>', '<p class="alignleft">[calendar]</p>', '<p class="alignright">[calendar]</p>', '<p class="aligncenter">[calendar]</p>', '<p class="alignjustify">[calendar]</p>'), 'function' => get_eventList());
	}

	//FB plugin
	$instafeedShortcode = array();
	$fbEventShortcode = array();
	$fbLoginShortcode = array();
	if ($fbConnectSwitch === 'checked') {
		$instafeedShortcode = array('string' => array('<p>[instagram-feed]</p>', '<p class="alignleft">[instagram-feed]</p>', '<p class="alignright">[instagram-feed]</p>', '<p class="aligncenter">[instagram-feed]</p>', '<p class="alignjustify">[instagram-feed]</p>'), 'function' => get_igFeed());
		// $fbEventShortcode = array('string' => array('<p>[facebook-events]</p>', '<p class="alignleft">[facebook-events]</p>', '<p class="alignright">[facebook-events]</p>', '<p class="aligncenter">[facebook-events]</p>', '<p class="alignjustify">[facebook-events]</p>'), 'function' => get_fbEvents());
		// $fbLoginShortcode = array('string' => array('<p>[facebook-login]</p>', '<p class="alignleft">[facebook-login]</p>', '<p class="alignright">[facebook-login]</p>', '<p class="aligncenter">[facebook-login]</p>', '<p class="alignjustify">[facebook-login]</p>'), 'function' => get_fbLogin());
	}

	//Contest plugin
	$contestShortcode = array();
	if ($contestSwitch === 'checked') {
		$contestShortcode = array('string' => array('<p>[contest]</p>', '<p class="alignleft">[contest]</p>', '<p class="alignright">[contest]</p>', '<p class="aligncenter">[contest]</p>', '<p class="alignjustify">[contest]</p>'), 'function' => get_contest());
	}

	$shortcodesArray = array(
		$gmShortcode = array('string' => array('<p>[map]</p>', '<p class="alignleft">[map]</p>', '<p class="alignright">[map]</p>', '<p class="aligncenter">[map]</p>', '<p class="alignjustify">[map]</p>'), 'function' => get_googleMaps()),
		$calendarShortcode,
		$cfShortcode = array('string' => array('<p>[contact-form]</p>', '<p class="alignleft">[contact-form]</p>', '<p class="alignright">[contact-form]</p>', '<p class="aligncenter">[contact-form]</p>', '<p class="alignjustify">[contact-form]</p>'), 'function' => get_contactForm()),
		$instafeedShortcode,
		$fbEventShortcode,
		$fbLoginShortcode,
		$someShortcode = array('string' => array('<p>[some-share]</p>', '<p class="alignleft">[some-share]</p>', '<p class="alignright">[some-share]</p>', '<p class="aligncenter">[some-share]</p>', '<p class="alignjustify">[some-share]</p>'), 'function' => get_someShare()),
		$contestShortcode,
		$ttShortcode = array('string' => array('<p>[timetable]</p>', '<p class="alignleft">[timetable]</p>', '<p class="alignright">[timetable]</p>', '<p class="aligncenter">[timetable]</p>', '<p class="alignjustify">[timetable]</p>'), 'function' => get_timetable()),
		$customShortcode = array('string' => array('<p>[custom-shortcode]</p>', '<p class="alignleft">[custom-shortcode]</p>', '<p class="alignright">[custom-shortcode]</p>', '<p class="aligncenter">[custom-shortcode]</p>', '<p class="alignjustify">[custom-shortcode]</p>'), 'function' => $customShortcodeFunction),
		$contactInfoShortcode = array('string' => array('[contact-info]'), 'function' => get_contactInfo()),
		$legalNameShortcode = array('string' => array('[legal-name]'), 'function' => $legalName),
		$homeUrlShortcode = array('string' => array('[home-url]'), 'function' => BASE_URL),
		$mainEmailShortcode = array('string' => array('[main-email]'), 'function' => $mainEmail),
		$cf2Shortcode = array('string' => array('<p>[contact-form-2]</p>', '<p class="alignleft">[contact-form-2]</p>', '<p class="alignright">[contact-form-2]</p>', '<p class="aligncenter">[contact-form-2]</p>', '<p class="alignjustify">[contact-form-2]</p>'), 'function' => get_contactForm2()),
	);

	foreach ($shortcodesArray as $shortcode) {
		if (array_key_exists('string', $shortcode) && strposa($content, $shortcode['string'])) {
			if ($shortcode['string'][0] === '<p>[custom-shortcode]</p>' && $customShortcodeSwitch !== 'checked') {
				$content = str_replace($shortcode['string'], '', $content);
			}
			if ($shortcode['string'][0] === '<p>[map]</p>' && $gmSwitch !== 'checked') {
				$content = str_replace($shortcode['string'], '', $content);
			}
			if ($shortcode['string'][0] === '<p>[contest]</p>' && $contestSwitch !== 'checked') {
				$content = str_replace($shortcode['string'], '', $content);
			}
			if ($shortcode['string'][0] === '<p>[calendar]</p>' && $gCalSwitch !== 'checked') {
				$content = str_replace($shortcode['string'], '', $content);
			}
			$content = str_replace($shortcode['string'], $shortcode['function'], $content);
		}
	}
	return $content;
}

function filterContent($content) {
	$content = filter_ptags_on_images($content);
	$content = filter_src($content);
	$content = do_shortcodes($content);
	return $content;
}
