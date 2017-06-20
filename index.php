<?php
  include_once('includes/include.php');
  include_once('includes/auth.php');
  include_once('includes/announcements.php');

  get_header("Home Page");
  $announcements = get_current_announcements();
?>

<?php if (!empty($announcements)) { ?>
  <div class="announcements-head">
    <div class="announcement-cover" id="announcement-display-<?php echo $announcement['id']; ?>">
      <div class="announcement-cover-titles">
        <h1 class="announcement-name"><?php echo $announcements[0]['name']; ?></h1>
        <p class="announcement-description">
          <?php if (count(explode(" ", $announcements[0]['description'])) <= 20) {
            echo $announcements[0]['description'];
          } else {
            echo implode(" ", array_slice(explode(" ", $announcements[0]['description']), 0, 20))."...";
          } ?>
        </p>
        <b class="heading">READ MORE...</b>
      </div>
    </div>
    <ul class="announcement-head-list">
      <?php foreach (array_slice($announcements, 1, 8) as $announcement) { ?>
      <li><?php echo $announcement['name']; ?></li>
      <? } ?>
      <?php if (count(array_slice($announcements, 1, 8)) < 8) { ?>
      <li>View All Announcements...</li>
      <?php } ?>
    </ul>
  </div>
<?php } ?>

<div class="container">
  <?php
  if (!$_SESSION['authenticated']) {
    print_alert_unauthenticated();
  }
  ?>

  <div id="announcements-container-error">
    <?php print_alert_warning("We could not find an announcement with the selected categories."); ?>
  </div>

  <div id="announcements-container">
    <ul class="announcements-tags">
      <li>ASB</li>
      <li>Sports</li>
      <li>Clubs</li>
      <li>Counseling</li>
      <li>General</li>
      <li>Academics</li>
    </ul>
    <div class="announcements-array">
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
    <script src="res/index_page.min.js"></script>
  </div>

</div>
<?php get_footer(); ?>
