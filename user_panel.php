<?php
  include_once('includes/include.php');
  include_once('includes/auth.php');
  include_once('includes/announcements.php');

  get_header("User Panel");
?>
<div class="container">
  <?php if ($_SESSION['authenticated']) { ?>
    <div class="alert">
      <i class="fa fa-info-circle"></i>
      <div class="alert-text">
        <b class="heading">NOTICE</b>
        <p>Welcome to the user panel. Here, you can create and edit announcements.</p>
      </div>
    </div>
    <?php $announcements = get_teacher_announcements($_SESSION['teacherID']); ?>
    <div class="panel-heading">
      <h3>Your Announcements</h3>
      <button onclick="location.href='create_announcement.php'">+ Create New Announcement</button>
    </div>
    <table>
      <tr>
        <th>Title</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>
      <?php foreach ($announcements as $announcement) { ?>
      <tr>
        <td style="max-width:250px;"><?php echo htmlspecialchars($announcement['name']); ?> <span class="user-announcement-id">(#<?php echo $announcement['id']; ?>)</span></td>
        <td style="max-width:650px;"><?php echo htmlspecialchars($announcement['description']); ?></td>
        <td class="user-form" style="width:60px;">
          <div class="action-selectors">
            <i id="user-deny-<?php echo $announcement['id']; ?>" class="round-touch red fa fa-times user-deny" aria-hidden="true"></i>
            <i id="user-edit-<?php echo $announcement['id']; ?>" class="round-touch blue fa fa-pencil-square-o user-edit" aria-hidden="true"></i>
          </div>
        </td>
      </tr>
      <?php } ?>
    </table>
    <br>
  <?php } else { ?>
    <div class="alert">
      <i class="fa fa-warning"></i>
      <div class="alert-text">
        <b class="heading">CREATE ANNOUNCEMENT</b>
        <p>In order to create an announcement, please sign in with a teacher's Google account.</p>
        <button onclick="lock.show();">Login with Google</button>
      </div>
    </div>
  <?php }?>
</div>
<?php get_footer(); ?>
