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
			if(isSet($_REQUEST['inserisci'])) {	// Se e' gia' stato premuto per l' inserimento
				$aiuto=$_SESSION['vet'];
				$app[20]=NULL;
				$app=$aiuto;
				$lung=count($aiuto)+1;
				$gp=$_SESSION['gp'];
				$pieces=explode(" - ", $gp);
				$gara=$pieces[0];
				$anno=$pieces[1];
				echo "<h1 align=\"center\">Inserisci qualifiche per il ".$gp."</h1>";
				$i=1;
				while($i<$lung) {
					$tempo=$_REQUEST["mil".$i]/(1000)+$_REQUEST["min".$i]*60+$_REQUEST["sec".$i];
					$vet[$i]=$tempo;
					$arrivo[$i]="NULL";
					$punti[$i]="NULL";
					$i++;					
				}
				# Seleziono i piloti gia' presenti in Gareggia
				$rs=mysql_query("select  pilota, tempo_qualifica, pos_fin, punti from Gareggia where gp=\"".$gara."\" and anno=".$anno.";", $connessione);
				if(mysql_num_rows($rs)) {
					$i=$lung;
					while($riga=mysql_fetch_array($rs)) {
						# Salvo i dati della gara dei piloti indicati
						$app[$i]=$riga['pilota'];
						$vet[$i]=$riga['tempo_qualifica'];
						$arrivo[$i]=$riga['pos_fin'];
						$punti[$i]=$riga['punti'];
						# Elimino i piloti indicati per non avere problemi nella successiva insert
						mysql_query("delete from Gareggia where gp=\"".$gara."\" and anno=".$anno." and pilota=\"".$riga['pilota']."\";", $connessione);
						$i++;
					}
				}
				$lung=$i;
				$i=1;
				while($i<$lung-1) { # Ordinamento
					$j=$i;
					if($vet[$i]!=0) {
						while($j<$lung) {
							if($vet[$j]<$vet[$i]) {
								# Ordino il vettore in base al tempo in qualifica
								$help=$vet[$j];
								$vet[$j]=$vet[$i];
								$vet[$i]=$help;
								# Ordino il vettore dei piloti in base al tempo in qualifica
								$help=$app[$j];
								$app[$j]=$app[$i];
								$app[$i]=$help;
								# Ordino i dati salvati in base al tempo in qualifica
								$help=$arrivo[$j];
								$arrivo[$j]=$arrivo[$i];
								$arrivo[$i]=$help;
								$help=$punti[$j];
								$punti[$j]=$punti[$i];
								$punti[$i]=$help;
							}
							$j++;
						}
					}else{
							$vet[$i]='NULL';
					}
					$i++;
				}
				$i=1;
				$posizione=1;
				while($i<$lung) {
					$rs=mysql_query("select  scuderia 
									from Pilota
									where dipendente=\"".$app[$i]."\";", $connessione);
					$riga=mysql_fetch_array($rs);
					if($vet[$i]!=0) {
						mysql_query("INSERT INTO Gareggia VALUES(\"".$app[$i]."\", \"Piloti\", \"".$riga['scuderia']."\", \"".$gara."\", ".$anno.", ".$posizione.", ".$arrivo[$i].", ".$punti[$i].", ".$vet[$i].");", $connessione);
						$posizione++;
					}
					$i++;
				}
				echo "<div align=center>Inserimento avvenuto correttamente.</div>";
					/*}else{
						$gp=$_SESSION['gp'];
						echo "<h1 align=\"center\">Inserisci qualifiche per il ".$gp."</h1>";
						session_start();
						$username=$_SESSION['username'];
						$rs=mysql_query("select scuderia, reparto
										from Dipendente
										where username=\"".$username."\"", $connessione);
						$riga=mysql_fetch_array($rs);
						mysql_query("INSERT INTO Dipendente VALUES(\"".$usr."\", \"qwerty\", \"".$cog."\", \"".$nome."\", \"".$nasc."\", ".$tel.", \"".$naz."\", \"".$ind."\", ".$stip.", \"".$ass."\", ".$term.", \"".$spec."\", NULL, \"".$riga['reparto']."\", \"".$riga['scuderia']."\");", $connessione);
						echo "<h1 align=\"center\" >Inserisci dipendente</h1>";
						echo "Inserimento avvenuto correttamente.";
					}*/
				
			}else{
				if(isSet($_REQUEST['seleziona'])) { # E' stato selezionato il Gran Premio
				$gp=$_REQUEST['gp'];
				$_SESSION['gp']=$gp;
				$pieces=explode(" - ", $gp);
				$gara=$pieces[0];
				$anno=$pieces[1];
				$rs=mysql_query("select  cognome, nome, username 
							from Pilota join Dipendente on (dipendente=username)
							where username NOT IN (select pilota 
										from Gareggia
										where gp=\"".$gara."\" and anno=".$anno.")
							order by cognome;", $connessione);
							$cont=1;
							$vet[mysql_num_rows($rs)]=NULL;
							if(mysql_num_rows($rs)==0) { # Se non ho piloti da inserire 
								echo "<h1 align=\"center\">Inserisci Qualifiche</h1>";
								echo "Non ci sono piloti da inserire per il ".$gp.".</br></br>
								<form action=\"".$_SERVER['PHP_SELF']."\">";
								$rs=mysql_query("select  anno, nome from GP;", $connessione);
								echo "Indicare il Gran Premio <select name=\"gp\" >";
								while($riga=mysql_fetch_array($rs)) {
									echo "<option>".$riga['nome']." - ".$riga['anno']."</option>";
								}
								echo "</select>";
								echo " <input type=\"submit\" name=\"seleziona\" value=\"Seleziona\"></form>";
							}else{
								echo "<h1 align=\"center\">Inserisci qualifiche per il ".$gara." - ".$anno."</h1>";
								echo "I piloti non indicati hanno gia' un tempo in qualifica per il ".$gara." - ".$anno.".</br></br>";
								echo "<form action=\"".$_SERVER['PHP_SELF']."\">
								<table border=0 cellpadding=\"5\" cellspacing=\"5\">
								<tr><td align=\"center\"><b>Minuti</b></td> <td align=\"center\"><b>Secondi</b></td> <td align=\"center\"><b>Millisecondi</b></td> <td align=\"center\"><b>Pilota</b></td></tr>";
								while($riga=mysql_fetch_array($rs)) {
									$vet[$cont]=$riga['username'];
									echo "<tr><td><input type=\"text\" name=\"min".$cont."\" placeholder=\"2 cifre\" maxlength=\"2\"></td>
									<td><input type=\"text\" name=\"sec".$cont."\" placeholder=\"2 cifre\" maxlength=\"2\"></td>
									<td><input type=\"text\" name=\"mil".$cont."\" placeholder=\"3 cifre\" maxlength=\"3\"></td>
									<td align=center>".$riga['cognome']." ".$riga['nome']."</td></tr>";
									$cont++;
								}
								$_SESSION['vet']=$vet;
							echo "<tr align=\"center\"></tr></table>";
							echo "</br><input type=\"submit\" name=\"inserisci\" value=\"Inserisci\">
								</form>";
						}
				}else{
					echo "<h1 align=\"center\">Inserisci Qualifiche</h1>";
					echo "<form action=\"".$_SERVER['PHP_SELF']."\">";
					$rs=mysql_query("select  anno, nome from GP order by anno;", $connessione);
					echo "Indicare il Gran Premio <select name=\"gp\" >";
					while($riga=mysql_fetch_array($rs)) {
						echo "<option>".$riga['nome']." - ".$riga['anno']."</option>";
					}
					echo "</select>";
					echo " <input type=\"submit\" name=\"seleziona\" value=\"Seleziona\"></form>";
				}
			}
			echo "</div>";
		?>
	</body>

</html>
