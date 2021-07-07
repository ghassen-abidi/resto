<?php

session_start();

if (!isset($_POST['id']) || !isset($_POST['title']) || !isset($_SESSION['ROLE']) || $_SESSION['ROLE'] != 'ADMIN') {
    header('Location: http://localhost/resto');
}

else {
    $id = $_POST['id'];
    $title = $_POST['title'];
    
    $conn = mysqli_connect('localhost', 'root', '', 'resto');
    
    if (!$conn) die('Error');
    
    $sql = "update category set title = '$title' where id = '$id'";
    $exec = mysqli_query($conn, $sql);
    
    header('Location: http://localhost/resto/admin');
}

?>