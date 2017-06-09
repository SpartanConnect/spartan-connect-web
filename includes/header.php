<?php
  function get_header($title) {
    echo '<!DOCTYPE html>
    <html>
      <head>
        <title>Spartan Connect: '.$title.'</title>
        <link rel="stylesheet" type="text/css" href="index.css">
        <link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
        <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="http://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
      </head>
      <body>
        <header>
          <h1>Spartan Connect Header</h1>
          <i>Spartan Connect header goes here.</i>
        </header>';
  }
  function get_footer() {
    echo '</body></html>';
  }
?>
