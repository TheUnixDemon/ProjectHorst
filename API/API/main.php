<?php
include_once("classes/DBconnection.php");
include_once("classes/getRequest.php");
include_once("classes/postRequest.php");

$DBconnection = new DBconnection("localhost", "horst", "horst", "horst123"); // erstellt eine PDO-SESSION
$connection = $DBconnection->getConnection(); 

header("Access-Control-Allow-Origin: *"); // verhindert möliche Fehler durch den Browser
$method = $_SERVER["REQUEST_METHOD"];     // fragt die Request-Methode ab

if($method == "GET") {
    $getMethod = $_GET["method"];
    
    if(!empty($getMethod)) {
        header("Content-Type: application/json");  // schaltet auf die JSON-Ansicht
        $getRequest = new getRequest($connection); // übergibt PDO-SESSION an Klasse

        $username = $_GET["username"];
        if($getMethod == "getUser") {
            $getRequest->getUser($username);
        }
        if($getMethod == "getRounds") {
            $getRequest->getRounds($username);
        }
        if($getMethod == "getRank") {
            $getRequest->getRank($username);
        }
    }
}

if($method == "POST") {
    $postMethod = $_POST["method"];
    
    if(!empty($postMethod)) {
        $postRequest = new postRequest($connection); // übergibt PDO-SESSION an Klasse

        if($postMethod == "postScore") { // speichert die Runde und den zugehörigen Score
            // ist inklusieve der Einträge der Rounds
            $user_id = $_POST["user_id"];
            $guest_id = $_POST["guest_id"];
            $role = $_POST["role"];
            $round_duration = $_POST["round_duration"];
            $score = $_POST["score"];
        
            $postRequest->postScore($user_id, $guest_id, $role, $round_duration, $score);
        }
        if($postMethod == "postFullScore") { // fullScore bildet sich aus den letzten Runden und zeigt den Durichschnit an
            $user_id = $_POST["user_id"];

            $postRequest->postFullScore($user_id);
        }
    }
}
?>