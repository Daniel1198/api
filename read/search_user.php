<?php

require '../header.php';

$search = htmlspecialchars($_GET['search']);

$query = $pdo->prepare("SELECT * FROM `users` WHERE `lastname` LIKE '%$search%' OR `firstname` LIKE '%$search%'");

if ($query->execute()) {
    $users = $query->fetchAll();
    http_response_code(200);
    if (count($users) > 0) {
        retour_json(true, "users list", $users);
    }
    else {
        retour_json(false, "Aucun utilisateur ne correspond à la recherche.");
    }
}
else {
    http_response_code(400);
    retour_json(false, 'Request failed');
}