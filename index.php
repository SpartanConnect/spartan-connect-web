<?php
  include_once('includes/include.php');
  include_once('includes/auth.php');
  include_once('includes/announcements.php');

  get_header("Home Page");
?>
<div class="container">
  <?php
    if (!$_SESSION['authenticated']) {
      print_alert_unauthenticated();
    }
    $announcements = get_current_announcements();
  ?>
  <h3 style="text-align: center; margin-top: 30px;">Current Announcements</h3>

  <div id="announcements-container">
    <div id="announcements-container-error">
      <?php print_alert_warning("We could not find an announcement with the selected categories."); ?>
    </div>
    <?php if (!empty($announcements)) { foreach ($announcements as $announcement) { ?>
      <div class="announcement" id="announcement-display-<?php echo $announcement['id']; ?>">
        <small>Posted from <span class="announcement-start-date"><?php echo $announcement['startDate']; ?></span> until <span class="announcement-end-date"><?php echo $announcement['endDate']; ?></span> by <span class="announcement-user"><?php echo get_teacher(intval($announcement['teacherID'])); ?></span></small>
        <h1 class="announcement-name"><?php echo $announcement['name']; ?></h1>
        <p class="announcement-description"><?php echo $announcement['description']; ?></p>
        <ul class="tags-list">
        <?php $tags = get_tags_by_post_id(intval($announcement['id'])); ?>
        <?php if (!empty($tags)) { foreach ($tags as $tag) { ?>
          <li class="announcement-tag"><i class="fa fa-tag"></i> <?php echo $tag['name']; ?></li>
        <?php }} ?>
        </ul>
      </div>
    <?php }} else { ?>
      <?php print_alert_warning("There are currently no announcements available to show."); ?>
    <?php } ?>
  </div>

  <div class="announcement-filter hidden">
    <center><button id="announcement-filter-toggle">Show Category Filters</button></center><br><br>
    <div class="announcement-filter-content">
      <label>Filter By</label><br><hr>
      <form>
        <?php $tags_all = get_tags(); ?>
        <div class="filters-list">
        <?php foreach ($tags_all as $tag) { ?>
          <div class="filter-list" id="filter-list">
            <label class="filter-list-text"><?php echo $tag['name']; ?></label>
            <?php print_checkbox("tag-search-".$tag['id'], $tag['id']); ?>
          </div>
        <?php } ?>
        </div>
        <div style="float: right; margin: 10px 0;">
          <button class="small" id="filter-list-select-all">Select All</button>
          <button class="small" id="filter-list-search">Search</button>
        </div>
        <br>
      </form><br>
      <center>
        <button class="download" onclick="window.open('download.php')">Download All Announcements</button>
      </center>
    </div>
    <script src="index.js"></script>
  </div>
</div>
<?php get_footer(); ?>
