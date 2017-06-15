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

function refreshAnnouncements(cat) {
  $.ajax({
    method: "GET",
    url: "api/get_announcements.php",
    data: {
      "filters": cat,
      "returnType": "ids"
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
        if (data[i].tags != null) {
          for (id in data[i].tags) {
            $("#announcement-display-"+(i+1)+" .tags-list").append('<li class="announcement-tag">'+data[i].tags[id].name+'</li>');
          }
        } else {
          $("#announcement-display-"+(i+1)+" .tags-list").remove();
        }
      }
    }
  });
}
