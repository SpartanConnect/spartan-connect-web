$(document).ready(function() {
  approve_dialog = $("#admin-dialog-approve").dialog({
    autoOpen: false,
    resizable: false,
    height: "auto",
    width: 600,
    modal: true,
    closeOnEscape: false,
    buttons: {
      Cancel: function() {
        closeOutDialog();
        $(this).dialog("close");
      },
      "Approve Announcements": function() {
        removeCurrentAnnouncements();
        closeOutDialog();
        $(this).dialog("close");
      }
    }
  });
  deny_dialog = $("#admin-dialog-deny").dialog({
    autoOpen: false,
    resizable: false,
    height: "auto",
    width: 600,
    modal: true,
    closeOnEscape: false,
    buttons: {
      Cancel: function() {
        closeOutDialog();
        $(this).dialog("close");
      },
      "Deny Announcements": function() {
        removeCurrentAnnouncements();
        closeOutDialog();
        $(this).dialog("close");
      }
    }
  });
  urgent_dialog = $("#admin-dialog-urgent").dialog({
    autoOpen: false,
    resizable: false,
    height: "auto",
    width: 600,
    modal: true,
    closeOnEscape: false,
    buttons: {
      Cancel: function() {
        closeOutDialog();
        $(this).dialog("close");
      },
      "Set Announcements to Urgent": function() {
        removeCurrentAnnouncements();
        closeOutDialog();
        $(this).dialog("close");
      }
    }
  });

  function removeCurrentAnnouncements() {
    for (var announce in selectedAnnouncements) {
      $("#announcement-row-"+selectedAnnouncements[announce]).remove();
    }
    $(".admin-form input[type='checkbox']").prop('checked', false);
    selectedAnnouncements = [];
    if ($(".admin-form-td input[type='checkbox']").length === 0) {
      location.reload();
    }
  }

  function closeOutDialog() {
    $(".admin-list-action").prop('selected', false);
    $("#admin-actions-list-default").prop('selected', true);
    $("#admin-actions-list").selectmenu("refresh");
  }

  $("#admin-actions-list").selectmenu({
    change: function(e, ui) {
      return_announcement(selectedAnnouncements.join(','), ui.item.value);
    }
  });

  // Select all elements
  $("#admin-select-all").click(function() {
    if ($('#admin-select-all').prop('checked')) {
      $(".admin-form input[type='checkbox']").prop('checked', true);
    } else {
      $(".admin-form input[type='checkbox']").prop('checked', false);
    }
  });

  var selectedCount = 0;
  var selectedAnnouncements = [];

  $(".admin-form input[type='checkbox']").change(function() {
    selectedAnnouncements = [];
    selectedCount = $(".admin-form-td input[type='checkbox']:checked").length;
    if (selectedCount === 0) {
      $("#admin-actions-list").selectmenu("disable");
      $("#admin-actions-list").selectmenu("refresh");
    } else {
      $("#admin-actions-list").selectmenu("enable");
      $("#admin-actions-list-approve").text("Approve "+selectedCount+" Announcement(s)");
      $("#admin-actions-list-urgent").text("Set "+selectedCount+" Announcement(s) To Urgent");
      $("#admin-actions-list-deny").text("Deny "+selectedCount+" Announcement(s)");
      $("#admin-actions-list").selectmenu("refresh");
    }
    $('.admin-form-td :checked').each(function() {
      selectedAnnouncements.push($(this).val());
    });
    console.log(selectedAnnouncements);
  });

  $(".admin-announcement-0").hide();

  function return_announcement(ids, type) {
    $("#admin-actions-list").selectmenu("disable");
    $("#admin-actions-list").selectmenu("refresh");
    $.ajax({
      method: "GET",
      url: "api/get_announcements.php",
      data: {
        "announcementIds": ids
      },
      dataType: "json"
    }).done(function(data) {
      var count = 0;
      $("#admin-dialog-"+type+"-announcements .residue").remove();
      for (var announcementId in data) {
        count = count + 1;
        if (count <= 3) {
          var announcement = $("#admin-dialog-"+type+"-announcements .admin-announcement-0").clone().removeClass('admin-announcement-0').addClass("residue").show();
          $(announcement).children(".admin-dialog-"+type+"-heading").text(data[announcementId].name);
          $(announcement).children(".admin-dialog-"+type+"-description").text(data[announcementId].description);
          $(announcement).children(".admin-dialog-"+type+"-author").text(data[announcementId].teacherName);
          if (data[announcementId].tagsString !== "") {
            $(announcement).children(".admin-dialog-"+type+"-tags").text("Tags: "+data[announcementId].tagsString);
          } else {
            $(announcement).children(".admin-dialog-"+type+"-tags").text("Tags: None");
          }
          $(announcement).appendTo("#admin-dialog-"+type+"-announcements");
        } else {
          $("#admin-dialog-"+type+"-announcements").append("<br class='residue'><i class='residue'>Plus "+(selectedAnnouncements.length-count+1)+" more...</i>");
          break;
        }
      }

      $("#admin-actions-list").selectmenu("enable");
      $("#admin-actions-list").selectmenu("refresh");

      switch(type) {
        case "approve":
          approve_dialog.dialog("open");
          break;
        case "urgent":
          urgent_dialog.dialog("open");
          break;
        case "deny":
          deny_dialog.dialog("open");
          break;
        default:
          break;
      }
    });
  }

});
