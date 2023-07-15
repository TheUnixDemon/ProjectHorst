<?php
require_once "parsedown/Parsedown.php";
class release {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    private function clearGameRelease() { // bereinigt die Einträge die Sicherheitslücken offen lassen und Speicher weiterhin belegen 
        try {
            $statement = $this->connection->prepare("SELECT * FROM game  WHERE release_id NOT IN 
            (SELECT release_id FROM 
            (SELECT release_id FROM game ORDER BY createDate DESC, release_id DESC LIMIT 5) as latest_releases)
            ORDER BY createDate DESC, release_id DESC;"); // filtert primär nach createDate und dann anch release_id
            $statement->execute();
            
            while($row = $statement->fetch()) { // return statement as array in $result
                $dir = "data/release/release_id=" . $row["release_id"];
    
                if (is_dir($dir) && is_readable($dir)) {
                    // Löschen Sie alle Dateien im Ordner
                    $files = glob($dir . '/*'); // Verwenden Sie die glob()-Funktion, um alle Dateien im Ordner zu erhalten
                    foreach ($files as $file) {
                        if (is_file($file)) {
                            unlink($file); // Löschen Sie jede Datei im Ordner
                        }
                    }
                    
                    // Löschen Sie den leeren Ordner
                    if (rmdir($dir) == false) {
                        echo "<p class='feedback'>Alte Ordner konnten nicht gelöscht werden</p>";
                    }
                }
            }
        } catch(PDOException $e) {
            echo "Fehler " . $e->getMessage();
        }

        try {
            $statement = $this->connection->prepare("DELETE FROM game WHERE release_id NOT IN 
            (SELECT release_id FROM 
            (SELECT release_id FROM game ORDER BY createDate DESC, release_id DESC
            LIMIT 5) as latest_releases) ORDER BY createDate DESC, release_id DESC;");
            $statement->execute(); // :example = $example
        
            $result = $statement->fetch(); // return statement as array in $result
        } catch(PDOException $e) {
            echo "Fehler: " . $e->getMessage();
        }
    }

    public function getGameRelease() {
        $this->clearGameRelease();

        try {
            $statement = $this->connection->prepare("SELECT * FROM game ORDER BY createDate DESC, release_id DESC LIMIT 5;"); // filtert primär nach createDate und dann anch release_id
            $statement->execute();

            echo "<div class='markdown-body'>";
            while($row = $statement->fetch()) {
                
                
                echo "<h1><u>Titel: " . $row["releaseTitle"] . "</u></h1>";
                echo "<h2>Datum: " . $row["createDate"] . "</h2>";


                $mdPath = $row["markdownFile"];
                if(file_exists($mdPath)) {

                    $md = file_get_contents($mdPath);
                    $Parsedown = new Parsedown();
                    $html = $Parsedown->text($md);

                    echo $html;
                }
            }
            echo "</div>";
            
        } catch(PDOException $e) {
            echo "Fehler: " . $e;
        }
    }

    public function setRelease($createTitle, $markdown) { // Methode für die Option, nur die Markdown hochzuladen(überladen hat nicht geklappt)
        try { // Erstellung des Eintrages
            $statement = $this->connection->prepare("INSERT INTO game (createDate, releaseTitle) VALUES (NOW(), :releaseTitle);");
            $statement->execute(array("releaseTitle" => $createTitle));

            $release_id = $this->connection->lastInsertId(); // übergibt die ID für Ordner und UPDATE des Eintrages
        } catch(PDOException $e) {
            echo "Fehler: " . $e;
        }
        
        $dir = "data/release/release_id=" . $release_id; // hier werden die Releases gespeichert

        $markdownFilename = $markdown["name"];
        $markdownTmp_path_data = $markdown["tmp_name"]; 

        if(!is_dir($dir)) { // checkt, ob der Ordner schon erstellt wurde
            if(!mkdir($dir, 0777, false)) { // erstellt Ordner
                echo "<p class='feedback'>Fehler beim Erstellen des Release-Verzeichnisses</p>";
            }
        }

        $pathMarkdown = $dir . "/" . $markdownFilename;
        array_map("unlink", glob($dir . "/*")); // löscht alle Dateien in dem Release-Ordner, falls Dateien vorhanden

        if(move_uploaded_file($markdownTmp_path_data, $pathMarkdown)) { // Verschiedt Datei in richtigen Ordner & checkt, ob es erfolgreich war | "tmp_name"  = temporärer Path von Datei
            try { // fügt Pfade zu den Dateien zu dem Eintrag hinzu
                $statement = $this->connection->prepare("UPDATE game SET markdownFile = :markdownFile WHERE release_id = $release_id;");
                $statement->execute(array("markdownFile" => $pathMarkdown));
            } catch(PDOException $e) {
                echo "Fehler: " . $e;
            }

            echo "<p class='feedback'>Markdown wurde erfolgreich hochgeladen</p>";
        } else {
            echo "<p class='feedback'>Es ist ein Fehler beim Hochladen geschehen</p>";
            $this->delGameRelease($createTitle);
        }
    }

    public function setGameRelease($createTitle, $game, $markdown) {
        try { // Erstellung des Eintrages
            $statement = $this->connection->prepare("INSERT INTO game (createDate, releaseTitle) VALUES (NOW(), :releaseTitle);");
            $statement->execute(array("releaseTitle" => $createTitle));

            $release_id = $this->connection->lastInsertId(); // übergibt die ID für Ordner und UPDATE des Eintrages
        } catch(PDOException $e) {
            echo "Fehler: " . $e;
        }
        
        $dir = "data/release/release_id=" . $release_id; // hier werden die Releases gespeichert

        $gameFilename = $game["name"]; $markdownFilename = $markdown["name"];
        $gameTmp_path_data = $game["tmp_name"]; $markdownTmp_path_data = $markdown["tmp_name"]; 

        if(!is_dir($dir)) { // checkt, ob der Ordner schon erstellt wurde
            if(!mkdir($dir, 0777, false)) { // erstellt Ordner
                echo "<p class='feedback'>Fehler beim Erstellen des Release-Verzeichnisses</p>";
            }
        }

        $pathGame = $dir . "/" . $gameFilename; 
        $pathMarkdown = $dir . "/" . $markdownFilename;
        array_map("unlink", glob($dir . "/*")); // löscht alle Dateien in dem Release-Ordner, falls Dateien vorhanden

        if(move_uploaded_file($gameTmp_path_data, $pathGame) && move_uploaded_file($markdownTmp_path_data, $pathMarkdown)) { // Verschiedt Datei in richtigen Ordner & checkt, ob es erfolgreich war | "tmp_name"  = temporärer Path von Datei
            try { // fügt Pfade zu den Dateien zu dem Eintrag hinzu
                $statement = $this->connection->prepare("UPDATE game SET gameFile = :gameFile, markdownFile = :markdownFile WHERE release_id = $release_id;");
                $statement->execute(array("gameFile" => $pathGame, "markdownFile" => $pathMarkdown));
            } catch(PDOException $e) {
                echo "Fehler: " . $e;
            }

            echo "<p class='feedback'>Game & Markdown wurde erfolgreich hochgeladen</p>";
        } else {
            echo "<p class='feedback'>Es ist ein Fehler beim Hochladen geschehen</p>";
            $this->delGameRelease($createTitle);
        }
    }

    public function delGameRelease($delTitle) {
        try {
            $statement = $this->connection->prepare("SELECT * FROM game WHERE releaseTitle = :releaseTitle;");
            $statement->execute(array("releaseTitle" => $delTitle));
            
            if($row = $statement->fetch() == false) {
                echo "<p class='feedback'>Der Name des Releases muss aus Sicherheitsgründen exakt übereinstimmen</p>";
            } else {
                $statement = $this->connection->prepare("DELETE FROM game WHERE releaseTitle = :releaseTitle;");
                $statement->execute(array("releaseTitle" => $delTitle));

                echo "<p class='feedback'>Der Release wurde erfolgreich gelöscht</p>";
            }
            
        } catch(PDOException $e) {
            echo "Fehler: " . $e;
        }
    }
}

?>