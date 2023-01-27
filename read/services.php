<?php

require '../header.php';
$query = $pdo->prepare('SELECT * FROM `services` ORDER BY `label`');

if ($query->execute()) {
    $services = $query->fetchAll();
    http_response_code(200);
    retour_json(true, 'services list', $services);
}
else {
    http_response_code(400);
    retour_json(false, 'Request failed');
}