<?php
  include('./includes/include.php');
  include('./includes/auth.php');
  include('./includes/announcements.php');
  get_header("Create Announcement");
?>
    <div class="container">
      <?php if ($_SESSION['authenticated']) { ?>
        <form class="announcement create-announcement" action="submit_announcement.php" method="post">
          <b class="heading">CREATE ANNOUNCEMENT</b><br>
          <i class="heading">All fields marked with a (*) are required.</i><br><br>
          <fieldset>
            <legend>General</legend>
            <input type="text" class="input-emojis" name="announce_name" style="padding:0;" placeholder="Title (*)"><br>
            <textarea name="announce_desc" class="input-emojis" style="height:100px; padding:0;" placeholder="Add your description here... (*)"></textarea>
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
            <legend>Announcement Show Dates (Today is <?php echo date('m/d/y'); ?>)</legend>
            <p class="heading">Select a window of dates you want this announcement to appear on.</p>
            <label>Start Date (*): </label><input type="text" class="datepicker" name="announce_start"><br><br>
            <label>End Date (*): </label><input type="text" class="datepicker" name="announce_end">
          </fieldset><br><br>
          <fieldset>
            <legend>Tagging</legend>
            <b class="heading">GRADES (*)</b><br>
            <?php print_checkbox("announce_tag_grade_7", "1"); ?><label> - Grade 7</label> <br>
            <?php print_checkbox("announce_tag_grade_8", "1"); ?><label> - Grade 8</label><br>
            <?php print_checkbox("announce_tag_grade_9", "1"); ?><label> - Grade 9</label><br>
            <?php print_checkbox("announce_tag_grade_10", "1"); ?><label> - Grade 10</label><br>
            <?php print_checkbox("announce_tag_grade_11", "1"); ?><label> - Grade 11</label><br>
            <?php print_checkbox("announce_tag_grade_12", "1"); ?><label> - Grade 12</label><br><br>
            <button id="announce_tag_grade_btn_middle" class="small">Select 7/8</button>
            <button id="announce_tag_grade_btn_high" class="small">Select 9-12</button>
            <button id="announce_tag_grade_btn_all" class="small">Select All</button><br><br>
            <b class="heading">TAGS (*)</b><br>
            <div id="announce_tag_selects">
              <select id="announce_tag_select_1" name="announce_tag_select_1" style="display: block; margin: 5px 0;" class="announce-tag tag-dropdown">
                <?php
                  $tags = get_tags();
                  $tag_count = 0;
                  if (!empty($tags)) {
                    foreach ($tags as $tag) {
                      if ($tag['visible']) {
                        echo '<option value="'.$tag['id'].'">'.$tag['name'].'</option>';
                        $tag_count++;
                      }
                    }
                    if ($tag_count == 0) {
                      echo '<option value="0">(no tags available)</option>';
                    }
                  } else {
                    echo '<option value="0">(no tags available)</option>';
                  }
                ?>
              </select>
            </div><br>
            <button id="announce_tag_btn_create" class="small">+ Add a Tag</button>
            <button id="announce_tag_btn_grow" class="small">+ Add Multiple Tags</button>
            <button id="announce_tag_btn_decimate" class="small">- Delete a Tag</button>
            <div id="announce_tag_grow" style="display:inline-block;">
              <input id="announce_tag_input_grow" type="number" style="width: 2em;" value="1" min="1" max="<?php echo $tag_count-1; ?>"/>
              <button id="announce_tag_submit_grow" class="small">Add</button>
            </div>
            <script>
              var selectCounter = 1;
              var maximumCounter = <?php echo $tag_count; ?>;
              $("#announce_tag_btn_create").click(function(e){
                e.preventDefault();
                if (selectCounter >= maximumCounter) {
                  alert("Cannot add more tags than the maximum provided!");
                } else {
                  selectCounter = selectCounter + 1;
                  $("#announce_tag_select_1").clone().prop("id", "announce_tag_select_"+selectCounter).prop("name", "announce_tag_select_"+selectCounter).appendTo("#announce_tag_selects");
                  $("#announce_tag_selects").append("&nbsp;");
                  $("#announce_tag_select_"+selectCounter).selectmenu();
                }
              });
              $("#announce_tag_btn_grow").click(function(e) {
                e.preventDefault();
                $("#announce_tag_grow").toggle();
              });
              $("#announce_tag_btn_decimate").click(function(e) {
                e.preventDefault();
                if (selectCounter > 1) {
                  $("#announce_tag_select_"+selectCounter).remove();
                  selectCounter = selectCounter - 1;
                } else {
                  alert("Your announcement must have at least one tag.");
                }
              });
              $("#announce_tag_submit_grow").click(function(e){
                e.preventDefault();
                for (i = 0; i < parseInt($("#announce_tag_input_grow").val()); i++) {
                  if (selectCounter >= maximumCounter) {
                    alert("Cannot add more tags than the maximum on the database!");
                    break;
                  } else {
                    selectCounter = selectCounter + 1;
                    $("#announce_tag_select_1").clone().prop("id", "announce_tag_select_"+selectCounter).prop("name", "announce_tag_select_"+selectCounter).appendTo("#announce_tag_selects");
                    $("#announce_tag_selects").append("&nbsp;");
                    $("#announce_tag_select_"+selectCounter).selectmenu();
                  }
                }
                $("#announce_tag_input_grow").val("1");
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
          <input type="submit" name="announce_sub" value="Submit Announcement">
        </form>
        <script>
        $(function() {
          $(".datepicker").datepicker();
          /*$(".timepicker").timepicker({
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
          });*/
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
