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
		<div align=center>
				<?php
					echo "<hr align=center size=\"100\" width=100% color=\"black\">
								<div class=\"logo\">
									<a href=\"index.php\" >
										<img src=\"Immagini/f1_logo.svg\" width=\"228\" height=\"80\"/>
									</a>
								</div>";
					session_start();
					if(!empty($_SESSION)) {
						$_REQUEST['accedi']="Accedi";
					}
					if(isSet($_REQUEST['accedi'])) {	// Se premuto pulsante per accedere
						if(!empty($_SESSION)) {
							$user=$_SESSION['username'];
							$pasw=$_SESSION['password'];
						}else{
							$user=$_REQUEST['user'];
							$pasw=$_REQUEST['pasw'];
						}
						if($user!="admin" and $pasw!="admin") {
							$rs=mysql_query("select * 
										from Dipendente 
										where username=\"".$user."\" and password=\"".$pasw."\";", $connessione);
							if(mysql_num_rows($rs)==1) {
								$rs=mysql_fetch_array($rs);
								$_SESSION['username']=$user;
								$_SESSION['password']=$pasw;
								if(!empty($rs['titolo_studio'])) {	# E' un direttore
									$_SESSION['ruolo']=0;
									echo "<h1 align=\"center\">Profilo</h1>";
									echo "<div class=\"menuPos\">
											<div id=\"menu\">
												<ul>
													<li>
														<a href=\"#\">Operazioni</a>
														<ul>
															<li><a href=\"classificaPiloti.php\">Classifica piloti</a></li>
															<li><a href=\"classificaCostruttori.php\">Classifica costruttori</a></li>
															<li><a href=\"pole.php\">Pilota con piu' pole</a></li>
															<li><a href=\"produttore.php\">Maggior produttore</a></li>
															<li><a href=\"presenze.php\">Pilota con più presenze</a></li>
															<li><a href=\"produttore.php\">Pilota piu' titolato</a></li>
														</ul>
													</li>
													<li>
													<a href=\"#\">Visualizza</a>
															<ul>
																<li><a href=\"visDir.php\">Direttori</a></li>
																<li><a href=\"visDip.php\">Dipendenti</a></li>
																<li><a href=\"visPil.php\">Piloti</a></li>
															</ul>
													</li>
													<li>
													<a href=\"#\">Inserisci</a>
															<ul>
																<li><a href=\"insDip.php\">Dipendente</a></li>
															</ul>
													</li>
													<li>
													<a href=\"#\">Modifica</a>
															<ul>
																<li><a href=\"modDip.php\">Dipendente</a></li>
															</ul>
													</li>
													<li>
														<a href=\"#\">Profilo</a>
														<ul>
															<li><a href=\"login.php\">Visualizza</a></li>
															<li><a href=\"logout.php\">Logout</a></li>
														</ul>
													</li>
													<li><a href=\"credits.php\">Credits</a></li>
												</ul>
											</div>
										</div>";
										$immagine="Immagini/direttore.jpg";
										echo "<table border=0 cellpadding=\"5\" cellspacing=\"15\">";
										echo "<td align=\"center\"><img src=\"".$immagine."\" width=\"300\" height=\"200\"/></td>";
										echo "<b>Cognome </b><tr align=right>".$rs['cognome']."</tr></br></br>";
										echo "<b>Nome </b><tr align=right>".$rs['nome']."</tr></br></br>";
										echo "<b>Username </b><tr align=right>".$rs['username']."</tr></br></br>";
										echo "<b>Data di nascita </b><tr align=right>".$rs['data_nascita']."</tr></br></br>";
										echo "<b>Telefono </b><tr align=right>".$rs['telefono']."</tr></br></br>";
										echo "<b>Nazionalità </b><tr align=right>".$rs['nazionalita']."</tr></br></br>";
										echo "<b>Indirizzo </b><tr align=right>".$rs['indirizzo']."</tr></br></br>";
										echo "<b>Stipendio </b><tr align=right>".$rs['stipendio']."</tr></br></br>";
										echo "<b>Data di assunzione </b><tr align=right>".$rs['data_assunzione']."</tr></br></br>";
										if(empty($rs['data_termine'])) {
											#echo "<b>Fine contratto </b><tr align=right>NULL</tr></br></br>";
										}else{
											echo "<b>Fine contratto </b><tr align=right>".$rs['data_termine']."</tr></br></br>";
										}
										echo "<b>Titolo di studio </b><tr align=right>".$rs['titolo_studio']."</tr></br></br>";
										echo "<b>Scuderia </b><tr align=right>".$rs['scuderia']."</tr></br></br>";
										echo "<b>Reparto </b><tr align=right>".$rs['reparto']."</tr></br></br>";
										echo "<b>Ruolo </b><tr align=right>Direttore</tr></br></br>";
										echo "</table>";
								}else{
									if(!empty($rs['specializzazione'])) {	# E' un dipendente
										$_SESSION['ruolo']=1;
										/*echo "<hr align=center size=\"100\" width=100% color=\"black\">
											<div class=\"logo\">
												<a href=\"home.php\">
													<img src=\"Immagini/f1_logo.svg\" width=\"228\" height=\"80\"/>
												</a>
											</div>";*/
										echo "<h1 align=\"center\">Profilo</h1>";
										echo "<div class=\"menuPos\">
											<div id=\"menu\">
												<ul>
													<li>
														<a href=\"#\">Operazioni</a>
														<ul>
															<li><a href=\"classificaPiloti.php\">Classifica piloti</a></li>
															<li><a href=\"classificaCostruttori.php\">Classifica costruttori</a></li>
															<li><a href=\"pole.php\">Pilota con piu' pole</a></li>
															<li><a href=\"produttore.php\">Maggior produttore</a></li>
															<li><a href=\"presenze.php\">Pilota con piu' presenze</a></li>
															<li><a href=\"campione.php\">Pilota piu' titolato</a></li>
														</ul>
													</li>
													<li>
														<a href=\"#\">Visualizza</a>
														<ul>
															<li><a href=\"visDir.php\">Direttori</a></li>
															<li><a href=\"visDip.php\">Dipendenti</a></li>
															<li><a href=\"visPil.php\">Piloti</a></li>
														</ul>
													</li>
													<li>
														<a href=\"#\">Profilo</a>
														<ul>
															<li><a href=\"login.php\">Visualizza</a></li>
															<li><a href=\"logout.php\">Logout</a></li>
														</ul>
													</li>
													<li><a href=\"credits.php\">Credits</a></li>
												</ul>
											</div>
										</div>";
										$immagine="Immagini/meccanico.png";
										echo "<table border=0 cellpadding=\"5\" cellspacing=\"15\">";
										echo "<td align=\"center\"><img src=\"".$immagine."\" width=\"200\" height=\"250\"/></td>";
										echo "<b>Cognome </b><tr align=right>".$rs['cognome']."</tr></br></br>";
										echo "<b>Nome </b><tr align=right>".$rs['nome']."</tr></br></br>";
										echo "<b>Username </b><tr align=right>".$rs['username']."</tr></br></br>";
										echo "<b>Data di nascita </b><tr align=right>".$rs['data_nascita']."</tr></br></br>";
										echo "<b>Telefono </b><tr align=right>".$rs['telefono']."</tr></br></br>";
										echo "<b>Nazionalità </b><tr align=right>".$rs['nazionalita']."</tr></br></br>";
										echo "<b>Indirizzo </b><tr align=right>".$rs['indirizzo']."</tr></br></br>";
										echo "<b>Stipendio </b><tr align=right>".$rs['stipendio']."</tr></br></br>";
										echo "<b>Data di assunzione </b><tr align=right>".$rs['data_assunzione']."</tr></br></br>";
										if(empty($rs['data_termine'])) {
											#echo "<b>Fine contratto </b><tr align=right>NULL</tr></br></br>";
										}else{
											echo "<b>Fine contratto </b><tr align=right>".$rs['data_termine']."</tr></br></br>";
										}
										echo "<b>Specializzazione </b><tr align=right>".$rs['specializzazione']."</tr></br></br>";
										echo "<b>Scuderia </b><tr align=right>".$rs['scuderia']."</tr></br></br>";
										echo "<b>Reparto </b><tr align=right>".$rs['reparto']."</tr></br></br>";
										echo "<b>Ruolo </b><tr align=right>Meccanico</tr></br></br>";
										echo "</table>";
										}else{	# E' un pilota
											
											$_SESSION['ruolo']=2;
											$ps=mysql_query("select * 
													from Pilota 
													where dipendente=\"".$user."\";", $connessione);
											$sr=mysql_fetch_array($ps);
											echo "<h1 align=\"center\">Profilo</h1>";
											echo "<div class=\"menuPos\">
												<div id=\"menu\">
												<ul>
													<li>
														<a href=\"#\">Operazioni</a>
														<ul>
															<li><a href=\"classificaPiloti.php\">Classifica piloti</a></li>
															<li><a href=\"classificaCostruttori.php\">Classifica costruttori</a></li>
															<li><a href=\"pole.php\">Pilota con piu' pole</a></li>
															<li><a href=\"produttore.php\">Maggior produttore</a></li>
															<li><a href=\"presenze.php\">Pilota con piu' presenze</a></li>
															<li><a href=\"campione.php\">Pilota piu' titolato</a></li>
														</ul>
													</li>
													<li>
														<a href=\"#\">Visualizza</a>
														<ul>
															<li><a href=\"visDir.php\">Direttori</a></li>
															<li><a href=\"visDip.php\">Dipendenti</a></li>
															<li><a href=\"visPil.php\">Piloti</a></li>
														</ul>
													</li>
													<li>
														<a href=\"#\">Profilo</a>
														<ul>
															<li><a href=\"login.php\">Visualizza</a></li>
															<li><a href=\"logout.php\">Logout</a></li>
														</ul>
													</li>
													<li><a href=\"credits.php\">Credits</a></li>
												</ul>
												</div>
											</div>";
											$immagine="Immagini/".$rs['cognome'].".jpg";
											echo "<table border=0 cellpadding=\"5\" cellspacing=\"15\">";
											echo "<td align=\"center\"><img src=\"".$immagine."\" width=\"230\" height=\"210\"/></td>";
											echo "<b>Cognome </b><tr align=right>".$rs['cognome']."</tr></br></br>";
											echo "<b>Nome </b><tr align=right>".$rs['nome']."</tr></br></br>";
											echo "<b>Username </b><tr align=right>".$rs['username']."</tr></br></br>";
											echo "<b>Data di nascita </b><tr align=right>".$rs['data_nascita']."</tr></br></br>";
											echo "<b>Telefono </b><tr align=right>".$rs['telefono']."</tr></br></br>";
											echo "<b>Nazionalità </b><tr align=right>".$rs['nazionalita']."</tr></br></br>";
											echo "<b>Indirizzo </b><tr align=right>".$rs['indirizzo']."</tr></br></br>";
											echo "<b>Stipendio </b><tr align=right>".$rs['stipendio']."</tr></br></br>";
											echo "<b>Data di assunzione </b><tr align=right>".$rs['data_assunzione']."</tr></br></br>";
											if(empty($rs['data_termine'])) {
												#echo "<b>Fine contratto </b><tr align=right>NULL</tr></br></br>";
											}else{
												echo "<b>Fine contratto </b><tr align=right>".$rs['data_termine']."</tr></br></br>";
											}
											echo "<b>Anni carriera </b><tr align=right>".$sr['anni_carriera']."</tr></br></br>";
											echo "<b>Stipendio sponsor </b><tr align=right>".$sr['stipendio_sponsor']."</tr></br></br>";
											echo "<b>Scuderia </b><tr align=right>".$rs['scuderia']."</tr></br></br>";
											echo "<b>Reparto </b><tr align=right>".$rs['reparto']."</tr></br></br>";
											echo "<b>Ruolo </b><tr align=right>Pilota</tr></br></br>";
											echo "</table>";
									}
								}
							}else{ # Dati inseriti non corretti
								echo "<h1 align=\"center\">Login</h1>";
								echo "<div class=\"menuPos\">
									<div id=\"menu\">
										<ul>
											<li>
												<a href=\"#\">Operazioni</a>
													<ul>
														<li><a href=\"classificaPiloti.php\">Classifica piloti</a></li>
														<li><a href=\"classificaCostruttori.php\">Classifica costruttori</a></li>
														<li><a href=\"pole.php\">Pilota con piu' pole</a></li>
														<li><a href=\"produttore.php\">Maggior produttore</a></li>
														<li><a href=\"presenze.php\">Pilota con piu' presenze</a></li>
														<li><a href=\"campione.php\">Pilota piu' titolato</a></li>
													</ul>
												</li>
												<li><a href=\"login.php\">Login</a></li>
												<li><a href=\"credits.php\">Credits</a></li>
											</ul>
										</div>
									</div>";
								echo "<form action=\"".$_SERVER['PHP_SELF']."\">
								<table border=0 cellpadding=\"5\" cellspacing=\"5\">
								<tr align=\"center\">Username</tr> <td><input type=\"text\" name=\"user\"></td></table></br>";
								echo "<table border=0 cellpadding=\"5\" cellspacing=\"5\">
								<tr align=\"center\">Password</tr> <td><input type=\"password\" name=\"pasw\"</td></table>";
								echo "Dati non corretti";
								echo "</br><input type=\"submit\" name=\"accedi\" value=\"Accedi\">
								</form>";
							}
						}else{	// E' amministratore del sistema
							$_SESSION['username']=$user;
							$_SESSION['password']=$pasw;
							$_SESSION['ruolo']=3;
							
							echo "<div class=\"menuPos\">
										<div id=\"menu\">
											<ul>
												<li>
													<a href=\"#\">Operazioni</a>
													<ul>
														<li><a href=\"classificaPiloti.php\">Classifica piloti</a></li>
														<li><a href=\"classificaCostruttori.php\">Classifica costruttori</a></li>
														<li><a href=\"pole.php\">Pilota con piu' pole</a></li>
														<li><a href=\"produttore.php\">Maggior produttore</a></li>
														<li><a href=\"presenze.php\">Pilota con più presenze</a></li>
														<li><a href=\"campione.php\">Pilota piu' titolato</a></li>
													</ul>
												</li>
												<li>
												<a href=\"#\">Inserisci</a>
														<ul>
															<li><a href=\"insPole.php\">Qualifiche</a></li>
															<li><a href=\"insRis.php\">Risulato gara</a></li>
														</ul>
												</li>
												<li>
												<li>
													<a href=\"#\">Profilo</a>
													<ul>
														<li><a href=\"login.php\">Visualizza</a></li>
														<li><a href=\"logout.php\">Logout</a></li>
													</ul>
												</li>
												<li><a href=\"credits.php\">Credits</a></li>
											</ul>
										</div>
									</div>";
									echo "<h1 align=\"center\">Profilo</h1>";
									echo "<font>Benvenuto amministratore.</font>";
						}
					}else{	// Non si e' fatto login
						echo "<h1 align=\"center\">Login</h1>";
						echo "<div class=\"menuPos\">
								<div id=\"menu\">
									<ul>
										<li>
											<a href=\"#\">Operazioni</a>
												<ul>
													<li><a href=\"classificaPiloti.php\">Classifica piloti</a></li>
													<li><a href=\"classificaCostruttori.php\">Classifica costruttori</a></li>
													<li><a href=\"pole.php\">Pilota con piu' pole</a></li>
													<li><a href=\"produttore.php\">Maggior produttore</a></li>
													<li><a href=\"presenze.php\">Pilota con piu' presenze</a></li>
													<li><a href=\"campione.php\">Pilota piu' titolato</a></li>
												</ul>
											</li>
											<li><a href=\"login.php\">Login</a></li>
											<li><a href=\"credits.php\">Credits</a></li>
										</ul>
									</div>
								</div>";
						echo "<form action=\"".$_SERVER['PHP_SELF']."\">
							<table border=0 cellpadding=\"5\" cellspacing=\"5\">
							<tr align=\"center\">Username</tr> <td><input type=\"text\" name=\"user\"></td></table></br>";
						echo "<table border=0 cellpadding=\"5\" cellspacing=\"5\">
							<tr align=\"center\">Password</tr> <td><input type=\"password\" name=\"pasw\"</td></table>";
						echo "</br><input type=\"submit\" name=\"accedi\" value=\"Accedi\">
							</form>";
					}
				?>
		</div>
	</body>

</html>
