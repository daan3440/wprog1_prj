<?php

include 'functions.php';
$ch = new Functions;

$str = file_get_contents("search_def.html");
$html = str_replace('--salkaslk1234lk3kioa--', $ch->countHit(), $str);
echo $html;


