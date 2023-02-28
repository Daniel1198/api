<?php

require '../header.php';

// nombre total de courriers
$query = $pdo->prepare("SELECT COUNT(*) as total FROM `mails` WHERE mail_date_received BETWEEN '2023-02-27' AND '2023-03-03'");
$query->execute();
$total_mail = $query->fetchAll(PDO::FETCH_ASSOC)[0]['total'];

// nombre total de courriers en attente
$query = $pdo->prepare("SELECT COUNT(*) as total FROM `mails` WHERE id_register = 1 AND mail_date_received BETWEEN '2023-02-27' AND '2023-03-03';");
$query->execute();
$mail_in_waiting = $query->fetchAll(PDO::FETCH_ASSOC)[0]['total'];

// nombre total de courriers adressé à la direction générale
$query = $pdo->prepare("SELECT COUNT(*) as total FROM `mails` WHERE id_direction = 2 AND mail_date_received BETWEEN '2023-02-27' AND '2023-03-03';");
$query->execute();
$mail_dg = $query->fetchAll(PDO::FETCH_ASSOC)[0]['total'];

// groupement par nature de la demande
$query = $pdo->prepare("SELECT mail_object, COUNT(mail_object) as total FROM `mails` WHERE mail_date_received BETWEEN '2023-02-27' AND '2023-03-03' GROUP BY mail_object");
$query->execute();
$total_by_object = $query->fetchAll();

// $query = $pdo->prepare("SELECT mail_object, COUNT(mail_object) as total FROM `mails` WHERE id_register = 1 AND mail_date_received BETWEEN '2023-02-27' AND '2023-03-03' GROUP BY mail_object");
// $query->execute();
// $total_by_object = $query->fetchAll();

$stats = [
    "total_mail" => $total_mail,
    "mail_in_waiting" => $mail_in_waiting,
    "mail_dg" => $mail_dg,
    "total_by_object" => $total_by_object
];

http_response_code(200);
retour_json(true, 'mail list', $stats);
