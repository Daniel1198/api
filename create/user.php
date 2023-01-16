<?php

require '../header.php';

if ($_POST) {

    // récupération des variables

    $lastname = $_POST['lastname'];
    $firstname = $_POST['firstname'];
    $email = $_POST['email'];
    $is_admin = $_POST['is_admin'];
    $password = $_POST['password'];

    if (
        empty(trim($lastname)) || 
        empty(trim($firstname)) || 
        empty(trim($email)) || 
        empty(trim($password)) ||
        is_null($lastname) ||
        is_null($firstname) ||
        is_null($email) ||
        is_null($is_admin) ||
        is_null($password)
    ) {
        retour_json(false, "Vérifiez que les champs ne sont pas vides.");
        return;
    }
    
    if (
        empty($_FILES['user_profile']['name']) ||
        is_null($_FILES['user_profile']['name']) ||
        $_FILES['user_profile']['name'] == 'undefined'
    ) {
        $image_link = "../uploaded_files/user.png";
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
        retour_json(true, "✔️ Utilisateur enregistré avec succès !", $results);
    }
    else {
        // Si requête incorrecte
        http_response_code(400);
        retour_json(false, "⚠️ Echec de l'enregistrement.");
    }
    
}

else {
    http_response_code(400);
    retour_json(false, "Aucune donnée trouvée.");
}