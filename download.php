<?php
  include('includes/include.php');
  include('includes/announcements.php');
  header('Content-Type: text/csv; charset=utf-16');
  header('Content-Disposition: attachment; filename=announcements.csv');
  $output = fopen('php://output', 'w');
  fputcsv($output, array('Name', 'Description', 'Start Date', 'End Date', 'Teacher'));
  $rows = get_approved_announcements();

  foreach ($rows as $row) {
    $result = array(
      'name' => mb_convert_encoding($row['name'], "UTF-8", "HTML-ENTITIES"),
      'description' => mb_convert_encoding($row['description'], "UTF-8", "HTML-ENTITIES"),
      'startDate' => $row['startDate'],
      'endDate' => $row['endDate'],
      'teacher' => get_teacher($row['teacherID'])
    );

    fputcsv($output, $result);
  }

 ?>
