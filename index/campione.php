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
			echo "<h1 align=\"center\">Pilota piu' titolato</h1>";
			$rs=mysql_query("select d.nome, d.cognome, d.data_nascita, d.nazionalita,  max(y.campionati_vinti) as campionati_vinti
							from Gareggia as g join Dipendente as d on (g.pilota=d.username) join (select pilota, count(pilota) as campionati_vinti 
																									from (select anno, pilota, max(t.punti) as punti 
																											from (select anno, pilota, sum(punti) as punti 
																													from Gareggia group by anno, pilota order by punti desc ) as t
																											group by anno 
																										  ) as x
																										  group by pilota
																									)as y on (g.pilota=y.pilota)
								group by d.nome
								order by campionati_vinti desc
								limit 1;", $connessione);
				echo "<center><table border=0 cellpadding=\"10\" cellspacing=\"20\">";
				echo "<td align=\"center\"><b>Pilota</b></td><td align=\"center\"><b>Data di nascita</b></td><td align=\"center\"><b>Nazionalita'</b></td><td><b>Campionati vinti</b></td>";
				while($riga=mysql_fetch_array($rs)) {
					echo "<tr><td align=left>".$riga['cognome']." ".$riga['nome']."</td>";							
					echo "<td align=left>".$riga['data_nascita']."</td>";
					echo "<td align=center>".$riga['nazionalita']."</td>";
					echo "<td align=center>".$riga['campionati_vinti']."</td>";
					$immagine="Immagini/".$riga['cognome'].".jpg";
					echo "<td align=right><img src=\"".$immagine."\" width=\"250\" height=\"230\"/></td></tr>";
				}
				echo "</table></center>";	
				
		?>
	</body>

</html>
