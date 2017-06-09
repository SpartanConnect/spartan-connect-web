<?php
  include('includes/include.php');
  include('includes/auth.php');
  include('includes/announcements.php');

  get_header("Home Page");
?>
<div class="container">
  <?php if ($_SESSION['authenticated']) { ?>
    <div class="announcement">
      <b class="heading">NOTICE</b>
      <p>You are already logged in.</p>
      <a href="create_announcement.php">Go to create an announcement.</a><br>
      <?php if ($_SESSION['privlevel'] == 1) {?><a href="admin_panel.php">Go to admin panel.</a><br><?php } ?>
      <a href="logout.php">Log out of your account.</a>
    </div>
  <?php } else { ?>
    <div class="announcement">
      <b class="heading">CREATE ANNOUNCEMENT</b>
      <p>In order to create an announcement, please sign in with a teacher's Google account.</p>
      <button onclick="lock.show();">Login with Google</button>
    </div>
  <?php } $announcements = get_current_announcements(); ?>
  <?php foreach ($announcements as $announcement) {?>
  <div class="announcement">
    <small>Posted from <?php echo $announcement['startDate']?> until <?php echo $announcement['endDate']?> by <?php echo get_teacher($announcement['teacherID']); ?></small>
    <h1><?php echo $announcement['name']; ?></h1>
    <p><?php echo $announcement['description']; ?></p>
  </div>
  <?php } ?>
</div>
<script src="https://cdn.auth0.com/js/lock/10.16/lock.min.js"></script>
<script>
  var lock = new Auth0Lock('<?php echo AUTH0_CLIENT_ID; ?>', '<?php echo AUTH0_DOMAIN; ?>', {
    auth: {
      redirectUrl: '<?php echo ((IS_DEVELOPMENT ? LOCAL_URL : REMOTE_URL).AUTH0_REDIRECT_URI); ?>',
      responseType: 'code',
      params: {
        scope: 'openid'
      }
    }
  });
</script>
<?php get_footer(); ?>
