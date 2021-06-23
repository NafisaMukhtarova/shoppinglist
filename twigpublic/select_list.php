<?php

session_start();

require_once 'bootstrap.php';

$result_lists = $pdo->query("SELECT * FROM `lists` A ORDER BY A.`list_id` DESC");

while ($row = $result_lists->fetch())
{
    $model_lists[] = $row;
}

$model = ['lists'=> $model_lists];

$template = $twig->load('lists.html');

echo $template->render($model);