<?php

require '../vendor/autoload.php';
require '../includes/header.php';
Use GuzzleHttp\Client;


$token = $_SESSION["token"];
$grade = $_SESSION["grade"];
try {
    $client = new Client([
        'base_uri' => 'https://pcs-all.online:8000'
    ]);
    $test = [
        'token' => $token,
        'grade' => $grade
    ];
    $response = $client->get('/files', [
        'json' => $test

    ]);

    $body = json_decode($response->getBody()->getContents(), true);
    $files= $body['files'];
    var_dump($body);
} catch (Exception $e) {
    
$files=[];
    echo $e->getMessage();
}


// front qui récupère tous les fichiers de l'utilisateur connecté et les affiches dans une liste avec un lien pour les télécharger 

?>
<link rel="stylesheet" href="../css/files.css">
<center><h1>Mes Documents</h1></center>
<?php if (isset($_SESSION["success"])){
     ?>
    <div class="alert alert-success" role="alert">
        <?php echo $_SESSION["success"]; ?>
        
    </div>
<?php
unset($_SESSION["success"]);
 }
if (isset($_SESSION['error'])){
    ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $_SESSION["error"]; ?>
        
    </div>
<?php

unset($_SESSION["error"]);
}
?>
<div class="file-container">
    <?php foreach ($files as $fileName => $fileContent): ?>
        <div class="file-item">
            <div class="file-name"><?php echo htmlspecialchars($fileName); ?></div>
            <center>
            <a href="download.php?file=<?php echo urlencode($fileName); ?>" class="btn btn-outline-primary">Télécharger <i class="fas fa-download"></i></a>
            <a href="delete.php?file=<?php echo urlencode($fileName); ?>" class="btn btn-outline-danger">Supprimer</a></center>
        </div>
    <?php endforeach; ?>
</div>
