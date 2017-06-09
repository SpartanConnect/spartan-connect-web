<?php
  include('includes/include.php');
  include('./includes/auth.php');
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
  <?php } ?>
  <div class="announcement">
    <small>Posted 6/10-6/14 by Karl Geckle</small>
    <h1>Tech Club Meeting on Friday!</h1>
    <p>Tech Club is meeting this Friday at Lunch. We will be discussing app coding and you will learn how to build a basic website! Be there!</p>
  </div>
</div>
<script src="https://cdn.auth0.com/js/lock/10.16/lock.min.js"></script>
<script>
  var lock = new Auth0Lock('z4LMciYyS8fjmS2SGB4MfMh45fS2C7di', 'spartanconnecttest.auth0.com', {
    auth: {
      redirectUrl: '<?php echo ((IS_DEVELOPMENT ? LOCAL_URL : REMOTE_URL).AUTH0_REDIRECT_URI); ?>',
      responseType: 'code',
      params: {
        scope: 'openid' // Learn about scopes: https://auth0.com/docs/scopes
      }
    }
  });
</script>
<?php get_footer(); ?>
