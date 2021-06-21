<?php

session_start();

require_once 'bootstrap.php';

$result_lists = $pdo->query("SELECT * FROM `products` A ");

$model_lists=[];
while ($row = $result_lists->fetch())
{
    $model_lists[] = $row;
}
//var_dump($model_lists);
//var_dump($_GET);

$model = ['product'=> $model_lists,
        //'list_id'=>$_GET['list_id']];
            'list_id'=>$_SESSION['list_id']];

//var_dump($model);            
echo $handlebars->render("products", $model);