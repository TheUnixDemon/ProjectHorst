<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<body>
    <?php
    session_start();

    include_once("classes/DBconnection.php");
    include_once("classes/htmlHandler.php");
    include_once("classes/profile.php");
    include_once("classes/ranking.php");
    ?>
    
    <?php
    $DBconnection = new DBconnection();
    $connection = $DBconnection->getConnection();

    $user_id = $_SESSION["user_id"];
    $profile = new profile($connection, $user_id);
    ?>

    <?php
    $htmlHandler = new htmlHandler();
    $htmlHandler->nav();
    if(!empty($user_id)) { // wird gecheckt, ob es sich schon angemeldet wurde
        $profile->getMyProfile(); // lädt die HTML-Module über die Klasse "profile"
    } else {
        // echo "<p class='feedback'>Sie müssen sich erst <a href='register.php'>Anmelden</a>, um Ihr Profil zu sehen</p>";
        header("Location: register.php");
        exit;
    }
    $htmlHandler->footer();
    ?>
</body>
</html>
