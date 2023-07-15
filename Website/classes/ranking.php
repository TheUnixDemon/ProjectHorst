<?php
class ranking {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    } 
    public function getUserRounds($user_id) { // gibt Userspezifisch die letzten Runden aus
        $statement = $this->connection->prepare("SELECT scores.score, user.username AS owner, guest.username AS guest, rounds.role, rounds.round_create_date FROM rounds
        INNER JOIN scores ON rounds.round_id = scores.round_id INNER JOIN user as user ON rounds.user_id = user.user_id INNER JOIN user as guest ON rounds.guest_id = guest.user_id WHERE user.user_id = :user_id ORDER BY rounds.round_create_date DESC LIMIT 15;");
        $statement->execute(array("user_id" => $user_id));

        echo "<table>
        <tr>
            <th>Datum</th>
            <th>Gespielt mit</th>
            <th>Rolle</th>
            <th>Win/Lose</th>
        </tr>";
        while($row = $statement->fetch()) {
            if($row["role"] == 1) {
                $role = "Horst";
            } else {
                $role = "Grim";
            }
            if($row["score"] == 1) {
                $score = "gewonnen";
            } else {
                $score = "verloren";
            }

            echo "<tr>";
            echo "<td>" . $row["round_create_date"] . "</td>";
            echo "<td>" . $row["guest"] . "</td>";
            echo "<td>" . $role . "</td>";
            echo "<td>" . $score . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public function getUserRank($user_id): int {
        $statment = $this->connection->prepare("SELECT position, user_id, username, full_score FROM (SELECT user_id, username, full_score, @row_number:=@row_number+1 AS position
        FROM user, (SELECT @row_number:=0) AS rn ORDER BY full_score DESC) AS ranked_users WHERE user_id = :user_id;");
        $statment->execute(array("user_id" => $user_id));
        $row = $statment->fetch();

        return $row["position"];
    }

    public function getRankTable(): void { // gibt Rangliste zurück
        $statment = $this->connection->prepare("SELECT position, username, full_score FROM (SELECT user_id, username, full_score, @row_number:=@row_number+1 AS position 
        FROM user, (SELECT @row_number:=0) AS rn ORDER BY full_score DESC) AS ranked_users LIMIT 30;");
        $statment->execute();

        echo "
        <div class = 'containerTables'>
            <div class = 'scoreTable'>
                <table>
                    <tr>
                        <th>Rang</th>
                        <th>Username</th>
                        <th>Win-Rate</th>
                    </tr>
        ";
        while($row = $statment->fetch()) {
            echo "<tr>";
            echo "<td>" . $row["position"] . "</td>";
            echo "<td class='username'>" . $row["username"] . "</td>";
            echo "<td class='score'>" . $row["full_score"] * 100 . " %</td>";
            echo "</tr>";
        }
            echo "
                    </table>
                </div>
            </div>
            ";
    }
}
?>