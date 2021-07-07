<?php


$id = $_POST['id'];

if (!isset($_COOKIE['panier'])) $current_panier = [];
else $current_panier = unserialize($_COOKIE['panier']);

array_push($current_panier, $id);
setcookie('panier', serialize($current_panier));

header('Location: http://localhost/resto');
?>