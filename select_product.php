<?php

session_start();
# With composer we can autoload the Handlebars package
require_once ("./vendor/autoload.php");

# If not using composer, you can still load it manually.
# require 'src/Handlebars/Autoloader.php';
# Handlebars\Autoloader::register();

use Handlebars\Handlebars;
use Handlebars\Loader\FilesystemLoader;

# Set the partials files
$partialsDir = __DIR__."/templates";
$partialsLoader = new FilesystemLoader($partialsDir,
    [
        "extension" => "html"
    ]
);

# We'll use $handlebars throughout this the examples, assuming the will be all set this way
$handlebars = new Handlebars([
    "loader" => $partialsLoader,
    "partials_loader" => $partialsLoader
]);

require_once 'connection.php';

$config = new Config;
$pdo = $config->Connect_PDO();


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