<?php

require '../header.php';
$query = $pdo->prepare('SELECT DISTINCT mail_corresponding FROM `mails`');

if ($query->execute()) {
    $corresponding = $query->fetchAll(PDO::FETCH_ASSOC);
    http_response_code(200);
    retour_json(true, 'Request succeed', $corresponding);
}
else {
    http_response_code(400);
    retour_json(false, 'Request failed');
}