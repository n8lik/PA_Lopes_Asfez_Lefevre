<?php
require 'includes/header.php';
session_start();


?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h1 class="text-center mb-4">Se connecter</h1>
            <form action="includes/login" method="POST">
                <div class="mb-3">
                    <?php
                    // Si une erreur existe, on l'affiche 
                    if (isset($_SESSION['ERRORS']['nouser'])) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['ERRORS']['nouser']; ?>
                        </div>
                    <?php
                        unset($_SESSION['ERRORS']['nouser']);
                    }

                    if (isset($_SESSION['ERRORS']['emptyfields'])) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['ERRORS']['emptyfields']; ?>
                        </div>
                    <?php
                        unset($_SESSION['ERRORS']['emptyfields']);
                    }
                    if (isset($_SESSION['ERRORS']['captcha'])) {
                    ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $_SESSION['ERRORS']['captcha']; ?>
                        </div>
                    <?php
                        unset($_SESSION['ERRORS']['captcha']);
                    }
                    ?>
                    <label for="signin-email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="signin-email" name="email" placeholder="Adresse email" required>

                </div>
                <div class="mb-3 position-relative">
                    <label for="signin-password" class="form-label">Mot de passe</label>
                    <input type="password" class="form-control" id="signin-password" name="password" placeholder="Mot de passe" required>
                    <i class="toggle-password bi bi-eye-slash position-absolute" style="top: 38px; right: 10px; cursor: pointer;"></i> 
                </div>
                <center>
                    <div class="g-recaptcha" data-sitekey="6Ldj_NopAAAAAPFMUGV9t6pDP3nJnqh-VuqpkTwg"></div>
                </center>

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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePassword = document.querySelector('.toggle-password');
        const passwordField = document.querySelector('#signin-password');

        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = passwordField.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordField.setAttribute('type', type);
            
            // Toggle the icon
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    });
</script>

<?php include 'includes/footer.php'; ?>