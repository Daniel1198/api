<?php

require '../header.php';

$id = $_GET['mail_id'];

$query = $pdo->prepare('SELECT * FROM `attachments` WHERE id_mail = :id');
$query->bindParam(':id', $id);

if ($query->execute()) {
    $attachments = $query->fetchAll();
    http_response_code(200);
    retour_json(true, "Succès", $attachments);
}