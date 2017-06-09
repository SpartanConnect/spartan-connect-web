<?php
  include('secret.php');

  global $dbc;

  $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=UTF8";
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
  ];
  try {
    $dbc = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
  } catch (PDOException $e) {
    echo "Connection failed: ".$e->getMessage();
  }
?>
