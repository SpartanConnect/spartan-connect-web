<?php
  include_once('includes/include.php');
  include_once('includes/auth.php');
  include_once('includes/announcements.php');

  get_header("Home Page");
?>
<div class="container">
  <?php
    if (!$_SESSION['authenticated']) {
      print_alert_unauthenticated();
    }
    $announcements = get_current_announcements();
  ?>
  <h3 style="text-align: center; margin-top: 30px;">Current Announcements</h3>
  <center><button class="download" onclick="window.open('download.php')">Download All Announcements</button></center>
  <?php foreach ($announcements as $announcement) {?>
  <div class="announcement">
    <small>Posted from <?php echo htmlspecialchars($announcement['startDate']); ?> until <?php echo htmlspecialchars($announcement['endDate']); ?> by <?php echo htmlspecialchars(get_teacher($announcement['teacherID'])); ?></small>
    <h1><?php echo $announcement['name']; ?></h1>
    <p><?php echo $announcement['description']; ?></p>
    <?php $tags = get_tags_by_post_id($announcement['id']); ?>
    <?php if (!empty($tags)) {?>
    <ul class="tags-list">
      <?php foreach ($tags as $tag) { ?>
        <li class="announcement-tag"><?php echo $tag['name']; ?></li>
      <?php }?>
    </ul>
    <?php } ?>
  </div>
  <?php } ?>
</div>
<?php get_footer(); ?>
