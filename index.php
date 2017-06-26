<?php
  include_once('includes/include.php');
  include_once('includes/auth.php');
  include_once('includes/announcements.php');

  get_header("Home Page");
  $announcements = get_current_announcements();
?>

<?php if (!empty($announcements)) { ?>
  <div class="announcements-head">
    <div class="announcement-cover">
      <div class="announcement-cover-titles">
        <h1 class="announcement-name article-redirect" onclick="location.href = 'view.php?id=<?php echo $announcements[0]['id']; ?>'">
          <?php
          if ($announcements[0]['urgent']) {
            echo '[<i class="fa fa-circle" aria-hidden="true"></i> URGENT] ';
          }
          echo $announcements[0]['name'];
          ?>
        </h1>
        <p class="announcement-description">
          <?php if (count(explode(" ", $announcements[0]['description'])) <= 20) {
            echo $announcements[0]['description'];
          } else {
            echo implode(" ", array_slice(explode(" ", $announcements[0]['description']), 0, 20))."...";
          } ?>
        </p>
        <b class="heading article-redirect" onclick="location.href = 'view.php?id=<?php echo $announcements[0]['id']; ?>'">READ MORE...</b>
      </div>
    </div>
    <ul class="announcement-head-list">
      <?php foreach (array_slice($announcements, 1, 8) as $announcement) { ?>
      <li onclick="location.href = 'view.php?id=<?php echo $announcement['id']; ?>'">
        <?php
        if ($announcement['urgent']) {
          echo '<i class="fa fa-circle" aria-hidden="true" style="font-size: 12px; vertical-align: text-top;"></i> ';
        }
        if (strlen($announcement['name']) > 35) {
          echo substr($announcement['name'], 0, 35)."...";
        } else {
          echo $announcement['name'];
        }
        ?>
      </li>
      <? } ?>
      <?php if (count(array_slice($announcements, 1, 8)) < 8) { ?>
      <li onclick="location.href = '#announcements-array'">View All Announcements...</li>
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

  <div id="announcements-container">
    <?php $all_tags = get_tags(); ?>
    <ul class="announcements-tags">
      <?php foreach (array_slice($all_tags, 0, 6) as $tag) { ?>
        <li value="<?php echo $tag['id']; ?>"><?php echo $tag['name']; ?></li>
      <?php } ?>
    </ul>

    <div id="announcements-container-error">
      <?php print_alert_warning("We could not find an announcement with the selected categories."); ?>
    </div>

    <div id="announcements-array" class="announcements-array">
      <?php if (!empty($announcements)) { foreach ($announcements as $announcement) { ?>
        <div class="announcement" id="announcement-display-<?php echo $announcement['id']; ?>" onclick="location.href = 'view.php?id=<?php echo $announcement['id']; ?>'">
          <ul class="tags-list">
            <?php $tags = get_tags_by_post_id(intval($announcement['id'])); ?>
            <?php if (!empty($tags)) { foreach ($tags as $tag) { ?>
              <li class="announcement-tag"><i class="fa fa-tag"></i> <?php echo $tag['name']; ?></li>
            <?php }} ?>
          </ul>
          <h1 class="announcement-name article-redirect"><?php echo $announcement['name']; ?></h1>
          <p class="announcement-description">
            <?php if (count(explode(" ", $announcement['description'])) <= 25) {
              echo $announcement['description'];
            } else {
              echo implode(" ", array_slice(explode(" ", $announcement['description']), 0, 25))."...";
            } ?>
            <b class="heading article-redirect" onclick="location.href = 'view.php?id=<?php echo $announcement['id']; ?>'">READ MORE</b>
          </p>
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
