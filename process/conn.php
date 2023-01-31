<?php

session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "pizzaria";

try {

    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

} catch (PDOException $e) {

    print "Erro: " . $e->getMessage() . "<br>";
    die();
}
