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
			echo "<h1 align=\"center\" >Maggior produttore di motori</h1>";
			$rs=mysql_query("select distinct s.nome, s.anno_fondazione, m.nome as motore
							from Motore as m join Scuderia as s on (m.produttore=s.nome)
							where s.nome IN (select produttore
											from numProduzioni
											where num IN (select max(num) from numProduzioni)
											);", $connessione);
			echo "<center><table border=0 cellpadding=\"10\" cellspacing=\"20\">";
			echo "<td align=\"center\"><b>Scuderia</b></td><td align=\"center\"><b>Anno fondazione</b></td><td align=\"center\"><b>Motore</b></td>";
			while($riga=mysql_fetch_array($rs)) {
					echo "<tr><td align=left>".$riga['nome']."</td>";							
					echo "<td align=center>".$riga['anno_fondazione']."</td>";
					echo "<td align=center>".$riga['motore']."</td>";
					$immagine="Immagini/".$riga['nome']."Logo.png";
					echo "<td align=right><img src=\"".$immagine."\" width=\"200\" height=\"70\"/></td></tr>";
			}
			echo "</table></center>";
		?>
	</body>

</html>
