<?php

require '../header.php';

$ref = $_GET['mail_ref'];

$query = $pdo->prepare("DELETE FROM `mails` WHERE `mail_ref`=:ref Limit 1");
$query->bindParam(':ref', $ref);

if ($query->execute()) {
    $users = $query->fetchAll();
    http_response_code(200);
    retour_json(true, "Courrier supprimé avec succès.", $users);
} else {
    http_response_code(400);
    retour_json(false, "Impossible de supprimer ce courrier. Veuillez contacter l'administrateur.", $resultat);
}