<?php

session_start();
include 'connessione.php';

if (isset($_POST['Login']) && !isset($_POST['Registrati'])) {

    if (isset($_COOKIE['user_cookie'])) {
    	$richiesta = "SELECT * FROM Credenziali WHERE Token = '" . $_COOKIE['user_cookie'] . "'";
    	$risultato = $connessione->query($richiesta);
    
    	$row = mysqli_fetch_assoc($risultato);
    	$_SESSION['username'] = $row['Username'];
    	$_SESSION['login'] = true;
    	header('location: welcome.php');
        die;
	}
	else {
    header('location: login.php');
    die;
	}
}

elseif (isset($_POST['Registrati']) && !isset($_POST['Login'])) {
    header('location: registrazione.php');
    die;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Benvenuto</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    </head>
    <body>
        <form action="index.php" method="POST">
        <table class="tab_position">
            
            <tr class="center">
                <td colspan="2" class="title">Benvenuto!</td>
            </tr>

            <tr>
                <td class="right">Clicca su login se sei registrato!</td>
                <td><input class="smussati" type="submit" value="Login" name="Login" /></td>
            </tr>

            <tr>
                <td class="right">Se non sei registrato invece, clicca qui!</td>
                <td><input class="smussati" type="submit" value="Registrati" name="Registrati" /></td>
            </tr>

        </table>
        </form>
    </body>
</html>