<?php
require '../header.php';
require "../vendor/autoload.php";

use \Firebase\JWT\JWT;

if (isset($_POST)) {

    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    if (empty(trim($email)) || empty(trim($pwd))) {
        retour_json(false, "Nom d'utilisateur ou mot de passe incorrecte.");
        return;
    }

    //verification du compte et mot de passe

    $query = $pdo->prepare("SELECT * FROM `users` WHERE `email`=:email LIMIT 1");
    $query->bindParam(':email', $email);
    $query->execute();
    $nb = count($query->fetchAll());
    if ($nb > 0) {
        $row = $query->fetch(PDO::FETCH_ASSOC);
        json_encode ($row);
        return;
        $lastname = $row['lastname'];
        $firstname = $row['firstname'];
        $password_hash = $row['password'];
        $image = $row['image'];
        $isAdmin = $row['isadmin'];
        $isFirstConnection = $row['isfirstconnection'];

        if (password_verify($pwd, $password_hash)) {
            $secret_key = "2txhWX#ç8800532Fvczj@";
            $issuer_claim = "localhost"; // this can be the servername
            $audience_claim = "THE_AUDIENCE";
            $issuedat_claim = time(); // issued at
            $notbefore_claim = $issuedat_claim + 0; //not before in seconds
            $expire_claim = $issuedat_claim + 28800; // expire time in seconds
            $token = array(
                "iss" => $issuer_claim,
                "aud" => $audience_claim,
                "iat" => $issuedat_claim,
                "nbf" => $notbefore_claim,
                "exp" => $expire_claim,
                "data" => array(
                    "lastname" => $lastname,
                    "firstname" => $firstname,
                    "image" => $image,
                    "isAdmin" => $isAdmin,
                    "isFirstConnection" => $isFirstConnection,
                )
            );

            http_response_code(200);

            $jwt = JWT::encode($token, $secret_key);
            // $result =  array(
            //     "message" => "Authentification réussie.",
            //     "jwt" => $jwt,
            //     "id" => $id,
            //     "users_email" => $users_email,
            //     "users_nomprenoms" => $users_nomprenoms,
            //     "users_lien_photo" => $users_lien_photo,
            //     "users_profil" => $users_profil,
            //     "premiereCnx" => $premiereCnx,
            // );
            retour_json(true, "Connexion réussie", $jwt);
        } else {
            http_response_code(400);
            retour_json(false, "Utilisateur ou mot de passe incorrecte.");
            return;
        }
    } else {
        http_response_code(400);
        retour_json(false, "Utilisateur ou mot de passe incorrecte.");
        return;
    }
}
