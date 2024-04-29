<?php
require "/var/www/html/includes/conf.inc.php";
session_start(); // Démarrer la session au début


//Connection a la DB
function connectDB()
{
    try {
        $connection = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT, DB_USER, DB_PWD);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    } catch (Exception $e) {
        echo "Erreur SQL " . $e->getMessage();
        exit;
    }
}



//#########################################Users #########################################
function nbUserByGrade($grade){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM user WHERE grade = ?");
    $req->execute([$grade]);
    // Récupérer le nombre d'utilisateurs ayant le grade passé en paramètre
    $count = $req->fetchColumn();
    return $count;
}

//afficher la liste des utilisateurs selon le grade
function getUsersByGrade($grade){
    $db = connectDB();
    if ($grade == "users"){
        $req = $db->prepare("SELECT * FROM user WHERE grade = 1 OR grade = 2 OR grade = 3");
        $req->execute();
        return $req->fetchAll();
    } else {
        $req = $db->prepare("SELECT * FROM user WHERE grade = ?");
        $req->execute([$grade]);
        return $req->fetchAll();
    }
}

function getUserById($id){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE id = ?");
    $req->execute([$id]);
    return $req->fetch();
}

//afficher le nombre total d'utilisateurs
function totalNbUsers(){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM user");
    $req->execute();
    return $req->fetchColumn();
}

//afficher la liste de tous les utilisateurs
function getAllUsers(){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user");
    $req->execute();
    return $req->fetchAll();
}

//Supprimer un utilisateur (is_deleted=1)
function deleteUser($id){
    $db = connectDB();
    $req = $db->prepare("UPDATE user SET is_deleted = 1 WHERE id = ?");
    $req->execute([$id]);
}
//Afficher le nombre de nouveaux utilisateurs selon le mois (1,2,3,4,5,6,7,8,9,10,11,12)
function getNewUsersByMonth($month){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM user WHERE MONTH(creation_date) = ?");
    $req->execute([$month]);
    return $req->fetchColumn();
}

function getGrade($grade){
    switch ($grade){
        case 1:
            return "Voyageur";
        case 2:
            return "Voyageur VIP1";
        case 3:
            return "Voyageur VIP2";
        case 4:
            return "Bailleurs";
        case 5:
            return "Prestataires";
        case 6:
            return "Administrateur";
    }
}

//Fonction pour savoir si un utilisateur est validé ou non, ou pire: supprimé
function getUserStatus($id){
    $db = connectDB();
    //On verifie si l'user est supprimé
    $req = $db->prepare("SELECT is_deleted FROM user WHERE id = ?");
    $req->execute([$id]);
    $is_deleted = $req->fetchColumn();
    if ($is_deleted == 1){
        return "Supprimé";
    }
    //On verifie si l'user est validé
    $req = $db->prepare("SELECT is_validated FROM user WHERE id = ?");
    $req->execute([$id]);
    $is_validated = $req->fetchColumn();
    if ($is_validated == 1){
        return "Validé";
    }
    return "En attente de validation";
}

//Update un user
function updateUser($id, $pseudo, $firstname, $lastname, $email, $grade){
    $db = connectDB();
    $req = $db->prepare("UPDATE user SET pseudo = ?, firstname = ?, lastname = ?, email = ?, grade = ? WHERE id = ?");
    $req->execute([$pseudo, $firstname, $lastname, $email, $grade, $id]);
}

//Insérer un nouvel administrateur$_POST['pseudo'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['pwd'], $_POST['pwdConfirm'], $_POST['grade']
function addNewAdmin($pseudo, $firstname, $lastname, $email, $password, $passwordConfirm){
    if ($password != $passwordConfirm){
        return "Les mots de passe ne correspondent pas";
    }
    $db = connectDB();
    $req = $db->prepare("INSERT INTO user (pseudo, firstname, lastname, email, password, grade, is_validated) VALUES (?, ?, ?, ?, ?, 6, 1)");
    $req->execute([$pseudo, $firstname, $lastname, $email, $password]);
}

//#########################################Pending #########################################
//Afficher la liste des utilisateur en attente de validation selon le grade passé en paramètre
function getPendingUsersByGrade($grade){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE grade = ? AND is_validated = 0");
    $req->execute([$grade]);
    return $req->fetchAll();
}

//Afficher la liste des utilisateur en attente de validation
function getAllPendingUsers(){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM user WHERE is_validated = 0");
    $req->execute();
    return $req->fetchAll();
}
function nbAllPendingUsers(){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM user WHERE is_validated = 0");
    $req->execute();
    return $req->fetchColumn();
}

//Afficher la liste des annonces en attente de validation
function getAllPendingAds(){
    $db = connectDB();
    $req = $db->prepare("SELECT * FROM housing WHERE is_validated = 0 UNION SELECT * FROM performance WHERE is_validated = 0");
    $req->execute();
    return $req->fetchAll();
}

function nbAllPendingAds(){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM housing WHERE is_validated = 0 UNION SELECT COUNT(*) FROM performance WHERE is_validated = 0");
    $req->execute();
    return  $req->fetchColumn();
}

//##########################################Ads #########################################
//Afficher la liste des annonces (housing + performance tables)
function nbAds(){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM housing UNION SELECT COUNT(*) FROM performance");
    $req->execute();
    $count = $req->fetchColumn();
    return $count;
}
function nbAdsByType($type){
    $db = connectDB();
    if ($type == "housing"){
        $req = $db->prepare("SELECT COUNT(*) FROM housing");
    }elseif($type == "performance"){
        $req = $db->prepare("SELECT COUNT(*) FROM performance");
    }
    $req->execute();
    $count = $req->fetchColumn();
    return $count;
}

function nbPerformancesByCategory($category){
    $db = connectDB();
    $req = $db->prepare("SELECT COUNT(*) FROM performance WHERE performance_type = ?");
    $req->execute([$category]);
    $count = $req->fetchColumn();
    return $count;
}

function getAdsByCategory($category){
    $db = connectDB();
    if ($category == "housing"){
        $req = $db->prepare("SELECT * FROM housing");
    }else{
        $req = $db->prepare("SELECT * FROM performance");
    }
    $req->execute();
    return $req->fetchAll();
}

function getAdsById($id, $type){
    $db = connectDB();
    if ($type == "housing"){
        $req = $db->prepare("SELECT * FROM housing WHERE id = ?");
    }else{
        $req = $db->prepare("SELECT * FROM performance WHERE id = ?");
    }
    $req->execute([$id]);
    return $req->fetch();
}

function deleteAd($id, $type){
    $db = connectDB();
    if ($type == "housing"){
        $req = $db->prepare("UPDATE housing SET is_deleted = 1 WHERE id = ?");
    }else{
        $req = $db->prepare("UPDATE performance SET is_deleted = 1 WHERE id = ?");
    }
    $req->execute([$id]);
}

//pour verifier que l'annonce n'est ni supprimée ni validée
function getAdStatus ($id, $type){
    $db = connectDB();
    if ($type == "housing"){
        $req = $db->prepare("SELECT is_deleted, is_validated FROM housing WHERE id = ?");
    }else{
        $req = $db->prepare("SELECT is_deleted, is_validated FROM performance WHERE id = ?");
    }
    $req->execute([$id]);
    $status = $req->fetch();
    if ($status['is_deleted'] == 1){
        return "Supprimée";
    }
    if ($status['is_validated'] == 0){
        return "En attente de validation";
    }
    return "Validée";
}
?>