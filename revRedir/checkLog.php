<?php
if (isset($_SESSION['username'])){
    $loggined_usr = $_SESSION['username'];
    if (isset($_GET['user']) AND ($_GET['user'] != $loggined_usr)){
        // unset($_SESSION);
        header('Location: ../logout.php');
    }

    // if (isset($_SESSION['TempUser']) AND ($_SESSION['TempUser'] != $loggined_usr)){
    //     // unset($_SESSION);
    //     // header('Location: ../logout.php');
    // }
} else {
    $loggined_usr = 'noUser';
}
// echo '<input style="display: none;" value="'.$loggined_usr.'" id="loggined_usr" name="loggined_usr">';
// echo '<li style="display: none;" value="'.$loggined_usr.'" id="loggined_usr" name="loggined_usr"></li>';