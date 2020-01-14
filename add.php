<?php

//header('Content-type: text/plain');

include 'connection.php';
include 'functions.php';
$con = new Connection();
$fun = new Functions();
//$stmt = initConnection();
$pdo = $con->initConnection();

//$words = $con->getDictionary($stmt);
//echo print_r($word);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $req = $_REQUEST;
//    echo print_r($req);
    $word = array($req);
    $con->addSuggestionByID($pdo, $word);
    
    //Flytta ut rutin
//    $id = $word[0]['id'];
    //add redirect ;message first; 
    $words = $con->getSuggestions($pdo);
    $fun->listSuggestions($words);
//    $result = array();
//    if ($x = $words->getElementsByTagName('term')) {
////    echo $words->saveXML();
//        for ($i = 0; $i < ($x->length); $i++) { //all words
//            $id = $x->item($i)->getElementsByTagName('id');
//            $eng = $x->item($i)->getElementsByTagName('eng');
//            $swe = $x->item($i)->getElementsByTagName('swe');
//            $sugg_date = $x->item($i)->getElementsByTagName('sugg_date');
//
//            $tmp = array("id" => $id->item(0)->childNodes->item(0)->nodeValue,
//                "eng" => $eng->item(0)->childNodes->item(0)->nodeValue,
//                "swe" => $swe->item(0)->childNodes->item(0)->nodeValue,
//                "sugg_date" => $sugg_date->item(0)->childNodes->item(0)->nodeValue);
//            array_push($result, $tmp);
//        }
//
//        ///Save this and putput to HTML file inspect.php/html
//        //Save this in a string
//        $headstr = "<th colspan=\"1\">Engelska</th><th colspan=\"1\">Svenska</th>"
//                . "<th colspan=\"1\">Datum</th>"
//                . "<th colspan=\"1\">Godkänn</th>"
//                . "<th colspan=\"1\">Avslå</th>";
//        $buildstr = "";
//        foreach ($result as $res) {
//            $buildstr .= "<tr><td>";
//            $buildstr .= $res['eng'] . "</td><td>";
//            $buildstr .= $res['swe'] . "</td><td>";
//            $buildstr .= $res['sugg_date'] .
//            "</td><td><a href='confirm.php?confirm=yes&id=" . $res['id'] . "'>Godkänn</a></td>" .
//            "<td><a href='confirm.php?confirm=no&id=" . $res['id'] . "'>Neka</a>";
//            $buildstr .= "</td></tr>";
//        }
////        echo " HEADSTRING" . $headstr . "\n";
////        echo $buildstr . " BUILDSTRING\n";
//        
//            
//    $str = file_get_contents("inspect.html");
//    //Table header
//    $tmpstr = str_replace('---19872789483619826197359175667sdfgheaderheheheghf---', $buildstr, $str);
//    //Table data
//    $html = str_replace('---19872789483619826197359175667sdfgfdfgfhghf---', $headstr, $tmpstr);
//    
//    echo $html;
//        
//        
//        
//        
//    }

//    echo "<pre>";
//    echo print_r($con->getByID($pdo, $id));
//    echo "</pre>";

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

