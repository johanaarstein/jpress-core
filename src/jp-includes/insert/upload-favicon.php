<?php
require __DIR__ . '/../app/variables.php';
require_once APP_ROOT . '/jp-config/config.php';
require APP_ROOT . '/jp-includes/app/functions.php';
require APP_ROOT . '/jp-includes/plugins/potracio/potracio.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_FILES['file'])) {

    $allowed = 'png';
    $targetDir = APP_ROOT . '/assets/img/site/';
    $targetFile = $targetDir . 'favicon.png';
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $fileSize = $_FILES['file']['size'][0];
    $fileError = $_FILES['file']['error'][0];
    if ($imageFileType === $allowed) {
      if ($fileError === 0) {
        if ($fileSize > 200000) {
          http_response_code(413);
          exit();
        } else {
          $upload = move_uploaded_file($_FILES['file']['tmp_name'][0], $targetFile);

          if (!$upload) {
            http_response_code(500);
            echo 'Could not write file';
            exit();
          }

          if (extension_loaded('imagick')) {
            $favicon32 = new \Imagick(realpath($targetFile));
            $favicon32 -> cropThumbnailImage(32, 32);
            $favicon32 -> writeImage($targetDir . 'favicon-32x32.png');
            $favicon32 -> clear();
            $favicon32 -> destroy();

            $favicon16 = new \Imagick(realpath($targetFile));
            $favicon16 -> cropThumbnailImage(16, 16);
            $favicon16 -> writeImage($targetDir . 'favicon-16x16.png');
            $favicon16 -> clear();
            $favicon16 -> destroy();

            $androidChrome = new \Imagick(realpath($targetFile));
            $androidChrome -> cropThumbnailImage(512, 512);
            $shadow = clone $androidChrome;
            $shadow -> setImageBackgroundColor(new ImagickPixel('transparent'));
            $shadow -> shadowImage(80, 10 , 5, 5);
            $shadow -> addImage($androidChrome);
            $shadow -> setImageFormat('png');
            $androidChrome512 = $shadow -> mergeImageLayers(1);
            $androidChrome512 -> writeImage($targetDir . 'android-chrome-512x512.png');
            $androidChrome -> clear();
            $androidChrome -> destroy();

            $androidChrome192 = new \Imagick(realpath($targetDir . 'android-chrome-512x512.png'));
            $androidChrome192 -> cropThumbnailImage(192, 192);
            $androidChrome192 -> writeImage($targetDir . 'android-chrome-192x192.png');
            $androidChrome192 -> clear();
            $androidChrome192 -> destroy();

            $bg = new Imagick();
            $bg -> newImage(180, 180, new ImagickPixel('#' . get_siteInfo()['themeColor']));
            $logo = new \Imagick(realpath($targetFile));
            $logo -> cropThumbnailImage(180, 180);
            $bg -> addImage($logo);
            $bg -> setImageFormat('png');
            $appleTouch = $bg -> mergeImageLayers(1);
            $appleTouch -> writeImage($targetDir . 'apple-touch-icon.png');
            $appleTouch -> clear();
            $appleTouch -> destroy();

            if (extension_loaded('imagick')) {
              $resizedImage = new \Imagick(realpath($targetFile));
              $resizedImage -> scaleImage(800, 800, true);
              $bg = new Imagick();
              $bg -> newImage(800, 800, new ImagickPixel('white'));
              $bg -> compositeimage($resizedImage, Imagick::COMPOSITE_OVER, 0, 0);
              $bg -> writeImage($targetDir . 'safari-pinned-tab.png');
              $safariPT = new Potracio\Potracio();
              $safariPT -> loadImageFromFile($targetDir . 'safari-pinned-tab.png');
              $safariPT -> process();
              file_put_contents($targetDir . 'safari-pinned-tab.svg', $safariPT -> getSVG(0.02));
              $resizedImage -> clear();
              $resizedImage -> destroy();
              unlink($targetDir . 'safari-pinned-tab.png');
            }

          } else {
            $originalImage = imagecreatefrompng($targetFile);
            $width = imagesx($originalImage);
            $height = imagesy($originalImage);
            $size = min($width, $height);
            $centerX = round(($width - $size) / 2);
            $centerY = round(($height - $size) / 2);
            if ($width > $height) {
              $croppedImage = imagecrop($originalImage, ['x' => $centerX, 'y' => 0, 'width' => $size, 'height' => $size]);
            } else if ($width < $height) {
              $croppedImage = imagecrop($originalImage, ['x' => 0, 'y' => $centerY, 'width' => $size, 'height' => $size]);
            } else if ($width === $height) {
              $croppedImage = $originalImage;
            }

            $resizedImage1 = imagecreatetruecolor(32, 32);
            imagecopyresampled($resizedImage1, $croppedImage, 0, 0, 0, 0, 32, 32, $width, $height);
            $favicon32 = imagepng($resizedImage, $targetDir . 'favicon-32x32.png', 90);

            $resizedImage2 = imagecreatetruecolor(16, 16);
            imagecopyresampled($resizedImage2, $croppedImage, 0, 0, 0, 0, 16, 16, $width, $height);
            $favicon32 = imagepng($resizedImage, $targetDir . 'favicon-16x16.png', 90);
            imagedestroy($originalImage);
          }

          http_response_code(200);
          exit();
        }
      } else {
        http_response_code(400);
        echo 'Error: ' . $fileError;
        exit();
      }
    } else {
      http_response_code(415);
      exit();
    }
  } else {
    http_response_code(400);
    echo 'Missing file';
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
