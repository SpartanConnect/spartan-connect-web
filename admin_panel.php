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
      <p>Welcome to the admin panel. Here, you can approve, deny, and edit announcements.</p>
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
        <td><?php echo htmlspecialchars($announcement['name']); ?> <span class="admin-announcement-id">(#<?php echo $announcement['id']; ?>)</span></td>
        <td><?php echo htmlspecialchars($announcement['description']); ?></td>
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
    <div id="admin-dialog-approve" class="dialog" title="Approve Announcement">
      <p>Are you sure you want to approve this announcement?</p>
      <div class="announcement">
        <h1 id="admin-dialog-approve-heading">Loading Announcement...</h1>
        <p id="admin-dialog-approve-description">Loading Announcement...</p>
      </div>
    </div>
    <div id="admin-dialog-deny" class="dialog" title="Deny Announcement">
      <p>Are you sure you want to deny this announcement? This will send an email notification to the teacher.</p>
      <div class="announcement">
        <h1 id="admin-dialog-deny-heading">Loading Announcement...</h1>
        <p id="admin-dialog-deny-description">Loading Announcement...</p>
      </div>
    </div>
    <div id="admin-dialog-edit" class="dialog" title="Edit Announcement">
      <div class="announcement">
        <h1 id="admin-dialog-edit-heading">Loading Announcement...</h1>
        <p id="admin-dialog-edit-description">Loading Announcement...</p>
      </div>
      <form>
        <label>Is Urgent:</label> <input name="urgent" type="checkbox" value="yes"/><br><br>
        <input name="submit" type="submit" value="Submit"/>
      </form>
    </div>
  <?php } else { ?>
    <div class="announcement create-announcement">
      <b class="heading">ERROR</b><br>
      <p>You do not have access to this page. Please return to the home page to login with an administrator account.</p>
      <a href="index.php">Return to home page.</a>
    </div>
  <?php } ?>
</div>
<script src="admin_panel.js"></script>
<?php get_footer(); ?>
