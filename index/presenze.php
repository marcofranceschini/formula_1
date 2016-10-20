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
			echo "<h1 align=\"center\" >Piota con piu' presenze nei Gran Premi</h1>";
			$rs=mysql_query("create or replace view gpFatti as select pilota, count(pilota) as gp_fatti 
							from Gareggia group by pilota;", $connessione);
			$rs=mysql_query("select distinct d.cognome, d.nome, s.nome as scuderia, anno_fondazione, max(gp_fatti) as presenze
							from ((Dipendente as d join Pilota as p on (username=dipendente))  join Gareggia as g on 	(dipendente=pilota)) join Scuderia as s on (p.scuderia=s.nome), gpFatti
							where g.pilota IN (  select pilota
												from gpFatti
												where gp_fatti IN (select max(gp_fatti) as gp from gpFatti)
							) ", $connessione);
			echo "<center><table border=0 cellpadding=\"10\" cellspacing=\"20\">";
			echo "<td align=\"center\"><b>Pilota</b></td><td align=\"center\"><b>Scuderia</b></td><td align=\"center\"><b>Anno fondazione</b></td><td align=\"center\"><b>Presenze</b></td><td align=\"center\"></td>";
			while($riga=mysql_fetch_array($rs)) {
				echo "<tr><td align=left>".$riga['cognome']." ".$riga['nome']."</td>";							
				echo "<td align=center>".$riga['scuderia']."</td>";
				echo "<td align=center>".$riga['anno_fondazione']."</td>";
				echo "<td align=center>".$riga['presenze']."</td>";
				$immagine="Immagini/".$riga['cognome'].".jpg";
				echo "<td align=right><img src=\"".$immagine."\" width=\"250\" height=\"230\"/></td></tr>";
			}
			echo "</table></center>";
		?>
	</body>

</html>
