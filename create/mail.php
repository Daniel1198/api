<?php

require '../header.php';

if ($_POST) {

    // récupération des variables

    $corresponding = $_POST['corresponding'];
    $object = $_POST['object'];
    $date_received = $_POST['date_received'];
    $id_receiver = $_POST['id_receiver'];
    $attachments = $_POST['attachments'];

    if (
        empty(trim($corresponding)) || 
        empty(trim($object)) || 
        empty(trim($date_received)) || 
        empty(trim($id_receiver)) ||
        is_null($corresponding) ||
        is_null($object) ||
        is_null($date_received) ||
        is_null($id_receiver)
    ) {
        retour_json(false, "Vérifiez que les champs ne sont pas vides.");
        return;
    }

    // var_dump($_FILES['attachments']);

    retour_json(true, 'files', json_decode($attachments));
        return;
    
    if ($_FILES['attachments[0]']) {
        retour_json(true, 'files', $_FILES);
        return;
    }
    else {
        $upload_dir = '../uploaded_files/';

        if ($_FILES['user_profile']) {
            $user_image_name = $_FILES['user_profile']['name'];
            $user_image_tmp_name = $_FILES['user_profile']['tmp_name'];
            $user_image_error = $_FILES['user_profile']['error'];

            if ($user_image_error > 0) {
                $response = array(
                    "status" => "error",
                    "error" => true,
                    "message" => "Error uploading the file!"
                );
            }
            else {
                $ext = pathinfo($user_image_name);
                $random_name = hash('ripemd160', $user_image_name) . "." . $ext['extension'];
                $upload_name = $upload_dir . strtolower($random_name);
                $image_link = preg_replace('/\s+/', '-', $upload_name);
    
                if (move_uploaded_file($user_image_tmp_name, $image_link)) {
                    $response = array(
                        "status" => "success",
                        "error" => false,
                        "message" => "File uploaded successfully"
                    );
                }
            }
        }
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = $pdo->prepare("INSERT INTO `users`(`id`, `lastname`, `firstname`, `email`, `isadmin`, `password`, `image`) 
    VALUES (null, :lastname, :firstname, :email, :isadmin, :pwd, :photo)");

    $query->bindParam(':lastname', $lastname);
    $query->bindParam(':firstname', $firstname);
    $query->bindParam(':email', $email);
    $query->bindParam(':isadmin', $is_admin);
    $query->bindParam(':pwd', $password_hash);
    $query->bindParam(':photo', $image_link);

    if ($query->execute()) {
        // Si requête correcte
        $results = $query->fetchAll();
        http_response_code(200);
        retour_json(true, "Utilisateur enregistré avec succès !", $results);
    }
    else {
        // Si requête incorrecte
        http_response_code(400);
        retour_json(false, "Echec de l'enregistrement.");
    }
    
}

else {
    http_response_code(400);
    retour_json(false, "Aucune donnée trouvée.");
}