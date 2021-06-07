<?php
session_start();


$product = $_POST['Product_list'];
//$item = $_POST['item'];

//var_dump($add);
//echo 'item: '.$item.'!';


//$list_id = $_POST['list_id'];
$list_id = $_SESSION['list_id'];
//echo $list_id;



require_once 'connection.php';

$config = new Config;
$pdo = $config->Connect_PDO();

$result_pr = $pdo->prepare("INSERT INTO `shopping_list`(`list_id`,`product_id`) VALUES (:list_id,:product_id)"); 

foreach($product as $value)
{
    $result_pr->execute([':list_id'=>$list_id,':product_id'=>$value]);

}

if (isset($_POST['item']))
{
    $item = $_POST['item'];
    echo 'Добавляем item: '.$item.'!';
    
    $result_it = $pdo->prepare("INSERT INTO `shopping_list`(`list_id`,`item`) VALUES (:list_id,:item)");
    $result_it->execute([':list_id'=>$list_id,':item'=>$item]);
}

header('Location: /');