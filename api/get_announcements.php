<?php
  include("api.php");
  include("../includes/announcements.php");

  // Options:
  // 'announcementIds' => list of announcement ids

  // Universal Variables
  $announcements = get_announcements();                                             // Retrieve all announcements

  $all_announcement_ids = array();                                                  // IDs of all announcements
  $selected_announcement_ids = array();
  $selected_announcements = array();

  $result_end = array();                                                            // Set final results to this variable

  // STAGE 0: Collect all announcements ids
  foreach ($announcements as $announcement) {                                       // TODO: Optimize this entire function
    $all_announcement_ids[] = $announcement['id'];
  }

  if (!empty($_GET['announcementIds'])) {
    $selected_announcement_ids = explode(",", $_GET['announcementIds']);
  } else {
    $selected_announcement_ids = $all_announcement_ids;
  }

  // STAGE 2: Retrieve all announcements based on $selected_announcement_ids

  foreach ($announcements as $announcement) {
    if (in_array($announcement['id'], $selected_announcement_ids)) {
      $announcement['teacherName'] = get_teacher(intval($announcement['teacherID']));
      $announcement['tags'] = get_tags_by_post_id(intval($announcement['id']));
      $tags = [];
      if (!empty($announcement['tags'])){
        foreach ($announcement['tags'] as $tag) {
          $tags[] = $tag['name'];
        }
      }
      $announcement['tagsString'] = implode(", ", $tags);
      array_push($selected_announcements, $announcement);
    }
  }
  $result_end = $selected_announcements;


  // STAGE 3: Returning responses as JSON (see api.php)
  echo_response($result_end);
?>
