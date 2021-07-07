<?php

session_start();

if (!isset($_POST['id']) || !isset($_SESSION['ROLE']) || $_SESSION['ROLE'] != 'ADMIN') {
    header('Location: http://localhost/resto');
}

else {
    $id = $_POST['id'];
    
    $conn = mysqli_connect('localhost', 'root', '', 'resto');
    if (!$conn) die('Error');

    $sql = "
        select * from produit 
        where id = '$id'
    ";
    $exec = mysqli_query($conn, $sql);
    $produit = mysqli_fetch_assoc($exec);

    $name = $produit['name'];
    $description = $produit['description'];
    $img = $produit['img'];
    $price = $produit['price'];
    $category = $produit['category'];


    $categories = [];
    $sql = "select * from category";
    $exec = mysqli_query($conn, $sql);
    while ($c = mysqli_fetch_assoc($exec))
        array_push($categories, $c);

}

?>

<form method="post" action="handleEditProduct.php" enctype="multipart/form-data">

    <h3>nom</h3>
    <input type="text" name="name" value='<?= $name ?>' />

    <h3>description</h3>
    <textarea name="description" >
    <?= $description ?>
    </textarea>

    <h3>prix</h3>
    <input type="text" name="price" value='<?= $price ?>' />

    <h3>image</h3>
    <input type="file" name="img" />

    <input type='hidden' name='img_in_case' value='<?= $img ?>' />
    <input type='hidden' name='id' value='<?= $id ?>' />

<br />
<h3>Category</h3>
    <select name='category' >
    <option value='' >Select</option>
    <?php
    foreach($categories as $c) {
        $id = $c['id'];
        $title = $c['title'];
        if ($id == $category)
            echo "
            <option value='$id' selected>$title</option>
            ";
        else 
            echo "
            <option value='$id' >$title</option>
            ";
    }
    ?>
    </select>
    <br />
    <br /><br />
    <input type="submit" value="Edit Category" />
</form>

