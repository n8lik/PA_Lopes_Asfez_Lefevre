<?php require 'includes/header.php'; ?>
<link rel="stylesheet" href="css/register.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Créer un compte</h2>
                    <?php if (isset($_SESSION['listOfErrors'])) : ?>
                        <div class="alert alert-danger" role="alert">
                            <ul>
                                <?php foreach ($_SESSION['listOfErrors'] as $error) : ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                                <?php unset($_SESSION['listOfErrors']); ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="includes/user_add" method="POST" class="needs-validation">
                        <input type="hidden" value="add" name="action">

                        <div class="card mb-4">
                            <div class="card-header">Rôle</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="grade" class="form-label">Je suis :</label>
                                    <select class="form-control" id="grade" name="grade" required>
                                        <option value="">Sélectionnez votre rôle</option>
                                        <option value="1">Client</option>
                                        <option value="5">Prestataire</option>
                                        <option value="4">Propriétaire</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">Identité</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="username" class="form-label">Pseudonyme</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Votre pseudonyme" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Votre email" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="firstname" class="form-label">Prénom</label>
                                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Votre prénom" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="lastname" class="form-label">Nom</label>
                                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Votre nom" required>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">Informations de Contact</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="extension" class="form-label">Extension</label>
                                        <select class="form-control" id="extension1" name="extension">
                                            <option value="+33">+33 France</option>
                                            <option value="+1">+1 USA/Canada</option>
                                            <option value="+44">+44 Royaume-Uni</option>
                                            <option value="+49">+49 Allemagne</option>
                                            <option value="+39">+39 Italie</option>
                                            <option value="+91">+91 Inde</option>
                                        </select>
                                    </div>
                                    <div class="col-md-9 mb-3">
                                        <label for="phone_number" class="form-label">Téléphone</label>
                                        <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="Votre numéro de téléphone" required>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">Adresse</div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="address" class="form-label">Adresse</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Votre adresse">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="postal_code" the="form-label">Code Postal</label>
                                        <input type="text" class="form-control" id="postal_code" name="postal_code" placeholder="Votre code postal">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="city" class="form-label">Ville</label>
                                        <input type="text" class="form-control" id="city" name="city" placeholder="Votre ville">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="country" class="form-label">Pays</label>
                                        <select class="form-control" id="country" name="country" required>
                                            <option value="">Sélectionnez votre pays</option>
                                            <option value="FR">France</option>
                                            <option value="US">États-Unis</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-3">
                            <div class="card-header">Sécurité</div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="password" the="form-label">Mot de passe</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Mot de passe" required>
                                </div>
                                <div class="mb-3">
                                    <label for="passwordConfirm" the="form-label">Confirmez le mot de passe</label>
                                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" placeholder="Confirmez le mot de passe" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="consentCheckbox2" name="consent" value="1" required>
                            <label class="form-check-label" for="consentCheckbox">Je consens à la <a href="politique.php" target="_blank">politique d'utilisation des données</a> de Paris CareTaker Services</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100" name="submit">S'inscrire</button>
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

<?php include 'includes/footer.php'; ?>