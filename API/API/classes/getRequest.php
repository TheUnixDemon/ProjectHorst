<?php
class getRequest { // geeinhaltet alle Get-Methoden die unter der Get-Request laufen soll
    private $connection;
    public function __construct($connection) { // übernimmt die PDO-SESSION
        $this->connection = $connection;
    }

    public function getUser($username) { // gibt UserDaten wieder
        try {
            $statement = $this->connection->prepare("SELECT * FROM user WHERE username = :username;");
            $statement->execute(array("username" => $username));
            $row = $statement->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($row);
        } catch (PDOException $e) {
            // Behandlung des Fehlers
            echo "Fehler: " . $e->getMessage();
        }
    }
    public function getRounds($username) { // übergibt alle Informationen zu den Runden, anhand des Username
        try {
            $statement = $this->connection->prepare("SELECT scores.score, user.username AS owner, guest.username AS guest, rounds.role, rounds.round_create_date FROM rounds 
                INNER JOIN scores ON rounds.round_id = scores.round_id INNER JOIN user as user ON rounds.user_id = user.user_id INNER JOIN user as guest ON rounds.guest_id = guest.user_id WHERE user.username = :username ORDER BY rounds.round_create_date DESC LIMIT 20;");
            $statement->execute(array("username" => $username));
            $row = $statement->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($row);
        } catch (PDOException $e) {
            // Behandlung des Fehlers
            echo "Fehler: " . $e->getMessage();
        }
    }
    public function getRank($username) { // gibt für den entsprechenden User den Rang wirder
        try {
            $statement = $this->connection->prepare("SELECT position, user_id, username, full_score FROM (SELECT user_id, username, full_score, @row_number:=@row_number+1 AS position
                FROM user, (SELECT @row_number:=0) AS rn ORDER BY full_score DESC) AS ranked_users WHERE username = :username;"); // Orndnet dem User die Tabellen-Position zu und selektiert dann nach Username
            $statement->execute(array("username" => $username));
            $row = $statement->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($row);
        } catch (PDOException $e) {
            // Behandlung des Fehlers
            echo "Fehler: " . $e->getMessage();
        }
    }
}
?>