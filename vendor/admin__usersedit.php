<?php

//This file sets new user to project
require "config.php";
$prid = $_POST['prid'];
$rows = explode("~~",$_POST['material_array']);
foreach ($rows as $key => $row) {
    $m = explode(",", $row);
    $meta = mysqli_query($db, "UPDATE `users` SET `username`='$m[1]',`role`='$m[2]',`permissionrank`='$m[3]',`visible_forall`='$m[4]',`phone`='$m[5]',`email`='$m[6]',`company`='$m[7]' WHERE `id`='$m[0]';");
}

print_r( $m); 