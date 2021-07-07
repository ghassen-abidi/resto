<?php

session_start();

if(!isset($_SESSION['ID']))
    header('Location: login.php');

print_R( $_POST);
$conn = mysqli_connect('localhost', 'root', '', 'resto');
if (!$conn) die('Error');

$client = $_SESSION['ID'];
$date = date("Y/m/d H:i:s");
echo $date;

$address = $_POST['address'];
$tel = $_POST['tel'];
$sql = "insert into commandes (client, address, date, telephone) values (
    $client, '$address', '$date', '$tel'
)";
$exec = mysqli_query($conn, $sql);
if ($exec) {
    $commande = mysqli_insert_id($conn);
    for ($x = 0; $x < count($_POST['element']); $x++) {
        $produit = $_POST['element'][$x];
        $qte = $_POST['qte'][$x];
        $sql = "insert into commande_produit (commande, produit, qte) values (
            $commande, $produit, $qte
        )";
        $exec = mysqli_query($conn, $sql);
    }
    
}

setcookie('panier', null, time() - 3600);

sleep(1);
header('Location: index.php');


?>