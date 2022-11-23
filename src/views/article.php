<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

include APP_ROOT . '/jp-includes/app/session-timeout.php';

if (!isset($_GET['slug']) && !isset($_GET['g1'])) {
	header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
	include APP_ROOT . '/404.php';
	exit();
} else {
	if (isset($_GET['slug'])) {
		$slug = $_GET['slug'];
		if (isset($_GET['lang'])) {
			if (!empty(getOption()['altLangOne']) && $_GET['lang'] === getOption()['altLangOne']) {
				$lang = getOption()['altLangOne'];
			} else {
				$lang = getOption()['lang'];
			}
		} else {
			$lang = getOption()['lang'];
		}
	} elseif (isset($_GET['g1'])) {
		$slug = $_GET['g1'];
	}

	$bodyClass = 'article white-background ' . strtolower($lang);

	include APP_ROOT . '/jp-includes/lang/lang.php';

	if (!getArticle('id', $slug, $lang)) {
		header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
		include APP_ROOT . '/404.php';
		exit();
	} else {

		$pageLabel = getArticle('label', $slug, $lang);
		$translatedSlug = getArticle('translatedSlug', $slug, $lang);
		$pageTitle = str_replace(['<h1>', '</h1>'], '', getArticle('title', $slug, $lang));
		$published = !!getArticle('published', $slug, $lang);

		$bodyClass .= ' article-' . getArticle('id', $slug, $lang);

		if (isLoggedIn()) {
			if (isset($_SESSION['LAST_ACTIVITY']) && ($time - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
				session_unset();
				session_destroy();
				header('Location: ' . CURRENT_URL . '/');
				exit();
			}

			// if (isPageSpeed() && !isset($_GET['ModPagespeed'])) {
			//   header('Location: ' . CURRENT_URL . '/?ModPagespeed=off');
			// }

			$_SESSION['LAST_ACTIVITY'] = $time;

		} elseif (!$published) {
			header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
			include APP_ROOT . '/404.php';
			exit();
		}

		include APP_ROOT . '/views/templates/header.php';
		?>
		<main id="main-content">
			<?php
			if (isLoggedIn()) { ?>
				<form id="update-article" method="post" action="">
					<input type="hidden" id="created" value="<?php echo getArticle('created', $slug, $lang); ?>">
					<input type="hidden" id="page-type" value="<?php echo getArticle('type', $slug, $lang); ?>">
					<input type="hidden" id="page-id" value="<?php echo getArticle('id', $slug, $lang); ?>">
					<input type="hidden" id="published" value="<?php echo $published; ?>">
					<input type="hidden" id="display-in-menu" value="<?php echo getArticle('displayInMenu', $slug, $lang); ?>">
					<div id="article-slug" class="hide-on-mobile white-color">
						<p><?php echo $permaLink_str; ?>: <?php echo BASE_URL; echo !empty($altLangOne) && $lang === $altLangOne ? '/' . $altLangOne : ''; ?>/<input type="hidden" name="article-slug" value="<?php echo $slug; ?>"><span id="slug-output"><?php echo $slug; ?></span>
							<span id="edit-slug-button">
								<button type="button" class="theme-background" aria-label="Rediger permalenke"><?php echo $edit_str ?></button>
							</span>
						</p>
					</div>
			<?php } ?>
			<div class="content">
				<div id="article-title" class="textarea">
					<h1><?php echo $pageTitle ?></h1>
				</div>
				<div id="article-summary" class="textarea">
					<?php
					echo getArticle('excerpt', $slug, $lang); ?>
				</div>
				<?php if ($slug !== strtolower($privacy_str) && $slug !== strtolower($contact_str)) { ?>
				<div id="featured-image-container" class="theme-background"<?php echo !isLoggedIn() && !getArticle('displayImage', $slug, $lang) ? ' hidden' : ''; ?>>
					<figure class="theme-background">
						<img id="featured-image-element" alt="<?php echo $pageTitle; ?>" src="<?php echo getArticle('featured-image', $slug, $lang); ?>" style="transform: translateY(<?php echo getArticle('image-position', $slug, $lang); ?>%)" data-id="<?php echo getArticle('featuredImageId', $slug, $lang); ?>" />
						<figcaption<?php echo !empty(get_photoCredit()) ? ' class="theme-background"' :  ''; ?>><?php echo !empty(get_photoCredit()) ? '<span class="icon-camerajpress"></span> <strong>' . get_photoCredit() . '</strong>' : ''; ?></figcaption>
					</figure>
					<?php if (isLoggedIn()) { ?>
						<input type="hidden" id="image-position-input" name="image-position" value="<?php echo getArticle('image-position', $slug, $lang); ?>" data-value="<?php echo getArticle('image-position', $slug, $lang); ?>" data-edited="false">
						<input type="hidden" id="featured-image-input" name="featured-image-input" value="<?php echo getArticle('featured-image', $slug, $lang); ?>">
						<input type="hidden" id="original-featured-image" value="<?php echo getArticle('featured-image', $slug, $lang); ?>">
						<input type="hidden" id="featured-image-id" value="<?php echo getArticle('featuredImageId', $slug, $lang); ?>">
						<div class="instructions theme-background"></div>
						<div id="edit-featured-image">
							<div id="edit-featured-image-button" class="">
								<span class="button-text"><?php echo $editImage_str; ?></span>
								<span class="icon-camerajpress"></span>
								<ul class="image-menu">
									<li>
										<a id="image-choose" class="module-link"><span class="icon-imagesjpress"></span> <?php echo $chooseImage_str; ?></a>
									</li>
									<li>
										<a id="image-upload" href="/jp-admin/upload.php"><span class="icon-uploadjpress"></span> <?php echo $uploadImage_str; ?></a>
									</li>
									<li class="hide-on-mobile">
										<a id="image-position"><span class="icon-movejpress"></span> <?php echo $reposition_str; ?></a>
									</li>
									<li class="inline-switch">
										<label class="switch" style="margin-left:0;">
											<input type="checkbox" id="display-image"<?php echo getArticle('displayImage', $slug, $lang) ? ' checked' : ''; ?>>
											<span class="slider round theme-background"></span>
										</label>
										<label style="margin-bottom:10px;"><?php echo $viewImage_str; ?></label>
									</li>
								</ul>
							</div>
						</div>
						<div id="image-buttons">
							<button id="image-cancel" class="theme-background"><?php echo $cancel_str; ?></button>
							<button id="image-save" class="theme-background">OK</button>
						</div>
					<?php } ?>
				</div>
			<?php } if ($someShareSwitch === 'checked') {
				if ($slug !== strtolower($privacy_str) && $slug !== strtolower($contact_str)) {
					echo get_someShare();
				}
			} ?>
				<div id="article-content" class="textarea">
					<?php
					if (!isLoggedIn()) {
						echo filterContent(getArticle('body', $slug, $lang));
					} else echo getArticle('body', $slug, $lang); ?>
				</div>
				<?php
				if (isPrivacy()) {
					if (empty(getArticle('updated', $slug, $lang))) {
						$time = getArticle('created', $slug, $lang);
					} else $time = getArticle('updated', $slug, $lang);
					$timeParse = DateTime::createFromFormat('Y-m-d H:i:s', $time);
					setlocale(LC_TIME, $lang);
					if ($lang === 'no') {
						$timeFormat = strtolower(date('j. M, Y, H:i', strftime($timeParse->getTimestamp())));
					} else {
						$timeFormat = date('M j<\s\up>S</\s\up>, Y, g:i a', strftime($timeParse->getTimestamp()));
					}
					echo '<p><em>' . $lastEdited_str . ' ' . $timeFormat . '.</em></p>';
				} ?>
			</div>
			<?php
			if(isLoggedIn()) { ?>
				<button style="display:none;" class="jp-save-changes" type="submit" name="save-changes">
				</button>
			</form>
			<?php
			}
			?>
		</main>
		<?php
	}
	include APP_ROOT . '/views/templates/footer.php';
}