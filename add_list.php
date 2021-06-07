<?php
session_start();

require_once 'connection.php';

$config = new Config;
$pdo = $config->Connect_PDO();

$data=[];
$data = [':lname'=>$_POST['list_name']];

var_dump($data);
$result = $pdo->prepare("INSERT INTO `lists`(`list_name`) VALUES (:lname)"); 
$result->execute($data);

$id = $pdo->lastInsertId();
//echo 'Новая запись '.$id;
$_SESSION['list_id']=$id;
//var_dump($_SESSION);

header('Location: /');