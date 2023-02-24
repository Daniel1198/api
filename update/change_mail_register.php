<?php

require '../header.php';

if ($_POST) {

    // récupération des variables

    $id = $_POST['mail_id'];
    $date_shipping = $_POST['mail_shipping_date'];
    $annotation = $_POST['mail_annotation'];
    $imputation = $_POST['mail_imputation'];

    $query = $pdo->prepare("UPDATE `mails` SET `id_register`=2, `mail_shipping_date`=:date_shipping, `mail_annotation`=:annotation, `mail_imputation`=:imputation WHERE `mail_id`=:id");
    $query->bindParam(':id', $id);
    $query->bindParam(':date_shipping', $date_shipping);
    $query->bindParam(':annotation', $annotation);
    $query->bindParam(':imputation', $imputation);

    if ($query->execute()) {
        // Si requête correcte
        $results = $query->fetchAll();
        http_response_code(200);
        retour_json(true, "Courrier prêt à être transmis. Vérifiez le registre de départ", $results);
    }
    else {
        // Si requête incorrecte
        http_response_code(400);
        retour_json(false, "Erreur lors du changement de registre.");
    }
    
}

else {
    http_response_code(400);
    retour_json(false, "Aucune donnée trouvée.");
}