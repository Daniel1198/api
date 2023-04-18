<?php

require '../header.php';

$firstDate = $_GET['first_date'];
$lastDate = $_GET['last_date'];

if (empty($lastDate) || empty($firstDate)) {
    retour_json(false, 'Veuillez renseigner la période', $stats);
    return;
}

// nombre total de courriers
$query = $pdo->prepare("SELECT COUNT(*) as total FROM `mails` WHERE mail_date_received BETWEEN '$firstDate' AND '$lastDate'");
$query->execute();
$total_mail = $query->fetchAll(PDO::FETCH_ASSOC)[0]['total'];

// nombre total de courriers en attente
$query = $pdo->prepare("SELECT COUNT(*) as total FROM `mails` WHERE id_register = 1 AND mail_date_received BETWEEN '$firstDate' AND '$lastDate';");
$query->execute();
$mail_in_waiting = $query->fetchAll(PDO::FETCH_ASSOC)[0]['total'];

// nombre total de courriers adressé à la direction générale
$query = $pdo->prepare("SELECT COUNT(*) as total FROM `mails` WHERE id_direction = 7 AND mail_date_received BETWEEN '$firstDate' AND '$lastDate';");
$query->execute();
$mail_dg = $query->fetchAll(PDO::FETCH_ASSOC)[0]['total'];

// groupement par nature de la demande
$query = $pdo->prepare("SELECT mail_object, COUNT(mail_object) as total FROM `mails` WHERE mail_date_received BETWEEN '$firstDate' AND '$lastDate' GROUP BY mail_object");
$query->execute();
$total_by_object = $query->fetchAll();

// groupement par expéditeur
$query = $pdo->prepare("SELECT mail_corresponding, COUNT(*) as total FROM `mails` WHERE mail_date_received BETWEEN '$firstDate' AND '$lastDate' GROUP BY mail_corresponding");
$query->execute();
$total_by_corresponding = $query->fetchAll(PDO::FETCH_ASSOC);

$stats = [
    "total_mail" => $total_mail,
    "mail_in_waiting" => $mail_in_waiting,
    "mail_dg" => $mail_dg,
    "total_by_object" => $total_by_object,
    "total_by_corresponding" => $total_by_corresponding,
];

http_response_code(200);
retour_json(true, 'mail list', $stats);
