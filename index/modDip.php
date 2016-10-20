<!--
	Tavallini & Franceschini
	Progetto Basi di Dati 2015
-->
<html>
	<head>
		<title>Formula 1</title>
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<?php
			require("connessione.php"); # Connessione al DB
		?>
	</head>
	<body style="background-color:#d7dee1">
		<?php
			require ("menu.php"); # Chiama il menu
			echo "<div align=center>";			
			if(isSet($_REQUEST['bottoneDip'])) {	// Se e' gia' stato selezionato il dipendente da modificare
				$dipendente=$_REQUEST['dipendente'];
				$rs=mysql_query("select *
									from Dipendente
									where username=\"".$dipendente."\"", $connessione);
				$riga=mysql_fetch_array($rs);
				echo "<h1 align=\"center\" >Modifica dipendente</h1>";
					echo "<form action=\"".$_SERVER['PHP_SELF']."\">
							<table border=0 cellpadding=\"5\" cellspacing=\"5\">
							<tr><td align=\"center\">Username</td> <td align=\"center\">Password</td></tr>
							<tr><td><input type=\"text\" name=\"user\" value=\"".$riga['username']."\" maxlength=\"8\"></td>
							<td><input type=\"text\" name=\"pass\" value=\"".$riga['password']."\" maxlength=\"10\"></td></tr>";
							
						echo "<tr><td align=\"center\">Cognome</td> <td align=\"center\">Nome</td></tr>
							<tr><td><input type=\"text\" name=\"cog\" value=\"".$riga['cognome']."\" maxlength=\"20\"></td>
							<td><input type=\"text\" name=\"nom\" value=\"".$riga['nome']."\" maxlength=\"20\"></td></tr>";

						echo "<tr><td align=\"center\">Data di nascita</td> <td align=\"center\">Telefono</td></tr>
							<tr><td><input type=\"text\" name=\"nasc\" value=\"".$riga['data_nascita']."\"></td>
							<td><input type=\"text\" name=\"tel\" value=\"".$riga['telefono']."\" maxlength=\"10\"></td></tr>";
						
						echo "<tr><td align=\"center\">Nazionalità</td> <td align=\"center\">Indirizzo</td></tr>
							<tr><td><input type=\"text\" name=\"naz\" value=\"".$riga['nazionalita']."\" maxlength=\"20\"></td>
							<td><input type=\"text\" name=\"ind\" value=\"".$riga['indirizzo']."\" maxlength=\"20\"></td></tr>";
						
						echo "<tr><td align=\"center\">Stipendio</td> <td align=\"center\">Data di assunzione</td></tr>
							<tr><td><input type=\"text\" name=\"stip\" value=\"".$riga['stipendio']."\" maxlength=\"9\"></td>
							<td><input type=\"text\" name=\"ass\" value=\"".$riga['data_assunzione']."\"></td></tr>";

						echo "<tr><td align=\"center\">Fine contratto</td> <td align=\"center\">Specializzazione</td></tr>
							<tr><td><input type=\"text\" name=\"term\" value=\"".$riga['data_termine']."\"></td>
							<td><input type=\"text\" name=\"spec\" value=\"".$riga['specializzazione']."\" maxlength=\"20\"></td></tr>";

						echo "
							<tr align=\"center\"></tr></table>";
						#inserirlo nel reparto del direttore
						echo "</br><input type=\"submit\" name=\"modifica\" value=\"Modifica\">
							</form>";
						$_SESSION['oldDip']=$dipendente;
			}else{
				if(isSet($_REQUEST['modifica'])) {	// Se e' gia' stato premuto il bottone modfifica
					$usr=$_REQUEST['user'];
					$psw=$_REQUEST['pass'];
					$cog=$_REQUEST['cog'];
					$nome=$_REQUEST['nom'];
					$nasc=$_REQUEST['nasc'];
					$tel=$_REQUEST['tel'];
					$naz=$_REQUEST['naz'];
					$ind=$_REQUEST['ind'];
					$stip=$_REQUEST['stip'];
					$ass=$_REQUEST['ass'];
					$term=$_REQUEST['term'];
					$spec=$_REQUEST['spec'];
					if(strlen($psw)<6) { #password troppo corta
						echo "<h1 align=\"center\" >Modifica dipendente</h1>";
						echo "<em style=\"color:red;\">Passowrd troppo corta</em>";
						echo "<form action=\"".$_SERVER['PHP_SELF']."\">
							<table border=0 cellpadding=\"5\" cellspacing=\"5\">
							<tr><td align=\"center\">Username</td> <td align=\"center\">Password</td></tr>
							<tr><td><input type=\"text\" name=\"user\" value=\"8 caratteri\" maxlength=\"8\"></td>
							<td><input type=\"password\" name=\"pass\" value=\"da 6 a 10 caratteri\" maxlength=\"10\"></td></tr>";
							
						echo "<tr><td align=\"center\">Cognome</td> <td align=\"center\">Nome</td></tr>
							<tr><td><input type=\"text\" name=\"cog\" value=\"20 caratteri\" maxlength=\"20\"></td>
							<td><input type=\"text\" name=\"nom\" value=\"20 caratteri\" maxlength=\"20\"></td></tr>";

						echo "<tr><td align=\"center\">Data di nascita</td> <td align=\"center\">Telefono</td></tr>
							<tr><td><input type=\"text\" name=\"nasc\" value=\"AAAA-MM-GG\"></td>
							<td><input type=\"text\" name=\"tel\" value=\"10 caratteri\" maxlength=\"10\"></td></tr>";
						
						echo "<tr><td align=\"center\">Nazionalità</td> <td align=\"center\">Indirizzo</td></tr>
							<tr><td><input type=\"text\" name=\"naz\" value=\"20 caratteri\" maxlength=\"20\"></td>
							<td><input type=\"text\" name=\"ind\" value=\"20 caratteri\" maxlength=\"20\"></td></tr>";
						
						echo "<tr><td align=\"center\">Stipendio</td> <td align=\"center\">Data di assunzione</td></tr>
							<tr><td><input type=\"text\" name=\"stip\" value=\"9 caratteri\" maxlength=\"9\"></td>
							<td><input type=\"text\" name=\"ass\" value=\"AAAA-MM-GG\"></td></tr>";

						echo "<tr><td align=\"center\">Fine contratto</td> <td align=\"center\">Specializzazione</td></tr>
							<tr><td><input type=\"text\" name=\"term\" value=\"AAAA-MM-GG\"></td>
							<td><input type=\"text\" name=\"spec\" value=\"20 caratteri\" maxlength=\"20\"></td></tr>";

						echo "<tr align=\"center\"></tr></table>";
						echo "</br><input type=\"submit\" name=\"modifica\" value=\"Modifica\">
							</form>";
					}else{
						#session_start();
						$old=$_SESSION['oldDip'];
						if($usr!=$old) { # verifico se e' stato modificato lo username
							$rs=mysql_query("select *
										from Dipendente
										where username=\"".$usr."\"", $connessione);
							if(mysql_num_rows($rs)==1) { # se lo username esiste gia'
								echo "<h1 align=\"center\" >Modifica dipendente</h1>";
								echo "<em style=\"color:red;\">Username gia' esistente</em>";
								echo "<form action=\"".$_SERVER['PHP_SELF']."\">
								<table border=0 cellpadding=\"5\" cellspacing=\"5\">
								<tr><td align=\"center\">Username</td> <td align=\"center\">Password</td></tr>
								<tr><td><input type=\"text\" name=\"user\" value=\"8 caratteri\" maxlength=\"8\"></td>
								<td><input type=\"password\" name=\"pass\" value=\"da 6 a 10 caratteri\" maxlength=\"10\"></td></tr>";
							
								echo "<tr><td align=\"center\">Cognome</td> <td align=\"center\">Nome</td></tr>
								<tr><td><input type=\"text\" name=\"cog\" value=\"20 caratteri\" maxlength=\"20\"></td>
								<td><input type=\"text\" name=\"nom\" value=\"20 caratteri\" maxlength=\"20\"></td></tr>";

								echo "<tr><td align=\"center\">Data di nascita</td> <td align=\"center\">Telefono</td></tr>
								<tr><td><input type=\"text\" name=\"nasc\" value=\"AAAA-MM-GG\"></td>
								<td><input type=\"text\" name=\"tel\" value=\"10 caratteri\" maxlength=\"10\"></td></tr>";
						
								echo "<tr><td align=\"center\">Nazionalità</td> <td align=\"center\">Indirizzo</td></tr>
								<tr><td><input type=\"text\" name=\"naz\" value=\"20 caratteri\" maxlength=\"20\"></td>
								<td><input type=\"text\" name=\"ind\" value=\"20 caratteri\" maxlength=\"20\"></td></tr>";
						
								echo "<tr><td align=\"center\">Stipendio</td> <td align=\"center\">Data di assunzione</td></tr>
								<tr><td><input type=\"text\" name=\"stip\" value=\"9 caratteri\" maxlength=\"9\"></td>
								<td><input type=\"text\" name=\"ass\" value=\"AAAA-MM-GG\"></td></tr>";

								echo "<tr><td align=\"center\">Fine contratto</td> <td align=\"center\">Specializzazione</td></tr>
								<tr><td><input type=\"text\" name=\"term\" value=\"AAAA-MM-GG\"></td>
								<td><input type=\"text\" name=\"spec\" value=\"20 caratteri\" maxlength=\"20\"></td></tr>";

								echo "<tr align=\"center\"></tr></table>";
						
								echo "</br><input type=\"submit\" name=\"modifica\" value=\"Modifica\">
								</form>";
							}else{ # inserisco la modifica
								#session_start();
								$username=$_SESSION['username'];
								$rs=mysql_query("select scuderia, reparto
												from Dipendente
												where username=\"".$username."\"", $connessione);
								$riga=mysql_fetch_array($rs);
								mysql_query("UPDATE Dipendente SET(username=\"".$usr."\", password=\"".$psw."\", cognome=\"".$cog."\", nome=\"".$nome."\", data_nascita=\"".$nasc."\", telefono=".$tel.", nazionalita=\"".$naz."\", indirizzo=\"".$ind."\", stipendio=".$stip.", data_assunzione=\"".$ass."\", data_termine=".$term.", specializzazione=\"".$spec."\");", $connessione);
								echo "<h1 align=\"center\" >Modifica dipendente</h1>";
								echo "Modifica avvenuta correttamente.";
								$user=$_SESSION['username'];
								$pasw=$_SESSION['password'];
								$_SESSION['username']=$user;
								$_SESSION['password']=$pasw;
							}
						}else{ # Inserisco la modifica
							mysql_query("UPDATE Dipendente SET(password=\"".$psw."\", cognome=\"".$cog."\", nome=\"".$nome."\", data_nascita=\"".$nasc."\", telefono=".$tel.", nazionalita=\"".$naz."\", indirizzo=\"".$ind."\", stipendio=".$stip.", data_assunzione=\"".$ass."\", data_termine=".$term.", specializzazione=\"".$spec."\");", $connessione);
							echo "<h1 align=\"center\" >Modifica dipendente</h1>";
							echo "Modifica avvenuta correttamente.";
							$user=$_SESSION['username'];
							$pasw=$_SESSION['password'];
							$_SESSION['username']=$user;
							$_SESSION['password']=$pasw;
						}
					}
				}else{
					echo "<h1 align=\"center\" >Modifica dipendente</h1>";
					$user=$_SESSION['username'];
					$rs=mysql_query("select scuderia, reparto
									from Dipendente
									where username=\"".$user."\"", $connessione);
					$riga=mysql_fetch_array($rs);
					echo "<form action=\"".$_SERVER['PHP_SELF']."\">";
					$rs=mysql_query("select username 
									from Dipendente
									where scuderia=\"".$riga['scuderia']."\" and reparto=\"".$riga['reparto']."\";", $connessione);
					echo "Scegliere il dipendente da modificare <select name=\"dipendente\" >";
					while($rs=mysql_fetch_array($rs)) {
						echo "<option>".$rs['username']."</option>";
					}
					echo "</select>";
					echo " <input type=\"submit\" name=\"bottoneDip\" value=\"Seleziona\"></form>";
			}
		}
		echo "</div>";
		?>
	</body>
</html>
