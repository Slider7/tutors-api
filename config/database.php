<?php
class Database{
    // specify your own database credentials
    // private $username = "epiz_27570818";
    // private $password = "LmVgIzbXCVF0";
    private $username = 'root';
    private $password = 'mysql';
    private $db_name = 'epiz_27570818_tutors';
    private $host = 'localhost'; 

    public $conn;
      // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("SET NAMES 'utf8'");
        }catch(PDOException $exception){
            echo $this->db;
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>