<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/organization.php';

// instantiate database and product object
$database = new Database();
$db = $database->getConnection();

// initialize object
$organization = new Organization($db);

// query organization
$stmt = $organization->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // organization array
    $organization_arr=array();
    $organization_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $organization_item=array(
            "id" => $id,
            "name" => $name,
            "description" => $description,
            "homepage" => $homepage
        );

        array_push($organization_arr["records"], $organization_item);
    }

    echo json_encode($organization_arr);
}

else{
    echo json_encode(
        array("message" => "No organizations found.")
    );
}
?>
