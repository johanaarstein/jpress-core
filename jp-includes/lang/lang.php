<?php

if (!isset($lang) || empty($lang)) {
	require_once APP_ROOT . '/jp-includes/app/functions.php';
	$lang = get_siteInfo()[0]['lang'];
}

$translatedSlug = $_SERVER['REQUEST_URI'];

if ($lang == 'no') {

	if ($translatedSlug == '/no/om-oss/') {
		$translatedSlug = '/about-us/';
	} elseif ($translatedSlug == '/no/kontakt/') {
		$translatedSlug = '/contact/';
	} elseif ($translatedSlug == '/no/personvern/') {
		$translatedSlug = '/privacy/';
	} elseif ($translatedSlug == '/no/ruteinformasjon/') {
		$translatedSlug = '/route-info/';
	} elseif ($translatedSlug == '/no/') {
		$translatedSlug = '/';
	}

	$strArray = array(

		$title_str = 'Tittel',
		$shortDescription_str = 'Kort beskrivelse av innholdet i artikkelen',

		$home_str = 'Hjem',

		$clickToLogout_str = 'Logg ut',
		$hello_str = 'Hei',

	  $settings_str = 'Innstillinger',
	  $media_str = 'Media',
	  $users_str = 'Brukere',

		$seoSettings_str = 'SEO',
		$layoutSettings_str = 'Layout',
		$languageSettings_str = 'Språk',
		$someSettings_str = 'Sosiale media',
		$navSettings_str = 'Navigasjon',
		$apiKey_str = 'API-nøkler',
		$emailSettings_str = 'E-post',

		$seoAbr_str = 'SEO',
		$layoutAbr_str = 'LYT',
		$langAbr_str = 'Språk',
		$someAbr_str = 'So-Me',
		$navAbr_str = 'Nav',

		$contactForm_str = 'Kontaktskjema',
		$contactInfo_str = 'E-postadresse',
		$contactInfoEx_str = 'for kontaktskjema, etc',
		$phoneNumber_str = 'Telefonnummer',

		$emptyName_str = 'Du må skrive inn et navn',
		$emptyEmail_str = 'Du må skrive inn e-postadresse',
		$invalidEmail_str = 'Du må skrive en gyldig e-postadresse',
		$emptyMessage_str = 'Husk å skrive en melding',
		$reCAPTCHAError_str = 'Du bestod ikke reCAPTCHA-testen. Vennligst prøv igjen.',
		$missingAdminMail_str = 'Til admin: mangler e-postadresse!',
		$emailSuccess_str = '<strong>Tusen takk!</strong><br>Vi høres om ikke lenge.',

	  $frontPage_str = 'Forside',
		$articles_str = 'Artikler',
	  $draft_str = 'kladd',
	  $newPage_str = 'Ny side',
	  $siteName_str = 'Navn på nettsida',
		$legalName_str = 'Navn på selskap/rettighetshaver',
	  $siteDescription_str = 'Beskrivelse av nettsida',
	  $metaTags_str = 'Metatagger',
		$addCodeHead_str = 'Legg til kode i &lt;head&gt;',
		$addCodeBody_str = 'Legg til kode i toppen av &lt;body&gt;',
		$addCodeFooter_str = 'Legg til kode i bunnen av &lt;body&gt;',
		$addCustomShortcode_str = 'Legg til egen shortcode <small>[custom-shortcode]</small>',
	  $divideByComma_str = 'skill med komma',
	  $lang_str = 'Språk',
	  $norwegian_str = 'Norsk',
	  $english_str = 'Engelsk (internasjonalt)',
		$altLang_str = 'Multispråklig side',
		$altSiteDescription_str = 'Beskrivelse av nettsida på alternativt språk',
		$chooseAltLanguage_str = 'Velg alternativt språk',
		$altLangOne_str = 'Alternativt språk',
		$robots_str = 'Be søkemotorer om ikke å indeksere nettstedet',
		$forDevelopment_str = 'Til bruk under utvikling',
		$logo_str = 'Logo',
		$featuredImage_str = 'Fremhevet bilde',
		$chooseFeaturedImage_str = 'Velg fremhevet bilde',
		$chooseImage_str = 'Velg bilde',
		$editImage_str = 'Rediger bilde',
		$edit_str = 'Rediger',
		$shortTitle_str = 'Kort tittel',
		$reposition_str = 'Posisjonér',
		$chooseFooterLink_str = 'Velg om link skal vises i footermenyen',
		$mainMenu_str = 'Hovedmeny',

		$plugins_str = 'Utvidelser',

		$editSection_str = 'Valg for seksjon',
		$editBackground_str = 'Endre bakgrunn',
		$chooseBackgroundImage_str = 'Bakgrunnsbilde',
		$black_str = 'Sort',
		$darkBg_str = 'Mørk bakgrunn',
		$lightBg_str = 'Lys bakgrunn',
		$bgImage_str = 'Bakgrunnsbilde',
		$deleteSection_str = 'Slett seksjon',

		$showShareIcons_str = 'Vis delingsikoner på artikler',

		$themeColor_str = 'Temafarge',
		$secondaryColor_str = 'Sekundær temafarge',
		$contrastColor_str = 'Kontrastfarge',
		$whiteColor_str = 'Lys farge',
		$translucence_str = 'Gjennomsiktighet',

		$typography_str = 'Typografi',
		$useGoogleFonts_str = 'Bruk Google Fonts',
		$googleAPIkey_str = 'Google API nøkkel',
		$useSendGrid_str = 'Bruk SendGrid',
		$useTypekit_str = 'Bruk Typekit',
		$tkStylesheet_str = 'Kode for å bygge inn stilark',
		$tkStylesheetExample_str = '&lt;link rel=&quot;stylesheet&quot; href=&quot;https://use.typekit.net/ditt-stilark.css&quot;&gt;',
		$example_str = 'Eksempel',
		$fontFamily_str = 'Fontfamilie',
		$fontFamilyHeader_str = 'Fontfamilie overskrift: <small>(Hvis annerledes enn hovedfont)</small>',
		$heading_str = 'Overskrift',
		$chosenImage_str = 'Valgt bilde',
		$useGoogleMaps_str = 'Bruk Google Maps',
		$scrollMenu_str = 'Scrollmeny',
		$useScrollMenu_str = 'Bruk scrollmeny',
		$showMailHeader_str = 'Vis e-post i header',
		$showPhoneHeader_str = 'Vis telefon i header',
		$copyLink_str = 'Kopier lenke',
		$copied_str = 'Kopiert',
		$photoCredit_str = 'Fotograf/byrå',
		$useCaption_str = 'Tekst',
		$saveChanges_str = 'Lagre endringer',

		$mediaLibrary_str = 'Mediebibliotek',
		$uploadImage_str = 'Last opp bilde/video',
		$upload_str = 'Last opp',
		$altText_str = 'Alternativ tekst',
		$imageDetails_str = 'Metadata',
		$fileName_str = 'Filnavn',
		$fileSize_str = 'Filstørrelse',
		$deleteFile_str = 'Slett fil',
		$permaLink_str = 'Permalenke',
		$filesSelected_str = 'filer valgt',

		$login_str = 'Logg inn',
		$forgottenPwd_str = 'Glemt passord',
		$password_str = 'Passord',
		$changePassword_str = 'Endre passord',
		$passowrdUpdated_str = 'Passord er oppdatert',
		$writeEmail_str = 'Vennligst skriv inn en e-postadresse.',
		$noUsers_str = 'Ingen brukere med denne e-post&shy;adressen. Skrev du riktig?',
		$awaitInstructions_str = 'Du vil få en e-post med instruksjoner for å endre passordet ditt.',
		$checkYourInbox = 'Sjekk innboksen din!',

		$userAdded_str = 'Ny bruker lagt til',
		$deleteUser_str = 'Slett Bruker',
		$userName_str = 'Brukernavn',
		$userOrEmail_str = 'Brukernavn eller e-postadresse',
		$email_str = 'E-post',
		$lastLogin_str = 'Sist logget inn',
		$addUser_str = 'Legg til ny bruker',
		$newUser_str = 'Ny bruker',
		$newUserName_str = 'Nytt brukernavn',
		$newPassword_str = 'Nytt passord',
		$newPasswordConfirm_str = 'Bekreft nytt passord',
		$add_str = 'Legg til',
		$mapError_str = 'Kartet kunne ikke lastes inn.',
		$regards_str = 'Hilsen',
		$newMessageFrom_str = 'Ny melding fra',
		$yourLoginUrl_str = 'URL\'en for innlogging er',
		$yourUserName_str = 'Brukernavnet ditt er',
		$yourPassword_str = 'Passordet ditt er',
		$toSetNewPwd_str = 'For å sette nytt passord, gå til følgende adresse',

		$savedAsDraft_str = 'Artikkelen er lagret som kladd.',
		$publish_str = 'Publiser',
		$published_str = 'Offentlig',
		$displayInMenu_str = 'Vis i meny',
		$hideFromMenu_str = 'Skjul fra meny',
		$depublish_str = 'Avpubliser',
		$share_str = 'Del',
		$on_str = 'på',

		$inactive_str = 'Du har vært inaktiv for lenge. ',
		$clickHere_str = 'Klikk her for å logge deg inn igjen',

		$contact_str = 'Kontakt',
		$name_str = 'Navn',
		$message_str = 'Melding',
		$send_str = 'Send',

		$privacy_str = 'Personvern',
		$privacyLink_str = 'Personvern',
		$lastEdited_str = 'Sist redigert',
		$cookieSettings_str = 'Cookie&shy;innstillinger',
		$recaptchaContact_str = '<span class="icon-recaptchajpress"></span> Dette kontakt&shy;skjemaet er beskyttet av reCAPTCHA, underlagt Googles <a class="recaptcha-link" href="https://policies.google.com/privacy" target="_blank">personvern&shy;regler</a> og <a class="recaptcha-link" href="https://policies.google.com/terms" target="_blank">vilkår</a>.',
		$recaptchaLogin_str = '<span class="icon-recaptchajpress"></span> Dette innloggings&shy;skjemaet er beskyttet av reCAPTCHA, underlagt Googles <a class="recaptcha-link" href="https://policies.google.com/privacy" target="_blank">personvern&shy;regler</a> og <a class="recaptcha-link" href="https://policies.google.com/terms" target="_blank">vilkår</a>.',

		$gfmReminder_str = 'Husk at alle endringer må gjøres på hvert språk.',
		$waypts_str = 'Stoppesteder',
		$labelWaypt_str = 'Navn',
		$descWaypt_str = 'Beskrivelse',
		$latitude_str = 'Breddegrad',
		$longitude_str = 'Lengdegrad',
		$imageWaypt_str = 'Bilde',

		$cancel_str = 'Avbryt',
		$tryAgain_str = 'Prøv på nytt!',
		$didntWritePassword_str = 'Du skrev ikke inn passord.',
		$pwdNoMatch_str = 'Passordene du skrev inn stemte ikke overens.',
		$cantVerifyRequest_str = 'Vi klarte ikke å verifisiere forespørselen din.',
		$setNewPwd_str = 'Sett nytt passord',
		$shortPwd_str = 'Passordet må ha minst 6 tegn',
		$pwdRequest_str = 'Vi fikk en forespørsel om å sette nytt passord for kontoen din på ' . BASE_URL . '. Dersom det ikke var du som ba om dette, kan du bare ignorere denne e-posten. For å sette nytt passord, gå til følgende adresse:',

		$photo_str = 'FOTO',

		$see_str = 'Se',

		$thereWasAnError_str = 'Det oppstod en feil',

		$bruteforce_str = 'Du har brukt opp inn&shy;loggings&shy;forsøkene dine. Prøv igjen om ti minutter, eller kontakt admini&shy;strator.',
		$noUsername_str = 'Husk å skriv et brukernavn',
		$takenUsername_str = 'Brukernavnet er allerede tatt',
		$takenEmail_str = 'Det finnes allerede en bruker med denne e-postadressen',
		$noPass_str = 'Husk å skrive et passord',
		$wrongPass_str = 'Passordet var feil',
		$unknownUser_str = 'Ingen med det brukernavnet.',
		$oops_str = 'Oops! Noe gikk galt. Vennligst prøv igjen senere.',

		$browserError = 'Backendfunksjonene i JPress er ikke optimalisert for Internet Explorer. Vi anbefaler derfor at du endrer til Chrome, Firefox eller Opera.',
		$oldBrowser_str = 'Du bruker en utdatert versjon av Internet Explorer. For å se denne sida må du oppdatere.',

		$notFoundMessage = 'Sida du ser etter finnes dessverre ikke. Trykk <a href="/">her</a> for å komme til forsida.',

		$noContent_str = 'Mangler innhold',
		$followOn_str = 'Følg oss på',
		$whatIs_str = 'Hva er',

		$userRole_str = 'Rolle',
		$editor_str = 'Redaktør',

		$underConstruction_str = 'Under utvikling',

		$cfReceipt_str = 'Kvittering',
		$cfReceiptBody_str = 'Kvitteringstekst for kontaktskjema',
		$cfReceiptBodyAltLang_str = 'Kvitteringstekst for kontaktskjema, alternativt språk',

		$choose_str = 'Velg',
		$nativeFont_str = 'Innebygget font',
		$large_str = 'Stor',
		$small_str = 'Liten',
		$embed_str = 'Bygg inn',

		$toTheTop_str = 'Til toppen',
		$customCursor_str = 'Spesialpeker'
	);

} else if ($lang == 'en') {

	if ($translatedSlug == '/route-info/') {
		$translatedSlug = '/ruteinformasjon/';
	} elseif ($translatedSlug == '/about-us/') {
		$translatedSlug = '/om-oss/';
	} elseif ($translatedSlug == '/contact/') {
		$translatedSlug = '/kontakt/';
	} elseif ($translatedSlug == '/privacy/') {
		$translatedSlug = '/personvern/';
	}

	$strArray = array(

		$title_str = 'Title',
		$shortDescription_str = 'Short description of the content of this article',

		$home_str = 'Home',

	  $clickToLogout_str = 'Log out',
		$hello_str = 'Hi',
	  $settings_str = 'Settings',
	  $media_str = 'Media',
	  $users_str = 'Users',

		$seoSettings_str = 'SEO',
		$layoutSettings_str = 'Layout',
		$languageSettings_str = 'Language',
		$someSettings_str = 'Social Media',
		$navSettings_str = 'Navigation',
		$apiKey_str = 'API Keys',
		$emailSettings_str = 'Email',

		$seoAbr_str = 'SEO',
		$layoutAbr_str = 'LYT',
		$langAbr_str = 'Lang',
		$someAbr_str = 'So-Me',
		$navAbr_str = 'Nav',

		$contactForm_str = 'Contact Form',
		$contactInfo_str = 'Email',
		$contactInfoEx_str = 'for contact forms, etc',
		$phoneNumber_str = 'Phone Number',

		$emptyName_str = 'You need to write a name',
		$emptyEmail_str = 'You need to write an email address',
		$invalidEmail_str = 'You need to write a valid email address',
		$emptyMessage_str = 'Remember to write a message',
		$reCAPTCHAError_str = 'You didn\'t pass the reCAPTCHA. Please try again.',
		$missingAdminMail_str = 'No admin email adress',
		$emailSuccess_str = '<strong>Thank you!</strong><br>We\'ll be in touch soon.',

	  $frontPage_str = 'Front Page',
		$articles_str = 'Articles',
	  $draft_str = 'draft',
	  $newPage_str = 'New Page',
	  $siteName_str = 'Site Name',
		$legalName_str = 'Company Name/Owner of Copyright',
	  $siteDescription_str = 'Site Description',
	  $metaTags_str = 'Meta Tags',
		$addCodeHead_str = 'Add code to &lt;head&gt;',
		$addCodeBody_str = 'Add code to top of &lt;body&gt;',
		$addCodeFooter_str = 'Add code to bottom of &lt;body&gt;',
		$addCustomShortcode_str = 'Add custom shortcode <small>[custom-shortcode]</small>',
	  $divideByComma_str = 'divide by comma',
	  $lang_str = 'Language',
	  $norwegian_str = 'Norwegian',
	  $english_str = 'English (International)',
		$altLang_str = 'Multilingual Site',
		$chooseAltLanguage_str = 'Choose Alternate Language',
		$altLangOne_str = 'Alternate Language',
		$altSiteDescription_str = 'Page Description for Alternate Language',
		$robots_str = 'Discourage search engines from indexing this site',
		$forDevelopment_str = 'For use during development',
		$logo_str = 'Logo',
		$featuredImage_str = 'Featured Image',
		$chooseFeaturedImage_str = 'Choose Featured Image',
		$chooseImage_str = 'Choose Image',
		$editImage_str = 'Edit Image',
		$edit_str = 'Edit',
		$shortTitle_str = 'Short Title',
		$reposition_str = 'Reposition',
		$chooseFooterLink_str = 'Choose whether to show this link in the Footer Menu',
		$mainMenu_str = 'Main Menu',

		$plugins_str = 'Plugins',

		$editSection_str = 'Section Options',
		$editBackground_str = 'Edit Background',
		$chooseBackgroundImage_str = 'Background Image',
		$black_str = 'Black',
		$darkBg_str = 'Dark Background',
		$lightBg_str = 'Light Background',
		$bgImage_str = 'Background Image',
		$deleteSection_str = 'Delete Section',

		$showShareIcons_str = 'Display Social Media Share icons on articles',

		$themeColor_str = 'Theme Color',
		$secondaryColor_str = 'Secondary Theme Color',
		$contrastColor_str = 'Contrast Color',
		$whiteColor_str = 'Light Color',
		$translucence_str = 'Translucence',

		$typography_str = 'Typography',
		$useGoogleFonts_str = 'Use Google Fonts',
		$googleAPIkey_str = 'Google API Key',
		$useSendGrid_str = 'Use SendGrid',
		$useTypekit_str = 'Use Typekit',
		$tkStylesheet_str = 'Code to embed stylesheet',
		$tkStylesheetExample_str = '&lt;link rel=&quot;stylesheet&quot; href=&quot;https://use.typekit.net/your-style-sheet.css&quot;&gt;',
		$example_str = 'Example',
		$fontFamily_str = 'Font Family',
		$fontFamilyHeader_str = 'Font Family Headlines: <small>(If different from main font)</small>',
		$heading_str = 'Heading',
		$chosenImage_str = 'Chosen Image',
		$useGoogleMaps_str = 'Use Google Maps',
		$scrollMenu_str = 'Scroll Menu',
		$useScrollMenu_str = 'Use Scroll Menu',
		$showMailHeader_str = 'Display mail in header',
		$showPhoneHeader_str = 'Display phone in header',
		$copyLink_str = 'Copy Link',
		$copied_str = 'Copied',
		$photoCredit_str = 'Photographer/Bureau',
		$useCaption_str = 'Caption',
		$saveChanges_str = 'Save Changes',

		$mediaLibrary_str = 'Media Library',
		$uploadImage_str = 'Upload Image/Video',
		$upload_str = 'Upload',
		$altText_str = 'Alternative Text',
		$imageDetails_str = 'Meta Data',
		$fileName_str = 'Filename',
		$fileSize_str = 'File size',
		$deleteFile_str = 'Delete File',
		$permaLink_str = 'Permalink',
		$filesSelected_str = 'files selected',

		$login_str = 'Login',
		$forgottenPwd_str = 'Forgotten password',
		$password_str = 'Password',
		$changePassword_str = 'Change password',
		$passowrdUpdated_str = 'Password is updated',
		$writeEmail_str = 'Please write a valid email address.',
		$noUsers_str = 'No users with this email address. Did you spell it correctly?',
		$awaitInstructions_str = 'You will recieve an email with instructions to change your password.',
		$checkYourInbox = 'Check your inbox',

		$userAdded_str = 'New user added',
		$deleteUser_str = 'Delete User',
		$userName_str = 'Username',
		$userOrEmail_str = 'Username or Email Address',
		$email_str = 'Email',
		$lastLogin_str = 'Last Login',
		$addUser_str = 'Add User',
		$newUser_str = 'New User',
		$newUserName_str = 'New Username',
		$newPassword_str = 'New Password',
		$newPasswordConfirm_str = 'Confirm New Password',
		$add_str = 'Add',
		$mapError_str = 'The map could not be loaded.',
		$regards_str = 'Regards',
		$newMessageFrom_str = 'New message from',
		$yourLoginUrl_str = 'Your login URL is',
		$yourUserName_str = 'Your username is',
		$yourPassword_str = 'Your passowrd is',
		$toSetNewPwd_str = 'To set a new password, go to this address',

		$savedAsDraft_str = 'The article is saved as a draft.',
		$publish_str = 'Publish',
		$published_str = 'Public',
		$displayInMenu_str = 'Show in menu',
		$hideFromMenu_str = 'Hide from menu',
		$depublish_str = 'Unpublish',
		$share_str = 'Share',
		$on_str = 'on',

		$inactive_str = 'You\'ve been inactive for too long. ',
		$clickHere_str = 'Click here to log in again',

		$contact_str = 'Contact',
		$name_str = 'Name',
		$message_str = 'Message',
		$send_str = 'Send',

		$privacy_str = 'Privacy',
		$privacyLink_str = 'Privacy Policy',
		$lastEdited_str = 'Last edited',
		$cookieSettings_str = 'Your Cookie Settings',
		$recaptchaContact_str = '<span class="icon-recaptchajpress"></span> This contact form is protected by reCAPTCHA and the Google <a class="recaptcha-link" href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> and <a class="recaptcha-link" href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.',
		$recaptchaLogin_str = '<span class="icon-recaptchajpress"></span> This login form is protected by reCAPTCHA and the Google <a class="recaptcha-link" href="https://policies.google.com/privacy" target="_blank">Privacy Policy</a> and <a class="recaptcha-link" href="https://policies.google.com/terms" target="_blank">Terms of Service</a> apply.',

		$gfmReminder_str = 'Remember that any changes must to be done on each language.',
		$waypts_str = 'Waypoints',
		$labelWaypt_str = 'Name',
		$descWaypt_str = 'Description',
		$latitude_str = 'Latitude',
		$longitude_str = 'Longitude',
		$imageWaypt_str = 'Image',

		$cancel_str = 'Cancel',
		$tryAgain_str = 'Try again!',
		$didntWritePassword_str = 'You didn\'t write a password.',
		$pwdNoMatch_str = 'The passwords you wrote didn\'t match.',
		$cantVerifyRequest_str = 'We can\'t verify your request.',
		$setNewPwd_str = 'Set new password',
		$shortPwd_str = 'The Password needs to be at least 6 characters',
		$pwdRequest_str = 'We got a request to reset your password on ' . BASE_URL . '. If you didn\'t ask for this, you can safely ignore this email. To set a new password, visit this address:',

		$photo_str = 'PHOTO',

		$see_str = 'See',

		$thereWasAnError_str = 'There was an error',

		$bruteforce_str = 'You\'ve used up your login attempts. Please try again in ten minutes',
		$noUsername_str = 'Remember to write a username',
		$takenUsername_str = 'Username already taken',
		$takenEmail_str = 'Email address already taken',
		$noPass_str = 'Rememeber to write a password',
		$wrongPass_str = 'The password was incorrect.',
		$unknownUser_str = 'No one with this username.',
		$oops_str = 'Oops! Something went wrong. Please try again in a litte while.',

		$browserError = 'The backend functions of JPress are not compatible with your browser. We recommend that you switch to Firefox, Chrome or Opera.',
		$oldBrowser_str = 'You are using an outdated version of Internet Explorer. To view this website, you need to update.',

		$notFoundMessage = 'The page you\'re looking for can\'t be found. Click <a href="/">here</a> to go back to the homepage.',

		$noContent_str = 'Missing content',

		$followOn_str = 'Follow us on',
		$whatIs_str = 'What is',

		$userRole_str = 'Role',
		$editor_str = 'Editor',

		$underConstruction_str = 'Under construction',

		$cfReceipt_str = 'Receipt',
		$cfReceiptBody_str = 'Receipt for contact form',
		$cfReceiptBodyAltLang_str = 'Receipt for contact form, alternate language',

		$choose_str = 'Choose',
		$nativeFont_str = 'Native Font',

		$large_str = 'Large',
		$small_str = 'Small',
		$embed_str = 'Embed',

		$toTheTop_str = 'To the top',
		$customCursor_str = 'Custom cursor'
	);
}
