    $errors[$index]=0;
        }
    }
    $query = "SELECT user_name,password,avatar from users where email='$email'";
    $result = mysqli_query($link,$query);
    if($result->num_rows===0 && $errors['email']===0)
    {
        $errors['email']="Пользователь с такой почтой не найден";
        $e=1;
    }
    $user = $result->fetch_array();
    if($password!=$user['password'] && $errors['password']===0)
    {
        $errors['password']="Неверный пароль";
        $e=1;
@@ -37,8 +37,9 @@
    {
        $user_name = $user['user_name'];
        $avatar = $user['avatar'];
        session_start();
        $_SESSION['user_name'] = $user_name;
        $_SESSION['avatar'] = $avatar;
        header("location:index.php");
    }
    else