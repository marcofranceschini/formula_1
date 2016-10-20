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
			if(isSet($_REQUEST['inserisci'])) {	// Se e' gia' stato premuto inserisci
				$username=$_SESSION['vet'];
				$lung=count($username);				
				$gp=$_SESSION['gp'];
				$pieces=explode(" - ", $gp);
				$gara=$pieces[0];
				$anno=$pieces[1];
				$posizione = NULL;
				$punti = NULL;
				$cont_inserimenti=0;
				echo "<h1 align=\"center\">Inserisci risultati per il ".$gara." - ".$anno."</h1>";
				for($i=1; $i<=$lung; $i++) {
					$posizione = $_REQUEST["pos".$i];
					#echo "ciaooooo".$punti;
					switch($posizione) {
						case 1:
							$punti = 25;
							break;
						case 2:
							$punti = 18;
							break;
						case 3:
							$punti = 15;
							break;
						case 4:
							$punti = 12;
							break;
						case 5:
							$punti = 10;
							break;
						case 6:
							$punti = 8;
							break;
						case 7:
							$punti = 6;
							break;
						case 8:
							$punti = 4;
							break;
						case 9:
							$punti = 2;
							break;
						case 10:
							$punti = 1;
							break;
						default:
							$punti = 0;
					}
					if($posizione != "N/A") {
						mysql_query("UPDATE Gareggia SET pos_fin=".$posizione.", punti=".$punti." WHERE gp=\"".$gara."\" and anno=".$anno." and pilota=\"".$username[$i]."\";", $connessione);
						$cont_inserimenti++;
					}
				}
				echo "</br></br><p>";
				if($cont_inserimenti > 0)
					echo "<div align=center>Inserimento avvenuto correttamente (".$cont_inserimenti." risultati).</div>";
				else
					echo "<div align=center>Non e' stato nessun risultato.</div>";
				echo "</p>";
			}else{
				if(isSet($_REQUEST['seleziona'])) { # E' stato selezionato il Gran Premio
				$gp=$_REQUEST['gp'];
				$_SESSION['gp']=$gp;
				$pieces=explode(" - ", $gp);
				$gara=$pieces[0];
				$anno=$pieces[1];
				$rs=mysql_query("select  cognome, nome, username 
							from Pilota join Dipendente on (dipendente=username)
							where username IN (select pilota 
										from Gareggia
										where gp=\"".$gara."\" and anno=".$anno." and pos_fin IS NULL and punti IS NULL)
							order by cognome;", $connessione);
							$cont=1;
							$vet[mysql_num_rows($rs)]=NULL;
							if(mysql_num_rows($rs)==0) { # Se non ho piloti da inserire 
								echo "<h1 align=\"center\">Inserisci Risultati Gara</h1>";
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
								echo "<h1 align=\"center\">Inserisci risultati per il ".$gara." - ".$anno."</h1>";
								echo "I piloti non indicati hanno gia' una posizione finale per il ".$gara." - ".$anno.".</br></br>";
								echo "<form action=\"".$_SERVER['PHP_SELF']."\">
								<table border=0 cellpadding=\"5\" cellspacing=\"5\">
								<tr><td align=\"center\"><b>Posizione d'arrivo</b></td> <td align=\"center\"><b>Pilota</b></td></tr>";
								$posizioni[21]=0;	#vettore che contiene lo stato delle posizioni (0 libere, 1 gia' usate);
								$query_pos_usate=mysql_query("select pos_fin
												from Gareggia
												where gp=\"".$gara."\" and anno=".$anno." and pos_fin IS NOT NULL;", $connessione);
								if(mysql_num_rows($query_pos_usate)>0) {
									while($riga=mysql_fetch_array($query_pos_usate)) {
										$posizioni[$riga['pos_fin']] = 1;
									}
								}
								while($riga=mysql_fetch_array($rs)) {
									$vet[$cont]=$riga['username'];
									echo "<tr><td>
											<center><select name=\"pos".$cont."\" >
													<option>N/A</option>";
									for( $i=1; $i<21; $i++ ) {
										if($posizioni[$i] != 1) {
											echo "<option>".$i."</option>";
										}
									}
									echo 		"</select></center>
										</td>
									<td align=center>".$riga['cognome']." ".$riga['nome']."</td></tr>";
									$cont++;
								}
								$_SESSION['vet']=$vet;
							echo "</table></br>";
							echo "</br><input type=\"submit\" name=\"inserisci\" value=\"Inserisci\">
								</form>";
						}
				}else{
					echo "<h1 align=\"center\">Inserisci Risultati Gara</h1>";
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
			echo "</div";
		?>
	</body>

</html>
