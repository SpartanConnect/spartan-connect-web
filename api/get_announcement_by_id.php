<?php
  include("api.php");
  include("../includes/announcements.php");

  $post = null;
  if (!empty($_GET['announcement_id'])) {
    try {
      $post = get_announcement_by_id(intval($_GET['announcement_id']));
      $post['teacherName'] = get_teacher(intval($post['teacherID']));
      $post['tags'] = get_tags_by_post_id(intval($_GET['announcement_id']));
      $tags = [];
      if (!empty($post['tags'])){
        foreach ($post['tags'] as $tag) {
          $tags[] = $tag['name'];
        }
      }
      $post['tagsString'] = implode(", ", $tags);
      if ($_GET['editHTML']) {
        $post['name'] = html_entity_decode(strip_tags($post['name']));
        $post['description'] = html_entity_decode($post['description']);
      }
    } catch (Exception $e) {
      echo 'Caught exception: ',  $e->getMessage(), "\n";
    }
  } else {
    $post = false;
  }

  echo_response($post);
?>
