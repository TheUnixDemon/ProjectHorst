<?php

session_start();
$user_id = $_SESSION["user_id"];

include_once("DBconnection.php");
?>

<?php 
try {
    $DBconnection = new DBconnection;
    $connection = $DBconnection->getConnection();

    $statement = $connection->prepare("SELECT gameFile FROM game WHERE gameFile IS NOT NULL ORDER BY createDate DESC, release_id DESC LIMIT 1;");
    $statement->execute();
    
    $row = $statement->fetch();   
} catch(PDOException $e) {
    echo "Fehler: " . $e;
}
?>

<?php
    if($row['gameFile'] !== false) {
        $gamePath = $row['gameFile']; // neuster Game-Release, der eine Datei beeinhaltet wird hier als Pfad verlinkt
    } else {
        $gamePath = "test";
    }

    echo "
    <nav>
        <ul>
    ";
            echo "<li><a href='ranking.php'>Rangliste</a></li>";
            echo "<li><a href='" . $gamePath . "'>Download</a></li>";
            echo "<li><a href='homepage.php'>Startseite</a></li>";
            echo "<li><a href='release.php'>Changelog</a></li>";
            if(!empty($user_id)) {
                echo "<li><a href='myProfile.php'>Profil</a></li>";
            }
            echo "<li><a href='register.php'>Login</a></li>";
    echo "
        </ul>
    </nav>
    ";
?>