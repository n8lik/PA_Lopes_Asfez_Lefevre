<?php require 'includes/header.php'; ?>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Créer un compte</h2>
                        <?php if (isset($_SESSION['listOfErrors'])) { ?>
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    <?php foreach ($_SESSION['listOfErrors'] as $error) {
                                        echo "<li>" . $error . "</li>";
                                    }
                                    unset($_SESSION['listOfErrors']); ?>
                                </ul>
                            </div>
                        <?php } ?>
                        <form action="includes/user_add.php" method="POST"  class="needs-validation" novalidate>
                            <input type="hidden" value="add" name="action">
                            <div class="mb-3">
                                <label for="firstname" class="form-label">Votre prénom</label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Votre prénom" required value="<?= (!empty($_SESSION["data"])) ? $_SESSION["data"]["firstname"] : ""; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="lastname" class="form-label">Votre nom</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Votre nom" required value="<?= (!empty($_SESSION["data"])) ? $_SESSION["data"]["lastname"] : ""; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Votre email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Votre email" required value="<?= (!empty($_SESSION["data"])) ? $_SESSION["data"]["email"] : ""; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="phone_mobile" class="form-label">Votre numéro de téléphone</label>
                                <input type="tel" class="form-control" id="phone_mobile" name="phone_mobile" placeholder="Votre numéro de téléphone" required value="<?= (!empty($_SESSION["data"])) ? $_SESSION["data"]["phone_mobile"] : ""; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="pwd" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Mot de passe">
                            </div>
                            <div class="mb-3">
                                <label for="pwdConfirm" class="form-label">Confirmez le mot de passe</label>
                                <input type="password" class="form-control" id="pwdConfirm" name="pwdConfirm" placeholder="Confirmez le mot de passe">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="consentCheckbox" name="consent" value="1" required>
                                <label class="form-check-label" for="consentCheckbox">Je consens à la <a href="politique.php" target="_blank">politique d'utilisation des données</a> de Paris CareTaker Services</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="forgot_password.php" class="text-decoration-none">Mot de passe oublié?</a><br>
                            <a href="index.php" class="text-decoration-none">Vous avez déjà un compte ? Connectez-vous !</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
        <?php include 'includes/footer.php'; ?>
