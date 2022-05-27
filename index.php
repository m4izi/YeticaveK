<?php
$is_auth = rand(0, 1);
$user_name = 'user'; // укажите здесь ваше имя

require_once('functions.php');
require_once('data.php');

$main = include_template(
    'index.php',
    [
    'categories' => $categories,
    'lots' => $lots,
    ]
);

$layout_content = include_template(
    'layout.php',
    [
    'title' => 'Главная страница',
    'main' => $main,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'user_name' => $user_name
    ]
);
foreach($array as $category){
                ?>
                <li class="promo__item promo__item--<?=$category["eng_name"]?>">
                    <a class="promo__link" href="all-lots.html"><?=$category["name"]?></a>
                    <a class="promo__link" href="#"><?=$category["name"]?></a>
                </li>
print($layout_content);
?>

