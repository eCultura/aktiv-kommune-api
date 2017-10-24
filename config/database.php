<?php
include_once("system.php");
class Database{

    // specify database credentials
    private $host = DB_HOST;
    private $dbname = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;
    public $conn;

    // get the database connection
    public function getConnection(){

        $this->conn = null;

        try{
            $dsn = 'pgsql:host=' . $this->host .';port='. $this->port. ';dbname='. $this->db_name. ';user='. $this->username . ';password='. $this->password;
            $this->conn = new PDO($dsn);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec('SET CLIENT_ENCODING TO UTF8;');
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
