<?php
  include('includes/include.php');
  include('./includes/auth.php');
  include('./includes/announcements.php');
  get_header("Admin Panel");
?>
<div class="container">
  <?php if ($_SESSION['authenticated'] && $_SESSION['privlevel'] == 1) { ?>
    <div class="announcement">
      <b class="heading">NOTICE</b>
      <p>You have administrator access! Congrats!</p>
      <a href="index.php">Return to home page.</a><br>
    </div>
    <?php $announcements = get_unapproved_announcements(); ?>
    <h3>Unapproved Announcements</h3>
    <table>
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>
      <?php foreach ($announcements as $announcement) { ?>
      <tr>
        <td><?php echo htmlspecialchars($announcement['name']); ?></td>
        <td><?php echo htmlspecialchars($announcement['description']); ?></td>
        <td class="admin-form" style="width:100px;">
          <div class="action-selectors">
            <i class="round-touch red fa fa-times" aria-hidden="true"></i>
            <i class="round-touch blue fa fa-pencil-square-o" aria-hidden="true"></i>
            <i class="round-touch green fa fa-check" aria-hidden="true"></i>
          </div>
        </td>
      </tr>
      <?php } ?>
    </table>
    <?php foreach ($announcements as $announcement) {?>
      <div class="announcement">
        <b style="heading">UNAPPROVED ANNOUNCEMENT</b><br>
        <small>Posted from <?php echo htmlspecialchars($announcement['startDate'])?> until <?php echo htmlspecialchars($announcement['endDate'])?> by <?php echo htmlspecialchars(get_teacher($announcement['teacherID'])); ?></small>
        <h1><?php echo htmlspecialchars($announcement['name']); ?></h1>
        <p><?php echo htmlspecialchars($announcement['description']); ?></p>
      </div>
    <?php } ?>
  <?php } else { ?>
    <div class="announcement create-announcement">
      <b class="heading">ERROR</b><br>
      <p>You do not have access to this page. Please return to the home page to login with an administrator account.</p>
      <a href="index.php">Return to home page.</a>
    </div>
  <?php } ?>
</div>
<?php get_footer(); ?>
