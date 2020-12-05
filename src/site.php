<?php
require __DIR__ . '/jp-includes/app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
require_once APP_ROOT . '/jp-includes/app/functions.php';
require_once APP_ROOT . '/jp-includes/app/siteinfo.php';
header('Content-type: application/json'); ?>
{
  "name": "<?php echo $siteName; ?>",
  "short_name": "<?php echo $siteName; ?>",
  "icons": [
    {
      "src": "/assets/img/site/android-chrome-192x192.png",
      "sizes": "192x192",
      "type": "image/png"
    },
    {
      "src": "/assets/img/site/android-chrome-512x512.png",
      "sizes": "512x512",
      "type": "image/png"
    }
  ],
  "theme_color": "<?php echo $secondaryColor; ?>",
  "background_color": "<?php echo $secondaryColor; ?>",
  "display": "standalone"
}
