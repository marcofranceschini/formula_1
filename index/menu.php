<!--
	Tavallini & Franceschini
	Progetto Basi di Dati 2015
-->

<?php
	session_start();
	echo "<hr align=\"center\" size=\"100\" width=\"100%\" color=\"black\">
					<div class=\"logo\">
						<a href=\"index.php\" >
							<img src=\"Immagini/f1_logo.svg\" width=\"228\" height=\"80\"/>
						</a>
					</div>";
			if(!empty($_SESSION['username'])) {
				if($_SESSION['ruolo']==0) { # Loggato come direttore
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
												<a href=\"op\">Inserisci</a>
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
				}else{ # Loggato come dipendente/pilota
					if($_SESSION['ruolo']==1 or $_SESSION['ruolo']==2) {
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
					}else{ #Amministrato di sistema
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
															<li><a href=\"insRis.php\">Risultati gara</a></li>
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
					}
				}
			}else{ #Ospite
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
			}
?>
