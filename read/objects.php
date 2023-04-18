<?php

require '../header.php';
$query = $pdo->prepare('SELECT DISTINCT mail_object FROM `mails`');

if ($query->execute()) {
    $mails_object = $query->fetchAll();
    http_response_code(200);
    retour_json(true, 'objects list', $mails_object);
}
else {
    http_response_code(400);
    retour_json(false, 'Request failed');
}