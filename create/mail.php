<?php

require '../header.php';

if ($_POST) {

    // récupération des variables
    $corresponding = $_POST['mail_corresponding'];
    $object = $_POST['mail_object'];
    $date_received = $_POST['mail_date_received'];
    $id_direction = $_POST['id_direction'];

    if (
        empty(trim($corresponding)) || 
        empty(trim($object)) || 
        empty(trim($date_received)) || 
        empty(trim($id_direction)) ||
        is_null($corresponding) ||
        is_null($object) ||
        is_null($date_received) ||
        is_null($id_direction)
    ) {
        retour_json(false, "Vérifiez que les champs ne sont pas vides.");
        return;
    }
    $sql = "SELECT `dir_sigle` FROM `directions` WHERE dir_id =:id_direction";
    $query = $pdo->prepare($sql);
    $query->bindParam(':id_direction', $id_direction);
    $query->execute();
    $direction_sigle = $query->fetchAll(PDO::FETCH_ASSOC)[0]['dir_sigle'];

    $sql = "SELECT COUNT(mail_ref) as mail_number FROM `mails`";
    $query = $pdo->prepare($sql);
    $query->execute();
    $mails_number = $query->fetchAll(PDO::FETCH_ASSOC)[0]['mail_number'];

    $currentYear = date("y");

    // création de l'identifiant du courrier
    $mail_ref = $mails_number + 1 . $direction_sigle . $currentYear;

    $sql = "INSERT INTO `mails`(`mail_ref`, `mail_corresponding`, `mail_object`, `mail_date_received`, `id_direction`, `id_register`) VALUES (:mail_ref,:corresponding,:objet,:date_received,:id_direction,1);";

    $query = $pdo->prepare($sql);
    $query->bindParam(':mail_ref', $mail_ref);
    $query->bindParam(':corresponding', $corresponding);
    $query->bindParam(':objet', $object);
    $query->bindParam(':date_received', $date_received);
    $query->bindParam(':id_direction', $id_direction);

    if ($query->execute()) {
        // Si requête correcte
        $results = $query->fetchAll();
        http_response_code(200);
        retour_json(true, "Courrier enregistré avec succès !", $results);
    }
    else {
        // Si requête incorrecte
        http_response_code(400);
        retour_json(false, "Echec de l'enregistrement.");
    }
}

else {
    http_response_code(400);
    retour_json(false, "Aucune donnée trouvée.");
}