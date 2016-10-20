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
			$user=$_SESSION['username'];
			$rs=mysql_query("select scuderia
							from Dipendente
							where username=\"".$user."\"", $connessione);
			$riga=mysql_fetch_array($rs);
			echo "<form action=\"".$_SERVER['PHP_SELF']."\">";
			$rs=mysql_query("select * 
							from Dipendente
							where scuderia=\"".$riga['scuderia']."\" and titolo_studio!='NULL'
							order by cognome DESC;", $connessione);
			echo "<h1 align=\"center\" >Direttori della ".$riga['scuderia']."</h1><div align=center>";
			echo "<table border=0 cellpadding=\"5\" cellspacing=\"15\">";
				echo "<td align=\"center\"><b>Cognome</b></td><td align=\"center\"><b>Nome</b></td><td align=\"center\"><b>Username</b></td><td align=\"center\"><b>Data di nascita</b></td><td align=\"center\"><b>Telefono</b></td>
				<td align=\"center\"><b>Nazionalita'</b></td><td align=\"center\"><b>Indirizzo</b></td><td align=\"center\"><b>Data di assunzione</b></td><td align=\"center\"><b>Titolo di studio</b></td><td align=\"center\"><b>Reparto</b></td>";
				while($riga=mysql_fetch_array($rs)) {
					echo "<tr><td align=left>".$riga['cognome']."</td>";
					echo "<td align=center>".$riga['nome']."</td>";
					echo "<td align=center>".$riga['username']."</td>";	
					echo "<td align=center>".$riga['data_nascita']."</td>";
					echo "<td align=center>".$riga['telefono']."</td>";
					echo "<td align=center>".$riga['nazionalita']."</td>";
					echo "<td align=center>".$riga['indirizzo']."</td>";
					echo "<td align=center>".$riga['data_assunzione']."</td>";
					echo "<td align=center>".$riga['titolo_studio']."</td>";
					echo "<td align=center>".$riga['reparto']."</td>";
				}
			echo "</div>";
		?>
	</body>
</html>
