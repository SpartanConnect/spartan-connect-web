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
  <div class="panel-heading">
    <h3>Unapproved Announcements</h3>
    <select id="admin-actions-list" disabled="disabled">
      <option id="admin-actions-list-default" selected>-- Select an Action --</option>
      <option id="admin-actions-list-approve" class="admin-list-action" value="approve">Approve Announcement</option>
      <option id="admin-actions-list-deny" class="admin-list-action" value="deny">Deny Announcement</option>
      <option id="admin-actions-list-urgent" class="admin-list-action" value="urgent">Set Announcement to Urgent</option>
    </select>
  </div>
  <table>
    <thead>
      <tr>
        <th class="admin-form"><?php print_checkbox("admin-select-all", "all"); ?></th>
        <th>Title</th>
        <th>Description</th>
        <th>Submitted By</th>
        <th>Tags</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($announcements)) { foreach ($announcements as $announcement) { ?>
      <tr id="announcement-row-<?php echo $announcement['id'] ?>">
        <td class="admin-form admin-form-td" style="width:30px;">
          <?php print_checkbox("admin-select-".$announcement['id'], $announcement['id']); ?>
        </td>
        <td style="max-width:150px;">
          <?php if ($announcement['urgent']) { ?>
            <span style="color: #f00; font-size: 0.75em;"><i class="fa fa-flag" aria-hidden="true"></i> AS URGENT</span><br>
          <?php } ?>
          <?php echo $announcement['name'] ?>
          <span class="admin-announcement-id">(#<?php echo $announcement['id']; ?>)</span>
        </td>
        <td style="max-width:450px;"><?php echo $announcement['description'] ?></td>
        <td style="max-width:120px;"><?php echo get_teacher($announcement['teacherID']); ?></td>
        <td style="max-width:200px;">
          <?php
            $announcement_tags = get_tags_by_post_id($announcement['id']);
            if (!empty($announcement_tags)) {
              $tags_string = array();
              foreach ($announcement_tags as $tag) {
                $tags_string[] = $tag['name'];
              }
              $tags_string = implode(', ', $tags_string);
              echo $tags_string;
            } else {
              echo "(none)";
            }
          ?>
        </td>
      </tr>
      <?php }} else { ?>
        <td>(none)</td>
        <td>(none)</td>
        <td>(none)</td>
        <td>(none)</td>
        <td>(none)</td>
      <?php } ?>
    </tbody>
  </table>
  <br>
  <!-- jQuery UI Dialogs -->
  <?php
    print_dialog_panel_announcement(
      "admin-dialog-approve",
      "Approve Announcements",
      "Are you sure you want to approve the following announcements?"
    );
    print_dialog_panel_announcement(
      "admin-dialog-deny",
      "Deny Announcements",
      "Are you sure you want to deny the following announcements?"
    );
    print_dialog_panel_announcement(
      "admin-dialog-urgent",
      "Set Announcements to Urgent",
      "Are you sure you want to set the following announcements to urgent?"
    );
  } else {
    print_alert_noaccess();
  } ?>
</div>
<script src="res/admin_panel.min.js"></script>
<?php get_footer(); ?>
