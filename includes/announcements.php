<?php
  include_once('secret.php');
  include_once('db.php');

  function get_announcements() {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS, array());
  }

  function update_announcement($id, $name, $description, $startDate, $endDate, $eventStartTime, $eventEndTime, $approved = 0, $urgent = 0)
  {
    return perform_query("UPDATE ".DB_TABLE_ANNOUNCEMENTS." SET `urgent`=:urgent, `name`=:name, `description`=:description, `startDate`=:startDate, `endDate`=:endDate, `eventStartTime`=:eventStartTime, `eventEndTime`=:eventEndTime, `approved`=:approved WHERE `id`=:id", array(
      ':id' => $id,
      `:name` => $name,
      `:description` => $description,
      `:startDate` => $startDate,
      `:endDate` => $startDate,
      `:eventStartTime` => $eventStartTime,
      `:eventEndTime` => $eventEndTime,
      ':urgent' => $urgent,
      ':approved' => $approved
    ));
  }

  function get_approved_announcements() {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `approved`=1", array());
  }

  function get_announcement_by_id($id) {
    return perform_query("SELECT * FROM ".DB_TABLE_ANNOUNCEMENTS." WHERE `id` = :id", array(
      ':id' => $id
    ))[0];
  }

  function deny_announcement($id, $reason) {
    $announcement = get_announcement_by_id($id);
    $teacher = get_all_teacher($id);
    $name = $teacher['name'];
    $email = $teacher['email'];
    $announcement_title = $announcement['name'];
    $announcement_description = $announcement['description'];

    $link = LOCAL_URL."user_panel.php";
    $subject = "Rejected Announcement '".$announcement_title."'";
    $body = <<<EOF

===========================

Hello {$name},

We regret to inform you that your announcement '{$announcement_title}' was rejected by an administrator.

Title: {$announcement_title}
Description:
{$announcement_description}

Reason for Denial:
{$reason}

You may edit and resubmit your announcement by going to {$link}.

- Spartan Connect Student Development Team

===========================

Do not reply to this email.
EOF;
    $headers = 'To: '.$name.' '.$email."\r\n".
        'From: studentdevteam@lcusd.net'."\r\n".
        'Reply-To: studentdevteam@lcusd.net'."\r\n".
        'X-Mailer: PHP/'.phpversion();
    mail($email, $subject, $body, $headers);
    perform_query("UPDATE ".DB_TABLE_ANNOUNCEMENTS." SET `approved`=2 WHERE `id` = :id", array(
      ':id' => $id
    ));
  }

  function approve_announcement($id){
    return perform_query("UPDATE ".DB_TABLE_ANNOUNCEMENTS." SET `approved`=1 WHERE `id` = :id", array(
      ':id' => $id
    ));
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

  function get_all_teacher($id){
    return perform_query("SELECT * FROM ".DB_TABLE_TEACHERS." WHERE `id` = :id", array(
      ':id' => $id
    ))[0];
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

  function get_posts_id_by_tag_id($id) {
    return perform_query("SELECT * FROM ".DB_TABLE_TAG_ANNOUNCEMENT." WHERE `tagID` = :tag_id", array(
      ':tag_id' => intval($id)
    ));
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
