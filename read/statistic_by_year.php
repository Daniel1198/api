<?php

require '../header.php';

$year = $_GET['year'];

$query = $pdo->prepare("SELECT MONTHNAME(mail_date_received) as `month`, COUNT(*) as total, (SELECT COUNT(*) FROM `mails` WHERE id_register = 2 AND MONTHNAME(mail_date_received) = MONTHNAME(m.mail_date_received)) as traite, (SELECT COUNT(*) FROM `mails` WHERE id_register = 1 AND MONTHNAME(mail_date_received) = MONTHNAME(m.mail_date_received)) as nontraite FROM `mails` as m WHERE YEAR(mail_date_received) =:selected_year GROUP BY MONTHNAME(mail_date_received);");
$query->bindParam(':selected_year', $year);
$query->execute();
$stats = $query->fetchAll();

http_response_code(200);
retour_json(true, 'mail list', $stats);
