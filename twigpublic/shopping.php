<?php
session_start();

require_once 'bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $id=1;

    if (isset($_SESSION['list_id'])) {
        $id= $_SESSION['list_id'];
    }

    //
    $result_lists = $pdo->prepare("SELECT * FROM `lists` WHERE `list_id`=?");
    $result_lists->execute([$id]);
    $list_name='';
    $list_id = 1;
    while ($row = $result_lists->fetch()) {
        $list_name = $row['list_name'];
        $list_id = $row['list_id'];
    }

    //продукты из списка
    $result_shopping_list_1 = $pdo->prepare("SELECT A.shopping_list_id AS shopping_list_id, B.product_name AS product_name, C.category_name AS category_name, A.shopping_list_id AS id, A.bought AS bought, A.price AS price
                                                FROM `shopping_list`A,`products` B,`products_category` C WHERE A.`list_id`=? AND (A.`product_id`=B.`product_id`) AND C.category_id=B.category_id 
                                                ORDER BY C.category_name, B.product_name");
    $result_shopping_list_1->execute([$id]);
    while ($row = $result_shopping_list_1->fetch(PDO::FETCH_ASSOC)) {
        $model_shopping_list[] = $row;
    }

    //продукты ручного ввода
    $result_shopping_list_2 = $pdo->prepare("SELECT A.shopping_list_id AS shopping_list_id, A.item AS product_name, 'нет категории' AS category_name, A.shopping_list_id AS id , A.bought AS bought, A.price AS price
                                                FROM `shopping_list`A WHERE A.`list_id`=? AND A.item is not null");
    $result_shopping_list_2->execute([$id]);
    while ($row = $result_shopping_list_2->fetch(PDO::FETCH_ASSOC)) {
        $model_shopping_list[] = $row;
    }

    $model = ['list_name'=> $list_name,'list_id'=> $list_id,'shopping_list'=>$model_shopping_list];
    //var_dump ($model);

    $template = $twig->load('shopping.html');

    echo $template->render($model);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
        //var_dump($_POST['price']);

        foreach ($_POST['shopping_list_id'] as $key => $value) {
            $price = (int)$_POST['price'][$key];
            if($price>0) {
            $data=[':id'=>$value,':price'=>$price];
            $result = $pdo->prepare("UPDATE `shopping_list`SET `bought`=1,`price`=:price WHERE `shopping_list_id`=:id"); 
            $result->execute($data);
            }
        }

    header('Location: /shopping.php');

}
