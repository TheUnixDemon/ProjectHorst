<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Datenschutzerklärung</title>

    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/terms.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
</head>
<body>
    <?php
    session_start();

    include_once("classes/DBconnection.php");
    include_once("classes/htmlHandler.php");
    include_once("classes/profile.php");
    ?>

    <?php
    $htmlHandler = new htmlHandler;
    $htmlHandler->nav();

    $htmlHandler->datenschutzerklärung();
    //$htmlHandler->footer();
    ?>
</body>
</html>