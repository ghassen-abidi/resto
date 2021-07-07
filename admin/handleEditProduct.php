<?php

session_start();

if (!isset($_POST['id']) || !isset($_SESSION['ROLE']) || $_SESSION['ROLE'] != 'ADMIN') {
    header('Location: http://localhost/resto');
}

else {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];


    $img = $_FILES['img']['name'] != '' ? "../img/".basename($_FILES['img']["name"]) : $_POST['img_in_case'];
    
    $conn = mysqli_connect('localhost', 'root', '', 'resto');
    
    if (!$conn) die('Error');
    
    $sql = "update category set title = '$title' where id = '$id'";
    $exec = mysqli_query($conn, $sql);


    if ($_FILES['img']['name'] != '') {
        
    $uploadOk = 1;
    $type = strtolower(pathinfo($img,PATHINFO_EXTENSION));



    
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["img"]["tmp_name"]);
      if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } else {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }
    
    // Check if file already exists
    if (file_exists($img)) {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }
    
    // Check file size
    if ($_FILES["img"]["size"] > 500000) {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }
    
    // Allow certain file formats
    if($type != "jpg" && $type != "png" && $type != "jpeg"
    && $type != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["img"]["tmp_name"], $img)) {
          
      } else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
    }
    $sql = "update produit 
    set 
        name = '$name',
        description = '$description',
        price = $price,
        category = $category,
        img = '$img'
    where id = $id";
    $exec = mysqli_query($conn, $sql);
    
    header('Location: http://localhost/resto/admin');
}

?>


