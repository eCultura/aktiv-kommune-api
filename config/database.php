<?php
class Database{

    // specify database credentials
    private $host = '';
    private $port = '';
    private $db_name = '';
    private $username = '';
    private $password = '';
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
