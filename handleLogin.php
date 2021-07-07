<?php

session_start();

if (!isset($_POST['email']) || !isset($_POST['password'])) {
    header('Location: http://localhost/resto/login.php');
}
else {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $conn = mysqli_connect('localhost', 'root', '', 'resto');
    
    if (!$conn) die('Error');
    
    $sql = "select id, nom, role from account where email = '$email' and password = '$password'";
    $exec = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($exec)) {
        // connected
        $data = mysqli_fetch_assoc($exec);
        $_SESSION['NOM'] = $data['nom'];
        $_SESSION['ID'] = $data['id'];
        $_SESSION['ROLE'] = $data['role'];

        if ($_SESSION['ROLE'] == 'ADMIN')
            header('Location: http://localhost/resto/admin');
        else
            header('Location: http://localhost/resto');
    }
    else {
        // doesnt exist
        header('Location: http://localhost/resto/login.php');
    }
}

?>