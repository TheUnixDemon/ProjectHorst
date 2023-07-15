<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/nav.css">
    <link rel="stylesheet" type="text/css" href="css/footer.css">
    <link rel="stylesheet" type="text/css" href="css/register.css">
</head>
<body>
    
    <?php
    session_start();

    include_once("classes/DBconnection.php");
    include_once("classes/htmlHandler.php");
    include_once("classes/registration.php");
    include_once("classes/login.php");
    ?>

    <?php
    $DBconnection = new DBconnection();
    $connection = $DBconnection->getConnection();

    $htmlHandler = new htmlHandler();
    $htmlHandler->register();

    $reg_username = $_POST["reg_username"]; $log_username = $_POST["log_username"];
    $reg_email = $_POST["reg_email"];
    $reg_password = $_POST["reg_password"]; $log_password = $_POST["log_password"];
    $reg_passwordVerify = $_POST["reg_verifyPassword"];

    $reg_button = $_POST["reg_button"];
    $log_button = $_POST["log_button"];
    echo $button;

    if(!empty($reg_button)) {
        $register = new registration($connection, $reg_email, $reg_username, $reg_password, $reg_passwordVerify);
        $register->checkValues();
        $register->insertValues();
    } else if(!empty($log_button)) {
        $login = new login($connection, $log_username, $log_password);
        $login->selectValues();

        $_SESSION["connection"] = $connection;
    }
    ?>

</body>
</html>
