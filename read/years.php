<?php

require '../header.php';

$query = $pdo->prepare("SELECT DISTINCT YEAR(mail_date_received) as `year` FROM `mails` ORDER BY YEAR(mail_date_received) DESC;");
$query->execute();
$years = $query->fetchAll(PDO::FETCH_ASSOC);

http_response_code(200);
retour_json(true, 'Request succeed', $years);
