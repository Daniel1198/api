<?php

require '../header.php';

$id = $_GET['mail_id'];

$query = $pdo->prepare('SELECT * FROM `mails` LEFT JOIN `services` ON mails.id_service = services.serv_id WHERE mails.mail_id = :id LIMIT 1');
$query->bindParam(':id', $id);

if ($query->execute()) {
    $mail = $query->fetchAll();
    http_response_code(200);
    if (count($mail) === 1) {
        retour_json(true, "Utilisateur trouvé", $mail);
    }
    else {
        retour_json(false, "Utilisateur inexistant");
    }
}