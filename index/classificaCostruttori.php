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
				echo "<h1 align=\"center\" >Classifica costruttori - ".$anno."</h1>";
				$rs=mysql_query("select s.nome, sum(punti) as punti
								from Partecipa join Scuderia as s on (scuderia=nome)
								where anno=".$anno."
								GROUP BY s.nome
								ORDER BY punti DESC", $connessione);
				echo "<center><table border=0 cellpadding=\"10\" cellspacing=\"20\">";
				echo "<td align=\"center\"><b>Scuderia			</b></td><td align=\"center\"><b>		Punti	</b></td>";
				while($riga=mysql_fetch_array($rs)) {
					echo "<tr><td align=left>".$riga['nome']."</td>";							
					echo "<td align=center>".$riga['punti']."</td>";
					$immagine="Immagini/".$riga['nome']."Logo.png";
					echo "<td align=right><img src=\"".$immagine."\" width=\"200\" height=\"70\"/></td></tr>";
				}
				echo "</table></center>";
			}else{
				echo "<form action=\"".$_SERVER['PHP_SELF']."\">";
				echo "<h1 align=\"center\" >Classifica costruttori</h1>";
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
