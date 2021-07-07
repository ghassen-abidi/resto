<?php

session_start();

$conn = mysqli_connect('localhost', 'root', '', 'resto');
    if (!$conn) die('Error');


            // get list of categories
                $categories = [];
                $sql = "select * from category";
                $exec = mysqli_query($conn, $sql);
                while ($c = mysqli_fetch_assoc($exec))
                    array_push($categories, $c);


                    $panier_arr = [];
                    if (!isset($_COOKIE['panier'])) $panier_arr = [];
                    else $panier_arr = unserialize($_COOKIE['panier']);
                    
                    
                    $array = implode(",", $panier_arr); // 1,4,5
                    
                    if (count($panier_arr) == 0) {
                      $panier = [];
                    } else {
                      $sql = "select * from Produit where id in ($array)";
                      $exec = mysqli_query($conn, $sql);
                      echo "<br /><br /><br />".mysqli_error($conn);
                      $panier = [];
                      
                      while ($r = mysqli_fetch_assoc($exec)) 
                        array_push($panier, $r);
                    }
                    


                  $isLoggeed = isset($_SESSION['NOM']);

                    
            ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css2?family=Lobster&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="main.css" />
    <title>Resto</title>
  </head>
<body data-spy="scroll" data-target=".navbar" data-offset="0" class="bg-secondary">
    <main>
      <header>
        <nav id="navbar" style="transition: 0.4s; background-color: rgba(1,1,50,0.6);" class="navbar navbar-expand-lg navbar-dark fixed-top py-0">
          <div class="container-fluid">
          <a style="font-size: 40px; cursor: default;" class="navbar-brand my-0 py-0">RESTO</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="collapsibleNavbar">
            <ul class="navbar-nav ">
              <li class="nav-item ">
                  <div class="mx-1 my-1">
                    <a style="background-color: rgba(200,200,200,0.8);" class="btn py-1 px-2 rounded font-weight-bold" href="tel:+216123456789">Order +216 12345678</a>
                  </div>
              </li>
              <li class="nav-item">
                <li class="nav-item ">
                  <div class="mx-1 my-1">

                    <button data-toggle="modal" data-target="#panier" style="background-color: rgba(200,200,200,0.8);" class="btn py-1 px-2 rounded font-weight-bold" >panier</button>
                  </div>
              </li>
              <li class="nav-item">
                <div class="mx-1 my-1">
                  <a style="background-color: rgba(200,200,200,0.8);" class="btn py-1 px-2 rounded" href="#Menu">Menu</a>
                </div>
              </li>
              <li class="nav-item">
                <div class="mx-1 my-1">
                  <a style="background-color: rgba(200,200,200,0.8);" class="btn py-1 px-2 rounded" href="#Map">Map</a>
                </div>
              </li>
              <li class="nav-item">
                <div class="mx-1 my-1">
                  <a style="background-color: rgba(200,200,200,0.8);" class="btn py-1 px-2 rounded" href="#About US">About us</a>
                </div>
              </li>
              <?php
                if ($isLoggeed) {
                  echo "
                  <li class='nav-item'>
                <div class='mx-1 my-1'>
                  <a style='background-color: red;' class='btn py-1 px-2 rounded' href='logout.php'>Logout</a>
                </div>
              </li>
                  ";
                }
                else {
                  echo "
                  <li class='nav-item'>
                <div class='mx-1 my-1'>
                  <a style='background-color: rgba(200,200,200,0.8);' class='btn py-1 px-2 rounded' href='login.php'>Login</a>
                </div>
              </li>
              <li class='nav-item'>
                <div class='mx-1 my-1'>
                  <a style='background-color: rgba(200,200,200,0.8);' class='btn py-1 px-2 rounded' href='signup.php'>Signup</a>
                </div>
              </li>
                  ";
                }
              ?>
              
            </ul>
          </div>
          </div>
        </nav>
  <div id="ss" class="carousel slide"data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#ss" data-slide-to="0" class="active"></li>
    <li data-target="#ss" data-slide-to="1"></li>
    <li data-target="#ss" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="p1.jpg" class="d-block w-100">
    </div>
    <div class="carousel-item">
      <img src="p2.jpg" class="d-block w-100">
    </div>
    <div class="carousel-item">
      <img src="p3.jpg" class="d-block w-100">
    </div>
  </div>
  <a class="carousel-control-prev" href="#ss" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#ss" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
      </header>

        
      <div >
          <nav id="Menu" style="background-color: red;" class="navbar navbar-expand py-1 my-0 px-0 mx-0">
              <h4 class="collapse navbar-collapse justify-content-center  " style=" margin-top: 6px; font-size: 35px">Menu</h4>
          </nav>
        <div class="tabs bg-light my-0 mx-0 px-0 py-2" >
        <?php
            
            $x = 0;
            foreach($categories as $c) {
                $title = $c['title'];
                
                if ($x == 0) echo "
                <input type='radio' id='$title' name='tab-control' checked />
                ";
                else echo "
                <input type='radio' id='$title' name='tab-control' />
                ";
                $x = 1;
                
            }
            
            ?>
        <ul>
            <?php
            

            foreach($categories as $c) {
                $title = $c['title'];
                $id = $c['id'];
                echo "
                <li title='$title'>
                    <label for='$title' role='button'>
                    <i class='fas fa-hamburger'></i> <br /><span>$title</span></label>
                </li>
                ";
            }
            
            ?>
        </ul>

        <div class="slider "><div class="indicator"></div>
      </div>


      <div class="content mx-0 my-0 py-0">
      <?php
            

            
                
            foreach($categories as $c) {
                $x = 1;
                $id = $c['id'];
                echo "
            <section style='color: black; margin:0px; background-image: url(p1.jpg); background-size:cover;' 
            class='container-fluid'>
             <div class='row px-3 py-3' >
";

                $sql = "
                    select * from produit where category = $id
                ";
                $exec = mysqli_query($conn, $sql);
                while ($r = mysqli_fetch_assoc($exec)) {
                    $id = $r['id'];
                    $name = $r['name'];
                    $description = $r['description'];
                    $price = $r['price'];
                    $img = substr($r['img'], 3);
                    echo "
                <div class='col-lg-4 col-12 col-sm-6  px-1 py-1 '>
                <div class='card mx-3 my-3 ' style='cursor: pointer;' data-toggle='collapse' data-target='#c1$x'>
                <div class='card-body px-2 py-2'>
                  <img src='$img' class=' d-block w-100'>
                  <h4 style='margin-bottom: 0px; margin-top: 10px'>$name</h4>
                  <div id='c1$x' class='collapse'>
                    $description
                  </div>
                  $price
                  ";
                  if (!isset($_COOKIE['panier']) || !in_array($id, unserialize($_COOKIE['panier']), true)) {
                    echo "
                      <form method='post' action='handlePanier.php' >
                      <input type='hidden' name='id' value='$id' />
                      <input type='submit' value='ajout dans panier' />
                  </form>
                    ";
                  } else {
                    echo "
                      <form method='post' action='freePanier.php' >
                        <input type='hidden' name='id' value='$id' />
                        <input type='submit' value='remove from panier' />
                    </form>
                    ";
                  }
                  echo "
                  
                </div>
                </div>
              </div>
                ";


                $x++;
                }

                echo "    
              </div>

          </section>
          ";
            }
            
            ?>


        </div>
      </div>  

      </div>
    </div>
        <div class="py-0 my-0" style="top: -10px ;position: relative;">
          <nav id="Map" style="background-color: orange" class="navbar navbar-expand py-1 my-0 px-0 mx-0">
              <h4 class="collapse navbar-collapse justify-content-center" style=" margin-top: 6px; font-size: 35px">Map</h4>
          </nav>
          <iframe class="my-0 py-0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6384.664595393403!2d10.25258153579113!3d36.858464176609544!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12e2caabaa408541%3A0xf461c93f74f856ca!2sDowntown%20Lounge%20Laouina!5e0!3m2!1sen!2stn!4v1596631440736!5m2!1sen!2stn" width="100%" height="550" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
