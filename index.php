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
  <div class="announcement" id="announcement-display-0" style="display: none;">
    <small>Posted from <span class="announcement-start-date">Loading</span> until <span class="announcement-end-date">Loading</span> by <span class="announcement-user">Loading</span></small>
    <h1 class="announcement-title">Loading Announcement Title</h1>
    <p class="announcement-description">Loading Announcement Description</p>
    <ul class="tags-list"></ul>
  </div>
  <div id="announcements-container"></div>

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
      <button class="download" onclick="window.open('download.php')">Download All Announcements</button>
    </div>
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

      $("#filter-list-search").click(function(e) {
        e.preventDefault();
        var categories = [];
        $('#filter-list :checked').each(function() {
          categories.push($(this).val());
        });
        categories = categories.join(",");
        refreshAnnouncements(categories);
      });

      var filterToggled = false;

      $("#announcement-filter-toggle").click(function(e) {
        $(".announcement-filter").toggleClass("hidden");
        if (filterToggled) {
          $("#announcement-filter-toggle").text("Show Category Filters");
          filterToggled = false;
        } else {
          $("#announcement-filter-toggle").text("Hide Category Filters");
          filterToggled = true;
        }
      });

      $(document).ready(function(){
        refreshAnnouncements('');
      });

      function refreshAnnouncements(cat) {
        $.ajax({
          method: "GET",
          url: "api/get_announcements.php",
          data: {
            "filters": cat
          },
          dataType: "json"
        }).done(function(data) {
          if (data.length == 0) {
            $('#announcements-container').html('<?php print_alert_warning("We could not find an announcement with the selected categories.", "WARNING", null, true) ?>');
          } else {
            $('#announcements-container').html('');
            for (i = 0; i < data.length; i++) {
              // Handle Display
              $("#announcement-display-0").clone().prop('id', 'announcement-display-'+(i+1)).prop('style','').appendTo('#announcements-container');
              $("#announcement-display-"+(i+1)+" .announcement-start-date").text(data[i].startDate);
              $("#announcement-display-"+(i+1)+" .announcement-end-date").text(data[i].endDate);
              $("#announcement-display-"+(i+1)+" .announcement-user").text(data[i].teacherName);
              $("#announcement-display-"+(i+1)+" .announcement-title").html(data[i].name);
              $("#announcement-display-"+(i+1)+" .announcement-description").html(data[i].description);

              // Handle Tags
              console.log(data[i].tags);
              if (data[i].tags != null) {
                for (id in data[i].tags) {
                  console.log(data[i].tags[id]);
                  $("#announcement-display-"+(i+1)+" .tags-list").append('<li class="announcement-tag">'+data[i].tags[id].name+'</li>');
                }
              } else {
                $("#announcement-display-"+(i+1)+" .tags-list").remove();
              }
            }
          }
        });
      }
    </script>
  </div>
</div>
<?php get_footer(); ?>
