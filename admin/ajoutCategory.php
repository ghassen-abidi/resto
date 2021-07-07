<?php

session_start();

if (!isset($_POST['title']) || !isset($_SESSION['ROLE']) || $_SESSION['ROLE'] != 'ADMIN') {
    header('Location: http://localhost/resto');
}

else {
    $title = $_POST['title'];
    
    $conn = mysqli_connect('localhost', 'root', '', 'resto');
    
    if (!$conn) die('Error');
    
    $sql = "insert into category (title) values ('$title')";
    $exec = mysqli_query($conn, $sql);
    
    header('Location: http://localhost/resto/admin');
}

?>