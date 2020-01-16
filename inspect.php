<?php
include 'connection.php';
include 'functions.php';
$con = new Connection();
$fun = new Functions();
$pdo = $con->initConnection();

    $words = $con->getSuggestions($pdo);
    if(strlen($words->textContent)==0){
        $fun->noSuggestions();
    }else{
    $fun->listSuggestions($words);
    }
    
    
