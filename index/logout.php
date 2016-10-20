<!--
	Tavallini & Franceschini
	Progetto Basi di Dati 2015
-->
<html>
	<head>
		<title>Formula 1</title>
		<link href="style.css" rel="stylesheet" type="text/css"/>
		<link rel="icon" href="Immagini/f1.ico" />
	</head>
	<body style="background-color:#d7dee1">
		<!--Barra nera del menù-->
		<hr align=center size="100" width=100% color="black">
		<div class="logo">
			<a href="index.php" >
				<img src="Immagini/f1_logo.svg" width="228" height="80"/>
			</a>
		</div>
		<!--Menù-->
		<div class="menuPos">
			<div id="menu">
			<!-- Lista generale -->
				<ul>
					<li>
						<a href="#">Operazioni</a>
						<ul>
							<li><a href="classificaPiloti.php">Classifica piloti</a></li>
							<li><a href="classificaCostruttori.php">Classifica costruttori</a></li>
							<li><a href="pole.php">Pilota con piu' pole</a></li>
							<li><a href="produttore.php">Maggior produttore</a></li>
							<li><a href="presenze.php">Pilota con più presenze</a></li>
							<li><a href="produttore.php">Pilota piu' titolato</a></li>
						</ul>
					</li>
					<li><a href="login.php">Login</a></li>
					<li><a href="credits.php">Credits</a></li>
				</ul>
			</div>
		</div>
		<?php
			// Initialize the session.
			// If you are using session_name("something"), don't forget it now!
			session_start();

			// Unset all of the session variables.
			$_SESSION = array();

			// If it's desired to kill the session, also delete the session cookie.
			// Note: This will destroy the session, and not just the session data!
			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}

			// Finally, destroy the session.
			session_destroy();
			echo "<h1 align=\"center\">Logout</h1>";
			echo "<div align=\"center\">Logout avvenuto con successo.</div>";
		?>
	</body>

</html>
