<?php
  include('constants.php');
  include('secret.php');

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
    } else {
      $_SESSION['authenticated'] = false;
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

?>
