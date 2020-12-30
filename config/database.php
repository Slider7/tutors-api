<?php
class Database{
    // specify your own database credentials

    private $username = "epiz_27570818";
    private $password = "LmVgIzbXCVF0";
    private $db_name = "epiz_27570818_tutors";
    private $host = "sql303.epizy.com:3306";

/*  public  $db = parse_ini_file("conn.ini");
    private $username = $db['user'];
    private $password = $db['pass'];
    private $db_name = $db['name'];
    private $host = $db['host']; */

    public $conn;
      // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("SET NAMES 'utf8'");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
  
        return $this->conn;
    }
}
?>