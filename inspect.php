<?php
    
    $word = $con->getByID($pdo, $id);
    $str = file_get_contents("inspect.html");
    
    $str = str_replace('---resultsbaby9876879---', $incomingString, $str);
    
    $html = str_replace('---id---', $word[0]['id'], $str);
    echo $html;