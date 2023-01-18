<?php

require '../header.php';

$id = $_GET['id'];

$query = $pdo->prepare("DELETE FROM `users` WHERE `id`=:id Limit 1");
$query->bindParam(':id', $id);

if ($query->execute()) {
    $users = $query->fetchAll();
    http_response_code(200);
    retour_json(true, "Utilisateur supprimé avec succès.", $users);
} else {
    http_response_code(400);
    retour_json(false, "Impossible de supprimer cet utilisateur.", $resultat);
}