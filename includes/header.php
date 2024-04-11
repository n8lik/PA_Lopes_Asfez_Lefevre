<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PA_Lopes_Asfez_Lefevre</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/base.css">
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
