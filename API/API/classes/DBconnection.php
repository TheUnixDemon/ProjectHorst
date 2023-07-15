<?php
class DBconnection {
    private $servername;        // IP oder gleichwertiges
    private $username;
    private $password;
    private $database;

    public function __construct($servername, $database, $username, $password) { // übergibt alle nötigen Variablen für PDO
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    public function getConnection() { // gibt PDO SESSION zurück
        try {
            //$connection = new mysqli($this->servername, $this->username, $this->password, $this->database); // diese Reihenfolge muss eingehalten werden
            $connection = new pdo("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
?>