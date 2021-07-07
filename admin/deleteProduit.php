<?php

session_start();

if (!isset($_POST['img']) || !isset($_POST['id']) || !isset($_SESSION['ROLE']) || $_SESSION['ROLE'] != 'ADMIN') {
    header('Location: http://localhost/resto');
}

else {
    $id = $_POST['id'];
    $img = $_POST['img'];
    
    $conn = mysqli_connect('localhost', 'root', '', 'resto');
    
    if (!$conn) die('Error');
    
    $sql = "delete from produit where id = '$id'";
    $exec = mysqli_query($conn, $sql);

    // delete image
    unlink($img);

    header('Location: http://localhost/resto/admin');
}

?>