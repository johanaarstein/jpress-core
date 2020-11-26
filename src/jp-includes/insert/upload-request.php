<?php
require __DIR__ . '/../app/variables.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require_once APP_ROOT . '/jp-config/config.php';

  if (isset($_FILES['file'])) {

    $allowed = ['jpg', 'jpeg', 'png', 'gif', 'svg', 'pdf', 'mp4'];
    $errors = [];
    $thumbnailSrc = $imageTitle = $imageAlt = '';

    $fileCount = count($_FILES['file']['name']);
    $idList = '';

    for ($i = 0; $i < $fileCount; $i++) {

      $targetDir = APP_ROOT . '/uploads/';
      $targetThumbDir = $targetDir . 'thumbnails/';

      $fileName = str_replace(' ', '_', $_FILES['file']['name'][$i]);
      $titleBase = $fileTitle = pathinfo($fileName, PATHINFO_FILENAME);
      $targetFile = $targetDir . $fileName;
      $targetFileBase = $targetDir . $titleBase;
      $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
      $fileName = $titleBase . '.' . $imageFileType;
      $mimeType = $_FILES['file']['type'][$i];
      $fileSize = $_FILES['file']['size'][$i];
      $fileError = $_FILES['file']['error'][$i];

      $counter = 0;
      while (file_exists($targetFile)) {
        $titleBase = $fileTitle . '_' . $counter; //For later reference
        $fileName = $fileTitle . '_' . $counter . '.' . $imageFileType;
        $targetFile = $targetDir . $fileName;
        $targetFileBase = $targetDir . $titleBase;
        $counter++;
      }

      if (in_array($imageFileType, $allowed)) {
        if ($fileError === 0) {

          $guid = '/uploads/' . $fileName;
          $tumbnailName = $titleBase . '-thumbnail.jpg';
          $thumbnailSrc = '/uploads/thumbnails/' . $tumbnailName;

          if ($mimeType === 'image/jpeg') {
            if ($fileSize < 350000) {
              if (extension_loaded('imagick') && in_array('WEBP', \Imagick::queryformats())) {
                $WebP = new Imagick();
                $WebP -> setResolution(300, 300);
                $WebP -> readImage($_FILES['file']['tmp_name'][$i]);
                $WebP -> setImageFormat('webp');
                $WebP -> setCompressionQuality(80);
                $WebP -> writeImage($targetFileBase . '.webp');
                $WebP -> clear();
                $WebP -> destroy();
              } elseif (imagetypes() & IMG_WEBP) {
                $originalImage = imagecreatefromjpeg($_FILES['file']['tmp_name'][$i]);
                $WebP = imagewebp($originalImage, $targetFileBase . '.webp', 80);
                imagedestroy($originalImage);
              } //else {
              //   exec('cwebp -q 80 ' . $targetFile . ' -o ' . $targetFileBase . '.webp' . '');
              // }
              move_uploaded_file($_FILES['file']['tmp_name'][$i], $targetFile);
            } else {
              if (extension_loaded('imagick') && in_array('WEBP', \Imagick::queryformats())) {
                $JPG = new Imagick();
                $JPG -> setResolution(300, 300);
                $JPG -> readImage($_FILES['file']['tmp_name'][$i]);
                $width = $JPG -> getImageWidth();
                $height = $JPG -> getImageHeight();
                $size = max($width, $height);
                if ($size > 1400) {
                  if ($width > $height) {
                    $newWidth = 1400;
                    $newHeight = round(1400 / $width * $height);
                  } else if ($width < $height) {
                    $newHeight = 1400;
                    $newWidth = round(1400 / $height * $width);
                  } else if ($width === $height) {
                    $newWidth = 1400;
                    $newHeight = 1400;
                  }
                  $JPG -> scaleImage($newWidth, $newHeight);
                }
                $JPG -> setCompressionQuality(80);
                $JPG -> writeImage($targetFileBase . '.' . $imageFileType);
                $JPG -> clear();
                $JPG -> destroy();
                $WebP = new Imagick();
                $WebP -> setResolution(300, 300);
                $WebP -> readImage($_FILES['file']['tmp_name'][$i]);
                if ($size > 1400) {
                  $WebP -> scaleImage($newWidth, $newHeight);
                }
                $WebP -> setImageFormat('webp');
                $WebP -> setCompressionQuality(80);
                $WebP -> writeImage($targetFileBase . '.webp');
                $WebP -> clear();
                $WebP -> destroy();
              } else {
                $initialSize = imagecreatefromjpeg($_FILES['file']['tmp_name'][$i]);
                $width = imagesx($initialSize);
                $height = imagesy($initialSize);
                $size = max($width, $height);
                if ($size > 1400) {
                  if ($width > $height) {
                    $newWidth = 1400;
                    $newHeight = round(1400 / $width * $height);
                  } else if ($width < $height) {
                    $newHeight = 1400;
                    $newWidth = round(1400 / $height * $width);
                  } else if ($width === $height) {
                    $newWidth = 1400;
                    $newHeight = 1400;
                  }
                  $newSize = imagecreatetruecolor($newWidth, $newHeight);
                  imagecopyresampled($newSize, $initialSize, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                  $JPG = imagejpeg($newSize, $targetFile, 80);
                  if (imagetypes() & IMG_WEBP) {
                    $WebP = imagewebp($newSize, $targetFileBase . '.webp', 80);
                  }
                  imagedestroy($newSize);
                } else {
                  $JPG = imagejpeg($initialSize, $targetFile, 80);
                  if (imagetypes() & IMG_WEBP) {
                    $WebP = imagewebp($initialSize, $targetFileBase . '.webp', 80);
                  }
                }
                imagedestroy($initialSize);
              }
            }
            if (extension_loaded('imagick') && in_array('WEBP', \Imagick::queryformats())) {
              $thumbnailJPG = new Imagick();
              $thumbnailJPG -> readImage($targetFileBase . '.' . $imageFileType);
              $thumbnailJPG -> cropThumbnailImage(500, 500);
              $thumbnailJPG -> writeImage($targetThumbDir . $tumbnailName);
              $thumbnailJPG -> clear();
              $thumbnailJPG -> destroy();
              $thumbnailWebP = new Imagick();
              $thumbnailWebP -> readImage($targetFileBase . '.' . $imageFileType);
              $thumbnailWebP -> setImageFormat('webp');
              $thumbnailWebP -> cropThumbnailImage(500, 500);
              $thumbnailWebP -> writeImage($targetThumbDir . $titleBase . '-thumbnail.webp');
              $thumbnailWebP -> clear();
              $thumbnailWebP -> destroy();
            } else {
              $originalImage = imagecreatefromjpeg($targetFileBase . '.' . $imageFileType);
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
              if ($size > 500) {
                $resizedImage = imagecreatetruecolor(500, 500);
                imagecopyresampled($resizedImage, $croppedImage, 0, 0, 0, 0, 500, 500, $size, $size);
                $thumbnailJPG = imagejpeg($resizedImage, $targetThumbDir . $tumbnailName, 90);
                if (imagetypes() & IMG_WEBP) {
                  $thumbnailWebP = imagewebp($resizedImage, $targetThumbDir . $titleBase . '-thumbnail.webp', 90);
                }
              } else {
                $thumbnailJPG = imagejpeg($croppedImage, $targetThumbDir . $tumbnailName, 90);
                if (imagetypes() & IMG_WEBP) {
                  $thumbnailWebP = imagewebp($croppedImage, $targetThumbDir . $titleBase . '-thumbnail.webp', 90);
                }
              }
              imagedestroy($originalImage);
            }
          } elseif ($mimeType === 'image/png' || $mimeType === 'image/gif' || $mimeType === 'image/svg+xml') {
            if ($fileSize > 2000000) {
              http_response_code(413);
              $db -> close();
              exit();
            } else {
              if ($mimeType === 'image/png') {
                if (extension_loaded('imagick') && in_array('WEBP', \Imagick::queryformats())) {
                  $WebP = new Imagick();
                  $WebP -> setResolution(300, 300);
                  $WebP -> readImage($_FILES['file']['tmp_name'][$i]);
                  $WebP -> setImageFormat('webp');
                  $WebP -> setCompressionQuality(80);
                  $WebP -> writeImage($targetFileBase . '.webp');
                  $WebP -> clear();
                  $WebP -> destroy();
                } elseif (imagetypes() & IMG_WEBP) {
                  $originalImage = imagecreatefrompng($_FILES['file']['tmp_name'][$i]);
                  $WebP = imagewebp($originalImage, $targetFileBase . '.webp', 80);
                  imagedestroy($originalImage);
                }
              }
              move_uploaded_file($_FILES['file']['tmp_name'][$i], $targetFile);
            }
          } elseif ($mimeType === 'application/pdf') {
            if ($fileSize > 2000000) {
              http_response_code(413);
              $db -> close();
              exit();
            } else {
              if (extension_loaded('imagick')) {
                $JPG = new Imagick();
                $JPG -> setResolution(300, 300);
                $JPG -> readImage($_FILES['file']['tmp_name'][$i]);
                $JPG -> setImageFormat('jpeg');
                $JPG -> setCompressionQuality(80);
                $JPG -> writeImage($targetFileBase . '.jpg');
                $JPG -> clear();
                $JPG -> destroy();
                $thumbnailJPG = new Imagick();
                $thumbnailJPG -> readImage($targetFileBase . '.jpg');
                $thumbnailJPG -> cropThumbnailImage(500, 500);
                $thumbnailJPG -> writeImage($targetThumbDir . $tumbnailName);
                $thumbnailJPG -> clear();
                $thumbnailJPG -> destroy();
              } else {
                echo 'You need to enable Imagick to upload PDFs';
                $db -> close();
                exit();
              }
              move_uploaded_file($_FILES['file']['tmp_name'][$i], $targetFile);
            }
          } elseif ($mimeType === 'video/mp4') {
            if ($fileSize > 10000000) {
              http_response_code(413);
              $db -> close();
              exit();
            } else {
              move_uploaded_file($_FILES['file']['tmp_name'][$i], $targetFile);
              $ffmpeg = trim(shell_exec('type -P ffmpeg'));
              if (!empty($ffmpeg) && file_exists(APP_ROOT . '/jp-includes/plugins/ffmpeg/vendor/autoload.php')) {
                require APP_ROOT . '/jp-includes/plugins/ffmpeg/vendor/autoload.php';

                try {
                  $ffmpeg = FFMpeg\FFMpeg::create();
                  $video = $ffmpeg -> open($targetFile);
                  $video -> frame(FFMpeg\Coordinate\TimeCode::fromSeconds(1)) -> save($targetThumbDir . $titleBase . '-thumbnail.jpg');
                } catch (Exception $e) {
                  http_response_code(510);
                  if (!empty($e)) {
                    echo $e;
                  } else {
                    echo 'Unknown Error';
                  }
                }
              } else {
                echo 'FFMpeg is not installed';
              }
            }
          } else {
            http_response_code(415);
            $db -> close();
            exit();
          }

          $insert = $db -> query(
            "INSERT INTO `media`
                        (`name`,
                         `guid`,
                         `thumbnail`,
                         `mimeType`,
                         `created`)
            VALUES      ('$fileName',
                         '$guid',
                         '$thumbnailSrc',
                         '$mimeType',
                         Now());"
          );

          if (!$insert) {
            http_response_code(500);
            if ($db -> error) {
              echo '(' . $db -> errno . '): ' . $db -> error;
            } else {
              echo 'Server error.';
            }
            $db -> close();
            exit();
          }
        } else {
          http_response_code(400);
          echo 'Error: ' . $fileError;
          $db -> close();
          exit();
        }
      } else {
        http_response_code(415);
        $db -> close();
        exit();
      }
      $select =
      "SELECT `id`
      FROM   `media`
      ORDER  BY `id` DESC
      LIMIT  1;";
      $result = $db -> query($select);
      if ($result && $result -> num_rows > 0) {
        while ($row = $result -> fetch_assoc()) {
          $id = $row['id'];
        }
      }
      $idList .= $id;
    }
    http_response_code(200);
    echo $idList;
    $db -> close();
    exit();
  } else {
    http_response_code(400);
    echo 'Missing file[]';
    $db -> close();
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
