<?php

if ((isset($_SESSION['goToPrevious'])) && ($_SESSION['goToPrevious'] == true)) {

    $curr_id = $_SESSION['TempId'];
    $julkisvu_label = mysqli_fetch_all(mysqli_query($db, "SELECT project_type FROM projects WHERE id = $curr_id"));
    $julkisvu_label = $julkisvu_label[0][0];
    if ($julkisvu_label == 'Julkisivu'){
        $loc = 'http://julkisivut2.gromi.fi/post.php?id=' . $_SESSION['TempId'] . '&user=' . $_SESSION['TempUser'];
    } else {
        $loc = './post.php?id=' . $_SESSION['TempId'] . '&user=' . $_SESSION['TempUser'];
    }
    // в зависимости от типа проекта надо отправить на Фасады после ввода пароля
    // либо оставить на текущем домене
    
    unset($_SESSION['TempId']);
    unset($_SESSION['TempUser']);
    unset($_SESSION['goToPrevious']);
    // echo $loc;
    header("location: $loc");
} else {
    header("location: welcome.php");
}
