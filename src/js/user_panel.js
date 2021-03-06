$(document).ready(function() {

  var selectedAction = "";
  var selectedAnnouncement = {
    id: 0,
    title: "Loading Announcement...",
    description: "Loading Announcement...",
    author: "Author",
    tags: "(none)"
  };

  edit_dialog = $("#user-dialog-edit").dialog({
    autoOpen: false,
    resizable: false,
    height: "auto",
    width: 600,
    modal: true,
    closeOnEscape: false,
    buttons: {
      Cancel: function() {
        selectedAction = "edit";
        closeOutDialog();
        $(this).dialog("close");
      },
      "Edit Announcement": function() {
        selectedAction = "edit";
        $.ajax({
          method: "POST",
          url: "api/update_announcement.php",
          data: {
            "id": selectedAnnouncement.id,
            "setTitle": $(".user-dialog-edit-heading .emojionearea-editor").html(),
            "setDescription": $(".user-dialog-edit-description .emojionearea-editor").html(),
            "userPanel": true
          },
          dataType: "json"
        }).done(ajaxUpdateAnnouncementCallback);
      }
    }
  });

  delete_dialog = $("#user-dialog-delete").dialog({
    autoOpen: false,
    resizable: false,
    height: "auto",
    width: 600,
    modal: true,
    closeOnEscape: false,
    buttons: {
      Cancel: function() {
        selectedAction = "delete";
        closeOutDialog();
        $(this).dialog("close");
      },
      "Delete Announcement": function() {
        selectedAction = "delete";
        $.ajax({
          method: "POST",
          url: "api/update_announcement.php",
          data: {
            "id": selectedAnnouncement,
            "setApproved": 3,
            "userPanel": true
          },
          dataType: "json"
        }).done(ajaxUpdateAnnouncementCallback);
      }
    }
  });

  function closeOutDialog() {
    switch (selectedAction) {
      case "edit":
        edit_dialog.dialog("close");
        break;
      case "delete":
        removeAnnouncement(selectedAnnouncement.id);
        delete_dialog.dialog("close");
        break;
    }
  }

  function removeAnnouncement(id) {
    $("#announcement-row-"+id).remove();

    if ($(".announcement-row").length === 0) {
      location.reload();
    }
  }

  function ajaxUpdateAnnouncementCallback(data) {
    if (data.success === true) {
      closeOutDialog();
    } else {
      alert("Failed to update announcement #"+selectedAnnouncement.id+"."+" Message: "+data.error);
    }
  }

  function syncAnnounceData(announce, type) {
    $(".user-dialog-"+type+"-heading").text(announce.title);
    $(".user-dialog-"+type+"-author").html(announce.description);
    $(".user-dialog-"+type+"-description").html(announce.author);
    if (announce.tags === "") {
      announce.tags = "(none)";
    }
    $(".user-dialog-"+type+"-tags").text("Tags: "+announce.tags);
  }

  function syncAnnounceForms(announce) {
    $(".user-dialog-edit-heading .emojionearea-editor").html(announce.title);
    $(".user-dialog-edit-description .emojionearea-editor").html(announce.description);
    if (announce.tags === "") {
      announce.tags = "(none)";
    }
    $(".user-dialog-edit-tags").text("Tags: "+announce.tags);
    edit_dialog.dialog("open");
  }

  $(".panel-btns-edit").click(function() {
    // prepare content of delete dialog
    selectedAnnouncement.id = parseInt($(this).prop('id').replace('panel-btns-edit-', ''));

    $.ajax({
      method: "GET",
      url: "api/get_announcement_by_id.php",
      data: {
        "announcement_id": selectedAnnouncement.id,
        "editHTML": true
      },
      dataType: "json"
    }).done(function (data) {
      console.log(data);
      selectedAnnouncement.title = data.name;
      selectedAnnouncement.description = data.description;
      selectedAnnouncement.author = data.teacherName;
      selectedAnnouncement.tags = data.tagsString;
      syncAnnounceForms(selectedAnnouncement);
    });

  });

  $(".panel-btns-delete").click(function() {
    // prepare content of delete dialog
    selectedAnnouncement.id = parseInt($(this).prop('id').replace('panel-btns-delete-', ''));

    $.ajax({
      method: "GET",
      url: "api/get_announcement_by_id.php",
      data: {
        "announcement_id": selectedAnnouncement.id,
        "editHTML": true
      },
      dataType: "json"
    }).done(function (data) {
      selectedAnnouncement.title = data.name;
      selectedAnnouncement.description = data.description;
      selectedAnnouncement.author = data.teacherName;
      selectedAnnouncement.tags = data.tagsString;
      syncAnnounceData(selectedAnnouncement, "delete");
      delete_dialog.dialog("open");
    });
  });

  $(".input-emojis").emojioneArea({
    pickerPosition: "bottom",
    tonesStyle: "bullet"
  });

});
