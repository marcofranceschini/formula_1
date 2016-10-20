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
			echo "<h1 align=\"center\" >Pilota con piu' pole position</h1>";
			$rs=mysql_query("select *
							from polePiloti
							where pole IN (select max(pole) from polePiloti);", $connessione);
			echo $rs['cognome']."<center><table border=0 cellpadding=\"5\" cellspacing=\"15\">";
			echo "<td align=\"center\"><b>Pilota</b></td><td align=\"center\"><b>Nazionalità</b></td><td align=\"center\"><b>Numero di pole</b></td><td><b>		</b></td>";
			while($riga=mysql_fetch_array($rs)) {
				echo "<tr><td align=left>".$riga['cognome']." ".$riga['nome']."</td>";							
				echo "<td align=left>".$riga['nazionalita']."</td>";
				echo "<td align=center>".$riga['pole']."</td>";
				$immagine="Immagini/".$riga['cognome'].".jpg";
				echo "<td align=right><img src=\"".$immagine."\" width=\"250\" height=\"230\"/></td></tr>";
			}
			echo "</table></center>";
		?>
	</body>

</html>
