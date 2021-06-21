<?php

require_once 'bootstrap.php';

$model = ['title'=> "Новый список"];
//var_dump($model);

echo $handlebars->render("new_list", $model);