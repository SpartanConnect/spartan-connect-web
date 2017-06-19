<?php
  include("api.php");
  include("../includes/announcements.php");

  // Options:
  // 'filters=[...]' => list of tag ids in commas
  // 'returnType' => returns either full announcements (old + slow, default) or announcement ids (optimized)

  // Universal Variables
  $current_announcements = get_current_announcements();                             // Retrieve all current announcements

  $selected_announcement_ids = array();                                             // Used by STAGE 1: Collect all announcement ids into one array ($selected_announcement_ids)
  $selected_announcements = array();                                                // Used by STAGE 2: Retrieve all announcements based on $selected_announcement_ids
  $current_announcement_ids = array();                                              // IDs of all current announcements

  $result_end = array();                                                            // Set final results to this variable

  // STAGE 0: Collect all current announcements ids
  foreach ($current_announcements as $announcement) {                               // TODO: Optimize this entire function
    $current_announcement_ids[] = $announcement['id'];
  }

  // STAGE 1: Collect all announcement ids with the selected tags into one array ($selected_announcement_ids)
  if (!empty($_GET['filters'])) {
    try {
      $filters = explode(",", $_GET['filters']);                                    // Split $_GET['filters'] into an array of tag ids

      // Go through each selected tag and collect post ids
      foreach ($filters as $filter) {                                               // TODO: Optimize this entire function
        $result = get_posts_id_by_tag_id(intval($filter));                          // Returns the announcements that have a certain tag
        if ($result) {
          foreach ($result as $post) {                                              // Loops through each post with the certain tag
            if (!in_array($post['announcementID'], $selected_announcement_ids)) {   // Do not put more than one of the same post id!
              $selected_announcement_ids[] = $post['announcementID'];               // Push each announcement id into $selected_announcement_ids
            }
          }
        }
      }

      // Filter out non-currenct announcements
      $selected_announcement_ids = array_intersect($current_announcement_ids, $selected_announcement_ids);

    } catch (Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  } else {
    $selected_announcement_ids = $current_announcement_ids;
  }

  // STAGE 2: Retrieve all announcements based on $selected_announcement_ids
  switch ($_GET['returnType']) {
    case 'ids':
      $result_end = $selected_announcement_ids;
      break;
    default:
      foreach ($current_announcements as $announcement) {
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
      break;
  }

  // STAGE 3: Returning responses as JSON (see api.php)
  echo_response($result_end);
?>
