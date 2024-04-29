<?php 
require '/var/www/html/includes/functions/functions.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PCS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/base.css">
</head>
<body class="body bg-light">
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index">
                    <img src="assets/logos/darkLogo.png" alt="Logo" height="70">
                </a>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Logements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Prestations</a>
                        </li>
						<?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'voyageur') { ?>
							<li class="nav-item">
								<a class="nav-link" href="#">Prochaine reservations</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Coups de coeur</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Sourscription VIP</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Messagerie</a>
							</li>
						<?php } ?>
						<?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'proprietaire') { ?>
							<li class="nav-item">
								<a class="nav-link" href="#">Mes logements</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Prochaines reservations</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Mes frais</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Mes documents</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Messagerie</a>
							</li>
						<?php } ?>
						<?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'prestataire') { ?>
							<li class="nav-item">
								<a class="nav-link" href="#">Mes prestations</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Historique des prestations</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Factures</a>
							</li>
							<li class="nav-item">
								<a class="nav-link" href="#">Messagerie</a>
							</li>
						<?php } ?>
                    </ul>
                </div>
            </div>
        </nav>

		
        <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
            <div class="justify-content-end">
				<!-- faire en sorte que le burger menu soit tout a droite -->
				<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                	<span class="navbar-toggler-icon"></span>
        		</button>
				<?php if(isset($_SESSION['role'])) { ?>
					<span class="navbar-text">
                    	<a href="login.php" class="btn btn-primary"><img src="assets\img\logout.png" </a>
                	</span>
				<?php } ?>
                <span class="navbar-text">
                    <a href="login.php" class="btn btn-primary"><img src="assets\img\login.png" height="20px"></a>
                </span>
            </div>
        </nav>
    </header>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

