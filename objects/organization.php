<?php
class Organization{

    // database connection and table name
    private $conn;
    private $table_name = 'bb_organization';

    // object properties
    public $id;
    public $organization_number;
    public $active;
    public $name;
    public $homepage;
    public $phone;
    public $email;
    public $street;
    public $zip_code;
    public $district;
    public $city;
    public $description;
    public $activity_id;
    public $customer_identifier_type;
    public $customer_number;
    public $customer_organization_number;
    public $customer_ssn;
    public $customer_internal;
    public $shortname;
    public $show_in_portal;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

// read organization
function read(){

    // select all query
    $query = "SELECT
            bb_organization.id,
            bb_organization.name,
            bb_organization.homepage,
            bb_organization.description
            FROM bb_organization
            WHERE bb_organization.active=1;";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}

// create organization
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
    $stmt->bindParam(":homepage", $this->homepage);
    $stmt->bindParam(":description", $this->description);
    $stmt->bindParam(":active", $this->active);

    // execute query
    if($stmt->execute()){
        return true;
    }else{
        return false;
    }
}

// used when filling up the update organization form
function readOne(){

    $query =  "SELECT id, name, homepage, description, active
              FROM ". $this->table_name . "
              WHERE id = ?
              LIMIT 1;";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of organization to be updated
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

// update the organization
function update(){

    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                name = :name,
                homepage = :homepage,
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

// delete the organization
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

// search organization
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
