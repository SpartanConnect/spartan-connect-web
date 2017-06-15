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
  <?php foreach ($announcements as $announcement) {?>
  <div class="announcement">
    <small>Posted from <?php echo htmlspecialchars($announcement['startDate']); ?> until <?php echo htmlspecialchars($announcement['endDate']); ?> by <?php echo htmlspecialchars(get_teacher($announcement['teacherID'])); ?></small>
    <h1><?php echo $announcement['name']; ?></h1>
    <p><?php echo $announcement['description']; ?></p>
    <?php $tags = get_tags_by_post_id($announcement['id']); ?>
    <?php if (!empty($tags)) {?>
    <ul class="tags-list">
      <?php foreach ($tags as $tag) { ?>
        <li class="announcement-tag"><?php echo $tag['name']; ?></li>
      <?php }?>
    </ul>
    <?php } ?>
  </div>
  <?php } ?>
  <div class="announcement-filter">
    <label>Filter By</label><br><hr>
    <form>
      <?php $tags_all = get_tags(); ?>
      <?php foreach ($tags_all as $tag) { ?>
        <div class="filter-list">
          <label class="filter-list-text"><?php echo $tag['name']; ?></label>
          <?php print_checkbox("tag-search-".$tag['id'], $tag['id']); ?>
        </div>
      <?php } ?>
      <div style="float: right; margin: 10px 0;">
        <button class="small" id="filter-list-select-all">Select All</button>
        <button class="small">Search</button>
      </div>
      <br>
    </form><br>
    <button class="download" onclick="window.open('download.php')">Download All Announcements</button>
    <script>
      var isSelected = false;
      $("#filter-list-select-all").click(function(e) {
        e.preventDefault();
        if (!isSelected) {
          $(".filter-list input[type='checkbox']").prop('checked', 'checked');
          $("#filter-list-select-all").text("Deselect All");
          isSelected = true;
        } else {
          $(".filter-list input[type='checkbox']").prop('checked', '');
          $("#filter-list-select-all").text("Select All");
          isSelected = false;
        }
      });
    </script>
  </div>
</div>
<?php get_footer(); ?>
