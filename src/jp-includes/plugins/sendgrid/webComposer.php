<?php
/*
Fork of ahsankhatri/webComposer.php
*/

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/../../app/variables.php';

use Composer\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput as Output;
use Symfony\Component\Console\Output\OutputInterface;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update-sendgrid'])) {

    $allowedCommands = [
      'update',
      'install',
      'dump-autoload',
      'dump-autoload -o',
    ];

    $cmdRaw = base64_decode($_POST['cmd']);

    if (!in_array($cmdRaw, $allowedCommands)) {
      http_response_code(400);
      exit();
    }

    $cmdRawArray = explode(' ', $cmdRaw);
    $inputArray = ['command' => array_shift($cmdRawArray) ] + $cmdRawArray;

    ini_set('memory_limit', '1G');
    set_time_limit(300); // 5 minutes execution

    $isDebug = isset($_POST['debug']) ? true : false;

    // set COMPOSER_HOME environment
    putenv('COMPOSER_HOME=' . __DIR__ . '/vendor/bin/composer');

    $output = new Output(
      $isDebug ? OutputInterface::VERBOSITY_DEBUG : OutputInterface::VERBOSITY_NORMAL
    );

    $input = new ArrayInput( $inputArray );
    $application = new Application();
    $application->setAutoExit(false);
    $application->run($input, $output);

    echo $output->fetch();
    //
    // function showOptions($allowedCommands) {
    //     $buttons = [];
    //     foreach ($allowedCommands as $cmd) {
    //         $buttons[] = '<button type="button" onclick="window.location=\'' . $_SERVER['SCRIPT_NAME'] . '?cmd=' . base64_encode($cmd) . '\'">composer ' . $cmd . '</button>';
    //     }
    //
    //     echo implode('&nbsp;', $buttons) . '<hr>';
    // }


  } else {
    http_response_code(400);
    exit();
  }
} else {
  header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found", true, 404);
  include APP_ROOT . '/404.php';
  exit();
}
