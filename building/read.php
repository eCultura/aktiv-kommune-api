<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/building.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$building = new Building($db);

// query building
$stmt = $building->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // building array
    $building_arr=array();
    $building_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $building_item=array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "homepage" => $homepage
        );

        array_push($building_arr["records"], $building_item);
    }

    echo json_encode($building_arr);
}

else{
    echo json_encode(
        array("message" => "No buildings found.")
    );
}
?>
