<?php

require '../header.php';

if ($_POST) {

    // récupération des variables
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

    $sql = "INSERT INTO `mails`(`mail_id`, `mail_corresponding`, `mail_object`, `mail_date_received`, `id_service`, `id_register`) VALUES (null,:corresponding,:objet,:date_received,:id_service,1);";
    
    if ($_FILES['attachments']) {
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
                    $sql .= "INSERT INTO `attachments`(`attach_id`, `attach_label`, `attach_file`, `id_mail`) VALUES (null,'$file_name', '$file_link',(SELECT MAX(mail_id) FROM `mails`));";
                }
            }
        }
    }

    $pdo->beginTransaction();
    try {
        $query = $pdo->prepare($sql);
        $query->bindParam(':corresponding', $corresponding);
        $query->bindParam(':objet', $object);
        $query->bindParam(':date_received', $date_received);
        $query->bindParam(':id_service', $id_service);

    }
    catch(PDOException$e) {
        $pdo->rollBack();
        retour_json(false, "Echec lors de l'enregistrement.", $results);
        return;
    }
    $pdo->commit();

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