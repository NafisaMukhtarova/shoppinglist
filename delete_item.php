<?php

require_once 'bootstrap.php';

$data = [':id'=>$_GET['id']];
var_dump($data);

$result = $pdo->prepare("DELETE FROM `shopping_list` WHERE `shopping_list_id`= :id"); 
$result->execute($data);