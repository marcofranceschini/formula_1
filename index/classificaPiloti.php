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
			#session_start();
			require ("menu.php");	
			if(isSet($_REQUEST['bottoneAnno'])) {	// Se è gia stato selezionato l'anno del campionato
				$anno=$_REQUEST['anno'];
				echo "<h1 align=\"center\" >Classifica piloti - ".$anno."</h1>";
				$rs=mysql_query("select nome, cognome, g.scuderia,  sum(punti) as punti
								from Gareggia as g join Dipendente on (pilota=username)
								where anno=".$anno."
								GROUP BY username
								ORDER BY punti DESC", $connessione);
				echo "<center><table border=0 cellpadding=\"5\" cellspacing=\"15\">";
				echo "<td align=\"center\"><b>Pilota			</b></td><td align=\"center\"><b>		Scuderia	</b></td><td align=\"center\"><b>		Punti	</b></td><td><b>		</b></td>";
				while($riga=mysql_fetch_array($rs)) {
					echo "<tr><td align=left>".$riga['cognome']." ".$riga['nome']."</td>";							
					echo "<td align=left>".$riga['scuderia']."</td>";
					echo "<td align=center>".$riga['punti']."</td>";
					$immagine="Immagini/".$riga['scuderia'].".png";
					echo "<td align=right><img src=\"".$immagine."\" width=\"100\" height=\"20\"/></td></tr>";
				}
				echo "</table></center>";
			}else{
				echo "<form action=\"".$_SERVER['PHP_SELF']."\">";
				echo "<h1 align=\"center\" >Classifica piloti</h1>";
				$rs=mysql_query("select distinct anno from GP;", $connessione);
				echo "<center>Indicare l' anno <select name=\"anno\" >";
				while($riga=mysql_fetch_array($rs)) {
					echo "<option>".$riga['anno']."</option>";
				}
				echo "</select>";
				echo " <input type=\"submit\" name=\"bottoneAnno\" value=\"Seleziona\"></form></center>";
			}
		?>
	</body>

</html>
