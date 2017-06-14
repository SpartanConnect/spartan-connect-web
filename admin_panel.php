<?php
  include('includes/include.php');
  include('./includes/auth.php');
  include('./includes/announcements.php');
  get_header("Admin Panel");
?>
<div class="container">
  <?php
  if ($_SESSION['authenticated'] && $_SESSION['privlevel'] == 1) {
    print_alert_info(
      "Welcome to the admin panel. Here, you can approve, deny, and edit announcements."
    );
    $announcements = get_unapproved_announcements();
  ?>
  <h3>Unapproved Announcements</h3>
  <table>
    <tr>
      <th>Title</th>
      <th>Description</th>
      <th>Actions</th>
    </tr>
    <?php foreach ($announcements as $announcement) { ?>
    <tr>
      <td style="max-width:250px;"><?php echo htmlspecialchars($announcement['name']); ?> <span class="admin-announcement-id">(#<?php echo $announcement['id']; ?>)</span></td>
      <td style="max-width:610px;"><?php echo htmlspecialchars($announcement['description']); ?></td>
      <td class="admin-form" style="width:100px;">
        <div class="action-selectors">
          <i id="admin-deny-<?php echo $announcement['id']; ?>" class="round-touch red fa fa-times admin-deny" aria-hidden="true"></i>
          <i id="admin-edit-<?php echo $announcement['id']; ?>" class="round-touch blue fa fa-pencil-square-o admin-edit" aria-hidden="true"></i>
          <i id="admin-approve-<?php echo $announcement['id']; ?>" class="round-touch green fa fa-check admin-approve" aria-hidden="true"></i>
        </div>
      </td>
    </tr>
    <?php } ?>
  </table>
  <br>
  <!-- jQuery UI Dialogs -->
  <?php
    print_dialog_panel_announcement(
      "admin-dialog-approve",
      "Approve Announcement",
      "Are you sure you want to approve this announcement?"
    );
    print_dialog_panel_announcement(
      "admin-dialog-deny",
      "Deny Announcement",
      "Are you sure you want to deny this announcement?"
    );
    print_dialog_panel_announcement(
      "admin-dialog-edit",
      "Edit Announcement",
      null,
      '<form>
        <label>Is Urgent:</label> <input name="urgent" type="checkbox" value="yes"/><br><br>
        <input name="submit" type="submit" value="Submit"/>
      </form>'
    );
  } else {
    print_alert_noaccess();
  } ?>
</div>
<script src="admin_panel.js"></script>
<?php get_footer(); ?>
