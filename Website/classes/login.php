<?php
class login {
    private $connection;
    private $username;
    private $password;
    public function __construct($connection, $username, $password) {
        $this->connection = $connection;
        $this->username = $username;
        $this->password = $password;
    }
    public function selectValues() {    // gleicht Passwort und Username ab & übergibt Variablen an SESSION
        session_destroy(); // für den RESET, um mögliche Bugs zu verhindern, also nicht unbedingt notwendig
        session_start();

        $statement = $this->connection->prepare("SELECT * FROM user WHERE username = :username");
        $result = $statement->execute(array('username' => $this->username));
        $userdata = $statement->fetch();

        if($userdata !== false && password_verify($this->password, $userdata["password"])) {
            $_SESSION["user_id"] = $userdata["user_id"];

            header("Location: myProfile.php");
            exit;
        } else {
            echo "<p class='feedback'>Ihr Username oder Ihr Passwort ist falsch</p>";
        }
    }
}
?>