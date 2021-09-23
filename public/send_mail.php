<?php

require_once 'bootstrap.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$id=1;
$id= $_GET['list_id'];

//продукты из списка
$result_shopping_list_1 = $pdo->prepare("SELECT B.product_name AS product_name, C.category_name AS category_name FROM `shopping_list`A,`products` B,`products_category` C WHERE A.`list_id`=? AND (A.`product_id`=B.`product_id`) AND C.category_id=B.category_id ORDER BY C.category_id");
$result_shopping_list_1->execute([$id]);

while ($row = $result_shopping_list_1->fetch())
{
    $model_shopping_list[] = $row;
}

//продукты ручного ввода
$result_shopping_list_2 = $pdo->prepare("SELECT A.item AS product_name, 'нет категории' AS category_name FROM `shopping_list`A WHERE A.`list_id`=? AND A.item is not null");
$result_shopping_list_2->execute([$id]);

while ($row = $result_shopping_list_2->fetch())
{
    $model_shopping_list[] = $row;
}
//список пользователей для возможной отправки письма
$result_users = $pdo->prepare("SELECT  `user_name`,`user_mail` FROM `users_list`");
$result_users->execute();

while ($row = $result_users->fetch())
{
    $model_users[] = $row;
}

//GET - отображаем форму
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{

$model = ['title'=> "Направить письмо испольнителю",'list'=> $id, 'shopping_list'=>$model_shopping_list, 'users'=>$model_users];


echo $handlebars->render("send_mail", $model);

}   

//POST- отправляем письмо

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    echo "ОТПРАВЛЯЕМ";
    //var_dump ($_POST);
    $mail = new PHPMailer(true);

    $host = $_ENV['MAIL_HOST'];
    $username = $_ENV['MAIL_USERNAME'];
    $pass = $_ENV['MAIL_PASSWORD'];

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output
        $mail->CharSet = "utf-8";
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = $host;                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = $username;                     //SMTP username
        $mail->Password   = $pass;                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail_address = $_POST['user'];


        $mail->setFrom('nafisa@ufa-lanka.com', 'BOSS');
        $mail->addAddress($mail_address);     //Add a recipient
        
        //Значения для контента
        $subject_name = "Задание: список покупок к выполнению!";
        
        $model = ['shopping_list'=>$model_shopping_list];
        var_dump($model);
        foreach($model as $item)
        {
            echo $item;
        }


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject =  '=?UTF-8?B?'.base64_encode($subject_name).'?=';
        $mail->Body    = '!!! Вам назначено задание: ';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'Message has been sent';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";

            $log = new Logger('send_mail.php');
            $log->pushHandler(new StreamHandler(__DIR__ .'/logs/debug/log', Logger::DEBUG));
                
            $log->debug('Message could not be sent. Mailer Error: ', ['message' => $mail->ErrorInfo]);
    }
}
