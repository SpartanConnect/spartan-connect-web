<?php
  include('./includes/include.php');
  include('./includes/auth.php');
  get_header("Create Announcement");
?>
    <div class="container">
      <?php if ($_SESSION['authenticated']) { ?>
        <form class="announcement create-announcement" action="submit_announcement.php" method="post">
          <b class="heading">CREATE ANNOUNCEMENT</b><br>
          <i class="heading">Welcome, <?php echo $_SESSION['fullname']; ?></i>.<br><br>
          <fieldset>
            <legend>General</legend>
            <label>Title: </label><input type="text" name="announce_name" style="width:300px;"><br><br>
            <label>Description: </label><br><textarea name="announce_desc" style="width: 400px; height: 100px;"></textarea>
            <?php if ($_SESSION['privlevel'] == 1) { ?>
              <label>Tag as Urgent:</label><input type="checkbox" name="announce_urgency" value="urgent">
            <?php } ?>
          </fieldset><br><br>
          <fieldset>
            <legend>Event Date & Time</legend>
            <p class="heading">Select what date and times your event will take place.</p>
            <label>Event Date: </label><input type="text" class="datepicker" name="announce_event_date"><br><br>
            <label>Start Time: </label><input type="text" id="announcement-start" class="timepicker" name="announce_event_start"><br><br>
            <label>End Time: </label><input type="text" id="announcement-end" class="timepicker" name="announce_event_end">
          </fieldset><br><br>
          <fieldset>
            <legend>Announcement Show Dates (Today is <?php echo date('m/d/y'); ?>)</legend>
            <p class="heading">Select a window of dates you want this announcement to appear on.</p>
            <label>Start Date: </label><input type="text" class="datepicker" name="announce_start"><br><br>
            <label>End Date: </label><input type="text" class="datepicker" name="announce_end">
          </fieldset><br><br>
          <input type="submit" name="announce_sub" value="Submit Announcement">
        </form>
        <script>
        $(function() {
          $(".datepicker").datepicker();
          $(".timepicker").timepicker({
            'minTime': '6:00 AM',
            'maxTime': '11:00 PM'
          });
          $("#announcement-end").timepicker('option', {
            'durationTime': $("#announcement-start").val(),
            'showDuration': true
          });
          $("#announcement-start").change(function() {
            $("#announcement-end").timepicker('option', {
              'minTime': $("#announcement-start").val(),
              'durationTime': $("#announcement-start").val()
            });
          });
        });
        </script>
      <?php } else { ?>
        <div class="announcement create-announcement">
          <b class="heading">ERROR</b><br>
          <p>You do not have access to this page. Please return to the home page to login with a teacher account.</p>
          <a href="index.php">Return to home page.</a>
        </div>
      <?php } ?>
    </div>
<?php get_footer(); ?>
