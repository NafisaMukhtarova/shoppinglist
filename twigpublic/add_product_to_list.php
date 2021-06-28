<?php
session_start();

require_once 'bootstrap.php';

$product = $_POST['Product_list'];

$list_id = $_SESSION['list_id'];
//echo $list_id;
// добавление продукта из выбранного списка
$result_pr = $pdo->prepare("INSERT INTO `shopping_list`(`list_id`,`product_id`) VALUES (:list_id,:product_id)"); 

foreach($product as $value)
{
    $result_pr->execute([':list_id'=>$list_id,':product_id'=>$value]);

}
//добавление продукта ручного ввода
$item = $_POST['item'];

if (!empty(trim($item))) {
    $item = $_POST['item'];
    echo 'Добавляем item: '.$item.'!';
    
    $result_it = $pdo->prepare("INSERT INTO `shopping_list`(`list_id`,`item`) VALUES (:list_id,:item)");
    $result_it->execute([':list_id'=>$list_id,':item'=>$item]);
}

header('Location: /');