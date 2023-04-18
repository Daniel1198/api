<?php

require '../header.php';

$query = $pdo->prepare('SELECT DISTINCT DATE(`attach_created_at`) as created_at FROM `attachments` ORDER BY created_at DESC');
$query->execute();
$dates = $query->fetchAll(PDO::FETCH_ASSOC);

for ($i=0; $i < count($dates); $i++) { 
    $query = $pdo->prepare('SELECT * FROM `attachments` WHERE DATE(attach_created_at) = :date_attach');
    $query->bindParam(':date_attach', $dates[$i]['created_at']);
    $query->execute();

    $attachments[$i] = [
        "date" => $dates[$i]['created_at'],
        "donnees" => $query->fetchAll(PDO::FETCH_ASSOC)
    ];
}
http_response_code(200);
retour_json(true, "Request succeed", $attachments);