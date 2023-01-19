<?php

require '../header.php';

if ($_POST) {

    // récupération des variables

    $id = $_POST['id'];
    $password = $_POST['password'];

    if (empty(trim($password)) || is_null($password)) {
        retour_json(false, "Le mot de passe saisi n'est pas valide.");
        return;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    $query = $pdo->prepare("UPDATE `users` SET `password`=:pwd WHERE `id`=:id");

    $query->bindParam(':id', $id);
    $query->bindParam(':pwd', $password_hash);

    if ($query->execute()) {
        // Si requête correcte
        $results = $query->fetchAll();
        http_response_code(200);
        retour_json(true, "Mot de passe modifié avec succès !", $results);
    }
    else {
        // Si requête incorrecte
        http_response_code(400);
        retour_json(false, "Echec de la modification.");
    }
    
}

else {
    http_response_code(400);
    retour_json(false, "Aucune donnée trouvée.");
}