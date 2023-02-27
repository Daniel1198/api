<?php

require '../header.php';

$ref = $_GET['mail_ref'];

$query = $pdo->prepare('SELECT * FROM `mails` LEFT JOIN `directions` ON mails.id_direction = directions.dir_id WHERE mails.mail_ref = :ref LIMIT 1');
$query->bindParam(':ref', $ref);

if ($query->execute()) {
    $mail = $query->fetchAll();
    http_response_code(200);
    if (count($mail) === 1) {
        retour_json(true, "Courrier trouvé", $mail);
    }
    else {
        retour_json(false, "Courrier inexistant");
    }
}