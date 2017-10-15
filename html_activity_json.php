<?php
/*
File  Name: html_activity_json.php
File  URI: https://wiki.aktiv-kommune.no/
Description: Used in Aktiv komunne API files
Version: 0.1.0
Author: Arild M. Halvorsen
Author URI: http://about.me/arild
*/

  include_once("/system.php");

  $con = pg_connect("host=".DB_HOST. " port=" .DB_PORT. " dbname=" .DB_NAME. " user=" .DB_USER. " password=" .DB_PASS);
  pg_set_client_encoding($con, "UTF8");

  $sql = "SELECT
          bb_activity.id,
          bb_activity.name,
          bb_activity.parent_id
          FROM bb_activity
          WHERE bb_activity.active=1;";

  $result = pg_query($con, $sql) or die('Query failed: ' . pg_last_error());

  $act_array = array();

  while ($row = pg_fetch_row($result)) {

      $activity_id = $row[0];
      $activity_name = $row[1];
      $activity_parent_id = $row[2];

          $act_array[] = array(
              'id' => $activity_id,
              'name' => $activity_name,
              'parent_id' => $activity_parent_id);

  }

  pg_close($con);

  $file = fopen('html_activity.json', 'w');
  fwrite($file, json_encode($act_array, JSON_PRETTY_PRINT));
  fclose($file);

  if ( CRON_JOB_OUTPUT ) {
    echo json_encode($act_array, JSON_PRETTY_PRINT);
  }

?>
