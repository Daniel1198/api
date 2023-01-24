<?php

require '../header.php';
$query = $pdo->prepare('SELECT * FROM `registers`');

if ($query->execute()) {
    $registers = $query->fetchAll();
    http_response_code(200);
    retour_json(true, 'registers list', $registers);
}
else {
    http_response_code(400);
    retour_json(false, 'Request failed');
}