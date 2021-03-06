<?php

  // Alert Box: General Function for Printing Alert Boxes
  function print_alert($iconClass, $title, $description, $html, $trim) {
    $alert = '<div class="alert">
      <i class="fa '.$iconClass.'"></i>
      <div class="alert-text">
        <b class="heading">'.htmlspecialchars($title).'</b>
        <p>'.htmlspecialchars($description).'</p>';
    if (!empty($html)) {
      $alert = $alert.$html;
    }
    $alert = $alert.'</div></div>';
    if ($trim) {
      $alert = str_replace("\n", '', $alert);
    }
    echo $alert;
  }

  // Alert Box: Alias functions
  function print_alert_info($description, $title = "NOTICE", $html = null, $trim = false) {
    print_alert("fa-info-circle", $title, $description, $html, $trim);
  }

  function print_alert_warning($description, $title = "WARNING", $html = null, $trim = false) {
    print_alert("fa-warning", $title, $description, $html, $trim);
  }

  function print_alert_unauthenticated() {
    print_alert_warning(
      "In order to create an announcement, please log in with a teacher's Google account.",
      "CREATE ANNOUNCEMENT",
      '<button onclick="showModal();">Login with Google</button>'
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
    $content = $content.'<div class="admin-announcements" id="'.$tag.'-announcements"><div class="admin-announcement admin-announcement-0">
      <h3 class="'.$tag.'-heading">Loading Announcement...</h3>
      <i class="heading '.$tag.'-author">Loading Author...</i>
      <p class="'.$tag.'-description">Loading Announcement...</p>
      <i class="heading '.$tag.'-tags">Tags: (none)</i>
    </div></div>';
    if (!empty($html)) { $content = $content.$html; }
    print_dialog($tag, $title, $content);
  }

  function print_dialog_panel_edit($tag, $title, $description = null, $html = null) {
    $content = "";
    if (!empty($description)) { $content = $content."<p>".$description."</p>"; }
    $content = $content.'<form id="'.$tag.'-announcements">
    <div class="admin-announcement admin-announcement-0">
      <input class="'.$tag.'-heading input-emojis" name="'.$tag.'-heading" placeholder="Insert title here..."/><br>
      <textarea class="'.$tag.'-description input-emojis" name="'.$tag.'-description" placeholder="Insert description here..."></textarea><br>
      <i class="heading '.$tag.'-tags">Tags: (none)</i>
    </div>
    </form>';
    if (!empty($html)) { $content = $content.$html; }
    print_dialog($tag, $title, $content);
  }

  // Checkbox: General Function for Printing Custom Checkbox
  function print_checkbox($id, $value) {
    echo '<div class="checkbox">
      <input id="'.$id.'" type="checkbox" name="'.$id.'" value="'.$value.'">
      <label for="'.$id.'"></label>
    </div>';
  }

?>
