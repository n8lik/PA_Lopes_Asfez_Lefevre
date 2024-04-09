<!DOCTYPE html>
<html>
<head>
	<title>PA_Lopes_Asfez_Lefevre</title>
	<link rel="stylesheet" type="text/css" href="css\base.css">
</head>
	<header class="header">
		<img src="assets/logos/darkLogo.png" alt="logo" width="10%">
	
		<form action="search.php" method="post" class="header-search-bar">
			<input type="text" name="destination" placeholder="Destination" >
			<p class="header-search-bar-text">Du</p>
			<input type="date" name="arrival_date" placeholder="Date d'arrivée">
			<p class="header-search-bar-text">Au</p>
			<input type="date" name="departure_date" placeholder="Date de départ">
			<input type="number" name="travelers" placeholder="Voyageurs" min="1" style="width :20% !important;">
			<button type="submit" name="submit-search"><img src="assets/img/search.png"alt="rechercher" width="30%"></button>
		</form>

		<div class="header-right">
			<?php
				if (isset($_SESSION['user_id'])) {
					echo 'photo de profil';

				} else {
					echo '<form action="login.php" method="post" class="header-login">
							<button type="submit" name="submit-login">Se connecter</button>
						</form>';
				}
			?>
			<div class="burger-menu">
				<div class="line"></div>
				<div class="line"></div>
				<div class="line"></div>
			</div>
		</div>


	</header>

<body class="body">
