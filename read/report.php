
<?php
    include_once '../header.php';
    require "../vendor/autoload.php";

    use Fpdf\Fpdf;

    $firstDate = $_GET['first_date'];
    $lastDate = $_GET['last_date'];

    if (empty($lastDate) || empty($firstDate)) {
        retour_json(false, 'Veuillez renseigner la période', $stats);
        return;
    }

    class PDF extends FPDF
    {

        // Pied de page
        function Footer()
        {
            // Positionnement à 1,5 cm du bas
            $this->SetY(-15);
            // Police Arial italique 8
            $this->SetFont('OpenSans','',8);
            // Numéro de page
            $this->Cell(0,10, $this->PageNo(),0,0,'C');
        }
        var $B=0;
        var $I=0;
        var $U=0;
        var $HREF='';
        var $ALIGN='';

        function WriteHTML($html)
        {
            //Parseur HTML
            $html=str_replace("\n",' ',$html);
            $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
            foreach($a as $i=>$e)
            {
                if($i%2==0)
                {
                    //Texte
                    if($this->HREF)
                        $this->PutLink($this->HREF,$e);
                    elseif($this->ALIGN=='center')
                        $this->Cell(0,5,$e,0,1,'C');
                    else
                        $this->Write(5,$e);
                }
                else
                {
                    //Balise
                    if($e[0]=='/')
                        $this->CloseTag(strtoupper(substr($e,1)));
                    else
                    {
                        //Extraction des attributs
                        $a2=explode(' ',$e);
                        $tag=strtoupper(array_shift($a2));
                        $prop=array();
                        foreach($a2 as $v)
                        {
                            if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                                $prop[strtoupper($a3[1])]=$a3[2];
                        }
                        $this->OpenTag($tag,$prop);
                    }
                }
            }
        }

        function OpenTag($tag,$prop)
        {
            //Balise ouvrante
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,true);
            if($tag=='A')
                $this->HREF=$prop['HREF'];
            if($tag=='BR')
                $this->Ln(5);
            if($tag=='P')
                $this->ALIGN=$prop['ALIGN'];
            if($tag=='HR')
            {
                if( !empty($prop['WIDTH']) )
                    $Width = $prop['WIDTH'];
                else
                    $Width = $this->w - $this->lMargin-$this->rMargin;
                $this->Ln(2);
                $x = $this->GetX();
                $y = $this->GetY();
                $this->SetLineWidth(0.4);
                $this->Line($x,$y,$x+$Width,$y);
                $this->SetLineWidth(0.2);
                $this->Ln(2);
            }
        }

        function CloseTag($tag)
        {
            //Balise fermante
            if($tag=='B' || $tag=='I' || $tag=='U')
                $this->SetStyle($tag,false);
            if($tag=='A')
                $this->HREF='';
            if($tag=='P')
                $this->ALIGN='';
        }

        function SetStyle($tag,$enable)
        {
            //Modifie le style et sélectionne la police correspondante
            $this->$tag+=($enable ? 1 : -1);
            $style='';
            foreach(array('B','I','U') as $s)
                if($this->$s>0)
                    $style.=$s;
            $this->SetFont('',$style);
        }

        function PutLink($URL,$txt)
        {
            //Place un hyperlien
            $this->SetTextColor(0,0,255);
            $this->SetStyle('U',true);
            $this->Write(5,$txt,$URL);
            $this->SetStyle('U',false);
            $this->SetTextColor(0);
        }
    }

    
    $date = new Datetime();
    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->SetAutoPageBreak(true, 10);
    $pdf->AddFont('Ubuntu', '', 'Ubuntu-Regular.php');
    $pdf->AddFont('OpenSans', '', 'OpenSans.php');
    $pdf->AddPage();
    $pdf->SetTitle(utf8_decode('Rapport périodique'));
    $pdf->Image('../icon/icon.png',10,6,10,7);
    $pdf->SetFont('OpenSans','',7);
    $pdf->Cell(0, 0, utf8_decode('Rapport périodique'), 0, 0, 'C');
    $pdf->Cell(0, 0, $date->format('Y-m-d H:i:s'), 0, 0, 'R');
    $pdf->Ln(10);
    $pdf->SetFont('Ubuntu','',10);
    $pdf->Rect(45, 20, 120, 10);
    $pdf->Cell(0, 10, utf8_decode("RAPPORT DE LA PERIODE DU « $firstDate » AU « $lastDate »"), '', 0, 'C');
    $pdf->Ln(20);
    $pdf->SetFont('OpenSans','',10);

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
    $query = $pdo->prepare("SELECT mail_object, COUNT(mail_object) as total FROM `mails` WHERE mail_date_received BETWEEN '$firstDate' AND '$lastDate' GROUP BY mail_object ORDER BY total DESC");
    $query->execute();
    $total_by_object = $query->fetchAll(PDO::FETCH_ASSOC);

    // groupement par expéditeur
    $query = $pdo->prepare("SELECT mail_corresponding, COUNT(*) as total FROM `mails` WHERE mail_date_received BETWEEN '$firstDate' AND '$lastDate' GROUP BY mail_corresponding ORDER BY total DESC");
    $query->execute();
    $total_by_corresponding = $query->fetchAll(PDO::FETCH_ASSOC);

    // groupement par direction
    $query = $pdo->prepare("SELECT dir_label, COUNT(*) as total FROM `mails` INNER JOIN `directions` ON mails.id_direction = directions.dir_id WHERE mail_date_received BETWEEN '$firstDate' AND '$lastDate' GROUP BY dir_label ORDER BY total DESC");
    $query->execute();
    $total_by_direction = $query->fetchAll(PDO::FETCH_ASSOC);

    $pdf->MultiCell(0, 7, utf8_decode("\t\tDurant la période du « $firstDate » au « $lastDate », le service courrier a enregistré « $total_mail » courriers dont « $mail_in_waiting » en attente de traitement jusqu'à la date d'aujourd'hui et « $mail_dg » adressés à la Direction Générale. Avec « " . $total_by_object[0]['total'] . " » courriers dénombrés, les courriers ayant pour objet : « " . $total_by_object[0]['mail_object'] . " » étaient les plus soumis pour traitement et avec « " . $total_by_corresponding[0]['total'] . " » courriers dénombrés, « " . $total_by_corresponding[0]['mail_corresponding'] . " » est celle qui compte le plus de courriers adressés à la Radiodiffusion Télévision Ivoirienne durant cette période. Durant cette même période, la « " . $total_by_direction[0]['dir_label'] . " » a reçu « " . $total_by_direction[0]['total'] . " » courriers pour traitement."), 0, 'J');
    $pdf->Ln(7);

    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0, 102, 204);
    $pdf->Cell(0, 10, "RECAPITULATIF", '', 0, 'L');
    $pdf->Ln(7);

    $pdf->SetFont('OpenSans','',10);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Cell(0, 10, utf8_decode("\t\t\tNombre total de courriers : « $total_mail »"), '', 0, 'L');
    $pdf->Ln(7);
    $pdf->Cell(0, 10, utf8_decode("\t\t\tNombre de courriers en attente : « $mail_in_waiting »"), '', 0, 'L');
    $pdf->Ln(10);

    // affichage des statistiques des courriers par direction dans un tableau
    $pdf->SetFont('Ubuntu','',10);
    $pdf->SetTextColor(255, 102, 102);
    $pdf->Cell(0, 10, "~ Statistiques des courriers par direction ~", '', 0, 'C');
    $pdf->Ln(10);

    
    $pdf->SetFont('OpenSans','',8);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(160, 7, utf8_decode("Libéllé de la direction"), '', 0, 'L', true);
    $pdf->Cell(15, 7, utf8_decode("Total"), '', 0, 'C', true);
    $pdf->Cell(15, 7, utf8_decode("%"), '', 0, 'R', true);
    $pdf->SetFont('OpenSans','',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln();
    

    for ($i=0; $i < count($total_by_direction); $i++) { 
        if ($i%2 == 0) {
            $pdf->SetFillColor(204, 229, 255);
        }
        else {
            $pdf->SetFillColor(255, 255, 255);
        }
        $pdf->Cell(160, 7, utf8_decode($total_by_direction[$i]['dir_label']), '', 0, 'L', true);
        $pdf->Cell(15, 7, utf8_decode($total_by_direction[$i]['total']), '', 0, 'C', true);
        $pdf->Cell(15, 7, utf8_decode(round((($total_by_direction[$i]['total'] / $total_mail) * 100), 2)." %"), '', 0, 'R', true);
        $pdf->Ln();
    }

    $pdf->Ln(10);

    // affichage des statistiques des courriers par expéditeur dans un tableau
    $pdf->SetFont('Ubuntu','',10);
    $pdf->SetFillColor(0, 0, 0);
    $pdf->SetTextColor(255, 102, 102);
    $pdf->Cell(0, 10, utf8_decode("~ Statistiques des courriers par expéditeur ~"), '', 0, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('OpenSans','',8);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(160, 7, utf8_decode("Nom de l'expéditeur"), '', 0, 'L', true);
    $pdf->Cell(15, 7, utf8_decode("Total"), '', 0, 'C', true);
    $pdf->Cell(15, 7, utf8_decode("%"), '', 0, 'R', true);
    $pdf->SetFont('OpenSans','',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln();
    

    for ($i=0; $i < count($total_by_corresponding); $i++) { 
        if ($i%2 == 0) {
            $pdf->SetFillColor(204, 229, 255);
        }
        else {
            $pdf->SetFillColor(255, 255, 255);
        }
        $pdf->Cell(160, 7, utf8_decode($total_by_corresponding[$i]['mail_corresponding']), '', 0, 'L', true);
        $pdf->Cell(15, 7, utf8_decode($total_by_corresponding[$i]['total']), '', 0, 'C', true);
        $pdf->Cell(15, 7, utf8_decode(round((($total_by_corresponding[$i]['total'] / $total_mail) * 100), 2)." %"), '', 0, 'R', true);
        $pdf->Ln();
    }

    $pdf->Ln(10);

    // affichage des statistiques des courriers par nature de la demande dans un tableau
    $pdf->SetFont('Ubuntu','',10);
    $pdf->SetTextColor(255, 102, 102);
    $pdf->Cell(0, 10, utf8_decode("~ Statistiques des courriers par nature de la demande ~"), '', 0, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('OpenSans','',8);
    $pdf->SetFillColor(0, 0, 0);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(160, 7, utf8_decode("Nature de la demande"), '', 0, 'L', true);
    $pdf->Cell(15, 7, utf8_decode("Total"), '', 0, 'C', true);
    $pdf->Cell(15, 7, utf8_decode("%"), '', 0, 'R', true);
    $pdf->SetFont('OpenSans','',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln();
    

    for ($i=0; $i < count($total_by_object); $i++) { 
        if ($i%2 == 0) {
            $pdf->SetFillColor(204, 229, 255);
        }
        else {
            $pdf->SetFillColor(255, 255, 255);
        }
        $pdf->Cell(160, 7, utf8_decode($total_by_object[$i]['mail_object']), '', 0, 'L', true);
        $pdf->Cell(15, 7, utf8_decode($total_by_object[$i]['total']), '', 0, 'C', true);
        $pdf->Cell(15, 7, utf8_decode(round((($total_by_object[$i]['total'] / $total_mail) * 100), 2)." %"), '', 0, 'R', true);
        $pdf->Ln();
    }

    $pdf->Ln(10);

    // affichage des statistiques des courriers par nature de la demande dans un tableau
    $pdf->SetFont('Arial','B',10);
    $pdf->SetTextColor(0, 102, 204);
    $pdf->Cell(0, 10, utf8_decode("~ LISTE DES COURRIERS ~"), '', 0, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('OpenSans','',8);
    $pdf->SetFillColor(0, 0, 0);
    $pdf->SetTextColor(255, 255, 255);
    $pdf->Cell(20, 7, utf8_decode("N°"), '', 0, 'L', true);
    $pdf->Cell(30, 7, utf8_decode("Expéditeur"), '', 0, 'L', true);
    $pdf->Cell(30, 7, utf8_decode("Date de réception"), '', 0, 'L', true);
    $pdf->Cell(90, 7, utf8_decode("Objet"), '', 0, 'L', true);
    $pdf->Cell(20, 7, utf8_decode("Destinataire"), '', 0, 'L', true);
    $pdf->SetFont('OpenSans','',8);
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln();

    $query = $pdo->prepare("SELECT * FROM `mails` INNER JOIN `directions` ON mails.id_direction = directions.dir_id WHERE mail_date_received BETWEEN '$firstDate' AND '$lastDate' ORDER BY id_register DESC");
    $query->execute();
    $mails = $query->fetchAll(PDO::FETCH_ASSOC);
    

    for ($i=0; $i < count($mails); $i++) {
        if ($mails[$i]['id_register'] == 1) {
            $pdf->SetFillColor(255, 255, 255);
        }
        else {
            $pdf->SetFillColor(204, 255, 204);
        }
        $pdf->Cell(20, 7, utf8_decode($mails[$i]['mail_ref']), 2, 0, 'L', true);
        $pdf->Cell(30, 7, utf8_decode($mails[$i]['mail_corresponding']), 2, 0, 'L', true);
        $pdf->Cell(30, 7, utf8_decode($mails[$i]['mail_date_received']), 2, 0, 'L', true);
        $pdf->Cell(90, 7, utf8_decode($mails[$i]['mail_object']), 2, 0, 'L', true);
        $pdf->Cell(20, 7, utf8_decode($mails[$i]['dir_sigle']), 2, 0, 'L', true);
        $pdf->Ln();
    }
    
    $pdf->Output();
?>

