<?php

require '../header.php';
$query = $pdo->prepare('SELECT * FROM `users`');

if ($query->execute()) {
    $users = $query->fetchAll();
    http_response_code(200);
    retour_json(true, 'users list', $users);
}
else {
    http_response_code(400);
    retour_json(false, 'Request failed');
}