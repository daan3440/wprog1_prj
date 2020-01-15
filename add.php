<?php
//header('Content-type: text/plain');
include 'connection.php';
include 'functions.php';
$con = new Connection();
$fun = new Functions();
$pdo = $con->initConnection();

//echo print_r($word);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $req = $_REQUEST;
//    echo print_r($req);
    $word = array($req);
    $con->addSuggestionByID($pdo, $word);
    $words = $con->getSuggestions($pdo);
    $fun->listSuggestions($words);
} else {
    $id = $_GET["id"];
    $word = $con->getByID($pdo, $id);
    $str = file_get_contents("add.html");
    $str = str_replace('---english---', $word[0]['eng'], $str);
    $html = str_replace('---id---', $word[0]['id'], $str);
    echo $html;
}
