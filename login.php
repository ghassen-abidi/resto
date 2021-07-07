<?php
session_start();

// if already logged in
if (isset($_SESSION['NOM'])) {
    header('Location: http://localhost/resto');
}

?>
 <link rel="stylesheet" href="style.css" media="screen" type="text/css" />

<form action="handleLogin.php" method="post" >
<center><h1>login</h1></center>
    <label><b>email</b></label>
    <input name="email" type="text" />

    <label><b>password</b></label>
    <input name="password" type="password" />

    <input value="Login" type="submit" />
    



    

</form>