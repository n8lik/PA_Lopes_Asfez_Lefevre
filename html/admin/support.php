<?php
require 'includes/admin_header.php';
require 'includes/fun_admin.php';
session_start();
//Verifier la connexion
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['choice'])) {
    header('Location: index.php');
    exit();
} else {
    $choice = $_GET['choice'];
}

//Afficher les erreurs


switch ($choice) {
    case 'chatbot':
        //Vérifier si le formulaire d'ajout a été soumis
        if (isset($_POST['addMessage'])) {
            $rep = addChatbotMessage($_POST['keyword'], $_POST['response']);
            if ($rep) {
                echo '<div class="alert alert-danger" role="alert"> Le mot clé "' . $_POST['keyword'] . '" existe déjà</div>';
            } else {
                echo '<div class="alert alert-success" role="alert"> Message ajouté avec succès</div>';
            }
            unset($_POST['addMessage']);
            unset($_POST['keyword']);
            unset($_POST['response']);
        }
        //Vérifier si le formulaire de modification a été soumis
        if (isset($_POST['editMessage'])) {
            editChatbotMessage($_POST['id'], $_POST['keyword'], $_POST['response']);
            unset($_POST['editMessage']);
            unset($_POST['id']);
            unset($_POST['keyword']);
            unset($_POST['response']);
        }
        //Vérifier si le formulaire de suppression a été soumis
        if (isset($_POST['deleteMessage'])) {
            deleteChatbotMessage($_POST['id']);
            unset($_POST['deleteMessage']);
            unset($_POST['id']);
            echo '<div class="alert alert-success" role="alert"> Message supprimé avec succès</div>';
        }

        //Vérifier si une recherche a été effectuée
        if (isset($_POST['search'])) {
            $messages = searchChatbotMessages($_POST['search']);
            echo '<div class="alert alert-success" role="alert"> Résultat de la recherche: ' . $_POST['search'] . '</div>';
            unset($_POST['search']);
        } else {
            $messages = getChatbotMessages();
        }
?>
        <div class="admin-content-line">
            <div class="stat-block">
                <h4>Messages du chatbot</h4>
                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Rechercher un mot clé" name="search" aria-label="Rechercher un mot clé" aria-describedby="button-addon2">
                        <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Rechercher</button>
                    </div>
                </form>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMessage">Ajouter un message</button>
                <div class="modal fade" id="addMessage" tabindex="-1" aria-labelledby="addMessageLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addMessageLabel">Ajouter un message</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" method="POST">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="keyword" class="form-label">Mot clé</label>
                                        <input type="text" class="form-control" id="keyword" name="keyword">
                                    </div>
                                    <div class="mb-3">
                                        <label for="response" class="form-label">Réponse</label>
                                        <textarea class="form-control" id="response" name="response" rows="3"></textarea>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                    <button type="submit" class="btn btn-primary" name="addMessage">Ajouter</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <hr>
                <?php
                if ($messages == null) {
                    echo '<div class="alert alert-danger" role="alert"> Aucun message trouvé</div>';
                } else {
                ?>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Mot clé</th>
                                    <th scope="col" width="70%">Réponse</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($messages as $index => $message) : ?>
                                    <tr>
                                        <td><?php echo $message['keyword']; ?></td>
                                        <td><?php echo $message['chatbotresponse']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editMessage<?php echo $index; ?>">Modifier</button>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteMessage<?php echo $index; ?>">Supprimer</button>
                                        </td>
                                    </tr>
                                    <!-- Modal de modification -->
                                    <div class="modal fade" id="editMessage<?php echo $index; ?>" tabindex="-1" aria-labelledby="editMessage<?php echo $index; ?>Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editMessage<?php echo $index; ?>Label">Modifier le message</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                                                        <div class="mb-3">
                                                            <label for="keyword" class="form-label">Mot clé</label>
                                                            <input type="text" class="form-control" id="keyword" name="keyword" value="<?php echo $message['keyword']; ?>">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="response" class="form-label">Réponse</label>
                                                            <textarea class="form-control" id="response" name="response" rows="3"><?php echo $message['chatbotresponse']; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-primary" name="editMessage">Enregistrer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal de suppression -->
                                    <div class="modal fade" id="deleteMessage<?php echo $index; ?>" tabindex="-1" aria-labelledby="deleteMessage<?php echo $index; ?>Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteMessage<?php echo $index; ?>Label">Supprimer le message</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="id" value="<?php echo $message['id']; ?>">
                                                        <p>Voulez-vous vraiment supprimer le message ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-danger" name="deleteMessage">Supprimer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
            </div>
        </div>
    <?php
        break;
    case 'lang':
        // afficher un tableau avec la liste des langues disponibles dans le dossier /var/www/html/includes/lang
        $langFiles = scandir('/var/www/html/includes/lang');
        $langFiles = array_diff($langFiles, array('.', '..'));
        foreach ($langFiles as $key => $langFile) {
            $langFiles[$key] = pathinfo($langFile, PATHINFO_FILENAME);
        }

        // Afficher les erreurs
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        } elseif (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }

        // Afficher le tableau des langues
    ?>
        <div>
            <div class="admin-content-line">
                <div class="stat-block">
                    <?php 
                    if (isset($_SESSION['delerror'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['delerror'] . '</div>';
                        unset($_SESSION['delerror']);
                    } elseif (isset($_SESSION['delsuccess'])) {
                        echo '<div class="alert alert-success" role="alert">' . $_SESSION['delsuccess'] . '</div>';
                        unset($_SESSION['delsuccess']);
                    }
                    ?>

                    <h4>Liste des langues disponibles</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">Langue</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($langFiles as $index => $langFile) : ?>
                                    <tr>
                                        <td><?php echo $langFile; ?></td>
                                        <td>
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteLang<?php echo $index; ?>">Supprimer</button>
                                        </td>
                                    </tr>
                                    <!-- Modal de suppression -->
                                    <div class="modal fade" id="deleteLang<?php echo $index; ?>" tabindex="-1" aria-labelledby="deleteLang<?php echo $index; ?>Label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteLang<?php echo $index; ?>Label">Supprimer la langue</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="includes/lang/del_lang" method="POST">
                                                    <div class="modal-body">
                                                        <input type="hidden" name="lang" value="<?php echo $langFile; ?>">
                                                        <p>Voulez-vous vraiment supprimer la langue <?php echo $langFile; ?> ?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                                                        <button type="submit" class="btn btn-danger" name="deleteLang">Supprimer</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <hr>
            <div class="admin-content-line">
                <div class="stat-block">
                    <?php         //Afficher les erreurs
                    if (isset($_SESSION['error'])) {
                        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                        unset($_SESSION['error']);
                    } elseif (isset($_SESSION['success'])) {
                        echo '<div class="alert alert-success" role="alert">' . $_SESSION['success'] . '</div>';
                        unset($_SESSION['success']);
                    }
                    ?>
                    <h4>Ajouter une langue</h4>
                    <p>Pour ajouter une langue, téléchargez le fichier de langue vierge, remplissez-le et téléversez-le ensuite, en respectant la nommenclature suivante: [lang].json</p>
                    <div class="d-flex ">
                        <a href="includes/lang/download_template.php?file=lang_template.json" class="btn btn-primary me-2">Télécharger le fichier de langue vierge</a>
                        <a href="includes/lang/download_template.php?file=fr_template.json" class="btn btn-primary">Télécharger le fichier en français</a>
                    </div>

                    <form action="includes/lang/add_new_lang" method="POST" enctype="multipart/form-data" style="margin-top: 5%;">
                        <div class="mb-3">
                            <label for="langFile" class="form-label">Insérer le fichier de langue</label>
                            <input class="form-control" type="file" id="langFile" name="langFile">

                            <label for="lang" class="form-label">Diminutif de la langue</label>
                            <input class="form-control" type="text" id="lang" name="lang">
                        </div>
                        <button type="submit" class="btn btn-primary" name="addLang" id="addLang">Ajouter</button>
                    </form>
                </div>
            </div>
        </div>



<?php
        break;

    default:
        header('Location: index.php');
        break;
}

require 'includes/admin_footer.php';
?>
