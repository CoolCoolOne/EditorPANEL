<?php
session_start();
$_SESSION['TempId']=$_GET['id'];
$_SESSION['TempUser']=$_GET['user'];


// echo $_SESSION['TempId'];
// echo $_SESSION['TempUser'];

// die();

header('Location: ../login.php');