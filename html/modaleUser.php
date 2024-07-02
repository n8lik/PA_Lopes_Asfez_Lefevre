<?php
require 'vendor/autoload.php';
use GuzzleHttp\Client;

$id_user = $_GET['id_user'] ?? null;

if (!$id_user) {
    die('ID utilisateur manquant.');
}

try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $response = $client->get('/users/' . $id_user);
    $body = json_decode($response->getBody()->getContents(), true);
    $user = $body['users'];
} catch (Exception $e) {
    echo 'Erreur: ' . $e->getMessage();
    die();
}
?>

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel"><?php echo htmlspecialchars($user['pseudo'], ENT_QUOTES, 'UTF-8'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-4 text-center">
                        <div class="profile-image">
                            <img src="https://via.placeholder.com/100" class="rounded-circle" alt="User Image">
                        </div>
                        <h6><?php echo htmlspecialchars($user['pseudo'], ENT_QUOTES, 'UTF-8'); ?></h6>
                        <p>Suivi par <?php echo $user['followers']; ?> membres.</p>
                    </div>
                    <div class="col-md-8">
                        <ul class="list-unstyled">
                            <li>📄 Pièce d'identité vérifiée</li>
                            <li>📞 Numéro de téléphone vérifié</li>
                            <li>📅 Membre depuis avril 2014</li>
                            <li>📍 Allier</li>
                        </ul>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <h6>2 annonces</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Annonce 1">
                                    <div class="card-body">
                                        <h5 class="card-title">Titre Annonce 1</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <img src="https://via.placeholder.com/150" class="card-img-top" alt="Annonce 2">
                                    <div class="card-body">
                                        <h5 class="card-title">Titre Annonce 2</h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
