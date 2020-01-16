<?php

include 'connection.php';
$con = new Connection();
$pdo = $con->initConnection();

$confirm = $_GET["confirm"];
$id = $_GET["id"];

if ($confirm == "no") {
    $word = $con->getByID($pdo, $id);
    $con->rollBackByID($pdo, $word);
} else {
    $word = $con->getByID($pdo, $id);
    $con->confirmByID($pdo, $word);
}
header("Location: http://localhost/wprog1_prj/search.php");
exit();

