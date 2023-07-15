<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rangliste</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/ranking.css">
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
    ?>

    <?php
    $htmlHandler = new htmlHandler();
    $htmlHandler->nav();

    $ranking = new ranking($connection);
    $ranking->getRankTable();

    $htmlHandler->footer();
    ?>
</body>
</html>