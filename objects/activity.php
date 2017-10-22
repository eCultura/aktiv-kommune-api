<?php
class Activity{

    // database connection and table name
    private $conn;
    private $table_name = 'bb_activity';

    // object properties
    public $id;
    public $name;
    public $parent_id;
    public $description;
    public $active;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

// read activity
function read(){

    // select all query
    $query = "SELECT
            bb_activity.id,
            bb_activity.name,
            bb_activity.parent_id,
            bb_activity.description
            FROM bb_activity
            WHERE bb_activity.active=1;";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}

// create activity
function create(){

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                name=:name, parent_id=:parent_id, description=:description, active=:active";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->parent_id=htmlspecialchars(strip_tags($this->parent_id));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->active=htmlspecialchars(strip_tags($this->active));

    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":parent_id", $this->parent_id);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":active", $this->active);

    // execute query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}

// used when filling up the update activity form
function readOne(){

    $query =  "SELECT id, name, parent_id, description, active
              FROM ". $this->table_name . "
              WHERE id = ?
              LIMIT 1;";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->name = $row['name'];
    $this->parent_id = $row['parent_id'];
    $this->description = $row['description'];
    $this->active = $row['active'];

}

// update the activity
function update(){

    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                parent_id = :parent_id,
                description = :description,
                active = :active
            WHERE
                id = :id";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->name=htmlspecialchars(strip_tags($this->name));
    $this->parent_id=htmlspecialchars(strip_tags($this->parent_id));
    $this->description=htmlspecialchars(strip_tags($this->description));
    $this->active=htmlspecialchars(strip_tags($this->active));
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':parent_id', $this->parent_id);
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

// delete the activity
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

// search activity
function search($keywords){

    // select all query
    $query = "SELECT
                id, name, parent_id, description, active
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
