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
            <input type="text" class="input-emojis" name="announce_name" style="width:100%; padding:0;" placeholder="Title"><br>
            <textarea name="announce_desc" class="input-emojis" style="width:100%; height:100px; padding:0;" placeholder="Add your description here..."></textarea>
            <script>
              $(document).ready(function() {
                $(".input-emojis").emojioneArea({
                  pickerPosition: "bottom",
                  tonesStyle: "bullet"
                });
                $("#announce_tag_select_1").selectmenu();
                $("#announce_tag_grow").hide();
              });
            </script>
            <?php if ($_SESSION['privlevel'] == 1) { ?>
              <br><label>Tag as Urgent:</label>
              <?php print_checkbox("announce_urgency", "urgent"); ?>
            <?php } ?>
          </fieldset><br><br>
          <fieldset>
            <legend>Tagging</legend>
            <b class="heading">GRADES</b><br>
            <label>7:</label> <?php print_checkbox("announce_tag_grade_7", "1"); ?>
            <label>8:</label> <?php print_checkbox("announce_tag_grade_8", "1"); ?><br>
            <label>9:</label> <?php print_checkbox("announce_tag_grade_9", "1"); ?>
            <label>10:</label> <?php print_checkbox("announce_tag_grade_10", "1"); ?>
            <label>11:</label> <?php print_checkbox("announce_tag_grade_11", "1"); ?>
            <label>12:</label> <?php print_checkbox("announce_tag_grade_12", "1"); ?><br><br>
            <button id="announce_tag_grade_btn_middle" class="small">Select 7/8</button>
            <button id="announce_tag_grade_btn_high" class="small">Select 9-12</button>
            <button id="announce_tag_grade_btn_all" class="small">Select All</button><br><br>
            <b class="heading">TAGS</b><br>
            <div id="announce_tag_selects">
              <select id="announce_tag_select_1" name="announce_tag_select_1" style="display: block; margin: 5px 0;" class="announce-tag tag-dropdown">
                <option value="volvo">Volvo</option>
                <option value="saab">Saab</option>
                <option value="mercedes">Mercedes</option>
                <option value="audi">Audi</option>
              </select>
            </div><br>
            <button id="announce_tag_btn_create" class="small">+ Add a Tag</button>
            <button id="announce_tag_btn_grow" class="small">+ Add Multiple Tags</button>
            <div id="announce_tag_grow" style="display:inline-block;">
              <input id="announce_tag_input_grow" type="number" style="width: 2em;" value="1" min="1"/>
              <button id="announce_tag_submit_grow" class="small">Add</button>
            </div>
            <script>
              var selectCounter = 1;
              $("#announce_tag_btn_create").click(function(e){
                e.preventDefault();
                selectCounter = selectCounter + 1;
                $("#announce_tag_select_1").clone().prop("id", "announce_tag_select_"+selectCounter).prop("name", "announce_tag_select_"+selectCounter).appendTo("#announce_tag_selects");
                $("#announce_tag_select_"+selectCounter).selectmenu();
              });
              $("#announce_tag_btn_grow").click(function(e) {
                e.preventDefault();
                $("#announce_tag_grow").toggle();
              })
              $("#announce_tag_submit_grow").click(function(e){
                e.preventDefault();
                for (i = 0; i < parseInt($("#announce_tag_input_grow").val()); i++) {
                  selectCounter = selectCounter + 1;
                  $("#announce_tag_select_1").clone().prop("id", "announce_tag_select_"+selectCounter).prop("name", "announce_tag_select_"+selectCounter).appendTo("#announce_tag_selects");
                  $("#announce_tag_select_"+selectCounter).selectmenu();
                }
                $("#announce_tag_grow").val(1);
                $("#announce_tag_grow").hide();
              });
              $("#announce_tag_grade_btn_middle").click(function(e){
                e.preventDefault();
                $("#announce_tag_grade_7").prop("checked", true);
                $("#announce_tag_grade_8").prop("checked", true);
                $("#announce_tag_grade_9").prop("checked", false);
                $("#announce_tag_grade_10").prop("checked", false);
                $("#announce_tag_grade_11").prop("checked", false);
                $("#announce_tag_grade_12").prop("checked", false);
              });
              $("#announce_tag_grade_btn_high").click(function(e){
                e.preventDefault();
                $("#announce_tag_grade_7").prop("checked", false);
                $("#announce_tag_grade_8").prop("checked", false);
                $("#announce_tag_grade_9").prop("checked", true);
                $("#announce_tag_grade_10").prop("checked", true);
                $("#announce_tag_grade_11").prop("checked", true);
                $("#announce_tag_grade_12").prop("checked", true);
              });
              $("#announce_tag_grade_btn_all").click(function(e){
                e.preventDefault();
                $("#announce_tag_grade_7").prop("checked", true);
                $("#announce_tag_grade_8").prop("checked", true);
                $("#announce_tag_grade_9").prop("checked", true);
                $("#announce_tag_grade_10").prop("checked", true);
                $("#announce_tag_grade_11").prop("checked", true);
                $("#announce_tag_grade_12").prop("checked", true);
              });
            </script>
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
