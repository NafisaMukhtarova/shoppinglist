<?php 
class Config{
    private $user = 'my_dbuser'; // пользователь

    private $password = 'Mba25fly!'; // пароль
    
    private $db = 'my_db'; // название бд
    
    private $host = 'localhost'; // хост
    
    private $charset = 'utf8'; // кодировка
    

    public function Connect_PDO()
    {

        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->db;charset=$this->charset", $this->user, $this->password,
            array (PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
                );
        } catch (PDOException $e) {
            echo "ОШИБКА Connect.php";
            die($e->getMessage());
        }

        $pdo->query("SET NAMES 'utf8'");

        $pdo->query("SET CHARACTER SET 'utf8';");
        $pdo->query("SET SESSION collation_connection = 'utf8_general_ci';");


        return $pdo;
    }


}