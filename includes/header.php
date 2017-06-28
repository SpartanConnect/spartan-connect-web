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

		    <link rel="stylesheet" type="text/css" href="bower_components/emojionearea/dist/emojionearea.min.css">
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.css">
        <link rel="stylesheet" type="text/css" href="res/styles.min.css">
        <link rel="icon" href="favicon.png">

        <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
		    <script src="bower_components/emojionearea/dist/emojionearea.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.min.js"></script>
        <script src="https://use.fontawesome.com/ac92a9740c.js"></script>
      </head>
      <body>
        <header>
          <div class="header-top">
            <span class="header-top-title" onclick="location.href=\'index.php\'">Spartan Connect</span>
            <i class="fa fa-bars header-top-mobile" aria-hidden="true"></i>
            <ul class="header-menu">';
      echo '<li onclick="location.href=\'index.php\'" href="#"><div id="headerItem">Home</div></li>';
      if ($_SESSION['authenticated']) {
        echo '<li onclick="location.href=\'user_panel.php\'" href="#">User Panel</li>';
        if ($_SESSION['privlevel'] == 1) {
          echo '<li onclick="location.href=\'admin_panel.php\'" href="#">Admin Panel</li>';
        }
        echo '<button onclick="signOut()">Sign Out</button>';
      }
      else {
        echo '<li><div class="g-signin2" data-onsuccess="onSignIn"></div></li></ul>';
      }
      echo '
          </div>
          <div class="header-school-container">
              <span class="header-school-text">La Cañada<br>High School</span>
          </div>
          <div class="header-title-container" onclick="location.href=\'index.php\'">
              <span class="header-title-text">Spartan Connect</span>
          </div>
          <script>
            $(document).ready(function() {
              if ($(".header-top-mobile").css("display") !== "none") {
                $(".header-menu").slideUp(0);
              }
            });
            $(window).resize(function() {
              if ($(".header-top-mobile").css("display") !== "none") {
                $(".header-menu").slideUp(0);
              }
              if ($(window).width() > 640) {
                $(".header-menu").slideDown(0);
              }
            });
            $(".header-top-mobile").click(function() {
              $(".header-menu").slideToggle();
            });
          </script>';
      if (!$_SESSION['authenticated']) {
        echo '<script src="https://apis.google.com/js/platform.js" async defer></script>';
        echo '<meta name="google-signin-client_id" content="'.OAUTH_CLIENT_ID.'">';
      }
      echo '</header>';
  }
  function get_footer() {
    echo '</body></html>';
  }
?>
