<?php

session_start();
include 'connessione.php';

if (isset($_POST['indietro'])) {
	header('location: index.php');
    die;
}

if (isset($_POST['nome']) != "" && isset($_POST['cognome']) != "" && isset($_POST['username']) != "" && isset($_POST['password1']) != "" && isset ($_POST['password2']) != "") {
    $richiesta = "SELECT * FROM Credenziali WHERE Username ='" . $_POST['username'] . "'";
    $risultato = $connessione->query($richiesta);
    
    if ($risultato->num_rows == 0) {
        $error = false;
        
        $richiesta = "SELECT * FROM Credenziali WHERE Email ='" . $_POST['email'] . "'";
        $risultato = $connessione->query($richiesta);
        if ($risultato->num_rows > 0) {
            echo "Esiste gia' una mail legata a un account.";
            $error = true;
            die;
        }
        
        if ($_POST['password1'] != $_POST['password2']) {
            ?><font color="red">Le password non corrispondono.<br /></font><?php
            $error = true;
            die;
        }
        
        if (!preg_match("/^[a-zA-Z0-9._]*$/", $_POST['username'])) {
            $error = true;
            echo "Username non valido: deve contenere solo lettere, numeri, punti e underscore.";
            die;
        }
            
        if (!preg_match("/^[a-zA-Z0-9._]*$/", $_POST['password1'])) {  
            $error = true;
            echo "Password non valida: deve contenere solo lettere, punti e underscore.";
            die;
        }
    
        if (strlen($_POST['password1']) < 8 && strlen($_POST['password1']) > 30) {
            $error = true;
            echo "Password non valida: deve avere una lunghezza compresa tra 8 e 30 caratteri.";
            die;
        }
        
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        	$error = true;
            echo "Email non valida: immettere un indirizzo valido (EX: example@domain.ext).";
            die;
        }
        
        if (!$error) {

            $sql = "INSERT into Credenziali
            (Nome, Cognome, Email, Username, Password, Token) values
            ('" . $_POST['nome'] . "',
            '" . $_POST['cognome'] . "',
            '" .$_POST['email'] . "',
            '". $_POST['username'] . "',
            MD5('" . $_POST['password1'] . "'),
            MD5('" . $_POST['username'] . "'))";

            $risultato = $connessione->query($sql);
            header('location: login.php');
            die;
        }
    }
    
    else {
        ?><font color="red">Lo username è già in uso. Utilizzare uno username diverso.</font><?php
    }
}

else {
    	?><font color="red">Necessario compilare tutti i campi.</font><?php
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Registrazione</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    </head>
    <body>

    	<form action="login.php" method="POST">
    		<input class="smussati color_indietro" type="submit" value="Indietro" name="indietro" />
    	</form>
    	
        <form action="registrazione.php" method="POST">

        	<table class="tab_position_reg">

        		<tr>
        			<td colspan="2" class="title center">Registrazione</td>
        		</tr>

        		<tr>
        			<td class="right">Nome:</td>
        			<td><input class="smussati" type="text" name="nome" placeholder="Nome" /></td>
        			<td>*</td>
        		</tr>

        		<tr>
        			<td class="right">Cognome:</td>
        			<td><input class="smussati" type="text" name="cognome" placeholder="Cognome" /></td>
        			<td>*</td>
        		</tr>

        		<tr>
        			<td class="right">Email:</td>
        			<td><input class="smussati" type="text" name="email" placeholder="example@domain.ext" /></td>
        			<td>*</td>
        		</tr>

        		<tr>
        			<td class="right">Username:</td>
        			<td><input class="smussati" type="text" name="username" placeholder="Username"/></td>
        			<td>*</td>
        		</tr>

        		<tr>
        			<td class="right">Password:</td>
        			<td><input class="smussati" type="password" name="password1" placeholder="Password 1" /></td>
        			<td>*</td>
        		</tr>

        		<tr>
        			<td class="right">Reinserire password:</td>
        			<td><input class="smussati" type="password" name="password2" placeholder="Password 2" /></td>
        			<td>*</td>
        		</tr>

        		<tr>
            		
            		<td colspan="2"><input class="smussati right_but color_invia" type="submit" name="Registrati" /></td>
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