<?php
session_start();
$_SESSION['TempId']=$_GET['id'];
$_SESSION['TempUser']=$_GET['user'];
header('Location: ../login.php');

