<!--
	Tavallini & Franceschini
	Progetto Basi di Dati 2015
-->
<?php
			#$connessione=mysql_connect("basidati.studenti.math.unipd.it", "USERNAME", "PASSWORD") or die ("Non e' stato possibile connettersi");
			#mysql_selectDB("mfrances-PR", $connessione);	// Selezione di un DB
			$connessione=mysql_connect("localhost", "root", "") or die ("Non e' stato possibile connettersi");
			mysql_selectDB("Formula_1", $connessione);	// Selezione di un DB
			echo "<link rel=\"icon\" href=\"Immagini/f1.ico\" />";
?>
