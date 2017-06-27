<?php
  // Because this is a secure portal, POST will be used instead of GET.
  // In addition, a session will also be employed to prevent non-admins from accessing this API gateway.

  // $_POST['id'] => the id number of the announcement
  // $_POST['setUrgent'] => the number for setting the urgent attribute
  // $_POST['setApproved'] => the number for setting the approved attribute
  // $_POST['setReason'] => the specific reason for doing such (used for approval)
  // $_POST['userPanel'] => true if using user panel, false otherwise. Should be automatic.

  // TODO: Prevent scripts from external sites from accessing this page!

  include('api.php');
  include('../includes/announcements.php');

  session_start();

  $result = null;
  $result['success'] = false;
  $result['id'] = intval($_POST['id']);

  if (empty($_POST['userPanel'])) {
    $_POST['userPanel'] = false;
  }

  if (empty($result['id'])) {
    $result['success'] = false;
    $result['error'] = "No post id specified.";
  } else if ($_SESSION['authenticated'] && $_SESSION['privlevel'] == 1 && !$_POST['userPanel']) {
    // Only allow certain values (0, 1)
    if (!empty($_POST['setUrgent'])) {
      if ($_POST['setUrgent'] == 0 || $_POST['setUrgent'] == 1) {
        update_announcement_urgent(intval($_POST['id']), intval($_POST['setUrgent']));
        $result['success'] = true;
      }
    }
    if (!empty($_POST['setApproved'])) {
      // IDEA: Move this logic into announcements.php?
      switch ($_POST['setApproved']) {
        case 1:     // Approval
          update_announcement_approve(intval($_POST['id']));
          $result['success'] = true;
          break;
        case 2:     // Denial
          update_announcement_deny(intval($_POST['id']), $_POST['setReason']);
          $result['success'] = true;
          break;
        default:
          $result['success'] = false;
          $result['error'] = "Invalid options.";
      }
    }
  } else if ($_SESSION['authenticated'] && $_POST['userPanel']) {
    // Step 1: Make sure it checks that the teacher is the actual creator!
    if (get_announcement_by_id($result['id'])['teacherID'] == $_SESSION['teacherID']) {
      if (!empty($_POST['setApproved'])) {
        switch ($_POST['setApproved']) {
          case 3:     // Obliterate
            update_announcement_obliterate(intval($_POST['id']));
            $result['success'] = true;
            break;
          default:
            $result['success'] = false;
            $result['error'] = "Invalid options.";
        }
      }
    } else {
      $result['success'] = false;
      $result['error'] = "Incorrect user.";
    }
  } else {
    $result['success'] = false;
    $result['error'] = "General error.";
  }

  echo_response($result);
?>
