<?php
session_start();

require_once 'bootstrap.php';

var_dump($_POST);

$data = [':product'=>$_POST['product_name'],':category_id'=>$_POST['category']];

var_dump($data);
$result = $pdo->prepare("INSERT INTO `products`(`product_name`,`category_id`) VALUES (:product,:category_id)"); 
$result->execute($data);

//header("Location: ".$_SERVER['HTTP_REFERER']);

$header = 'Location: /'.$_ENV['LOCATION'].'select_product.php';
header($header);
