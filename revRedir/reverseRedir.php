<?php

if ((isset($_SESSION['goToPrevious'])) && ($_SESSION['goToPrevious'] == true)) {
    $loc = './post.php?id=' . $_SESSION['TempId'] . '&user=' . $_SESSION['TempUser'];
    unset($_SESSION['TempId']);
    unset($_SESSION['TempUser']);
    unset($_SESSION['goToPrevious']);
    header("location: $loc");
} else {
    header("location: welcome.php");
}
