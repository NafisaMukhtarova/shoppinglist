<?php

require_once ("../vendor/autoload.php");

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$appdir = dirname(__DIR__);

//ENV
$dotenv = Dotenv\Dotenv::createImmutable($appdir);
$dotenv->load();

//log
$log = new Logger('geography');
$log->pushHandler(new StreamHandler($appdir.'/logs/debug/log', Logger::DEBUG));

//twig
$loader = new \Twig\Loader\FilesystemLoader($appdir."/twigtemplates");
$twig = new \Twig\Environment($loader);

class Config
{
    private $user = ''; // пользователь

    private $password = ''; // пароль
    
    private $db = ''; // название бд
    
    private $host = ''; // хост
    
    private $charset = 'utf8'; // кодировка
    
    private $log;

    public function __construct($db,$user,$pass,$host)
    {
        $this->db = $db;
        $this->user = $user;
        $this->password = $pass;
        $this->host = $host;
        
    }


    public function Connect_PDO($log) 
    {
        $this->log = $log;
        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->db;charset=$this->charset",
                        $this->user, 
                        $this->password,
                        array (PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
                        );
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->log->debug('Подключение bootstrap.php: ', ['message' => 'успешно']);
        } catch (PDOException $e) {
            echo "ОШИБКА Connect.php";
            $this->log->debug('Ошибка bootstrap.php: ', ['message' => $e->getMessage()]);
        }
        $pdo->query("SET NAMES 'utf8'");
        $pdo->query("SET CHARACTER SET 'utf8';");
        $pdo->query("SET SESSION collation_connection = 'utf8_general_ci';");

        return $pdo;
    }


}
//var_dump($_ENV);

$db = $_ENV['CONFIG_DB'];
$us = $_ENV['CONFIG_USER'];
$pw = $_ENV['CONFIG_PASSWORD'];
$ht = $_ENV['CONFIG_HOST'];
$config = new Config($db,$us,$pw,$ht);
$pdo = $config->Connect_PDO($log);

