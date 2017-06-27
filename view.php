<?php
  include_once('includes/include.php');
  include_once('includes/auth.php');
  include_once('includes/announcements.php');

  if (!empty($_GET['id'])) {
    $announcement = get_announcement_by_id(intval($_GET['id']));
    if (!empty($announcement)) {
      get_header("Announcement: ".$announcement['name']);
    } else {
      get_header("Announcement Not Found");
    }
  } else {
    get_header("Announcement Not Found");
  }

?>
<div class="view-container">
  <?php if (!empty($announcement)) { ?>
    <div style="margin: 60px 0; max-width: 720px;">

      <h1><?php echo $announcement['name']; ?></h1>
      <ul class="tags-list">
        <?php $tags = get_tags_by_post_id(intval($announcement['id'])); ?>
        <?php if (!empty($tags)) { foreach ($tags as $tag) { ?>
          <li class="announcement-tag"><i class="fa fa-tag"></i> <?php echo $tag['name']; ?></li>
        <?php }} ?>
      </ul>
      <p><?php echo $announcement['description']; ?></p>
      <button onclick="location.href='index.php'">Return to Home Page</button>
    </div>

  <?php } else { ?>
    <center style="margin: 120px 50px;">
      <h1>Could Not Find Announcement</h1>
      <p>We could not find the selected announcement from our archives.</p>
      <p>Why not try returning to the home page?</p>
    </center>
  <?php } ?>
</div>
<?php get_footer(); ?>
