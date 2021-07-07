<?php

session_start();

if (!isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['password'])) {
    header('Location: http://localhost/resto/signup.php');
} else {
    $name = $_POST['name']; 
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $conn = mysqli_connect('localhost', 'root', '', 'resto');
    
    if (!$conn) die('Error');
    
    $sql = "insert into account (nom, email, password) values ('$name', '$email', '$password')";
    $exec = mysqli_query($conn, $sql);
    
    if ($exec) {
        // signedup
        $_SESSION['NOM'] = $name;
        $_SESSION['ROLE'] = 'CLIENT';
        header('Location: http://localhost/resto');
    }
    else {
        // error
        header('Location: http://localhost/resto/signup.php');
    }
}


?>