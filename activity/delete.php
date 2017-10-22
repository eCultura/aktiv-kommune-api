<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file
include_once '../config/database.php';
include_once '../objects/activity.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare activity object
$activity = new Activity($db);

// get activity id
$data = json_decode(file_get_contents("php://input"));

echo 'Data : ' . $data;

// set activity id to be deleted
$activity->id = $data->id;

// delete the activity
if($activity->delete()){
    echo '{';
        echo '"message": "Activity was deleted."';
    echo '}';
}

// if unable to delete the activity
else{
    echo '{';
        echo '"message": "Unable to delete activity."';
    echo '}';
}
?>
