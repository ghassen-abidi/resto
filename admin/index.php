<?php

session_start();
if (!isset($_SESSION['ROLE']) || $_SESSION['ROLE'] != 'ADMIN') {
    header('Location: http://localhost/resto');
    die();
} else {
    $conn = mysqli_connect('localhost', 'root', '', 'resto');
    if (!$conn) die('Error');

    // get list of categories
    $categories = [];
    $sql = "select * from category";
    $exec = mysqli_query($conn, $sql);
    while ($c = mysqli_fetch_assoc($exec))
        array_push($categories, $c);

    // get list of products
    $produits = [];
    $sql = "
        select produit.id, name, price, img, title, produit.category 
        from produit, category
        where produit.category = category.id
    ";
    $exec = mysqli_query($conn, $sql);
    while ($c = mysqli_fetch_assoc($exec))
        array_push($produits, $c);

    // get list of products
    $commandes = [];

    $sql = "
        select commandes.id, nom, date, address, telephone
        from account, commandes
        where commandes.client = account.id and delivered = 0
    ";
    $exec = mysqli_query($conn, $sql);
    while ($c = mysqli_fetch_assoc($exec)) {

        $id = $c['id'];
        $nom = $c['nom'];
        $date = $c['date'];
        $address = $c['address'];
        $telephone = $c['telephone'];

        $sql = "
            select qte, name
            from commande_produit, produit
            where commande_produit.commande = $id
            and commande_produit.produit = produit.id
        ";
        $exec2 = mysqli_query($conn, $sql);
        $prod = [];
        while ($p = mysqli_fetch_assoc($exec2))
            array_push($prod, $p);
            
        $final = [
            'id' => $id,
            'nom' => $nom,
            'date' => $date,
            'address' => $address,
            'telephone' => $telephone,
            'achats' => $prod
        ];
        array_push($commandes, $final);
    }
       

}
?>


 <a href="../logout.php">Logout</a>






<style>
.tabset > input[type="radio"] {
  position: absolute;
  left: -200vw;
}

.tabset .tab-panel {
  display: none;
}

.tabset > input:first-child:checked ~ .tab-panels > .tab-panel:first-child,
.tabset > input:nth-child(3):checked ~ .tab-panels > .tab-panel:nth-child(2),
.tabset > input:nth-child(5):checked ~ .tab-panels > .tab-panel:nth-child(3),
.tabset > input:nth-child(7):checked ~ .tab-panels > .tab-panel:nth-child(4),
.tabset > input:nth-child(9):checked ~ .tab-panels > .tab-panel:nth-child(5),
.tabset > input:nth-child(11):checked ~ .tab-panels > .tab-panel:nth-child(6) {
  display: block;
}

/*
 Styling
*/
body {
  font: 16px/1.5em "Overpass", "Open Sans", Helvetica, sans-serif;
  color: #333;
  font-weight: 300;
}

.tabset > label {
  position: relative;
  display: inline-block;
  padding: 15px 15px 25px;
  border: 1px solid transparent;
  border-bottom: 0;
  cursor: pointer;
  font-weight: 600;
}

.tabset > label::after {
  content: "";
  position: absolute;
  left: 15px;
  bottom: 10px;
  width: 22px;
  height: 4px;
  background: #8d8d8d;
}

.tabset > label:hover,
.tabset > input:focus + label {
  color: #06c;
}

.tabset > label:hover::after,
.tabset > input:focus + label::after,
.tabset > input:checked + label::after {
  background: #06c;
}

.tabset > input:checked + label {
  border-color: #ccc;
  border-bottom: 1px solid #fff;
  margin-bottom: -1px;
}

.tab-panel {
  padding: 30px 0;
  border-top: 1px solid #ccc;
}

/*
 Demo purposes only
*/
*,
*:before,
*:after {
  box-sizing: border-box;
}

body {
  padding: 30px;
}

.tabset {
  max-width: 65em;
}
</style>

<div class="tabset">
  <!-- Tab 1 -->
  <input type="radio" name="tabset" id="tab1" aria-controls="commandes" checked>
  <label for="tab1">Commandes</label>

  <!-- Tab 2 -->
  <input type="radio" name="tabset" id="tab2" aria-controls="categories">
  <label for="tab2">Categories</label>


  <!-- Tab 3 -->
  <input type="radio" name="tabset" id="tab3" aria-controls="products">
  <label for="tab3">Products</label>

  
  <div class="tab-panels">

    <section id="commandes" class="tab-panel">
      
    <table style="width:100%; border: 2px solid black; text-align: center">
