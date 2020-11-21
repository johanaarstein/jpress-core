<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update-article'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    require APP_ROOT . '/jp-includes/app/functions.php';

    $featuredImage = '';
    $featuredImageId = $imagePosition = 0;

    $lang = $_POST['lang'];

    $pageTitle = str_replace(['<h1>', '</h1>', '<br>'], '', cSHY($_POST['article-title']));
    $pageId = $_POST['page-id'];
    $pageLabel = $_POST['article-label'];
    $pageSlug = slugify($_POST['article-slug']);
    $translatedSlug = slugify($_POST['translated-slug']);
    $pageDesc = cSHY($_POST['article-summary']);
    $pageContent = cSHY($_POST['article-content']);
    if (isset($_POST['featured-image'])) {
      $featuredImage = trim(str_replace(BASE_URL, '', $_POST['featured-image']));
      $imagePosition = $_POST['image-position'];
      if (!empty($_POST['featured-image-id'])) {
        $featuredImageId = $_POST['featured-image-id'];
      } else {
        $featuredImageId = '0';
      }
    }
    $created = $_POST['created'];
    $pageType = 'article';
    $published = $_POST['published'];
    $displayInMenu = $_POST['display-in-menu'];

    $select =
    "SELECT Count(`id`) AS counter
    FROM   `articles`
    WHERE  `slug` LIKE '$pageSlug%';";
    $result = $db -> query($select);
    if ($result && $result -> num_rows > 1) {
      while ($row = $result -> fetch_assoc()) {
        $counter = $row['counter'];
        $pageSlug = $pageSlug . '-' . $counter;
      }
    }

    $update = $db -> query(
      "UPDATE `articles`
      SET    `title`            = '$pageTitle',
             `label`            = '$pageLabel',
             `featured-image`   = '$featuredImage',
             `featuredImageId`  = '$featuredImageId',
             `image-position`   = '$imagePosition',
             `excerpt`          = '$pageDesc',
             `body`             = '$pageContent',
             `slug`             = '$pageSlug',
             `translatedSlug`   = '$translatedSlug',
             `type`             = '$pageType',
             `published`        = b'$published',
             `displayInMenu`    = '$displayInMenu',
             `created`          = '$created',
             `updated`          = Now()
      WHERE  `id`               = '$pageId'
             AND `lang`         = '$lang';"
    );

    if ($db -> error) {
      http_response_code(500);
      header('Content-Type: application/x-www-form-urlencoded');
      echo '(' . $db -> errno . '): ' . $db -> error;
      $db -> close();
      exit();
    }

    $insert = $db -> query(
      "INSERT INTO `articles_revisions`
                  (`lang`,
                   `original-id`,
                   `title`,
                   `featured-image`,
                   `featuredImageId`,
                   `image-position`,
                   `excerpt`,
                   `body`,
                   `created`)
      VALUES      ('$lang',
                   '$pageId',
                   '$pageTitle',
                   '$featuredImage',
                   '$featuredImageId',
                   '$imagePosition',
                   '$pageDesc',
                   '$pageContent',
                   Now());"
    );

    if ($update && $insert) {
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
    // $db -> close();
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  // $db -> close();
  exit();
}
