<?php

  // Alert Box: General Function for Printing Alert Boxes
  function print_alert($iconClass, $title, $description, $html) {
    echo '<div class="alert">
      <i class="fa '.$iconClass.'"></i>
      <div class="alert-text">
        <b class="heading">'.htmlspecialchars($title).'</b>
        <p>'.htmlspecialchars($description).'</p>';
    if (!empty($html)) {
      echo $html;
    }
    echo '</div></div>';
  }

  // Alert Box: Alias functions
  function print_alert_info($description, $title = "NOTICE", $html = null) {
    print_alert("fa-info-circle", $title, $description, $html);
  }

  function print_alert_warning($description, $title = "WARNING", $html = null) {
    print_alert("fa-warning", $title, $description, $html);
  }

  function print_alert_unauthenticated() {
    print_alert_warning(
      "In order to create an announcement, please log in with a teacher's Google account.",
      "CREATE ANNOUNCEMENT",
      '<button onclick="lock.show();">Login with Google</button>'
    );
  }

  function print_alert_noaccess() {
    print_alert_warning(
      "You do not have access to this page. Please log in with an account with appropriate permissions.",
      "ERROR"
    );
  }

  // Dialog Box: General Function for Printing jQuery UI Dialog Boxes
  function print_dialog($tag, $title, $content) {
    echo '<div id="'.$tag.'" class="dialog" title="'.$title.'">'.$content.'</div>';
  }

  // Dialog Box: Alias functions
  // ~~~~~~~~
  // Dialog Box for Panel w/ Announcement:
  // Prints a dialog box with an announcement viewer and descriptions + additional html if provided
  function print_dialog_panel_announcement($tag, $title, $description = null, $html = null) {
    $content = "";
    if (!empty($description)) { $content = $content."<p>".$description."</p>"; }
    $content = $content.'<div class="announcement">
      <h1 id="'.$tag.'-heading">Loading Announcement...</h1>
      <p id="'.$tag.'-description">Loading Announcement...</p>
    </div>';
    if (!empty($html)) { $content = $content.$html; }
    print_dialog($tag, $title, $content);
  }

?>