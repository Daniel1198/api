<?php

require '../header.php';

$id_register = $_GET['id_register'];

if ($_GET['id_register'] != "undefined") {
    $query = $pdo->prepare("SELECT * FROM `mails` LEFT JOIN `directions` ON mails.id_direction = directions.dir_id WHERE mails.id_register = :id_register ORDER BY mails.mail_date_received DESC");
    $query->bindParam(':id_register', $id_register);
}
else {
    $query = $pdo->prepare("SELECT * FROM `mails` LEFT JOIN `directions` ON mails.id_direction = directions.dir_id ORDER BY mails.mail_date_received DESC");
}

if ($query->execute()) {
    $mails = $query->fetchAll();
    http_response_code(200);
    retour_json(true, 'mail list', $mails);
}
else {
    http_response_code(400);
    retour_json(false, 'Request failed');
}