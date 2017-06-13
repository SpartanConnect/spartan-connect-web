<?php
  include_once('includes/include.php');
  include_once('includes/auth.php');
  include_once('includes/announcements.php');

  get_header("Home Page");
?>
<div class="container">
  <?php if (!$_SESSION['authenticated']) { ?>
    <div class="alert">
      <i class="fa fa-warning"></i>
      <div class="alert-text">
        <b class="heading">CREATE ANNOUNCEMENT</b>
        <p>In order to create an announcement, please log in with a teacher's Google account.</p>
      </div>
    </div>
  <?php } $announcements = get_current_announcements(); ?>
  <h3 style="text-align: center; margin-top: 30px;">Current Announcements</h3>
  <?php foreach ($announcements as $announcement) {?>
  <div class="announcement">
    <small>Posted from <?php echo htmlspecialchars($announcement['startDate']); ?> until <?php echo htmlspecialchars($announcement['endDate']); ?> by <?php echo htmlspecialchars(get_teacher($announcement['teacherID'])); ?></small>
    <h1><?php echo htmlspecialchars($announcement['name']); ?></h1>
    <p><?php echo htmlspecialchars($announcement['description']); ?></p>
  </div>
  <?php } ?>
</div>
<?php get_footer(); ?>
