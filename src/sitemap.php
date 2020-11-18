<?php
require __DIR__ . '/jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
header('Content-type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" ?>';
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url>
    <loc><?php echo BASE_URL; ?>/</loc>
    <lastmod>2020-02-15</lastmod>
    <changefreq>monthly</changefreq>
    <priority>1.00</priority>
  </url>
  <?php

  $select =
  "SELECT `slug`,
         `updated`,
         `lang`
  FROM   `articles`
  ORDER  BY `created` DESC;";
  $result = $db -> query($select);
  if ($result && $result -> num_rows > 0) {
  	while ($row = $result -> fetch_assoc()) {
      $slug = stripslashes($row['slug']);
      $date = date("Y-m-d", strtotime($row['updated']));
      $lang = $row['lang']; ?>
      <url>
        <?php if ($lang !== 'en') { ?>
          <loc><?php echo BASE_URL . '/' . $lang . '/' . $slug; ?>/</loc>
          <priority>0.8</priority>
        <?php } else { ?>
          <loc><?php echo BASE_URL . '/' . $slug; ?>/</loc>
          <priority>0.9</priority>
        <?php } ?>
        <lastmod><?php echo $date ?></lastmod>
        <changefreq>never</changefreq>
      </url>
 <?php }
} ?>
</urlset>
