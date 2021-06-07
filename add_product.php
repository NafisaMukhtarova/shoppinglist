<?php
session_start();

require_once 'connection.php';

$config = new Config;
$pdo = $config->Connect_PDO();

var_dump($_POST);

$data = [':product'=>$_POST['product_name'],':category_id'=>$_POST['category']];

var_dump($data);
$result = $pdo->prepare("INSERT INTO `products`(`product_name`,`category_id`) VALUES (:product,:category_id)"); 
$result->execute($data);

//header("Location: ".$_SERVER['HTTP_REFERER']);

header('Location: /select_product.php');