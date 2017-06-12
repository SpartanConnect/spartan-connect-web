<?php
  if (IS_DEVELOPMENT) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);
  } else {
    ini_set('display_errors', 0);
    error_reporting(0);
  }

  function exception_handler($exception) {
    if (IS_DEVELOPMENT) {
      var_dump($exception);
    } else {
      $to = ''; // Receiptant(s) to Receive Error Notifications
      $subject = 'Error @ ' . date('Y-m-d H:i:s');
      $text = 'Date: ' . date('Y-m-d H:i:s') . "\nFile: " . $exception->getFile() . "\nLine: " . $exception->getLine() . "\nMessage: " . $exception->getMessage();
      $text = wordwrap($text, 70);
      $headers = "From: system@"; // Domain

      mail($to, $subject, $text, $headers);
    }
  }
?>
