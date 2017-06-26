<?php
  include_once('includes/include.php');
  include_once('includes/auth.php');
  include_once('includes/announcements.php');

  get_header("User Panel");
?>
<div class="container">
  <?php if ($_SESSION['authenticated']) {
    print_alert_info("Welcome to the user panel. Here, you can create and edit announcements.");
    $announcements = array_merge(
      get_teacher_approved_announcements($_SESSION['teacherID'], 0),
      get_teacher_approved_announcements($_SESSION['teacherID'], 2)
    );
  ?>
  <div class="panel-heading">
    <h3>Your Announcements</h3>
    <button onclick="location.href='create_announcement.php'">+ Create New Announcement</button>
  </div>
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($announcements)) { foreach ($announcements as $announcement) { ?>
      <tr>
        <td style="max-width:250px;">
          <?php if ($announcement['urgent']) { ?>
            <span style="color: #f00; font-size: 0.75em;"><i class="fa fa-flag" aria-hidden="true"></i> AS URGENT</span><br>
          <?php } ?>
          <?php echo $announcement['name']; ?>
          <span class="user-announcement-id">(#<?php echo $announcement['id']; ?>)</span></td>
        <td style="max-width:650px;"><?php echo $announcement['description']; ?></td>
        <td class="user-form" style="width:60px;">
          <div class="action-selectors">
            <i id="user-deny-<?php echo $announcement['id']; ?>" class="round-touch red fa fa-times user-deny" aria-hidden="true"></i>
            <i id="user-edit-<?php echo $announcement['id']; ?>" class="round-touch blue fa fa-pencil-square-o user-edit" aria-hidden="true"></i>
          </div>
        </td>
      </tr>
      <?php }} else { ?>
      <tr>
        <td style="max-width:250px;">No announcements</td>
        <td style="max-width:650px;">Click on '+ Create New Announcement' to create an announcement.</td>
        <td class="user-form" style="width:60px;"></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <br>
  <?php } else {
    print_alert_unauthenticated();
  } ?>
</div>
<?php get_footer(); ?>
