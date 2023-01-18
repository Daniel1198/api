<?php

require '../header.php';

$id = $_GET['id'];

$query = $pdo->prepare('SELECT * FROM `users` WHERE `id`=:id LIMIT 1');
$query->bindParam(':id', $id);

if ($query->execute()) {
    $user = $query->fetchAll();
    http_response_code(200);
    if (count($user) === 1) {
        retour_json(true, "Utilisateur trouvé", $user);
    }
    else {
        retour_json(false, "Utilisateur inexistant");
    }
}