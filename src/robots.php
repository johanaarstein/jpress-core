<?php
require __DIR__ . '/jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
header('Content-type: text/plain');
?>
User-agent: *
Sitemap: <?php echo BASE_URL; ?>/sitemap.xml
<?php $db -> close(); exit(); ?>
