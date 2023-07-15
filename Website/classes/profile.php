<?php
class profile {
    private $connection;
    private $result; // in Array gespeicherte Datenbank-Daten
    private $user_id; // über diese werden die Userdaten ermittelt

    public function __construct($connection, $user_id) {
        $this->connection = $connection;
        $this->user_id = $user_id;
        
        $statement = $this->connection->prepare("SELECT * FROM user WHERE user_id = :user_id;");
        $statement->execute(array("user_id" => $this->user_id));

        $this->result = $statement->fetch();
    }

    public function getMyProfile() { // zur Auslagerung der Grafik der MyProfile-Website
        $username = $this->getUsername();
        $Full_score = $this->getFull_score() * 100;
        $user_profile = $this->getPicture();

        $ranking = new ranking($this->connection);      // Verbindungsaufbau mit der Klasse "ranking"
        $rank = $ranking->getUserRank($this->user_id);  // Rang des Spielers

        echo "
            <div class='profileContainer'>
                <div class='profile'>
                    <table>
                        <tr>
                        <td><img src=$user_profile alt='Error'></td>
                        <td class='username' valign=top>$username</td>
                        </tr>
                        <tr>
                            <th>Aktueller Rang</th>
                            <td># $rank</td>
                        </tr>
                        <tr>
                            <th>Win Rate</th>
                            <td>$Full_score %</td>
                        </tr>
                    </table>
                </div>
                <div class='lastRounds'>";
                    $ranking->getUserRounds($this->user_id);
                echo "
                </div>
            </div>

            <div class='userContainer'>
                <div class='editProfile'>
                    <table>
                        <form method='post' action='changeData.php'>
                            <tr>
                                <td><button type='submit' name='submit' value='user_image'>Profilbild ändern</button></td>
                                <td><button type='submit' name='submit' value='username'>Username ändern</button></td>
                            </tr>
                            <tr>
                                <td><button type='submit' name='submit' value='user_email'>E-Mail anpassen</button></td>
                                <td><button type='submit' name='submit' value='newPassword'>Passwort ändern</button></td>
                            </tr>
                            <tr>
                                <td><button type='submit' name='submit' value='deleteUser'>User löschen</button></td>
                            </tr>
                        </from>
                    </table>
                </div>
            </div>
    ";
    }

    public function getUsername() {
        return $this->result["username"];
    }
    public function getUsermail() {
        return $this->result["user_email"];
    }
    public function getPassword() {
        return $this->result["password"];
    }
    public function getPicture() {
        return $this->result["user_picture"];
    }
    public function getRights() {
        return $this->result["rights"];
    }
    public function getSuperRights() {
        return $this->result["superRights"];
    }
    public function getFull_score() {
        return $this->result["full_score"];
    }

    private function setUserData($categorie, $data): void { // schreibt abgeänderte Userdaten in die Datenbank
        try {
            $statement = $this->connection->prepare("UPDATE user SET $categorie = :data WHERE user_id = :user_id;"); //  Spalten- oder Tabellennamen normalerweise nicht als Parameter in einer Prepared Statement ersetzt werden, da Prepared Statements nur Werte, aber keine Spaltennamen ersetzen können, deshalb als Variable
            $statement->execute(array("data" => $data, "user_id" => $this->user_id));
        } catch(PDOException $e) {
            echo "<p class='feedback'>" . $e->getMessage() . "</p>";
        }
    }

    public function setUsername($username): void {
        $this->setUserData("username", $username); // ruft die basis-funktion auf
    }
    public function setUsermail($user_email): void {
        $this->setUserData("user_email", $user_email);
    }
    public function setPassword($password): void {
        $this->setUserData("password", $password);
    }
    public function setPicture($user_picture): void {
        $this->setUserData("user_picture", $user_picture);
    }
    public function setRights($rights): void {
        $this->setUserData("rights", $rights);
    }

    public function verifyPassword($password) { // für das externe Verifizieren des Users
        $realPassword = $this->getPassword();
        
        return password_verify($password, $realPassword);
    }

    public function deleteUser() {
        try {
        $statement = $this->connection->prepare("SELECT round_id FROM rounds WHERE user_id = :user_id;");
        $statement->execute(array("user_id" => $this->user_id));

        while($row = $statement->fetch()) {
            $deleteStatement = $this->connection->prepare("DELETE S FROM scores AS S INNER JOIN rounds AS R ON S.round_id = R.round_id WHERE S.round_id = :round_id; DELETE R FROM rounds AS R WHERE R.round_id = :round_id;");
            $deleteStatement->execute(array("round_id" => $row["round_id"]));
        }

        $statement = $this->connection->prepare("DELETE FROM user WHERE user_id = :user_id;");
        $statement->execute(array("user_id" => $this->user_id));
        
        } catch(PDOException $e) {
            echo "<p class='feedback'>" . "Connection failed: " . $e->getMessage() . "</p>";
        }
    }
}
?>
