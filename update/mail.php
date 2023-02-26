<?php

require '../header.php';

if ($_POST) {

    // récupération des variables
    $id = $_POST['mail_id'];
    $corresponding = $_POST['mail_corresponding'];
    $object = $_POST['mail_object'];
    $date_received = $_POST['mail_date_received'];
    $id_service = $_POST['id_service'];

    if (
        empty(trim($corresponding)) || 
        empty(trim($object)) || 
        empty(trim($date_received)) || 
        empty(trim($id_service)) ||
        is_null($corresponding) ||
        is_null($object) ||
        is_null($date_received) ||
        is_null($id_service)
    ) {
        retour_json(false, "Vérifiez que les champs ne sont pas vides.");
        return;
    }

    $sql = "UPDATE `mails` SET `mail_corresponding`=:corresponding,`mail_object`=:objet,`mail_date_received`=:date_received,`id_service`=:id_service WHERE mail_id = :id";

    $query = $pdo->prepare($sql);
    $query->bindParam(':corresponding', $corresponding);
    $query->bindParam(':objet', $object);
    $query->bindParam(':date_received', $date_received);
    $query->bindParam(':id_service', $id_service);
    $query->bindParam(':id', $id);

    if ($query->execute()) {
        // Si requête correcte
        $results = $query->fetchAll();
        http_response_code(200);
        retour_json(true, "Courrier modifié avec succès !", $results);
    }
    else {
        // Si requête incorrecte
        http_response_code(400);
        retour_json(false, "Echec de la modification.");
    }
}

else {
    http_response_code(400);
    retour_json(false, "Aucune donnée trouvée.");
}