<?php

require '../header.php';

$id = $_GET['mail_id'];

$query = $pdo->prepare("DELETE FROM `mails` WHERE `mail_id`=:id Limit 1");
$query->bindParam(':id', $id);

if ($query->execute()) {
    $users = $query->fetchAll();
    http_response_code(200);
    retour_json(true, "Courrier supprimé avec succès.", $users);
} else {
    http_response_code(400);
    retour_json(false, "Impossible de supprimer ce courrier. Veuillez contacter l'administrateur.", $resultat);
}