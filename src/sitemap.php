<?php
require __DIR__ . '/jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
require_once APP_ROOT . '/jp-includes/app/functions.php';
require APP_ROOT . '/jp-includes/app/siteinfo.php';

header('Content-type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
  <url>
    <loc><?php echo BASE_URL; ?>/</loc>
    <?php if (!!$altLangOne) { ?>
          <xhtml:link rel="alternate" hreflang="<?php echo $altLangOne; ?>" href="<?php echo BASE_URL . '/' . $altLangOne; ?>/" />
        <?php
    } ?>
    <lastmod>2020-02-15</lastmod>
    <changefreq>monthly</changefreq>
    <priority>1.00</priority>
  </url>
  <?php

  $select =
  "SELECT `slug`,
         `updated`,
         `lang`,
         `translatedSlug`
  FROM   `articles`
  ORDER  BY `created` DESC;";
  $result = $db -> query($select);
  if ($result && $result -> num_rows > 0) {
  	while ($row = $result -> fetch_assoc()) {
      $slug = stripslashes($row['slug']);
      $date = date("Y-m-d", strtotime($row['updated']));
      $postLang = $row['lang'];
      $translatedSlug = $row['translatedSlug']; ?>
        <?php
        if ($postLang !== $mainLang) {
          continue;
        } ?>
      <url>
        <loc><?php echo BASE_URL . '/' . $slug; ?>/</loc>
        <?php if (!!$altLangOne && !empty($translatedSlug)) { ?>
          <xhtml:link rel="alternate" hreflang="<?php echo $altLangOne; ?>" href="<?php echo BASE_URL . '/' . $altLangOne . '/' . $translatedSlug; ?>/" />
        <?php
        } ?>
        <priority>0.9</priority>
        <lastmod><?php echo $date ?></lastmod>
        <changefreq>never</changefreq>
      </url>
 <?php }
} ?>
</urlset>
