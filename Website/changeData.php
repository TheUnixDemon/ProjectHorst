<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Userinformationen ändern</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/changeData.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<body>
    <?php
    session_start();

    include_once("classes/DBconnection.php");
    include_once("classes/htmlHandler.php");
    include_once("classes/profile.php");
    include_once("classes/changeData.php");
    ?>
    
    <?php
    $DBconnection = new DBconnection();
    $connection = $DBconnection->getConnection();
    
    $user_id = $_SESSION["user_id"];
    $profile = new profile($connection, $user_id);

    $htmlHandler = new htmlHandler();

    $submit = $_POST["submit"]; // die Auswahl welche Änderung vorgenommen werden soll

    // aus den zuvor geladenen Change modulen des Änderns der Userdaten
    $submitChange = $_POST["submitChange"]; // value = newPassword or username or user_image or user_email

    $user_image = $_FILES["user_image"];
    $user_email = $_POST["user_email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $newPassword = $_POST["newPassword"];
    ?>

    <?php
    $htmlHandler->nav();

    if(!empty($submit)) { // Speichert die Variable für das laden nach dem neu laden des Tabs
        switch($submit) {
            case "user_image";
                $_SESSION["changeSetting"] = "user_image";
                break;
            case "username";
                $_SESSION["changeSetting"] = "username";
                break;
            case "user_email";
                $_SESSION["changeSetting"] = "user_email";
                break;
            case "newPassword";
                $_SESSION["changeSetting"] = "newPassword";
                break;
            case "deleteUser";
                $_SESSION["changeSetting"] = "deleteUser";
                break;
        }
    }

    if(!empty($_SESSION["changeSetting"])) { // lädt das HTML-Modul auch bei neu Laden der Website
        switch($_SESSION["changeSetting"]) {
            case "user_image";
                include_once("html/modulsChangeData/image.html");
                break;
            case "username";
                include_once("html/modulsChangeData/username.html");
                break;
            case "user_email";
                echo "<p class='feedback'>Ihre Email: <br>" . $profile->getUsermail() . "</p>"; 
                include_once("html/modulsChangeData/email.html");
                break;
            case "newPassword";
                include_once("html/modulsChangeData/password.html");
                break;
            case "deleteUser";
                include_once("html/modulsChangeData/deleteUser.html");
                break;
        }
    }

    if(!empty($submitChange)) { // checkt die an die Klasse zu übergebenden Variablen
        $changeData = new changeData($connection, $user_id);
        switch($submitChange) {
            case "user_image";
                if(!empty($user_image) AND !empty($password)) {
                    $changeData->changeProfile($password, $user_image);
                } else {
                    echo "<p class='feedback'>Es wurde ein Wert nicht gesetzt</p>";
                }
                break;

            case "username";
                if(!empty($username) AND !empty($password)) {
                    $changeData->changeUsername($password, $username);
                } else {
                    echo "<p class='feedback'>Es wurde ein Wert nicht gesetzt</p>";
                }
                break;

            case "user_email";
                if(!empty($user_email) AND !empty($password)) {
                    $changeData->changeMail($password, $user_email);
                } else {
                    echo "<p class='feedback'>Es wurde ein Wert nicht gesetzt</p>";
                }
                break;

            case "newPassword";
                if(!empty($newPassword) AND !empty($password)) {
                    $changeData->changePassword($password, $newPassword);
                } else {
                    echo "<p class='feedback'>Es wurde ein Wert nicht gesetzt</p>";
                }
                break;
                
            case "deleteUser";
                if(!empty($password)) {
                    $changeData->deleteUser($password);
                } else {
                    echo "<p class='feedback'>Es wurde ein Wert nicht gesetzt</p>";
                }
                break;
        }
    }
    $htmlHandler->footer();
    ?>
</body>
</html>