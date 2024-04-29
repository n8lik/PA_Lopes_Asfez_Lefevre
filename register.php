<?php include 'includes/header.php'; ?>
<style>
    .button-container {
        text-align: center;
        /* Centre les boutons horizontalement */
        display: flex;
        justify-content: center;
        /* Assure que les boutons sont centrés dans le conteneur */
        align-items: center;
        /* Alignement vertical */
    }

    .form-button {
        font-size: 1.2em;
        padding: 1px 10px;
        /* Ajusté pour un meilleur aspect visuel */
        margin: 0 10px;
        /* Espace entre les boutons */
        flex: 0 0 auto;
        /* Empêche les boutons de s'étirer ou de se comprimer */
        width: 150px;
        /* Assure que tous les boutons ont la même largeur */
    }

    .form-button:focus {
        background-color: #4CAF50;
        color: white;
    }
</style>

<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h2 class="card-title text-center mb-4">Créer un compte</h2>
                        <!-- Boutons pour sélectionner le type de formulaire -->
                        <div class="text-center mb-4 button-container">
                            <button onclick="showForm('client')" class="btn btn-secondary form-button">Client</button>
                            <button onclick="showForm('presta')" class="btn btn-secondary form-button">Prestataire</button>
                            <button onclick="showForm('Propriétaire')" class="btn btn-secondary form-button">Propriétaire</button>
                        </div>
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

                        <!-- Formulaire Prestataire -->
                        <form id="form-presta" action="includes/user_add.php" method="POST" class="needs-validation d-none" novalidate>


                            <input type="hidden" name="role" value="5">
                            <input type="hidden" value="add" name="action">
                            <h3 class="card-title text-center mb-4">Prestataire</h3>
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
                            <div class="text-center mt-3">
                                <a href="forgot_password.php" class="text-decoration-none">Mot de passe oublié?</a><br>
                                <a href="login.php" class="text-decoration-none">Vous avez déjà un compte ? Connectez-vous !</a>
                            </div>
                        </form>

                        <!-- Formulaire Client -->
                        <form id="form-client" action="includes/user_add.php" method="POST" class="needs-validation d-none" novalidate>



                            <input type="hidden" value="add" name="action">
                            <input type="hidden" name="role" value="1">
                            <h3 class="card-title text-center mb-4">Client</h3>

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
                            <div class="text-center mt-3">
                                <a href="forgot_password.php" class="text-decoration-none">Mot de passe oublié?</a><br>
                                <a href="login.php" class="text-decoration-none">Vous avez déjà un compte ? Connectez-vous !</a>
                            </div>
                        </form>

                        <!-- Formulaire Propriétaire -->
                        <form id="form-Propriétaire" action="includes/user_add.php" method="POST" class="needs-validation d-none" novalidate>


                            <input type="hidden" value="add" name="action">
                            <input type="hidden" name="role" value="4">
                            <h3 class="card-title text-center mb-4">Propriétaire</h3>

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
                            <div class="text-center mt-3">
                                <a href="forgot_password.php" class="text-decoration-none">Mot de passe oublié?</a><br>
                                <a href="login.php" class="text-decoration-none">Vous avez déjà un compte ? Connectez-vous !</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <?php include 'includes/footer.php'; ?>
    </footer>
    <script>
        function showForm(formType) {
            // Masquer tous les formulaires
            document.getElementById('form-presta').classList.add('d-none');
            document.getElementById('form-client').classList.add('d-none');
            document.getElementById('form-Propriétaire').classList.add('d-none');

            // Afficher le formulaire sélectionné
            document.getElementById('form-' + formType).classList.remove('d-none');
        }
    </script>
</body>

</html>