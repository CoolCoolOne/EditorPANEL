<?php
if (isset($_SESSION['username'])){
    $loggined_usr = $_SESSION['username'];
} else {
    $loggined_usr = 'noUser';
}
// echo '<input style="display: none;" value="'.$loggined_usr.'" id="loggined_usr" name="loggined_usr">';
// echo '<li style="display: none;" value="'.$loggined_usr.'" id="loggined_usr" name="loggined_usr"></li>';