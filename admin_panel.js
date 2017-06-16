$(document).ready(function() {
  approve_dialog = $("#admin-dialog-approve").dialog({
    autoOpen: false,
    resizable: false,
    height: "auto",
    width: 600,
    modal: true,
    buttons: {
      Cancel: function() {
        $(this).dialog("close");
      },
      "Approve Announcement": function() {
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
    buttons: {
      Cancel: function() {
        $(this).dialog("close");
      },
      "Deny Announcement": function() {
        $(this).dialog("close");
      }
    }
  });
  urgent_dialog = $("#admin-dialog-urgency").dialog({
    autoOpen: false,
    resizable: false,
    height: "auto",
    width: 600,
    modal: true,
    buttons: {
      Cancel: function() {
        $(this).dialog("close");
      }
    }
  });

  $("#admin-actions-list").selectmenu({
    change: function(e, ui) {
      return_announcement(0, ui.item.value);
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

  $(".admin-form input[type='checkbox']").change(function() {
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
  });

  function return_announcement(ids, type) {
    $.ajax({
      method: "GET",
      url: "api/get_announcements.php",
      data: {
        "ids": parseInt(ids)
      },
      dataType: "json"
    }).done(function(data) {
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
