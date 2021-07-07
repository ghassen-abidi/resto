<?php
session_start();

// if already logged in
if (isset($_SESSION['NOM'])) {
    header('Location: http://localhost/resto');
}

?>
 <link rel="stylesheet" href="style.css" media="screen" type="text/css" />

<form action="handleSignup.php" method="post" >


    <center><h1>login</h1></center>
    
                
    <label><b>Nom d'utilisateur</b></label>
     <input type="text" placeholder="Entrer Nom d'utilisateur " name="name" required>
    

               
                
    <label><b>email</b></label>
     <input type="text" placeholder="Entrer email" name="email" required>

    <label><b>Mot de passe</b></label>
    <input type="password" placeholder="Entrer le mot de passe" name="password" required>

    <input type="submit" id='submit' value='LOGIN' >
       
    

</form>