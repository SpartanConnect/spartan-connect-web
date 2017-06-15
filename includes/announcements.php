<?php
  include_once('secret.php');
  include_once('db.php');

  function get_announcements() {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS, array());
  }

  function get_approved_announcements() {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `approved`=1", array());
  }
  function get_announcement_by_id($id) {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `id` = :id", array(
      ':id' => $id
    ))[0];
  }

  function delete_announcement_by_id($id) {
    return perform_query("DELETE FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `id` = :id", array());
  }

  function get_current_announcements() {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `startDate` <= CURRENT_DATE AND `endDate` >= CURRENT_DATE AND `approved`=1 ORDER BY `timeSubmitted` DESC", array());
  }

  function get_unapproved_announcements() {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `approved` = 0", array());
  }

  function get_teacher_announcements($id) {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `teacherID` = :teacherID", array(
      ':teacherID' => intval($id)
    ));
  }

  function get_teacher_approved_announcements($id, $approved = 0) {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `teacherID` = :teacherID AND `approved`=:approved", array(
      ':teacherID' => intval($id),
      ':approved' => intval($approved)
    ));
  }

  function get_teacher($id) {
    return perform_query("SELECT * FROM ".DB_TABLE_TEACHERS." WHERE `id` = :id", array(
      ':id' => $id
    ))[0]['name'];
  }

  function get_teacher_email($id) {
    return perform_query("SELECT * FROM ".DB_TABLE_TEACHERS." WHERE `id` = :id", array(
      ':id' => $id
    ))[0]['email'];
  }


  function get_teacher_id($email) {
    return perform_query("SELECT * FROM ".DB_TABLE_TEACHERS." WHERE `email` = :email", array(
      ':email' => $email
    ))[0]['id'];
  }

  function get_tags() {
    return perform_query("SELECT * FROM ".DB_TABLE_TAGS, array());
  }

  function get_tag_id_by_slug($slug) {
    return perform_query("SELECT * FROM ".DB_TABLE_TAGS." WHERE `slug` = :slug", array(
      ':slug' => $slug
    ))[0]['id'];
  }

  function get_tag_by_id($id) {
    return perform_query("SELECT * FROM ".DB_TABLE_TAGS." WHERE `id` = :id", array(
      ':id' => $id
    ))[0];
  }

  function get_tags_by_post_id($id) {
    $results = perform_query("SELECT * FROM ".DB_TABLE_TAG_ANNOUNCEMENT." WHERE `announcementID` = :announcement_id", array(
      ':announcement_id' => intval($id)
    ));
    if (!empty($results)) {
      $tags = array();
      foreach ($results as $tag) {
        array_push($tags, get_tag_by_id($tag['tagID']));
      }
      return $tags;
    } else {
      return null;
    }
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
      return get_last_inserted_id();
    } else {
      return false;
    }
  }

  function update_announcement_tags($id, $tags = array()) {
    if (!empty($tags)) {
      foreach ($tags as $tag) {
        $result = perform_query("INSERT INTO ".DB_TABLE_TAG_ANNOUNCEMENT." (`announcementID`, `tagID`) VALUES (:announcement_id, :tag_id)", array(
          ':announcement_id' => intval($id),
          ':tag_id' => intval($tag)
        ));
      }
    } else {
      return false;
    }
  }
?>
