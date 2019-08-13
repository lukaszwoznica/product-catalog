<?php
    class Database{
        private $host = "localhost";
        private $db_name = "catalog_database";
        private $username = "root";
        private $password = "";  
        public $connection;

        public function dbConnect(){
            $this->connection = null;
            try{
                $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8", $this->username, $this->password);
                $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            }
            catch(PDOException $exception){
                echo "Błąd połączenia: " . $exception->getMessage();
            }
            
            return $this->connection;
        }
    }
?>