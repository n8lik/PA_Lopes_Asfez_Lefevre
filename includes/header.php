<?php
session_start();

require_once "functions/functions.php";

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PA_Lopes_Asfez_Lefevre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="css/base.css">
</head>
<body class="body bg-light">
    <header class="header">
        <nav class="navbar navbar-expand-lg navbar-dark bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="assets/logos/darkLogo.png" alt="Logo" height="70">
                </a>
				<!-- faire en sorte que le burger menu soit tout a droite -->
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Logements</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Prestations</a>
                        </li>
						<?php
					
						
						if(isConnected()) {
							$conn = connectDB();
							$stmt = $conn->prepare("SELECT role FROM ".DB_PREFIX."user WHERE email = :email");
							$stmt->bindParam(':email', $_SESSION['email'], PDO::PARAM_STR);
							$stmt->execute();
							$row = $stmt->fetch(PDO::FETCH_ASSOC);
							$_SESSION['role'] = $row['role'];
						}
						
						if(isset($_SESSION['role']) && $_SESSION['role'] == '1') { ?>
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
							<li class="nav-item">
								<a class="nav-link" href="logout.php">Déconnexion</a>
							</li>
						<?php } ?>
						<?php if(isset($_SESSION['role']) && $_SESSION['role'] == '4') { ?>
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
							<li class="nav-item">
								<a class="nav-link" href="logout.php">Déconnexion</a>
							</li>
						<?php } ?>
						<?php if(isset($_SESSION['role']) && $_SESSION['role'] == '5') { ?>
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
							<li class="nav-item">
								<a class="nav-link" href="logout.php">Déconnexion</a>
							</li>
						<?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
            <div class="container-fluid justify-content-end">
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

