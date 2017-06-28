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

$(".announcements-tags li").click(function () {
  refreshAnnouncements(parseInt($(this).attr('value')));
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

function onSignIn(googleUser) {
  var profile = googleUser.getBasicProfile();
  console.log('ID: ' + profile.getId()); // Do not send to your backend! Use an ID token instead.
  console.log('Name: ' + profile.getName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail()); // This is null if the 'email' scope is not present.
}

function signOut() {
  var auth2 = gapi.auth2.getAuthInstance();
  auth2.signOut().then(function () {
    console.log('User signed out.');
  });
}

function onSignIn(googleUser) {
  var id_token = googleUser.getAuthResponse().id_token;
  var xhr = new XMLHttpRequest();
  xhr.open('POST', 'localhost:8888/spartan-connect-web/includes/OAuthToken.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    console.log('Signed in as: ' + xhr.responseText);
  };
  xhr.send('idtoken=' + id_token);
}
