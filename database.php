<?php
class Database{

    //private $host = "172.20.252.173";
    private $host = "localhost";
    private $db_name = "p-342402_cardcol";
    private $username = "p-342402_col";
    private $password = "Su#4i040j";

    public $conn;
    public function getConnectionMysql(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

}
?>
