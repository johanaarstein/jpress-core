<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['new-article']) && isset($_POST['lang'])) {
    require_once APP_ROOT . '/jp-config/config.php';
    require_once APP_ROOT . '/jp-includes/app/functions.php';
    include APP_ROOT . '/jp-includes/lang/lang.php';

    $altLangOne = $mainLang = '';

    $lang = $_POST['lang'];
    if (isset($_POST['alt-lang-one']) && isset($_POST['main-lang'])) {
      $altLangOne = $_POST['alt-lang-one'];
      $mainLang = $_POST['main-lang'];
    }

    $pageTitle = $pageLabel = $newPage_str;
    $pageDesc = '<p>' . $shortDescription_str . '</p>';
    $pageContent = '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Cras ornare arcu dui vivamus arcu felis bibendum ut tristique. Faucibus ornare suspendisse sed nisi lacus sed viverra tellus in.</p><h2>In ornare quam viverra</h2><p>Orci sagittis eu volutpat odio. Est placerat in egestas erat imperdiet sed euismod nisi porta. Ut tellus elementum sag<img src="/assets/img/jpress.png" alt="" class="alignright" width="1200" height="635">ittis vitae et leo duis. Arcu ac tortor dignissim convallis. Tortor condimentum lacinia quis vel. A scelerisque purus semper eget duis. Nulla aliquet enim tortor at auctor urna nunc. Orci phasellus egestas tellus rutrum tellus pellentesque eu tincidunt tortor.</p><p>Viverra justo nec ultrices dui sapien. Lacus luctus accumsan tortor posuere ac ut consequat semper viverra. Elit duis tristique sollicitudin nibh sit. Tellus id interdum velit laoreet.</p><blockquote><p>Pulvinar elementum integer enim neque volutpat ac tincidunt vitae.</p></blockquote><p>Fermentum et sollicitudin ac orci phasellus. Imperdiet nulla malesuada pellentesque elit. Volutpat blandit aliquam etiam erat velit. Netus et malesuada fames ac. Leo vel orci porta non pulvinar neque laoreet. Id porta nibh venenatis cras. Purus in mollis nunc sed id semper risus in.</p>';

    $pageSlug = preg_replace("/-$/","",preg_replace('/[^a-z0-9]+/i', "-", strtolower($pageTitle)));
    $select =
    "SELECT Count(`id`) AS counter
    FROM   `articles`
    WHERE  `slug` LIKE '$pageSlug%';";
    $result = $db -> query($select);
    if ($result && $result -> num_rows > 0) {
      while ($row = $result -> fetch_assoc()) {
        $counter = $row['counter'];
        $pageSlug = $pageSlug . '-' . $counter;
      }
    }
    $pageType = 'article';
    $published = false;

    $select =
    "SELECT Count(`order`) AS new_order
    FROM    `articles`
    WHERE   `lang` = '$lang';";
    $result = $db -> query($select);
    if ($result && $result -> num_rows > 0) {
      while ($row = $result -> fetch_assoc()) {
        $order = $row['new_order'] + 1;
      }
    }
    $insert = $db -> query(
      "INSERT INTO `articles`
                  (`lang`,
                   `title`,
                   `order`,
                   `label`,
                   `excerpt`,
                   `body`,
                   `slug`,
                   `type`,
                   `published`,
                   `displayInMenu`,
                   `created`)
      VALUES      ('$lang',
                   '$pageTitle',
                   '$order',
                   '$pageLabel',
                   '$pageDesc',
                   '$pageContent',
                   '$pageSlug',
                   '$pageType',
                   '$published',
                   'checked',
                   Now());"
    );

    if ($insert) {
      if ($lang !== $altLangOne) {
        header('Location: /' . $pageSlug . '/');
        $db -> close();
        exit();
      } else {
        header('Location: /' . $altLangOne . '/' . $pageSlug . '/');
        $db -> close();
        exit();
      }
    } elseif ($db -> error) {
      http_response_code(500);
      printf($thereWasAnError_str . ': (' . $db -> errno . ') ' . $db -> error);
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
