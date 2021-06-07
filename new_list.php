<?php

# With composer we can autoload the Handlebars package
require_once ("./vendor/autoload.php");

//echo $_SERVER['REQUEST_METHOD'];

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






$model = ['title'=> "Новый список"];
//var_dump($model);

echo $handlebars->render("new_list", $model);