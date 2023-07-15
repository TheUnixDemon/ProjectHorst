<?php
class postRequest { // geeinhaltet alle post-Methoden die unter der post-Request laufen soll
    private $connection;
    public function __construct($connection) { // übernimmt die PDO-SESSION
        $this->connection = $connection;
    }

    public function postFullScore($user_id) { // setzt die User-Variable, die für den eigentlichen Score
        try {
            $statment = $this->connection->prepare("SELECT scores.score FROM rounds INNER JOIN scores ON rounds.round_id = scores.score_id WHERE user_id = :user_id ORDER BY rounds.round_create_date DESC LIMIT 20;");
            $statment->execute(array("user_id" => $user_id));

            $counter = 0;   // der gesamte Score aus allen Runden addiert
            $fullScore = 0; // für das Dividieren zuständig
            while($row = $statment->fetch()) {
                $fullScore = $fullScore + $row["score"];
                $counter = $counter + 1; 
            }
            
            if($counter >= 15) { // verhintert eine verfrühte User-Bewertung anhand der Runden-Scores
                $calculateFullScore = $fullScore / $counter;
            } else {
                $calculateFullScore = 0;
            }
            $calculateFullScore = round($calculateFullScore,  3); // damit nur die ersten drei Nachkommerstellen dargestellt werden

            $statment = $this->connection->prepare("UPDATE user SET full_score = :full_score WHERE user_id = :user_id;");
            $statment->execute(array("full_score" => $calculateFullScore, "user_id" => $user_id));
        
        } catch (PDOException $e) {
            // Behandlung des Fehlers
            echo "Fehler: " . $e->getMessage();
        }
    }  

    public function postScore($user_id, $guest_id, $role, $round_duration, $score) { // speichert die Runde und den Zugehötigen Score für die Runde(der Score gilt für die "user_id")
        try {
            $statement = $this->connection->prepare("INSERT INTO rounds (user_id, guest_id, role, round_create_date, round_duration)
            VALUES (:user_id, :guest_id, :role, NOW(), :round_duration);
            INSERT INTO scores (round_id, score) VALUES (LAST_INSERT_ID(), :score);");
            // LAST_INSERT_ID() nimmt die letzte round_id, die in der jetzigen erstellten PDO-SESSION erstellt wurde. Dies ist also nicht Verbindungs-Übergreifend
            $statement->execute(array("user_id" => $user_id, "guest_id" => $guest_id, "role" => $role, "round_duration" => $round_duration, "score" => $score));  

            $this->postFullScore($user_id); // ruft die Funktion auf für den Score
        } catch (PDOException $e) {
            // Behandlung des Fehlers
            echo "Fehler: " . $e->getMessage();
        }       
    } 
}
?>