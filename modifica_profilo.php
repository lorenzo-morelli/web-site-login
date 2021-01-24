<?php

session_start();
include 'connessione.php';

if (isset($_POST['indietro'])) {
	header('location: welcome.php');
    die;
}

if ($_SESSION['login'] == true) {

	$richiesta = "SELECT * FROM Credenziali WHERE Username = '" . $_SESSION['username'] . "'";
    $risultato = $connessione->query($richiesta);
    
    $row = mysqli_fetch_assoc($risultato);

	if(isset($_POST['Elimina_Account'])) {

		$richiesta1 = "DELETE FROM Credenziali WHERE ID = '" . $row['ID'] . "'";
		$risultato1 = $connessione->query($richiesta1);
		setcookie("user_cookie", "", time() - (86400 * 14), "/", "lorenzomorelli.co.nf");		//14 giorni
        session_destroy();
		header('location: index.php');
		die;
	}

	if (isset($_POST['nome']) != "" && isset($_POST['cognome']) != "" && isset($_POST['username']) != "" && isset($_POST['password1']) != "" && isset ($_POST['password2']) != "") {

	    $error = false;
	    
	    $richiesta = "SELECT * FROM Credenziali WHERE Email ='" . $_POST['email'] . "' AND ID != '" . $row['ID'] . "'";
	    $risultato = $connessione->query($richiesta);

	    if ($risultato->num_rows > 0) {
	        ?><p class="messaggi_errore"><font color="red">Esiste gia' una mail legata a un account.</font></p><?php
	        $error = true;
	        die;
	    }

	    $richiesta = "SELECT * FROM Credenziali WHERE Email ='" . $_POST['email'] . "' AND ID != '" . $row['ID'] . "'";
	    $risultato = $connessione->query($richiesta);

	    if ($risultato->num_rows > 0) {
        	?><p class="messaggi_errore"><font color="red">Lo username è già in uso. Utilizzare uno username diverso.</font></p><?php
        	$error = true;
	        die;
    	}
	        
	    if ($_POST['password1'] != $_POST['password2']) {
	    	$error = true;
	        ?><p class="messaggi_errore"><font color="red">Le password non corrispondono.</font></p><?php
	        die;
	    }
	        
	    if (!preg_match("/^[a-zA-Z0-9._]*$/", $_POST['username'])) {
	        $error = true;
	        ?><p class="messaggi_errore"><font color="red">Username non valido: deve contenere solo lettere, numeri, punti e underscore.</font></p><?php
	        die;
	    }
	            
	    if (!preg_match("/^[a-zA-Z0-9._]*$/", $_POST['password1'])) {  
	        $error = true;
	        ?><p class="messaggi_errore"><font color="red">Password non valida: deve contenere solo lettere, punti e underscore.</font></p><?php
	        die;    
	    }
	    
	    if (strlen($_POST['password1']) < 8 && strlen($_POST['password1']) > 30) {
	        $error = true;
	        ?><p class="messaggi_errore"><font color="red">Password non valida: deve avere una lunghezza compresa tra 8 e 30 caratteri.</font></p><?php
	        die;
	    }
	        
	    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	        $error = true;
	        ?><p class="messaggi_errore"><font color="red">Email non valida: immettere un indirizzo valido (EX: example@domain.ext).</font></p><?php
	        die;
	    }
	        
	    if (!$error) {

	        $richiesta = "UPDATE Credenziali set
	    	Nome = '" . $_POST['nome'] . "',
	    	Cognome = '" . $_POST['cognome'] . "',
			Email = '" . $_POST['email'] . "',
			Username = '" . $_POST['username'] . "',
			Password = MD5('" . $_POST['password1'] . "'),
			Token = '" . $row['Token'] . "'
			WHERE ID = '" . $row['ID'] . "'";

	        $risultato = $connessione->query($richiesta);
	        header('location: login.php');
	        die;
	    }

	    else {
	    	die;
	    }        
    }

    else {
    ?><font color="red">Necessario compilare tutti i campi.</font><?php
	}
}

else {
    header('location: login.php');
    die;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Modifica profilo</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    </head>

    <body>

    	<form action="login.php" method="POST">
    		<input class="smussati color_indietro" type="submit" value="Indietro" name="indietro" />
    	</form>

        <form id="form" name="myForm" action="modifica_profilo.php" method="POST">

        	<table class="tab_position_reg">

        		<tr>
        			<td class="title right">Modifica impostazioni</td>
        			<td class="title">profilo</td>	
        		</tr>

        		<tr>
        			<td class="right">Nome:</td>
        			<td><input id="nome" class="smussati" type="text" name="nome" value = "<?php echo $row['Nome']; ?>" /></td>
        			<td>*</td>
        		</tr>

        		<tr>
        			<td class="right">Cognome:</td>
        			<td><input id="cognome" class="smussati" type="text" name="cognome" value = "<?php echo $row['Cognome']; ?>" /></td>
        			<td>*</td>
        		</tr>

        		<tr>
        			<td class="right">Email:</td>
        			<td><input id="email" class="smussati" type="text" name="email" value = "<?php echo $row['Email']; ?>" /></td>
        			<td>*</td>
        		</tr>

        		<tr>
        			<td class="right">Username:</td>
        			<td><input id="username" class="smussati" type="text" name="username" value = "<?php echo $row['Username']; ?>" /></td>
        			<td>*</td>
        		</tr>

        		<tr>
        			<td class="right">Password:</td>
        			<td><input id="password1" class="smussati" type="password" name="password1" /></td>
        			<td>*</td>
        		</tr>

        		<tr>
        			<td class="right">Reinserire password:</td>
        			<td><input id="password2" class="smussati" type="password" name="password2" /></td>
        			<td>*</td>
        		</tr>

        		<tr>
            		<td></td>
            		<td><input class="smussati color_invia right_but" type="button" value="Modifica" name="Modifica" onclick="validateForm()" /></td>
            	</tr>

            	<script src="script.js"></script>

            	<tr> <!-- Si fa cosi? -->
            		<td><font color="#990000"><b>Elimina account:</b></font></td>
            		<td><input class="smussati right_but color_elimina" type="submit" value="Elimina Account" name="Elimina_Account" /></td>
            	</tr>

        	</table>
        </form>

        <p class="div_scritte">
        	<font color="red">* = Necessario compilare quel campo.</font><br />
        	Lo username puo' contenere solo lettere, punti e underscore.<br />
        	La password puo' contenere solo lettere, punti e underscore e dev'essere lunga da 8 a 30 caratteri.
        </p>

    </body>
</html>