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
    <div class="panel-heading-right">
      <button onclick="location.href='create_announcement.php'">+ Create New Announcement</button>
    </div>
  </div>
  <table>
    <thead>
      <tr>
        <th>Title</th>
        <th>Description</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($announcements)) { foreach ($announcements as $announcement) { ?>
      <tr>
        <td style="max-width:240px;">
          <?php if ($announcement['urgent']) { ?>
            <span style="color: #f00; font-size: 0.75em;"><i class="fa fa-flag" aria-hidden="true"></i> AS URGENT</span><br>
          <?php } ?>
          <?php echo $announcement['name']; ?>
          <span class="user-announcement-id">(#<?php echo $announcement['id']; ?>)</span></td>
        <td style="max-width:660px;" class="panel-description">
          <?php echo $announcement['description']; ?>
          <div class="panel-description-btns">
            <button class="small panel-btns-edit" id="panel-btns-edit-<?php echo $announcement['id']; ?>">Edit</button>
            <button class="small panel-btns-delete" id="panel-btns-delete-<?php echo $announcement['id']; ?>">Delete</button>
          </div>
        </td>
      </tr>
      <?php }} else { ?>
      <tr>
        <td style="max-width:250px;">No announcements</td>
        <td style="max-width:650px;">Click on '+ Create New Announcement' to create an announcement.</td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php
    print_dialog_panel_announcement(
      "user-dialog-edit",
      "Edit Announcements",
      null);
    print_dialog_panel_announcement(
      "user-dialog-delete",
      "Delete Announcements",
      "Are you sure you want to delete the following announcements?"
    );
  ?>
  <br>
  <?php } else {
    print_alert_unauthenticated();
  } ?>
</div>
<script src="res/user_panel.min.js"></script>
<?php get_footer(); ?>
