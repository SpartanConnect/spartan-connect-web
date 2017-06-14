<?php
  include_once('secret.php');
  include_once('db.php');

  function get_announcements() {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS, array());
  }

  function get_approved_announcements() {
    return perform_query("SELECT `name`, `description`, `startDate`, `endDate` FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `approved`=1", array());
  }
  function get_announcement_by_id($id) {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `id` = :id", array(
      ':id' => $id
    ))[0];
  }
  function delete_announcement_by_id($id)
  {
    return perform_query("DELETE FROM ".DB_TABLE_ANNOUNCEMENTS."WHERE `id` = :id");
  }

  function get_current_announcements() {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `startDate` <= CURRENT_DATE AND `endDate` >= CURRENT_DATE AND `approved`=1", array());
  }

  function get_unapproved_announcements() {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `approved` = 0", array());
  }

  function get_teacher_announcements($id) {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `teacherID` = :teacherID AND `approved`=0", array(
      ':teacherID' => intval($id)
    ));
  }

  function get_teacher_all_announcements($id) {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `teacherID` = :teacherID", array(
      ':teacherID' => intval($id)
    ));
  }

  function get_teacher($id) {
    return perform_query("SELECT * FROM ".DB_TABLE_TEACHERS." WHERE `id` = :id", array(
      ':id' => $id
    ))[0]['name'];
  }

  function get_teacher_id($email) {
    return perform_query("SELECT * FROM ".DB_TABLE_TEACHERS." WHERE `email` = :email", array(
      ':email' => $email
    ))[0]['id'];
  }

  function create_announcement($title, $description, $teacherID, $start_date, $end_date, $event_date, $event_start, $event_end, $all_day, $urgent) {
    $result = perform_query("INSERT INTO ".DB_TABLE_ANNOUNCEMENTS." (`name`, `description`, `teacherID`, `startDate`, `endDate`, `eventDate`, `eventStartTime`, `eventEndTime`, `allDay`, `urgent`, `approved`, `timeSubmitted`) VALUES (:name, :description, :teacherID, :startDate, :endDate, :eventDate, :eventStartTime, :eventEndTime, :allDay, :urgent, :approved, CURRENT_TIMESTAMP)", array(
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
      ':approved' => $urgent
    ), false);
    if ($result) {
      return true;
    } else {
      return false;
    }
  }
?>
