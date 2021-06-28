<?php

require_once 'bootstrap.php';

$model = ['title'=> "Новый список"];
//var_dump($model);

$template = $twig->load('new_list.html');

echo $template->render($model);

