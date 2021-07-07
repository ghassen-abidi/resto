<?php

session_start();

if (!isset($_POST['id']) || !isset($_SESSION['ROLE']) || $_SESSION['ROLE'] != 'ADMIN') {
    header('Location: http://localhost/resto');
}

else {
    $id = $_POST['id'];
    
    $conn = mysqli_connect('localhost', 'root', '', 'resto');
    
    if (!$conn) die('Error');
    
    $sql = "delete from category where id = $id";

    $exec = mysqli_query($conn, $sql);
    header('Location: http://localhost/resto/admin');
}

?>