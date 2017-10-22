<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/building.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare building object
$building = new Building($db);

// set ID property of building to be edited
$building->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of building to be edited
$building->readOne();

// create array
$building_arr = array(
    "id" =>  $building->id,
    "name" => $building->name,
    "description" => $building->description,
    "homepage" => $building->homepage,
    "active" => $building->active

);

// make it json format
print_r(json_encode($building_arr));
?>
