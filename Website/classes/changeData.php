<?php
include_once("profile.php");
class changeData {
    private $connection;
    private $profile; // Klassenobjekt der Klasse Profile für das Aufrufen von Userinformationen
    private $user_id;

    public function __construct($connection, $user_id) {
        $this->connection = $connection;
        $this->user_id = $user_id;

        $this->profile = new profile($this->connection, $this->user_id);
    }
    
    private function verifyPassword($password) {
        $realPassword = $this->profile->getPassword();
        
        return password_verify($password, $realPassword);
    }

    private function deleteSession() { // wird aufgerufen, um sich neu Anzumelden und fehler durch alte SESSION-Variablen zu verhindern
        sleep(2);
        session_destroy();
        header("Location: register.php");
    }

    public function changeProfile($password, $user_picture) { // Anpassung des Profilbildes
        $dir = "data/userProfile/user_id=" . $this->user_id; // hier werden die Profilbilder gespeichert
        $filename = $user_picture["name"];
        $filesize = $user_picture["size"];
        $tmp_path_data = $user_picture["tmp_name"];

        if($this->verifyPassword($password) == true) {
            if(!is_dir($dir)) { // checkt, ob Ordner für User-Profilbild erstellt wurde
                if(!mkdir($dir, 0777, false)) { // erstellt Ordner
                    echo "<p class='feedback'>Fehler beim Erstellen des Profilbild-Verzeichnisses</p>";
                }
            } 

            $max_size = 1000*1024; 
            if($filesize > $max_size) { // überprüft Größe der Datei
                echo "<p class='feedback'>Datei ist größer als ein MB</p>";
            } else {
                $pathWithName = $dir . "/" . $filename;
                array_map("unlink", glob($dir . "/*")); // löscht alle Dateien in dem Profil-Ordner
                if(move_uploaded_file($tmp_path_data, $pathWithName)) { // Verschiedt Datei in richtigen Ordner & checkt, ob es erfolgreich war | "tmp_name"  = temporärer Path von Datei
                    $this->profile->setPicture($pathWithName);
                    echo "<p class='feedback'>Profilbild wurde erfolgreich hochgeladen</p>";
                } else {
                    echo "<p class='feedback'>Es ist ein Fehler beim Hochladen geschehen</p>";
                }
            }
        } 
    }

    public function changeUsername($password, $username) {
        $statement = $this->connection->prepare("SELECT username FROM user WHERE username = :username;");
        $statement->execute(array("username" => $username));
        $row = $statement->fetch(); // fetch() gibt den Datensatz als Array aus
        if($row == false) {
            if($this->verifyPassword($password) == true) {
                $this->profile->setUsername($username);
                echo "<p class='feedback'>Der Username wurde erfolgreich geändert</p>" . $this->user_id;

                $this->deleteSession();
            } else {
                echo "<p class='feedback'>Das Passwort ist falsch</p>";
            }
        } else {
            echo "<p class='feedback'>Der Username ist bereits belegt</p>";
        }
    }

    public function changeMail($password, $user_email) {
        if($this->verifyPassword($password) == true) {
            $this->profile->setUsermail($user_email);
            echo "<p class='feedback'>Die Email wurde erfolgreich geändert</p>";

            $this->deleteSession();
        } else {
            echo "<p class='feedback'>Das Passwort ist falsch</p>";
        }
    }

    public function changePassword($password, $newPassword) {
        if($this->verifyPassword($password) == true) {
            $passwort_hash = password_hash($newPassword, PASSWORD_DEFAULT);  
            $this->profile->setPassword($passwort_hash);

            $this->deleteSession();
        } else {
            echo "<p class='feedback'>Das alte Passwort stimmt nicht</p>";
        }
    }

    public function deleteUser($password) {
        if($this->verifyPassword($password) == true) {
            $this->profile->deleteUser();

        } else {
            echo "<p class='feedback'>Das alte Passwort stimmt nicht</p>";
        }
    }
}
?>