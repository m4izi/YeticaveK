 'title' => 'Добавление лота'
]);
if(!isset($_SESSION['user_name'])){
    $page_content = include_template('403.php', ['array' => $array, 'category_info'=>$category_info,]);
    $layout_content = include_template('layout.php', [
        'main' => $page_content,
        'array' => $array,
        'title' => 'Неавторизованный пользователь'
    ]);
}
else{
    if($_SERVER['REQUEST_METHOD']=='POST') {
        $link = mysqli_connect('127.0.0.1','root','','yeticave');
        mysqli_set_charset($link, utf8);
        $lot_name = $_POST["lot-name"];
        $category = $_POST["category"];
        $description = $_POST["message"];
        $start_price = $_POST["lot-rate"];
        $step_price = $_POST["lot-step"];
        $date_end = $_POST["lot-date"];
        $image= 'img/'.$_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], 'img/'.$_FILES['image']['name']);
        $error_name1 = "";
        if(empty($lot_name) || empty($category) || empty($description) || empty($start_price) || empty($step_price) || empty($date_end) || empty($_FILES['image']['name'])){
            $error_name1 = "form--invalid";
            $page_content = include_template('add.php', ['array' => $array, 'category_info'=>$category_info, 'error_name1'=>$error_name1]);
            $layout_content = include_template('layout.php', [
                'main' => $page_content,
                'array' => $array,
                'title' => 'Добавление лота'
            ]);
        }
        else{
            $query_category = "SELECT id_category from category where name ='$category'";
            $query = "INSERT INTO lot (id_lot,id_user,id_category,id_winner,creation_date,lot_name,description,image,start_price,date_end,step_price)
        VALUES (NULL,1,($query_category),NULL,now(),'$lot_name','$description ','$image',$start_price,'$date_end',$step_price)";
            $result4 = mysqli_query($link,$query);
            $query_id_lot = "SELECT id_lot from lot where lot_name= '$lot_name'";
            $result5 = mysqli_query($link,$query_id_lot);
            $ID= $result5->fetch_row()[0];
            header("Location:lot.php?id_lot=$ID");
        }
    }
}
function is_empty($lot,$lot2,$lot3,$lot4,$lot5,$lot6){