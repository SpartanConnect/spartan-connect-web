<?php
  include("api.php");
  include("../includes/announcements.php");

  $posts = array();
  $post_ids = array();
  if (!empty($_GET['filters'])) {
    try {
      $filters = explode(",", $_GET['filters']);
      $selected_announcements = array();
      $announcements = get_current_announcements();

      // Go through filters provided and collect post ids
      foreach ($filters as $filter) {
        $result = get_posts_id_by_tag_id(intval($filter));

        if ($result) {
          foreach ($result as $post) {
            if (!in_array($post['announcementID'], $post_ids)) {
              array_push($post_ids, $post['announcementID']);
            }
          }
        }
      }

      // Collect posts from post ids
      foreach ($announcements as $announcement) {
        if (in_array($announcement['id'], $post_ids)) {
          $announcement['teacherName'] = get_teacher(intval($announcement['teacherID']));
          $announcement['tags'] = get_tags_by_post_id(intval($announcement['id']));
          array_push($posts, $announcement);
        }
      }
    } catch (Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  } else {
    $announcements = array();
    $announcements_get = get_current_announcements();
    foreach ($announcements_get as $announcement) {
      $announcement['teacherName'] = get_teacher(intval($announcement['teacherID']));
      $announcement['tags'] = get_tags_by_post_id(intval($announcement['id']));
      array_push($announcements, $announcement);
    }
    $posts = $announcements;
  }

  echo_response($posts);
?>
