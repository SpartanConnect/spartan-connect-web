<?php
  include('secret.php');

  function deny_announcement($name, $email, $reason, $announcement_title, $announcement_description) {
    $link = LOCAL_URL."user_panel.php";
    $subject = "Rejected Announcement";
    $body = <<<EOF

===========================

Hello {$name},

We regret to inform you that your announcement '{$announcement_title}' was rejected by an administrator.

Title: {$announcement_title}
Description:
{$announcement_description}

Reason for Denial:
{$reason}

You may edit and resubmit your announcement by going to {$link}.

- Spartan Connect Student Development Team

===========================

Do not reply to this email.
EOF;
    $headers = 'To: '.$name.' '.$email."\r\n".
        'From: studentdevteam@lcusd.net'."\r\n".
        'Reply-To: studentdevteam@lcusd.net'."\r\n".
        'X-Mailer: PHP/'.phpversion();
    mail($email, $subject, $body, $headers);
  }
  function allow_announcement() {
    // code to allow announcement here...
  }
  function edit_announcement() {
    // code to edit announcement here...
  }
?>
