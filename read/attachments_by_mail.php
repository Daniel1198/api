<?php

require '../header.php';

$ref = $_GET['mail_ref'];

$query = $pdo->prepare('SELECT * FROM `attachments` WHERE ref_mail = :ref');
$query->bindParam(':ref', $ref);

if ($query->execute()) {
    $attachments = $query->fetchAll();
    http_response_code(200);
    retour_json(true, "Succès", $attachments);
}