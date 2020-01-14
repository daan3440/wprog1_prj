<?php
include 'connection.php';
include 'functions.php';
$con = new Connection();
$fun = new Functions();
//$stmt = initConnection();
$pdo = $con->initConnection();
    //Flytta ut rutin

    $words = $con->getSuggestions($pdo);
//    print_r($words);
    if(strlen($words->textContent)==0){
        $fun->noSuggestions();
    }else{
        //    echo sizeof($words);
    $fun->listSuggestions($words);
    }
    
    
