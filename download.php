<?php
  include('includes/include.php');
  include('includes/announcements.php');
  header('Content-Type: text/csv; charset=utf-8');
  header('Content-Disposition: attachment; filename=announcements.csv');
  $output = fopen('php://output', 'w');
  fputcsv($output, array('Name', 'Description', 'Start Date', 'End Date'));
  $rows = get_approved_announcements();
  foreach ($rows as $row)
  {
    fputcsv($output, $row);
  }

 ?>
