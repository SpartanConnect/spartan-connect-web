<?php
  include('includes/include.php');
  include('./includes/auth.php');
  get_header("Admin Panel");
?>
<div class="container">
  <?php if ($_SESSION['authenticated'] && $_SESSION['privlevel'] == 1) { ?>
    <div class="announcement">
      <b class="heading">NOTICE</b>
      <p>You have administrator access! Congrats!</p>
      <a href="index.php">Return to home page.</a><br>
    </div>
  <?php } else { ?>
    <div class="announcement create-announcement">
      <b class="heading">ERROR</b><br>
      <p>You do not have access to this page. Please return to the home page to login with an administrator account.</p>
      <a href="index.php">Return to home page.</a>
    </div>
  <?php } ?>
</div>
<?php get_footer(); ?>
