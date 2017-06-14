<?php
  function get_header($title) {
    session_start();
    echo '<!DOCTYPE html>
    <html>
      <head>
        <title>Spartan Connect: '.$title.'</title>

        <meta charset=UTF-8>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Welcome to Spartan Connect, La Cañada High School\'s official student connection program.">

        <meta property="og:title" content="'.$title.'">
        <meta property="og:description" content="Welcome to Spartan Connect, La Cañada High School\'s official student connection program.">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Spartan Connect">
        <meta property="og:url" content="http://www.connect.lchsspartans.net/">
        <meta property="og:image" content="">

        <link rel="stylesheet" type="text/css" href="index.css">
		    <link rel="stylesheet" type="text/css" href="bower_components/emojionearea/dist/emojionearea.min.css">
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css">

        <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
		    <script src="bower_components/emojionearea/dist/emojionearea.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
        <script src="https://use.fontawesome.com/ac92a9740c.js"></script>
      </head>
      <body>
        <header>
          <div class="header-top">
            <ul class="header-menu">';
      echo '<li onclick="location.href=\'index.php\'" href="#">Home</li>';
      if ($_SESSION['authenticated']) {
        echo '<li onclick="location.href=\'user_panel.php\'" href="#">User Panel</li>';
        if ($_SESSION['privlevel'] == 1) {
          echo '<li onclick="location.href=\'admin_panel.php\'" href="#">Admin Panel</li>';
        }
        echo '<li onclick="location.href=\'logout.php\'" href="#">Log Out</li>';
      } else {
        echo '<li onclick="showModal();" href="#">Log In</li>';
        echo '<div id="login-modal"></div>';
      }
      echo '</ul>
          </div>
          <div class="header-school-container">
              <span class="header-school-text">La Cañada<br>High School</span>
          </div>
          <div class="header-title-container" onclick="location.href=\'index.php\'">
              <span class="header-title-text">Spartan Connect</span>
          </div>
      </header>';
  }
  function get_footer() {
    echo '
    <script src="https://cdn.auth0.com/js/lock/10.16/lock.min.js"></script>
    <script>
      var lock = new Auth0Lock(\''.AUTH0_CLIENT_ID.'\', \''.AUTH0_DOMAIN.'\', {
        container: "login-modal",
        auth: {
          redirectUrl: \''.((IS_DEVELOPMENT ? LOCAL_URL : REMOTE_URL).AUTH0_REDIRECT_URI).'\',
          responseType: \'code\',
          params: {
            scope: \'openid\'
          }
        },
        theme: {
          primaryColor: "#862633",
          authButtons: {
            "google-oauth2": {
              displayName: "@lcusd.net",
              primaryColor: "#862633",
              foregroundColor: "#F2A900"
            }
          }
        },
        languageDictionary: {
          title: "Spartan Connect"
        }
      });
      function showModal() {
        $("#login-modal").toggleClass("hidden");
      }
      $(document).ready(function() {
        lock.show();
        //$("#login-modal").toggleClass("hidden");
      });
    </script>
      </body>
    </html>';
  }
?>
