<?php
  include_once('./includes/include.php');
  include_once('./includes/auth.php');

  $userInfo = $auth0->getUser();
  if ($_GET['error'] == 'unauthorized') {
    // Incorrect user type
    set_session(false);
    echo "Unsuccessful login. Please log in with a teacher or administrator account to proceed. <a href='".((IS_DEVELOPMENT ? LOCAL_URL : REMOTE_URL)."index.php")."'>Return to home page</a>.";
  } else if (!$userInfo) {
    set_session(false);
    echo "Unsuccessful login. Please try logging in again at <a href='".((IS_DEVELOPMENT ? LOCAL_URL : REMOTE_URL)."index.php")."'>the home page</a>.";
  } else if (explode("@", $userInfo["email"])[1] == "mylcusd.net") {
    if (!in_array($userInfo['nickname'], AUTH0_MYLCUSD_EXCEPTIONS)) {
      // User does not have privileges. (not lcusd.net)
      set_session(false);
      echo "Unsuccessful login. Please log in with a teacher or administrator account to proceed. <a href='".((IS_DEVELOPMENT ? LOCAL_URL : REMOTE_URL)."index.php")."'>Return to home page</a>.";
    }
    else {
      // User is authenticated
      set_session(true);
      header('Location: user_panel.php');
      echo "Hello ".$_SESSION['fullname']."! Redirecting you shortly to the announcements creation page.<br>";
      echo "You have ".($_SESSION['privlevel'] == 1 ? "admin" : "basic")." privileges.";
    }
  } else {
    // User is authenticated
    set_session(true);
    header('Location: user_panel.php');
    echo "Hello ".$_SESSION['fullname']."! Redirecting you shortly to the announcements creation page.<br>";
    echo "You have ".($_SESSION['privlevel'] == 1 ? "admin" : "basic")." privileges.";
  }
?>
