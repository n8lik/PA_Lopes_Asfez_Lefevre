<?php require 'includes/header.php';
?>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h1 class="text-center mb-4">Se connecter</h1>
                <form action="includes/login.inc.php" method="POST">
                    <div class="mb-3">
                        <label for="signin-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="signin-email" name="email" placeholder="Adresse email" required>
                        <?php if (isset($_SESSION['ERRORS']['nouser'])) { ?>
                            <div class="text-danger">
                                <?= $_SESSION['ERRORS']['nouser']; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="signin-password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="signin-password" name="password" placeholder="Mot de passe" required>
                        <?php if (isset($_SESSION['ERRORS']['wrongpassword'])) { ?>
                            <div class="text-danger">
                                <?= $_SESSION['ERRORS']['wrongpassword']; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="RememberPassword">
                        <label class="form-check-label" for="RememberPassword">Se souvenir de moi</label>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary" name="loginsubmit">Connexion</button>
                    </div>
                    <div class="mt-3 text-center">
                        Pas de compte ? <a href="register.php">Inscrivez-vous ici</a>.
                    </div>
                    <div class="mt-2 text-center">
                        <a href="forgot_password.php">Mot de passe oublié?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>




    <?php include 'includes/footer.php'; ?>