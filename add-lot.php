<?php
require_once('functions.php');
require_once('conn.php');


$form_class = "";
$div_class = "";
$form_items = array("","","","","","","");
$page_content = include_template('add-lot.php',  [
    'cat' => $cat,
    'form_class' => $form_class,
    'div_class' => $div_class,
    'form_items' => $form_items
]);
$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'page_name' => 'Добавление лота',
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'cat' => $cat
]);

print($layout_content);