<?php

//header('Content-type: text/plain');

include 'connection.php';
$con = new Connection();
//$stmt = initConnection();
$pdo = $con->initConnection();
//$words = $con->getDictionary($stmt);
//echo print_r($word);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $req = $_REQUEST;
//    echo print_r($req);
    $word = array($req);
    $con->insertByID($pdo, $word);
    $id = $word[0]['id'];
    echo "<pre>";
    echo print_r($con->getByID($pdo, $id));
    echo "</pre>";

//    $str = file_get_contents("add.html");
//    $str = str_replace('---english---', $word[0]['eng'], $str);
//    $html = str_replace('---id---', $word[0]['id'], $str);
//    echo $html;
} else {
    $id = $_GET["id"];
    $word = $con->getByID($pdo, $id);
    $str = file_get_contents("add.html");
    $str = str_replace('---english---', $word[0]['eng'], $str);
    $html = str_replace('---id---', $word[0]['id'], $str);
    echo $html;
}



/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

