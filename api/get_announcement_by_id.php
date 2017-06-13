<?php
  include("api.php");
  include("../includes/announcements.php");

  $post = null;
  if (!empty($_GET['announcement_id'])) {
    try {
      $post = get_announcement_by_id(intval($_GET['announcement_id']));
      $post['teacherName'] = get_teacher(intval($post['teacherID']));
    } catch (Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  } else {
    $post = false;
  }

  echo_response($post);
?>
