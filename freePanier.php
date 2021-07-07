<?php

$id = $_POST['id'];

if (!isset($_COOKIE['panier'])) $current_panier = [];
else $current_panier = unserialize($_COOKIE['panier']);

array_splice($current_panier, array_search($id, $current_panier ), 1);



setcookie('panier', serialize($current_panier));

sleep(2);

header('Location: http://localhost/resto');
?>