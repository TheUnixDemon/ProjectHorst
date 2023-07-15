<?php
class registration {
    private $connection; // hier wird die PDO-Session mir der Datenbank übertragen
    private $error;
    private $email;
    private $username;
    private $password;
    private $passwordVerify;
    
    public function __construct($connection, $email, $username, $password, $passwordVerify) {
        $this->connection = $connection;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->passwordVerify = $passwordVerify;
}

    public function insertValues(): void {
        if($this->error == false) {
            $passwort_hash = password_hash($this->password, PASSWORD_DEFAULT);  // PASSWORD_DEFAULT nutzt die beste HASH-Methode, die implementiert wurde
            $statement = $this->connection->prepare("INSERT INTO user (username, user_email, password, user_picture, rights, superRights) VALUES (:username, :user_email, :password, 'data/userProfile/default.png', false, false);");
            $result = $statement->execute(array("username" => $this->username, "user_email" => $this->email, "password" => $passwort_hash));
        
            echo "<p class='feedback'>Ihr Account wurde erstellt</p>";
        }
    }

    public function checkValues(): void {
        $this->error = false;
        
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->error = true;
            echo "<p class='feedback'>Die E-Mail ist ungültig</p>";
        }
        if(strlen($this->username) == 0) {
            $this->error = true;
            echo "<p class='feedback'>Es wurde kein Username angegeben</p>";
        }
        if(strlen($this->password) < 8) {
            $this->error = true;
            echo "<p class='feedback'>Das Passwort muss mindestens 8 Zeichen beeinhalten</p>";
        }
        if($this->password != $this->passwordVerify) {
            $this->error = true;
            echo "<p class='feedback'>Die Passwörter stimmen nicht überein</p>";
        }

        // prüfe, ob die Email noch zur Verfügung steht
        if($this->error == false) {
            $statement = $this->connection->prepare("SELECT * FROM user WHERE username = :username;");
            $result = $statement->execute(array("username" => $this->username));
            $username = $statement->fetch();

            if($username !== false) {  // hier wird "ungleich false" verwendet, weil wenn $username leer ist dann "false" und wenn nicht dann weder "true" noch "false"
                $this->error = true;
                echo "<p class='feedback'>Der Username oder die Email ist schon belegt</p>";
            }
        }
    }
}