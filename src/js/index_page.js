var filterToggled = false;
var isSelected = false;
var isLoading = false;

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
  if (!isLoading) {
    var categories = [];
    $('#filter-list :checked').each(function() {
      categories.push($(this).val());
    });
    categories = categories.join(",");
    refreshAnnouncements(categories);
    $("#filter-list-search").text("Loading...").attr('disabled', true);
  }
});

$(document).ready(function(){
  $("#announcements-container-error").hide();
});

function refreshAnnouncements(cat) {
  isLoading = true;
  $.ajax({
    method: "GET",
    url: "api/get_current_announcements.php",
    data: {
      "filters": cat,
      "returnType": "ids"
    },
    dataType: "json"
  }).done(function(data) {
    if (data.length === 0) {
      $("#announcements-container .announcement").hide();
      $("#announcements-container-error").show();
    } else {
      $("#announcements-container .announcement").hide();
      $("#announcements-container-error").hide();
      for (var announcement_id in data) {
        $("#announcement-display-"+data[announcement_id]).show();
      }
    }
    isLoading = false;
    $("#filter-list-search").text("Search").attr('disabled', false);
  });
}
