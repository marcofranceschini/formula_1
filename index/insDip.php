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
			require ("menu.php");		
			echo "<div align=center>";
			if(isSet($_REQUEST['inserisci'])) {	// Se e' gia' stato premuto per l' inserimento
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
				if(strlen($psw)<6) {
					echo "<h1 align=\"center\" >Inserisci dipendente</h1>";
					echo "<em style=\"color:red;\">Passowrd troppo corta</em>";
					echo "<form action=\"".$_SERVER['PHP_SELF']."\">
							<table border=0 cellpadding=\"5\" cellspacing=\"5\">
							<tr><td align=\"center\">Username</td> <td align=\"center\">Password</td></tr>
							<tr><td><input type=\"text\" name=\"user\" placeholder=\"8 caratteri\" maxlength=\"8\"></td>
							<td><input type=\"text\" name=\"pass\" placeholder=\"da 6 a 10 caratteri\" maxlength=\"10\"></td></tr>";
							
						echo "<tr><td align=\"center\">Cognome</td> <td align=\"center\">Nome</td></tr>
							<tr><td><input type=\"text\" name=\"cog\" placeholder=\"20 caratteri\" maxlength=\"20\"></td>
							<td><input type=\"text\" name=\"nom\" placeholder=\"20 caratteri\" maxlength=\"20\"></td></tr>";

						echo "<tr><td align=\"center\">Data di nascita</td> <td align=\"center\">Telefono</td></tr>
							<tr><td><input type=\"text\" name=\"nasc\" placeholder=\"AAAA-MM-GG\"></td>
							<td><input type=\"text\" name=\"tel\" placeholder=\"10 caratteri\" maxlength=\"10\"></td></tr>";
						
						echo "<tr><td align=\"center\">Nazionalità</td> <td align=\"center\">Indirizzo</td></tr>
							<tr><td><input type=\"text\" name=\"naz\" placeholder=\"20 caratteri\" maxlength=\"20\"></td>
							<td><input type=\"text\" name=\"ind\" placeholder=\"20 caratteri\" maxlength=\"20\"></td></tr>";
						
						echo "<tr><td align=\"center\">Stipendio</td> <td align=\"center\">Data di assunzione</td></tr>
							<tr><td><input type=\"text\" name=\"stip\" placeholder=\"9 caratteri\" maxlength=\"9\"></td>
							<td><input type=\"text\" name=\"ass\" placeholder=\"AAAA-MM-GG\"></td></tr>";

						echo "<tr><td align=\"center\">Fine contratto</td> <td align=\"center\">Specializzazione</td></tr>
							<tr><td><input type=\"text\" name=\"term\" placeholder=\"AAAA-MM-GG\"></td>
							<td><input type=\"text\" name=\"spec\" placeholder=\"20 caratteri\" maxlength=\"20\"></td></tr>";

						echo "
							<tr align=\"center\"></tr></table>";
						#inserirlo nel reparto del direttore
						echo "</br><input type=\"submit\" name=\"inserisci\" value=\"Inserisci\">
							</form>";
				}else{
					$rs=mysql_query("select *
									from Dipendente
									where username=\"".$usr."\"", $connessione);
					if(mysql_num_rows($rs)==1) {
						echo "<h1 align=\"center\" >Inserisci dipendente</h1>";
						echo "<em style=\"color:red;\">Username gia' esistente</em>";
						echo "<form action=\"".$_SERVER['PHP_SELF']."\">
							<table border=0 cellpadding=\"5\" cellspacing=\"5\">
							<tr><td align=\"center\">Username</td> <td align=\"center\">Password</td></tr>
							<tr><td><input type=\"text\" name=\"user\" placeholder=\"8 caratteri\" maxlength=\"8\"></td>
							<td><input type=\"text\" name=\"pass\" placeholder=\"da 6 a 10 caratteri\" maxlength=\"10\"></td></tr>";
							
						echo "<tr><td align=\"center\">Cognome</td> <td align=\"center\">Nome</td></tr>
							<tr><td><input type=\"text\" name=\"cog\" placeholder=\"20 caratteri\" maxlength=\"20\"></td>
							<td><input type=\"text\" name=\"nom\" placeholder=\"20 caratteri\" maxlength=\"20\"></td></tr>";

						echo "<tr><td align=\"center\">Data di nascita</td> <td align=\"center\">Telefono</td></tr>
							<tr><td><input type=\"text\" name=\"nasc\" value=\"AAAA-MM-GG\"></td>
							<td><input type=\"text\" name=\"tel\" value=\"10 caratteri\" maxlength=\"10\"></td></tr>";
						
						echo "<tr><td align=\"center\">Nazionalità</td> <td align=\"center\">Indirizzo</td></tr>
							<tr><td><input type=\"text\" name=\"naz\" placeholder=\"20 caratteri\" maxlength=\"20\"></td>
							<td><input type=\"text\" name=\"ind\" placeholder=\"20 caratteri\" maxlength=\"20\"></td></tr>";
						
						echo "<tr><td align=\"center\">Stipendio</td> <td align=\"center\">Data di assunzione</td></tr>
							<tr><td><input type=\"text\" name=\"stip\" placeholder=\"9 caratteri\" maxlength=\"9\"></td>
							<td><input type=\"text\" name=\"ass\" placeholder=\"AAAA-MM-GG\"></td></tr>";

						echo "<tr><td align=\"center\">Fine contratto</td> <td align=\"center\">Specializzazione</td></tr>
							<tr><td><input type=\"text\" name=\"term\" placeholder=\"AAAA-MM-GG\"></td>
							<td><input type=\"text\" name=\"spec\" placeholder=\"20 caratteri\" maxlength=\"20\"></td></tr>";

						echo "
							<tr align=\"center\"></tr></table>";
						#inserirlo nel reparto del direttore
						echo "</br><input type=\"submit\" name=\"inserisci\" value=\"Inserisci\">
							</form>";
					}else{
						#session_start();
						$username=$_SESSION['username'];
						$rs=mysql_query("select scuderia, reparto
										from Dipendente
										where username=\"".$username."\"", $connessione);
						$riga=mysql_fetch_array($rs);
						mysql_query("INSERT INTO Dipendente VALUES(\"".$usr."\", \"qwerty\", \"".$cog."\", \"".$nome."\", \"".$nasc."\", ".$tel.", \"".$naz."\", \"".$ind."\", ".$stip.", \"".$ass."\", ".$term.", \"".$spec."\", NULL, \"".$riga['reparto']."\", \"".$riga['scuderia']."\");", $connessione);
						echo "<h1 align=\"center\" >Inserisci dipendente</h1>";
						echo "Inserimento avvenuto correttamente.";
					}
				}
			}else{
				echo "<h1 align=\"center\" >Inserisci dipendente</h1>";
				echo "<form action=\"".$_SERVER['PHP_SELF']."\">
							<table border=0 cellpadding=\"5\" cellspacing=\"5\">
							<tr><td align=\"center\">Username</td> <td align=\"center\">Password</td></tr>
							<tr><td><input type=\"text\" name=\"user\" placeholder=\"8 caratteri\" maxlength=\"8\"></td>
							<td><input type=\"text\" name=\"pass\" placeholder=\"da 6 a 10 caratteri\" maxlength=\"10\"></td></tr>";
							
						echo "<tr><td align=\"center\">Cognome</td> <td align=\"center\">Nome</td></tr>
							<tr><td><input type=\"text\" name=\"cog\" placeholder=\"20 caratteri\" maxlength=\"20\"></td>
							<td><input type=\"text\" name=\"nom\" placeholder=\"20 caratteri\" maxlength=\"20\"></td></tr>";

						echo "<tr><td align=\"center\">Data di nascita</td> <td align=\"center\">Telefono</td></tr>
							<tr><td><input type=\"text\" name=\"nasc\" placeholder=\"AAAA-MM-GG\"></td>
							<td><input type=\"text\" name=\"tel\" placeholder=\"10 caratteri\" maxlength=\"10\"></td></tr>";
						
						echo "<tr><td align=\"center\">Nazionalità</td> <td align=\"center\">Indirizzo</td></tr>
							<tr><td><input type=\"text\" name=\"naz\" placeholder=\"20 caratteri\" maxlength=\"20\"></td>
							<td><input type=\"text\" name=\"ind\" placeholder=\"20 caratteri\" maxlength=\"20\"></td></tr>";
						
						echo "<tr><td align=\"center\">Stipendio</td> <td align=\"center\">Data di assunzione</td></tr>
							<tr><td><input type=\"text\" name=\"stip\" placeholder=\"9 caratteri\" maxlength=\"9\"></td>
							<td><input type=\"text\" name=\"ass\" placeholder=\"AAAA-MM-GG\"></td></tr>";

						echo "<tr><td align=\"center\">Fine contratto</td> <td align=\"center\">Specializzazione</td></tr>
							<tr><td><input type=\"text\" name=\"term\" placeholder=\"AAAA-MM-GG\"></td>
							<td><input type=\"text\" name=\"spec\" placeholder=\"20 caratteri\" maxlength=\"20\"></td></tr>";

						echo "
							<tr align=\"center\"></tr></table>";
						#inserirlo nel reparto del direttore
						echo "</br><input type=\"submit\" name=\"inserisci\" value=\"Inserisci\">
							</form>";
			}
			echo "<div align=center>";
		?>
	</body>

</html>
