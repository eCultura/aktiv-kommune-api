<?php
/*
File  Name: activity_json.php
File  URI: https://wiki.aktiv-kommune.no/
Description: Used in Aktiv komunne API files
Version: 0.1.0
Author: Arild M. Halvorsen
Author URI: http://about.me/arild
License: GLPv2
*/

  include_once("system.php");

if (isset($_GET['html_code'])) {
  $html_code = $_GET['html_code'];
  if ( $html_code == 1 ) {
    $html_code = TRUE;
  }
} else {
  $html_code = FALSE;
}

if (isset($_GET['csv_create'])) {
  $csv_create = $_GET['csv_create'];
  if ( $csv_create == 1 ){
    $csv_create = TRUE;
  }
} else {
  $csv_create = FALSE;
}

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

  if ( $csv_create ) {
    $file = fopen('activity.csv', 'w');
    fputcsv( $file, array('Id', 'Name', 'Parent Id' ));
  }

  while ($row = pg_fetch_row($result)) {

      $activity_id = $row[0];
      $activity_name = $row[1];
      $activity_parent_id = $row[2];

      if ( $html_code ) {

        if ( $activity_parent_id > 0 ) {
            $html_string = '
              <a class="btn btn-primary btn-lg" href="'.gethostname().'/lag-og-organisasjonar/?wdt_column_filter[13]='.$activity_id.'">'.$activity_name. '</a>
            ';
        } else {
            $html_string = '
             <a class="btn btn-danger btn-lg" href="'.gethostname(). '/aktivitetar/?wdt_column_filter[2]='.$activity_id.'">' .$activity_name. '</a>
            ';
        }

        $act_array[] = array(
            'id' => $activity_id,
            'name' => $activity_name,
            'parent_id' => $activity_parent_id,
            'html_string' => $html_string);

      } else {

          $act_array[] = array(
              'id' => $activity_id,
              'name' => $activity_name,
              'parent_id' => $activity_parent_id);
      }

          if ( $csv_create ) {
            fputcsv( $file, array( $activity_id, $activity_name, $activity_parent_id ));
          }

  }

  pg_close($con);

  if ( $csv_create ) {
    fclose($file);
  }

  if ( $html_code ) {
    $file = fopen('html_activity.json', 'w');
  } else {
    $file = fopen('activity.json', 'w');
  }

  fwrite($file, json_encode($act_array, JSON_PRETTY_PRINT));
  fclose($file);

  if ( CRON_JOB_OUTPUT ) {
    echo json_encode($act_array, JSON_PRETTY_PRINT);
  }

?>
