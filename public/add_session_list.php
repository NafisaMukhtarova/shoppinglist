<?php
session_start();

echo $_GET['id'];
echo ' устанавливаем сессию ';

$_SESSION['list_id']=$_GET['id'];

$header = 'Location: /'.$_ENV['LOCATION'];
header($header);
