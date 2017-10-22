<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/activity.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare activity object
$activity = new Activity($db);

// set ID property of activity to be edited
$activity->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of activity to be edited
$activity->readOne();

// create array
$activity_arr = array(
    "id" =>  $activity->id,
    "name" => $activity->name,
    "description" => $activity->description,
    "parent_id" => $activity->parent_id,
    "active" => $activity->active

);

// make it json format
print_r(json_encode($activity_arr));
?>
