<?php
  // Import all constants
  include('constants.php');
  include('secret.php');

  include('header.php');

  if (IS_DEVELOPMENT) {
    ini_set('display_errors', 1);
    error_reporting(E_ALL & ~E_NOTICE);
  } else {
    ini_set('display_errors', 0);
    error_reporting(0);
  }
?>
