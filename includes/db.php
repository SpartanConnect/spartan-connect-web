<?php
  include_once('secret.php');
  include_once('errors.php');

  $dbc = null;

  $dsn = "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=UTF8";
  $options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
  ];

  // Setup PDO connection
  try {
    $dbc = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
  } catch (PDOException $e) {
    echo "Connection failed: ".$e->getMessage();
  }

  function perform_query($queryString, $parameters, $selecting = true) {
    global $dbc;
    try {
      $query = $dbc->prepare($queryString);
      $query->execute($parameters);

      if ($query->rowCount()) {
        $row = $query->fetchAll();
        if ($selecting) {
          return $row;
        } else {
          return $query->rowCount();
        }
      } else {
        return null;
      }
    } catch(PDOException $e) {
      exception_handler($e);
    }
  }

  function get_last_inserted_id() {
    global $dbc;
    try {
      return $dbc->lastInsertId();
    } catch (PDOException $e) {
      exception_handler($e);
    }
  }
?>
