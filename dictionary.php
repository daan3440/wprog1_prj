<?php
include 'connection.php';
include 'functions.php';
$con = new Connection();
$fun = new Functions();
$pdo = $con->initConnection();
$fun->console_log($pdo);

    $words = $con->getDictionary($pdo);
//    print_r($words);
    if(strlen($words->textContent)==0){
        $fun->noSuggestions();
    }else{
    $fun->listDictionary($words);
    }
    
    
