<?php

session_start();

if (!isset($_POST['commande']) || !isset($_SESSION['ROLE']) || $_SESSION['ROLE'] != 'ADMIN') {
    header('Location: http://localhost/resto');

}

else {
    $id = $_POST['commande'];
    
    $conn = mysqli_connect('localhost', 'root', '', 'resto');
    
    if (!$conn) die('Error');
    $sql = "update commandes set delivered = true where id = $id";

    $exec = mysqli_query($conn, $sql);
    
    echo mysqli_error($conn);
    header('Location: http://localhost/resto/admin');
}

?>