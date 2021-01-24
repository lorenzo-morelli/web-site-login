<?php

session_start();
include 'connessione.php';

if (isset($_POST['indietro']) && !isset($_POST['Registrati']) && !isset($_POST['Login'])) {
	header('location: index.php');
    die;
}


if (isset($_POST['Registrati']) && !isset($_POST['Login']) && !isset($_POST['indietro'])) {
    header('location: registrazione.php');
    die;
}




if (isset($_COOKIE['user_cookie'])) {
    $richiesta = "SELECT * FROM Credenziali WHERE Token = '" . $_COOKIE['user_cookie'] . "'";
    $risultato = $connessione->query($richiesta);
    
    $row = mysqli_fetch_assoc($risultato);
    $_SESSION['username'] = $row['Username'];
    $_SESSION['login'] = true;
    header('location: welcome.php');
    die;
}
elseif (isset($_POST['username']) && isset($_POST['password'])) {          //controlla se username e password sono stati immessi

    $sql = "SELECT Username, Password
    FROM Credenziali
    WHERE Username = '" . $_POST['username'] ."' AND
    Password = MD5('" . $_POST['password'] . "')";

    $result = $connessione->query($sql);        //facciamo compiere al SQL la query della riga precedente

        if ($result->num_rows > 0) {                              //se $risultato ha trovato un numero di righe >0
            $_SESSION['login'] = true;                          //il login è compiuto
            $_SESSION['username'] = $_POST['username'];

			if (isset($_POST['Ricordami'])) {
            	$sql = "INSERT into Credenziali
            	(Token) values
            	(MD5('" . $_POST['username'] . "'))";

            	$nome_cookie = "user_cookie";
            	$token = md5($_POST['username']);
            	setcookie($nome_cookie, $token, time() + (86400 * 14), "/", "lorenzomorelli.co.nf");		//14 giorni
            	echo $_COOKIE['user_cookie'];

            }

            header('location: welcome.php');                         //trasferisciti a welcome.php
            die;                                                     //chiudi questa pagina
        }

        else {                                                       //se non sono stati trovati username o password
             ?><div align="center"><font color="red">Nome utente o password errati.</font></div><?php
        }
}

else {
    ?><div align="center"><font color="red">Prego inserire nome utente o password.</font></div><?php
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Login Page</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    </head>
    <body>

    	<form action="login.php" method="POST">
    		<input class="smussati color_indietro" type="submit" value="Indietro" name="indietro" />
    	</form>

        <form action="login.php" method="POST">

            <table class="tab_position">

	           	<tr>
	           		<td></td>
	           		<td class="title">Login</td>
	           </tr>
																						<!-- cosa si fa? -->
	            <tr>
	            	<td class="right">Username:</td>
	            	<td><input class="smussati" type="text" name="username" /></td>
	            </tr>

	            <tr>
	            	<td class="right">Password:</td>
	            	<td><input class="smussati" type="password" name="password" id="psw" /></td>
	            	<td>
	            		<input class="smussati" type="checkbox" onclick="myFunction()">
	            		<img src="Media/eye.png" width="20" height="20">
	            	</td>
	            </tr>

				<script src="script.js"></script>

				<tr >
	            	<td class="right">Ricordami (per 14 gg):</td>
	            	<td><input class="smussati" type="checkbox" name="Ricordami" value="ON" /></td>
	            </tr>

	            <tr>
	            	<td></td>
	            	<td><input class="smussati color_invia" type="submit" value="Invia" /></td>
	        	</tr>

	        	<tr>
	        		<td><i>Oppure:</i></td>
	        	</tr>

	            <tr>
	            	<td class="right">se non sei registrato invece, <br />clicca qui!</td>
	            	<td><input class="smussati" type="submit" value="Registrati" name="Registrati"/></td>
	            </tr>

            </table>

        </form>
        
    </body>
</html>
