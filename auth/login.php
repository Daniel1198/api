<?php
include_once '../header.php';
require "../vendor/autoload.php";

use \Firebase\JWT\JWT;

if (isset($_POST)) {

    $email = $_POST['user_email'];
    $pwd = $_POST['user_pwd'];

    if (empty(trim($email)) || empty(trim($pwd))) {
        retour_json(false, "Email ou mot de passe incorrecte.");
        return;
    }

    //verification du compte et mot de passe

    $query = $pdo->prepare('SELECT * FROM `users` WHERE `user_email`=:email LIMIT 1');
    $query->bindParam(':email', $email);
    $query->execute();
    $nb = $query->RowCount();
    if ($nb > 0) {
        $row = $query->fetchAll(PDO::FETCH_ASSOC);
        $id = $row[0]['user_id'];
        $lastname = $row[0]['user_lastname'];
        $firstname = $row[0]['user_firstname'];
        $password_hash = $row[0]['user_password'];
        $image = $row[0]['user_image'];
        $isAdmin = $row[0]['user_isadmin'];
        $isFirstConnection = $row[0]['user_isfirstconnection'];

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
                    "user_id" => $id,
                    "user_lastname" => $lastname,
                    "user_firstname" => $firstname,
                    "user_image" => $image,
                    "user_isAdmin" => $isAdmin,
                    "user_isFirstConnection" => $isFirstConnection,
                )
            );

            http_response_code(200);

            $jwt = JWT::encode($token, $secret_key, 'HS512');
            retour_json(true, "Connexion réussie", $jwt);
        } else {
            retour_json(false, "Email ou mot de passe incorrecte.");
            return;
        }
    } else {
        retour_json(false, "Email ou mot de passe incorrecte.");
        return;
    }
}
