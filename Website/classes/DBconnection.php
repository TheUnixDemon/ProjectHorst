<?php
class DBconnection {
    private $servername;        // IP oder gleichwertiges
    private $username;
    private $password;
    private $database;

    public function __construct() { // logg-Daten hier übertragen
        $this->servername = "localhost";
        $this->username = "horst";
        $this->password = "horst123";
        $this->database = "horst";
    }

    public function getConnection() {
        
        try {
            //$connection = new mysqli($this->servername, $this->username, $this->password, $this->database); // diese Reihenfolge muss eingehalten werden
            $connection = new pdo("mysql:host=$this->servername;dbname=$this->database", $this->username, $this->password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            return $connection;
        } catch(PDOException $e) {
            echo "<p class='feedback'>" . "Connection failed: " . $e->getMessage() . "</p>";
        }
    }
}
?>