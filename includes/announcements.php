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
    $query = "SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `startDate` <= CURRENT_DATE AND `endDate` >= CURRENT_DATE AND `approved`=1";
    $stmt = $dbc->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  function get_unapproved_announcements() {
    require("db.php");
    $query = "SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `approved`=0";
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

  function get_teacher_id($email) {
    require("db.php");
    $query = "SELECT * FROM ".DB_TABLE_TEACHERS." WHERE email = :email";
    $stmt = $dbc->prepare($query);
    $stmt->execute(array(
      ':email' => $email
    ));
    return $stmt->fetchAll()[0]['id'];
  }

  function create_announcement($title, $description, $teacherID, $start_date, $end_date, $event_date, $event_start, $event_end, $all_day, $urgent) {
    require("db.php");
    $query = "INSERT INTO ".DB_TABLE_ANNOUNCEMENTS." (`name`, `description`, `teacherID`, `startDate`, `endDate`, `eventDate`, `eventStartTime`, `eventEndTime`, `allDay`, `urgent`, `approved`, `timeSubmitted`) VALUES (:name, :description, :teacherID, :startDate, :endDate, :eventDate, :eventStartTime, :eventEndTime, :allDay, :urgent, :approved, CURRENT_TIMESTAMP)";
    $stmt = $dbc->prepare($query);
    $stmt->execute(array(
      ':name' => $title,
      ':description' => $description,
      ':teacherID' => $teacherID,
      ':startDate' => $start_date,
      ':endDate' => $end_date,
      ':eventDate' => $event_date,
      ':eventStartTime' => $event_start,
      ':eventEndTime' => $event_end,
      ':allDay' => $all_day,
      ':urgent' => $urgent,
      ':approved' => 0
    ));
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
?>
