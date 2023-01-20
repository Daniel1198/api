<?php
include_once '../header.php';
require "../vendor/autoload.php";

use \Firebase\JWT\JWT;

if (isset($_POST)) {

    $email = $_POST['email'];
    $pwd = $_POST['pwd'];

    if (empty(trim($email)) || empty(trim($pwd))) {
        retour_json(false, "Email ou mot de passe incorrecte.");
        return;
    }

    //verification du compte et mot de passe

    $query = $pdo->prepare('SELECT * FROM `users` WHERE `email`=:email LIMIT 1');
    $query->bindParam(':email', $email);
    $query->execute();
    $nb = $query->RowCount();
    if ($nb > 0) {
        $row = $query->fetchAll(PDO::FETCH_ASSOC);
        $lastname = $row[0]['lastname'];
        $firstname = $row[0]['firstname'];
        $password_hash = $row[0]['password'];
        $image = $row[0]['image'];
        $isAdmin = $row[0]['isadmin'];
        $isFirstConnection = $row[0]['isfirstconnection'];

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

            $jwt = JWT::encode($token, $secret_key, 'HS512');
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
            // http_response_code(400);
            retour_json(false, "Email ou mot de passe incorrecte.");
            return;
        }
    } else {
        // http_response_code(400);
        retour_json(false, "Email ou mot de passe incorrecte.");
        return;
    }
}
