<?php
  include('constants.php');
  include('secret.php');
  include('db.php');

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
    if ($success) {
      $_SESSION['authenticated'] = true;
      $_SESSION['fullname'] = $_SESSION['auth0__user']['name'];
      // Determine privileges based on admin array
      // 0 = basic privileges (can create announcements), 1 = admin privileges (use urgent tag)
      if (in_array($_SESSION['auth0__user']['nickname'], USER_ADMINISTRATORS)) {
        $_SESSION['privlevel'] = 1;
      } else {
        $_SESSION['privlevel'] = 0;
      }
      enforce_teachers_table();
    } else {
      $_SESSION['authenticated'] = false;
    }
  }

  // Checks if user is in teachers table and adds them if they are not.
  function enforce_teachers_table() {
    $query = "SELECT * FROM ".DB_TABLE_TEACHERS." WHERE email = :email";
    $stmt = $dbc->prepare($query);
    $stmt->execute(array(
      ':email' => $_SESSION['auth0__user']['email']
    ));
    if (count($stmt->fetchAll()) > 0) {
      return true;
    } else {
      // Add them to table
      $query = "INSERT INTO ".DB_TABLE_TEACHERS." (`name`, `email`) VALUES (:name, :email)";
      $stmt = $dbc->prepare($query);
      $stmt->execute(array(
        ':name' => $_SESSION['auth0__user']['name'],
        ':email' => $_SESSION['auth0__user']['email']
      ));
      if ($stmt->rowCount() > 0) {
        return true;
      } else {
        return false;
      }
    }
  }

  function validate_date($date) {
    $d = DateTime::createFromFormat('m/d/Y', $date);
    return $d && $d->format('m/d/Y') === $date;
  }
  function validate_time($time) {
    $d = DateTime::createFromFormat('g:i A', $time);
    return $d && $d->format('h:i A') === $time;
  }
  // convert for storage into MySQL db
  function format_date($date) {
    $d = DateTime::createFromFormat('m/d/Y', $date);
    return $d->format('Y-m-d');     // ex: 2017-07-12 from 07/12/2017
  }
  function format_time($time) {
    $t = DateTime::createFromFormat('h:i A', $date);
    return $t->format('H:i');       // convert to 24-hour time
  }

?>
