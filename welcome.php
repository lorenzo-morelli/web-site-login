<?php

session_start();
include 'connessione.php';

if (isset($_POST['indietro']) && !isset($_POST['mod_prof']) && !isset($_POST['Logout'])) {
	header('location: index.php');
    die;
}

if (isset($_POST['Logout']) && !isset($_POST['mod_prof']) && !isset($_POST['indietro'])) {
        setcookie("user_cookie", "", time() - (86400 * 14), "/", "lorenzomorelli.co.nf");		//14 giorni
        session_destroy();
        header('location: login.php');
    	die;
}

if (!isset($_POST['Logout']) && isset($_POST['mod_prof']) && !isset($_POST['indietro'])) {
	header('location: modifica_profilo.php');
    die;
}

if ($_SESSION['login'] == true) {
    $richiesta = "SELECT * FROM Credenziali WHERE Username = '" . $_SESSION['username'] . "'";
    $risultato = $connessione->query($richiesta);
    
    $row = mysqli_fetch_assoc($risultato);
}

else {
    header('location: login.php');
    die;
}
?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <title>Welcome <?php echo $_SESSION['username']?>!</title>
        <link rel="stylesheet" type="text/css" href="style.css">
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    </head>
    <body>
    	
    	<form action="welcome.php" method="POST">
    		<input class="smussati color_indietro" type="submit" value="Indietro" name="indietro" />
    	</form>

    	<table>
    		<tr>
    			<td class="right title"><b>Bentornato, </b></td>
    			<td class="title"><b>"<?php echo $row['Username']?>"!</b></td>
    		</tr>
    		<tr>
    			<td class="right"><b>Nome:</b></td>
    			<td><?php echo $row['Nome']?></td>
    		</tr>

    		<tr>
    			<td class="right"><b>Cognome: </b></td>
    			<td><?php echo $row['Cognome']?></td>
    		</tr>

    		<tr>
    			<td class="right"><b>Email: </b></td>
    			<td><?php echo $row['Email']?></td>
    		</tr>

    		<tr>
				<td class="right"><b>Username: </b></td>
				<td><?php echo $row['Username']?></td>
			</tr>

    	</table>

    	<form action="welcome.php" method="POST">
    		<input class="smussati color_mod" type="submit" value="Modifica profilo" name="mod_prof" />
            <input class="smussati color_logout" type="submit" value="Logout" name="Logout" />
        </form>
   	</body>
</html>