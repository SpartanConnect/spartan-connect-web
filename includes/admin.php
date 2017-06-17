<?php
  include('secret.php');
  include('announcements.php');


  function deny_announcement($id, $reason) {
    $announcement = get_announcement_by_id($id);
    $teacher = get_all_teacher($id);
    $name = $teacher['name'];
    $email = $teacher['email'];
    $announcement_title = $announcement['name'];
    $announcement_description = $announcement['description'];

    $link = LOCAL_URL."user_panel.php";
    $subject = "Rejected Announcement '".$announcement_title."'";
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
    deny_announcement($id);
  }
  function allow_announcement($id)
  {
    approve_announcement($id);
  }
  function edit_announcement() {
    // code to edit announcement here...
  }
?>