<tr>
    <th>nom</th>
    <th>achat</th>
    <th>address</th>
    <th>telephone</th>
    <th>date</th>
    <th>Delivered</th>
</tr>

<?php

    foreach($commandes as $c) {
        $nom = $c['nom'];
        $date = $c['date'];
        $id = $c['id'];
        $address = $c['address'];
        $telephone = $c['telephone'];
        $achats = $c['achats'];
        
        echo "
        <tr>
            <td>$nom</td>
            <td> <ul>
            ";
        foreach($achats as $a) {
            $name = $a['name'];
            $qte = $a['qte'];
            echo "
            <li style='list-style: none'>$name x$qte</li>
            ";
        }
        echo "
        </ul></td>
            <td>$address</td>
            <td>$telephone</td>
            <td>$date</td>
            <td>
                <form action='delivered.php' method='post'>
                    <input type='hidden' value='$id' name='commande' />
                    <input type='submit' value='Set as delivered' />
                </from>    
            </td>
        </tr>
        ";
    }
?>


</table>
      
      </section>


    <section id="categories" class="tab-panel">
    <h2>Manage Categories</h2>
<table style="width:100%; border: 2px solid black; text-align: center">
<tr>
    <th>title</th>
    <th>edit</th>
    <th>delete</th>
</tr>

<?php

    foreach($categories as $c) {
        $id = $c['id'];
        $title = $c['title'];
        echo "
        <tr>
            <td>$title</td>
            <td>
                <form action='editCategory.php' method='post' >
                    <input type='text' name='title' />
                    <input type='hidden' name='id' value='$id' />
                    <input type='submit' value='Edit Category' />
                </form>
            </td>
            <td>
                <form action='deleteCategory.php' method='post' >
                    <input type='hidden' name='id' value='$id' />
                    <input type='submit' value='Delete Category' />
                </form>
            </td>
        </tr>
        ";
    }
?>
</table>


<h2>Ajout Category</h2>
<form method="post" action="ajoutCategory.php">
    <input type="text" name="title" />
    <input type="submit" value="Ajouter Category" />
</form>

      </section>


    <section id="products" class="tab-panel">
      


    <h2>Manage Products</h2>
<table style="width:100%; border: 2px solid black; text-align: center">
<tr>				
    <th>name</th>
    <th>img</th>
    <th>price</th>
    <th>category</th>
    <th>edit</th>
    <th>delete</th>
</tr>
<?php

    foreach($produits as $c) {
        $id = $c['id'];
        $name = $c['name'];
        $price = $c['price'];
        $category = $c['title'];
        $img = $c['img'];
        echo "
        <tr>
            <td>$name</td>
            <td><img src='$img' width='100' /></td>
            <td>$price</td>
            <td>$category</td>
            <td>
                <form action='updateProduit.php' method='post' >
                    <input type='hidden' name='id' value='$id' />
                    <input type='submit' value='Update Produit' />
                </form>
            </td>
            <td>
                <form action='deleteProduit.php' method='post' >
                    <input type='hidden' name='id' value='$id' />
                    <input type='hidden' name='img' value='$img' />
                    <input type='submit' value='Delete Produit' />
                </form>
            </td>
        </tr>
        ";
    }
?>
</table>








<h2>Ajout Produit</h2>
<form method="post" action="ajoutProduit.php" enctype="multipart/form-data">

    <h3>nom</h3>
    <input type="text" name="name" />

    <h3>description</h3>
    <textarea name="description" >
    </textarea>

    <h3>prix</h3>
    <input type="text" name="price" />

    <h3>image</h3>
    <input type="file" name="img" />

<br />
<h3>Categorie</h3>
    <select name='category'>
    <option value='' >Select</option>
    <?php
    foreach($categories as $c) {
        $id = $c['id'];
        $title = $c['title'];
        echo "
        <option value='$id' >$title</option>
        ";
    }
    ?>
    </select>
    <br />
    <br /><br />
    <input type="submit" value="Ajouter produit" />
</form>


      </section>

  </div>
  
</div>
