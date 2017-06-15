<?php
  include('./includes/include.php');
  include('./includes/auth.php');
  include('./includes/announcements.php');

  // logic to submit!
  $errs = [];

  if (isset($_POST['announce_sub'])) {
    // checking if fields are empty
    if (strlen($_POST['announce_name']) < 5) {
      array_push($errs, "Announcement title cannot be less than five characters.");
    }
    if (strlen($_POST['announce_desc']) < 10) {
      array_push($errs, "Announcement description cannot be less than ten characters.");
    }
    if (!validate_date($_POST['announce_start']) || empty($_POST['announce_start'])) {
      array_push($errs, "The start date of the announcement is not formatted correctly.");
    }
    if (!validate_date($_POST['announce_end']) || empty($_POST['announce_end'])) {
      array_push($errs, "The end date of the announcement is not formatted correctly.");
    }
    if(format_date($_POST['announce_end']) < format_date($_POST['announce_start']))
    {
      array_push($errs, "The end date of the announcement cannot occur before the start date.");
    }
    if (!validate_date($_POST['announce_event_date']) || empty($_POST['announce_event_date'])) {
      array_push($errs, "The date of the event is not formatted correctly.");
    }
    if (!validate_time($_POST['announce_event_start']) || empty($_POST['announce_event_start'])) {
      array_push($errs, "The start time of the announcement is not formatted correctly.");
    }
    if (!validate_time($_POST['announce_event_end']) || empty($_POST['announce_event_end'])) {
      array_push($errs, "The end time of the announcement is not formatted correctly.");
    }

    // Continue only if there were no errors.
    if (empty($errs) && $_SESSION['authenticated']) {
      $result = create_announcement(mb_convert_encoding(htmlspecialchars($_POST['announce_name']),"HTML-ENTITIES"), mb_convert_encoding(htmlspecialchars($_POST['announce_desc']), "HTML-ENTITIES"), $_SESSION['teacherID'], format_date($_POST['announce_start']), format_date($_POST['announce_end']), format_date($_POST['announce_event_date']), format_time($_POST['announce_event_start']), format_time($_POST['announce_event_end']), 0, ((($_POST['announce_urgency'] == 'urgent') && ($_SESSION['privlevel'] == 1)) ? 1 : 0));
      if (!$result) {
        array_push($errs, "There was a problem submitting an announcement to the database. Please try again in a while.");
      }
    }
  } else {
    array_push($errs, "Please use the online form to submit an announcement.");
  }

  get_header("Create Announcement");
?>
    <div class="container">
      <?php if ($_SESSION['authenticated']) { ?>
        <?php if (empty($errs)) { ?>
          <div class="announcement create-announcement">
            <b class="heading">SUCCESS</b><br>
            <p>Your announcement has been successfully submitted for approval.</p>
            <button onclick="location.href='user_panel.php'">Return to User Panel</button>
          </div>
        <?php } else { ?>
          <div class="announcement create-announcement">
            <b class="heading">ERROR</b><br>
            <ul>
              <?php foreach ($errs as $err) {?>
              <li><?php echo $err; ?></li>
              <?php } ?>
            </ul>
            <button onclick="location.href='create_announcement.php'">Return to Announcement Creation</button>
          </div>
        <?php } ?>
      <?php } else {
        print_alert_unauthenticated();
      } ?>
    </div>
<?php get_footer(); ?>
