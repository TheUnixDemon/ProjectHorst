<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Release</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/release.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">

    <link rel="stylesheet" href="css/github-markdown-light.css">
</head>
<style>
	.markdown-body {
		box-sizing: border-box;
		min-width: 200px;
		max-width: 980px;
		margin: 0 auto;
		padding: 45px;
	}

	@media (max-width: 767px) {
		.markdown-body {
			padding: 15px;
		}
	}
</style>
<body>
    <?php
    session_start();

    include_once("classes/DBconnection.php");
    include_once("classes/profile.php");
    include_once("classes/release.php");
    include_once("classes/htmlHandler.php");
    ?>

    <?php
    $DBconnection = new DBconnection();
    $connection = $DBconnection->getConnection();

    $user_id = $_SESSION["user_id"];

    $htmlHandler = new htmlHandler;

    $profile = new profile($connection, $user_id);
    $release = new release($connection);
    ?>

    <?php
    $htmlHandler->nav();

    if($profile->getSuperRights() == true) {
        include_once("html/release.html");

        $delTitle = $_POST["delTitle"]; $createTitle = $_POST["createTitle"];
        $game = $_FILES["game"]; $markdown = $_FILES["markdown"];
        $delPass = $_POST["delPass"]; $createPass = $_POST["createPass"];
        $submit = $_POST["submit"];

        if(!empty($submit)) {
            if($submit == "submitRelease") {
                if($profile->verifyPassword($createPass) == true) {
                    if(!empty($createTitle) && !empty($markdown)) { // prüft, ob Titel und Markdown gesetzt ist 
                        if(!empty($game["name"])) { // argiert so, dass entweder mit oder ohne Gamefile gesichert wird
                            $release->setGameRelease($createTitle, $game, $markdown);
                        } else {
                            $release->setRelease($createTitle, $markdown);
                        }
                    } else {
                        echo "<p class='feedback'>Sie müssen mindestens einen Titel und eine Markdown angeben</p>";
                    }
                } else {
                    echo "<p class='feedback'>Die Verifizierung ist gescheitert</p>";
                }

            } else if($submit == "submitDelete") {
                if($profile->verifyPassword($delPass) == true) {
                    if(!empty($delTitle)) {
                        $release->delGameRelease($delTitle);
                    } else {
                        echo "<p class='feedback'>Sie haben einen Wert nicht gesetzt</p>";
                    }
                } else  {
                    "<p class='feedback'>Die Verifizierung ist gescheitert</p>";
                }
            }
        }
    }

    $release->getGameRelease();

    $htmlHandler->footer();
    ?>
</body>
</html>