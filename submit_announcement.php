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
    if (format_date($_POST['announce_end']) < format_date($_POST['announce_start'])) {
      array_push($errs, "The end date of the announcement cannot occur before the start date.");
    }

    $tags_grades = array();
    $tags_other = array();

    // Check grades
    $grades = array(7, 8, 9, 10, 11, 12);
    foreach ($grades as $grade) {
      if (!empty($_POST['announce_tag_grade_'.$grade])) {
        array_push($tags_grades, get_tag_id_by_slug('grade-'.$grade));
      }
    }

    if (empty($tags_grades)) {
      array_push($errs, "Announcement must have at least one grade level selected.");
    }

    // Check other tags
    for ($id = 1; $id <= count(get_tags()); $id++) {
      if (!empty($_POST['announce_tag_select_'.$id]) && !in_array(intval($_POST['announce_tag_select_'.$id]), $tags_other)) {
        array_push($tags_other, intval($_POST['announce_tag_select_'.$id]));
      }
    }

    if (empty($tags_other)) {
      array_push($errs, "Announcement must have at least one tag selected.");
    }

    $tags = array_merge($tags_grades, $tags_other);

    // Continue only if there were no errors.
    if (empty($errs) && $_SESSION['authenticated']) {
      $result = create_announcement(mb_convert_encoding(htmlspecialchars($_POST['announce_name']),"HTML-ENTITIES"), mb_convert_encoding(htmlspecialchars($_POST['announce_desc']), "HTML-ENTITIES"), $_SESSION['teacherID'], format_date($_POST['announce_start']), format_date($_POST['announce_end']), 0, ((($_POST['announce_urgency'] == 'urgent') && ($_SESSION['privlevel'] == 1)) ? 1 : 0), 0);
      if (!$result) {
        array_push($errs, "There was a problem submitting an announcement to the database. Please try again in a while.");
      } else {
        $result2 = update_announcement_tags($result, $tags);
        if (!$result) {
          array_push($errs, "There was a problem submitting an announcement to the database. Please try again in a while.");
        }
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
