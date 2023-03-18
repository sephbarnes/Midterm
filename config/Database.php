<?php 
  class Database {
    // DB Params
    private $username; 
    private $password; 
    private $dbname; 
    private $host; 
    private $port; 
    private $conn;

    public function __construct() {
        $this->username = 'postgres';
        $this->password = 'Sh3mas43P';
        $this->dbname = 'quotesdb';
        $this->host = 'localhost';
        $this->port = '5432';
      }
/*
public function __construct() {
  $this->username = getenv('USERNAME');
  $this->password = getenv('PASSWORD');
  $this->dbname = getenv('DBNAME');
  $this->host = getenv('HOST');
  $this->port = getenv('PORT');
}*/

    // Database Connection
       public function connect () {
             if ($this->conn) {
                 return $this->conn;
             } else {
                 $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->dbname};";

                 try {
                     $this->conn = new PDO($dsn, $this->username, $this->password);
                     $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                     return $this->conn;  
                 } catch(PDOException $e) {
                     echo 'Connection Error: ' . $e->getMessage();
                 }
             }
         }
  }