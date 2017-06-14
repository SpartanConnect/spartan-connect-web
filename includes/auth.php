<?php
  include_once('constants.php');
  include_once('secret.php');
  include_once('db.php');

  require __DIR__ . '/../vendor/autoload.php';
  use Auth0\SDK\Auth0;

  $auth0 = new Auth0([
    'domain' => AUTH0_DOMAIN,
    'client_id' => AUTH0_CLIENT_ID,
    'client_secret' => AUTH0_CLIENT_SECRET,
    'redirect_uri' => ((IS_DEVELOPMENT ? LOCAL_URL : REMOTE_URL).AUTH0_REDIRECT_URI),
    'audience' => AUTH0_AUDIENCE,
    'persist_id_token' => true,
    'persist_access_token' => true,
    'persist_refresh_token' => true,
  ]);

  function set_session($success) {
    require_once('announcements.php');
    if ($success) {
      $_SESSION['authenticated'] = true;
      $_SESSION['fullname'] = $_SESSION['auth0__user']['name'];
      $_SESSION['email'] = $_SESSION['auth0__user']['email'];

      // Determine privileges based on admin array
      // 0 = basic privileges (can create announcements), 1 = admin privileges (use urgent tag)
      if (in_array($_SESSION['auth0__user']['nickname'], USER_ADMINISTRATORS)) {
        $_SESSION['privlevel'] = 1;
      } else {
        $_SESSION['privlevel'] = 0;
      }
      enforce_teachers_table();
      $_SESSION['teacherID'] = get_teacher_id($_SESSION['email']);
    } else {
      $_SESSION['authenticated'] = false;
    }
  }

  // Checks if user is in teachers table and adds them if they are not.
  function enforce_teachers_table() {
    $result = perform_query("SELECT * FROM ".DB_TABLE_TEACHERS." WHERE `email` = :email", array(
      ':email' => $_SESSION['auth0__user']['email']
    ));
    if (count($result) > 0) {
      return true;
    } else {
      // Add them to table
      perform_query("INSERT INTO ".DB_TABLE_TEACHERS." (`name`, `email`) VALUES (:name, :email)", array(
        ':name' => $_SESSION['auth0__user']['name'],
        ':email' => $_SESSION['auth0__user']['email']
      ));
      return true;
    }
  }

  function validate_date($date) {
    $d = DateTime::createFromFormat('m/d/Y', $date);
    return $d && $d->format('m/d/Y') === $date;
  }
  function validate_time($time) {
    $d = DateTime::createFromFormat('g:ia', $time);
    return $d && $d->format('g:ia') === $time;
  }
  // convert for storage into MySQL db
  function format_date($date) {
    $fd = DateTime::createFromFormat('m/d/Y', $date);
    return $fd->format('Y-m-d');     // ex: 2017-07-12 from 07/12/2017
  }
  function format_time($time) {
    $ft = DateTime::createFromFormat('g:ia', $time);
    return $ft->format('H:i');       // convert to 24-hour time
  }

?>
