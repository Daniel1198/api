<?php

require '../header.php';

if ($_POST) {

    // récupération des variables

    $ref = $_POST['mail_ref'];
    $date_shipping = $_POST['mail_shipping_date'];
    $annotation = $_POST['mail_annotation'];
    $imputation = $_POST['mail_imputation'];

    $sql = "START TRANSACTION;";

    if (isset($_FILES['attachments'])) {
        $upload_dir = '../uploaded_files/documents/';
        for ($i = 0; $i < count($_FILES['attachments']['name']); $i++) {
            $file_name = $_FILES['attachments']['name'][$i];
            $file_tmp_name = $_FILES['attachments']['tmp_name'][$i];
            $file_error = $_FILES['attachments']['error'][$i];

            if ($file_error > 0) {
                $response = array(
                    "status" => "error",
                    "error" => true,
                    "message" => "Error uploading the file!"
                );
            }
            else {
                $ext = pathinfo($file_name);
                $random_name = hash('ripemd160', $file_name) . "." . $ext['extension'];
                $upload_name = $upload_dir . strtolower($random_name);
                $file_link = preg_replace('/\s+/', '-', $upload_name);
    
                if (move_uploaded_file($file_tmp_name, $file_link)) {
                    $sql .= "INSERT INTO `attachments` (`attach_id`, `attach_label`, `attach_link`, `ref_mail`) VALUES (null,'$file_name', '$file_link','$ref');";
                }
            }
        }
    }
    $sql .= "UPDATE `mails` SET `id_register`=2, `mail_shipping_date`=:date_shipping, `mail_annotation`=:annotation, `mail_imputation`=:imputation WHERE `mail_ref`=:ref;";
    $sql .= "COMMIT;";

    $query = $pdo->prepare($sql);
    $query->bindParam(':ref', $ref);
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