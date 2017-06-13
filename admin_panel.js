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
  edit_dialog = $("#admin-dialog-edit").dialog({
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

  function return_announcement(id, type, dialog) {
    $.ajax({
      method: "GET",
      url: "api/get_announcement_by_id.php",
      data: {
        "announcement_id": parseInt(id.replace('admin-'+type+'-', ''))
      },
      dataType: "json"
    }).done(function(data) {
      $("#admin-dialog-"+type+"-heading").text(data.name);
      $("#admin-dialog-"+type+"-description").text(data.description);
      dialog.dialog("open");
    });
  }

  $(".admin-approve").click(function() {
    return_announcement($(this).attr('id'), "approve", approve_dialog);
  });
  $(".admin-deny").click(function() {
    return_announcement($(this).attr('id'), "deny", deny_dialog);
  });
  $(".admin-edit").click(function() {
    return_announcement($(this).attr('id'), "edit", edit_dialog);
  });
});
