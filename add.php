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
    $con->addSuggestionByID($pdo, $word);
    $id = $word[0]['id'];
    //add redirect ;message first; 
    $words = $con->getSuggestions($pdo);
    $result = array();
    if ($x = $words->getElementsByTagName('term')) {
//    echo $words->saveXML();
        for ($i = 0; $i < ($x->length); $i++) { //all words
            $id = $x->item($i)->getElementsByTagName('id');
            $eng = $x->item($i)->getElementsByTagName('eng');
            $swe = $x->item($i)->getElementsByTagName('swe');
            $sugg_date = $x->item($i)->getElementsByTagName('sugg_date');

            $tmp = array("id" => $id->item(0)->childNodes->item(0)->nodeValue,
                "eng" => $eng->item(0)->childNodes->item(0)->nodeValue,
                "swe" => $swe->item(0)->childNodes->item(0)->nodeValue,
                "sugg_date" => $sugg_date->item(0)->childNodes->item(0)->nodeValue);
            array_push($result, $tmp);
        }

        foreach ($result as $res) {
            echo "<tr><td>";
            echo $res['eng'] . "</td><td>";
            echo $res['swe'] . "</td><td>";
            echo $res['sugg_date'] .
            "<a href='add.php?confirm=yes&id=" . $res['id'] . "'>Godkänn</a>" .
            "<a href='add.php?confirm=no&id=" . $res['id'] . "'>Neka</a>";

            echo "</td></tr>";
        }
    }

//    echo "<pre>";
//    echo print_r($con->getByID($pdo, $id));
//    echo "</pre>";

//    $str = file_get_contents("add.html");
//    $str = str_replace('---english---', $word[0]['eng'], $str);
//    $html = str_replace('---id---', $word[0]['id'], $str);
//    echo $html;
} elseif(isset($_GET["confirm"])) {
    $id = $_GET["id"];
    $confirm = $_GET["confirm"];
        if ($confirm == "yes") {
            $word = $con->getByID($pdo, $id);
            $con->updateByID($pdo, $word);
        } else {
//            echo "Inget ändrat.";
            header("Location: http://localhost/wprog1_prj/search.php");
            exit();
        }
    
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

