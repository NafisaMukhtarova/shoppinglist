<?php

require_once 'bootstrap.php';

$result= $pdo->prepare("SELECT * FROM `products_category`");
$result->execute([$id]);

$model_row=[];
while ($row = $result->fetch())
{
    $model_row[] = $row;
}



$model = ['title'=> "Новый продукт",'categories'=>$model_row];

//var_dump($model);

echo $handlebars->render("new_product", $model);