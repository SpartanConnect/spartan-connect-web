<?php
  function get_header($title) {
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
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
        <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
        <script src="https://use.fontawesome.com/ac92a9740c.js"></script>
      </head>
      <body>
      <header>
          <div class="header-top"></div>
          <div class="header-school-container">
              <span class="header-school-text">La Cañada<br>High School</span>
          </div>
          <div class="header-title-container" onclick="location.href=\'index.php\'">
              <span class="header-title-text">Spartan Connect</span>
          </div>
      </header>';
  }
  function get_footer() {
    echo '</body></html>';
  }
?>
