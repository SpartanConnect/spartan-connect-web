<?php
  function deny_announcement($reason, $name, $description, $email) {
    $subject = "Rejected Announcement"
    $body = "Hello ".$name.", <br><br>"."We regret to inform you that your announcement '".$name."' request was rejected by an administrator.\n\r\n\rDescription:\n\r".$description."\n\r\n\rThe reason for which your announcement was denied, as described by the administrator are included below:\n\r\n\r".$reason;
    $headers = 'To: '.$name.' '.$email."\r\n".
        'From: studentdevteam@lcusd.net'."\r\n".
        'Reply-To: studentdevteam@lcusd.net'."\r\n".
        'X-Mailer: PHP/'.phpversion();
    mail($email, $subject, $body, $headers);
  }
  function allow_announcemnt() {
    // code to allow announcement here...
  }
  function edit_announcement() {
    // code to edit announcement here...
  }
?>
