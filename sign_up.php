<?php
require_once('functions.php');
require_once ('data.php');

$err = [];
$message = [];
$flag = 0;
$form = '';
$pattern = '/\A[А-Яа-яЁё]/';
$pattern1 = '/^[ 0-9]+$/';
$pattern2 = '/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i';

$connection = new mysqli('127.0.0.1', 'root', '', 'yeticave');



if($_SERVER['REQUEST_METHOD']=='POST')
{
    $name = $_POST['name'];
    $contacts = $_POST['contacts'];
    $email = $_POST['email'];
    $pass = $_POST['pass'];
    $avatar = $_FILES['avatar']['name'];
    $avatar = 'img/'.$_FILES['avatar']['name'];
    if(empty($name))
    {
        $err['name'] = 'form__item--invalid';
        $message['name'] = '<span class="form__error">Введите Имя пользователя.</span>';
        $flag = 1;
    }
    else
    {
        if(!preg_match($pattern,$name))
        {
            $err['name'] = 'form__item--invalid';
            $message['name'] = '<span class="form__error">Имя пользователя может содержать только кириллицу.</span>';
            $flag = 1;
        }
    }
    if(empty($contacts))
    {
        $err['contacts'] = 'form__item--invalid';
        $message['contacts'] = '<span class="form__error">Введите номер Вашего телефона.</span>';
        $flag = 1;
    }
    else
    {
        if(!preg_match($pattern1,$contacts))
        {
            $err['contacts'] = 'form__item--invalid';
            $message['contacts'] = '<span class="form__error">Номер телефона может содержать только цифры.</span>';
            $flag = 1;
        }
    }
    if(empty($email))
    {
        $err['email'] = 'form__item--invalid';
        $message['email'] = '<span class="form__error">Введите e-mail</span>';
        $flag = 1;
    }
    else
    {
        if(!preg_match($pattern2,$email))
        {
            $err['email'] = 'form__item--invalid';
            $message['email'] = '<span class="form__error">Некорректно введен адрес электронной почты.</span>';
            $flag = 1;
        }
    }
    if(empty($pass))
    {
        $err['pass'] = 'form__item--invalid';
        $message['pass'] = '<span class="form__error">Введите пароль.</span>';
        $flag = 1;
    }
    if(empty($avatar))
    {
        $err['avatar'] = 'form__item--invalid';
        $message['avatar'] = '<span class="form__error">Добавьте фото профиля.</span>';
        $flag = 1;
    }
    else
    {
        if(!empty($form))
        {
            $err['avatar'] = 'form__item--invalid';
            $message['avatar'] = '<span class="form__error">Ошибка загрузки.</span>';
            $flag = 1;
        }
        else
        {
            move_uploaded_file($_FILES['avatar']['tmp_name'], 'img/'.$_FILES['avatar']['name']);
        }
    }
    if(!empty($err))
    {
        $form = 'form--invalid';
        $message['form'] = '<span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>';
        $flag = 1;
    }
    if(!empty($name)&&!empty($contacts)&&!empty($email)&&!empty($pass)&&!empty($avatar))
    {
        $result = $connection->query("SELECT email, contacts FROM users WHERE email = '$email' OR contacts = '$contacts'");

        if (mysqli_num_rows($result) > 0)
        {
            $form = 'form--invalid';
            $message['form'] = '<span class="form__error form__error--bottom">Профиль с такими данными уже существует.</span>';
            $flag = 1;

            $data_main = ['array' => $array, 'category_info'=>$category_info,'err' => $err, 'message' => $message, 'form' => $form];
            $page_content = include_template('sign_up.php', $data_main);
            $layout_content = include_template('layout.php', [
                'page_content' => $page_content,
                'main' => $page_content,
                'array' => $array,
                'title' => 'Регистрация'
            ]);

            print($layout_content);
        }
        else
        {
            $query = "INSERT INTO users (id_user,date_register,email,user_name,password,avatar,contacts) VALUES (NULL,now(),'$email','$name','$pass','$avatar','$contacts')";

            $query_result = $connection->query($query);

            $connection->close();

            header('Location: login.php');
        }
    }
    $data_main = ['array' => $array, 'category_info'=>$category_info,'err' => $err, 'message' => $message, 'form' => $form];
    $page_content = include_template('sign_up.php', $data_main);
    $layout_content = include_template('layout.php', [
        'page_content' => $page_content,
        'main' => $page_content,
        'array' => $array,
        'title' => 'Регистрация'
    ]);

    print($layout_content);
}
else
{
    $data_main = ['array' => $array, 'category_info'=>$category_info,'err' => $err, 'message' => $message, 'form' => $form];
    $page_content = include_template('sign_up.php', $data_main);
    $layout_content = include_template('layout.php', [
        'page_content' => $page_content,
        'main' => $page_content,
        'array' => $array,
        'title' => 'Регистрация'
    ]);

    print($layout_content);
}
?>