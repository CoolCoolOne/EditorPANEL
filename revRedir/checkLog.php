<?php
if (isset($_SESSION['username'])){
    // уже авторизован
    $loggined_usr = $_SESSION['username'];
    // используем переменную при нажатии VALMIS в valinta

    if (isset($_GET['user']) AND ($_GET['user'] != $loggined_usr)){
        // unset($_SESSION);
        header('Location: ../logout.php');
    } 
    // логаут при попытке зайти под другим пользователем если уже авторизован

    if (isset($_GET['id'])){
        $curr_id = $_GET['id'];
        $julkisvu_label = mysqli_fetch_all(mysqli_query($db, "SELECT project_type FROM projects WHERE id = $curr_id"));
        $julkisvu_label = $julkisvu_label[0][0];
        if ($julkisvu_label == 'Julkisivu'){
            $url = 'http://julkisivut2.gromi.fi/post.php?id='.$_GET['id'].'&user='.$_GET['user'];
            header("Location: $url");
        }
    }
    // редирект на julkisivult поддомен, если проект типа Фасад (и пользователь авторизован верно)

} else {
    // не авторизован
    $loggined_usr = 'noUser';
    // используем переменную при нажатии VALMIS в valinta
    
    if (isset($_GET['user']) AND ($_GET['user'] != 'valinta')){
        // unset($_SESSION);
        $url = './revRedir/sessionFromGet.php?id='.$_GET['id'].'&user='.$_GET['user'];
        header("Location: $url");
    }
    //редирект если зашли по адресу ...&user=tester-specialist-comment без авторизации
}


// механизм авторизаций охватывает случаи для valinta, конкретного пользователя, 
// случаи с авторизованным или не авторизованным пользователем
// и случаи с проектом фасадов, тогда авторизация прроисходит 
// на поддомене этого проекта с последующим редиректом на 
// поддомен фасадов. На поддомене фасадов нет своей авторизации,
// поэтому ПРИ ПРЯМОМ ЗАХОДЕ НА JULK надо либо каждый раз вводить пароль на этом поддомене
// либо пускать туда без пароля, но перекидывать сюда
// если там выбран тип проекта НЕ ФАСАДЫ
