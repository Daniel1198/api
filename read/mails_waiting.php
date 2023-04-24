<?php

require '../header.php';
$query = $pdo->prepare("SELECT *, DATEDIFF(CURDATE(), DATE(mail_date_received)) as jourdiff FROM `mails` INNER JOIN `directions` ON mails.id_direction = directions.dir_id WHERE mails.id_register = 1 AND DATEDIFF(CURDATE(), DATE(mail_date_received)) != 0");
$query->execute();
$mails = $query->fetchAll(PDO::FETCH_ASSOC);

http_response_code(200);
retour_json(true, 'Request succeed', $mails);
