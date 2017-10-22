<?php
class Building{

    // database connection and table name
    private $conn;
    private $table_name = 'bb_building';

    // object properties
    public $id;
    public $active;
    public $deactivate_calendar;
    public $deactivate_application;
    public $deactivate_sendmessage;
    public $name;
    public $homepage;
    public $location_code;
    public $phone;
    public $email;
    public $street;
    public $zip_code;
    public $district;
    public $city;
    public $description;
    public $tilsyn_name;
    public $tilsyn_email;
    public $tilsyn_phone;
    public $calendar_text;
    public $tilsyn_name2;
    public $tilsyn_email2;
    public $tilsyn_phone2;
    public $extra_kalendar;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

// read building
function read(){

    // select all query
    $query = "SELECT
            bb_building.id,
            bb_building.name,
            bb_building.homepage,
            bb_building.description
            FROM bb_building
            WHERE bb_building.active=1;";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}

// create buiding
function create(){

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, homepage=:homepage, description=:description, active=:active";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->homepage=htmlspecialchars(strip_tags($this->homepage));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->active=htmlspecialchars(strip_tags($this->active));

    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":homepage", $this->parent_id);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":active", $this->active);

    // execute query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}

// used when filling up the update building form
function readOne(){

    $query =  "SELECT id, name, homepage, description, active
              FROM ". $this->table_name . "
              WHERE id = ?
              LIMIT 1;";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of building to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->name = $row['name'];
    $this->homepage = $row['homepage'];
    $this->description = $row['description'];
    $this->active = $row['active'];

}

// update the building
function update(){

    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                parent_id = :homepage,
                description = :description,
                active = :active
            WHERE
                id = :id";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->homepage=htmlspecialchars(strip_tags($this->homepage));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->active=htmlspecialchars(strip_tags($this->active));
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':homepage', $this->homepage);
    $stmt->bindParam(':description', $this->description);
    $stmt->bindParam(':active', $this->active);
    $stmt->bindParam(':id', $this->id);

    // execute the query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}

// delete the building
function delete(){

    // delete query
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

    echo $query;

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind id of record to delete
    $stmt->bindParam(1, $this->id);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;

}

// search building
function search($keywords){

    // select all query
    $query = "SELECT
                id, name, homepage, description, active
            FROM
                " . $this->table_name . "
            WHERE
                LOWER(name) LIKE LOWER(?)
            ORDER BY
                name;";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";

    // bind
    $stmt->bindParam(1, $keywords);
    // $stmt->bindParam(2, $keywords);
    // $stmt->bindParam(3, $keywords);

    // execute query
    $stmt->execute();

    return $stmt;
}
}
?>
