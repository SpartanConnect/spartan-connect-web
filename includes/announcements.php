<?php
  include('secret.php');
  include('db.php');

  global $dbc;

  function get_announcements() {
    require("db.php");
    $query = "SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS;
    $stmt = $dbc->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  function get_current_announcements() {
    require("db.php");
    $query = "SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `startDate` <= CURRENT_DATE AND `endDate` >= CURRENT_DATE";
    $stmt = $dbc->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  function get_teacher($id) {
    require("db.php");
    $query = "SELECT * FROM ".DB_TABLE_TEACHERS." WHERE id = :id";
    $stmt = $dbc->prepare($query);
    $stmt->execute(array(
      ':id' => $id
    ));
    return $stmt->fetchAll()[0]['name'];
  }
?>
