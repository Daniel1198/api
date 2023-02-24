<?php

require '../header.php';

if ($_POST) {

    // récupération des variables

    $id = $_POST['user_id'];
    $isFirstConnection = $_POST['user_is_first_connection'];
    $password = $_POST['user_password'];
    $newPassword = $_POST['user_new_password'];

    if (empty(trim($password)) || is_null($password) || empty(trim($newPassword)) || is_null($newPassword)) {
        retour_json(false, "Le mot de passe saisi n'est pas valide.");
        return;
    }

    if ($isFirstConnection == 1) {
        $query = $pdo->prepare("SELECT `user_password` FROM `users` WHERE `user_id`=:id");
        $query->bindParam(':id', $id);
        $query->execute();
        $pwd = $query->fetch(PDO::FETCH_ASSOC)["user_password"];

        if (!password_verify($password, $pwd)) {
            retour_json(false, "Le mot de passe actuel est incorrecte.");
            return;
        }

        if ($password == $newPassword) {
            retour_json(false, "Le mot de passe actuel doit être différent du nouveau mot de passe.");
            return;
        }

        $query = $pdo->prepare("UPDATE `users` SET `user_password`=:pwd, `user_isfirstconnection`=1 WHERE `user_id`=:id");
    }

    else {
        $query = $pdo->prepare("UPDATE `users` SET `user_password`=:pwd, `user_isfirstconnection`=0 WHERE `user_id`=:id");
    }

    $password_hash = password_hash($newPassword, PASSWORD_DEFAULT);
   
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