<footer class="page-footer bg-secondary my-0 py-0">
  <div class="container-fluid text-center">
    <section class="row">
      <div class=" col-6 col-md-3 text-center mx-0 px-2" >
        <h4 style="color: black;">Social</h4>
          <div class="btn-group rounded " role="group" >
            <a href="#!" class="btn fab fa-facebook btn-dark"></a>
            <a href="#!" class="btn fab fa-instagram btn-dark"></a>
            <a href="#!" class="btn fab fa-whatsapp btn-dark"></a>
            <a href="#!" class="btn fab fa-pinterest btn-dark"></a>
          </div>
      </div>
      <div class="col-6 col-md-3 text-center mx-0 px-2" >
        <h4 style="color: black;">Contact</h4>
          <h6 class="container-fluid" style="color: rgba(255,255,255,0.6)">ghassenabidi63@gmail.com</h6>
      </div>
      <div class="col-12 col-md-6 mx-0 px-0 px-5" >
              <h4 id="About US" style="color: black;">About US</h4>
        <p class=" text-center container-fluid" style="color: rgba(255,255,255,0.6)">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
         Integer tincidunt ex purus, a cursus ligula posuere ac. 
          Curabitur ligula </p>
    </div>
    </section>
  </div>
  <div class="footer-copyright text-center py-0 my-0" style="background-color: #000033; color: rgba(255,255,255,0.6)">© 2021 Copyright :
    <a href="https://www.facebook.com/profile.php?id=100009275795690" target="_blank" style="color: rgba(255,255,255,0.6)">ghassenabidi</a>
  </div>
</footer>

<div class="modal fade" id="panier" tabindex="-1" role="dialog" aria-labelledby="panierLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="panierLabel">Panier
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action='panier.php' method='post' >
      <div class="modal-body">
        <h3>Address</h3>
        <input name='address' type='text' />
        <h3>Tel</h3>
        <input name='tel' type='text' />
        <?php

            for($x = 0; $x < count($panier); $x++) {
              $id = $panier[$x]['id'];
              $name = $panier[$x]['name'];
              $price = $panier[$x]['price'];
              echo "
                <h3>$name</h3> | $price TND
                <input type='hidden' name='element[$x]' value='$id' />
                <input type='number' name='qte[$x]' value='1' />
              
              ";
            }
        ?>
        
       
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <?php
          if ($isLoggeed) {
            echo "
            <input type='submit' class='btn btn-primary' value='Acheter' />
            ";
          } else {
            echo "<a href='login.php' >Login to order</a>";
          }
        ?>
        
        </div>
        </form>
    </div>
  </div>
</div>


    </main>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/d9d5094af0.js" crossorigin="anonymous"></script>
    <script type="text/javascript">
      window.onscroll = function(e) {
        let x = document.getElementById("navbar")
  if (this.oldScroll > this.scrollY) {
    x.style.top = "0"
  } else {
    x.style.top = "-280px"
  }
  this.oldScroll = this.scrollY;
}
    </script>
  </body>
</html>