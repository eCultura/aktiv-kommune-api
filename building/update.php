<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/activity.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare product object
$activity = new Activity($db);

// get id of activity to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of product to be edited
$activity->id = $data->id;

// set activity property values
$activity->name = $data->name;
$activity->parent_id = $data->parent_id;
$activity->active = $data->active;

// update the activity
if($activity->update()){
    echo '{';
        echo '"message": "Activity was updated."';
    echo '}';
}

// if unable to update the activity, tell the user
else{
    echo '{';
        echo '"message": "Unable to update activity."';
    echo '}';
}
?>s
