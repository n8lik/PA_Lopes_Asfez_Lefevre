<?php
require "../includes/header.php";
$id = $_GET["id"];
$userId = $_SESSION['userId'];
$user = getUserById($userId);
$performance = getPerformanceById($id);

if (!isConnected()) {
    header('Location: ../login.php');
}
if ($user['grade'] != 5) {
    header('Location: /');
}

if ($performance['id_user'] != $userId) {
    header("Location: logements/houses.php");
}
?>

<div class="container border-form mt-5">
    <form method="post" action="../bailleurs/logements/action?= $id ?>&usertype=provider" enctype="multipart/form-data">


        <?php if (!empty($_SESSION['errorFile'])) {

            echo $_SESSION['errorFile'];
        }
        $_SESSION['errorFile'] = ''; ?>
        <div class="alert alert-primary" role="alert">
            Veuillez ajouter votre document d'identité et une preuve de votre activité de prestataire
        </div>
        <div>
            <div class="form-group">
                <label for="type">Type de document</label>
                <select class="form-select" id="type" name="type">
                    <option value="1">Document d'identité</option>
                    <option value="2">Licence d'activité</option>
                    <option value="3">Carte professionnelle</option>
                    <option value="4">Facture</option>

                </select>
            </div>
            <div>
                <label for="image">Ajoute tes documents</label><br>
                <input type="file" id="file" name="file"><br><br>
            </div>
            <input type="submit" value="Publier" name="submit">


        </div>
    </form>
</div>

<?php
require "../includes/footer.php";
?>