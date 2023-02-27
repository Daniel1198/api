<?php

require '../header.php';
$query = $pdo->prepare('SELECT * FROM `directions` ORDER BY `dir_label`');

if ($query->execute()) {
    $directions = $query->fetchAll();
    http_response_code(200);
    retour_json(true, 'directions list', $directions);
}
else {
    http_response_code(400);
    retour_json(false, 'Request failed');
}