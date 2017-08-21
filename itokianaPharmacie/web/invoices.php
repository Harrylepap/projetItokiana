<?php
header('Content-Type: text/html; charset=UTF-8');
date_default_timezone_set("Indian/Antananarivo");
include('fpdf/fpdf.php');
include('connexion.php');

function dateToFr($data){
  $string = "";
  $dt = array();
  $date = array();
  $time = array();
  $month = array("Jan","Fev","Mar","Avr","Mai","Jun",
                "Jul","Aou","Sep","Oct","Nov","Dec");


  $dt = explode(" ",$data);
  $date = explode("-",@$dt[0]);
  $time = explode(":",@$dt[1]);

  foreach ($month as $key => $value) {
    if(@$date[1] == ($key+1)){
      $string = @$date[2]." ".$value." ".@$date[0]." à ".@$time[0]."h".@$time[1]."min";
    }
  }


  return $string;
}

/*
* Récupération dernière ligne facture
*/
$query = "SELECT vente.nombre,vente.prixUnitaire,vente.personne,medicament.libelle,utilisateur.username 
            FROM vente 
            INNER JOIN medicament ON medicament_id = medicament.id 
            INNER JOIN utilisateur ON utilisateur_id = utilisateur.id 
            WHERE daty = (
              SELECT daty 
              FROM vente 
              GROUP BY daty 
              ORDER BY id DESC 
              LIMIT 1)";



$resultset = $database->prepare($query);

$resultset->execute();

$ligne_factures = $resultset->fetchAll();

/*
* Comptage nombre facture 
*/
$query = "SELECT count(id) FROM vente GROUP BY daty";

$resultset = $database->prepare($query);

$resultset->execute();

$nombre_facture = $resultset->fetchAll();

$nombre_facture = count($nombre_facture) + 1;


function generer_facture ($ligne_factures,$numero_facture) {

    $acheteur = 'Client particulier';
    if(!empty(@$ligne_factures[0]['personne'])) {
      $acheteur = @$ligne_factures[0]['personne'];  
    }

    $vendeur = 'Pharmacienne';
    if(!empty(@$ligne_factures[0]['username'])) {
      $vendeur = @$ligne_factures[0]['username'];  
    }

    define('FPDF_FONTPATH','fpdf/font/');

    //class pdf extends FPDF{}
    $pdf=new FPDF();
    $pdf->AddPage();

    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Arial','',9);

    $pdf->Ln(0);
    $pdf->cell(75,5,'Pharmacie Itokiana',1,0,'C',1);

    $pdf->SetFont('Arial','',6);
    $pdf->Ln(4);
    $pdf->cell(80,5,'020 22 322 64',0,0,'C',1); //VO8C Manakambahiny
    $pdf->Ln(3);
    $pdf->cell(80,5,'Antananarivo Madagascar',0,0,'C',0);
    $pdf->Image("logo.png",15,7,10,10);
    



    /* En - tête de la facture */
    $pdf->Ln(8);
    $pdf->SetFillColor(255,255,255);
    $pdf->SetFont('Arial','',10);
    $pdf->cell(75,5,iconv('UTF-8','ISO-8859-2','FACTURE N° '.$numero_facture),1,0,'C',1);


    $pdf->SetFont('Arial','',7);
    $pdf->SetFillColor(255,255,255);


    $date = dateToFr(date('Y-m-d h:i:s'));
    $heure = date('H:i:s');
    $date = utf8_decode($date);

    $pdf->Ln(8);
    $pdf->cell(30,5,'Date du : ',1,0,'L');
    $pdf->cell(45,5,substr($date, 0,11).' / '.$heure,1,0,'L');

    $pdf->Ln();
    $pdf->cell(30,5,'Agent de comptoir : ',1,0,'L');
    $pdf->cell(45,5,$vendeur,1,0,'L');

    $pdf->Ln();
    $pdf->cell(30,5,utf8_decode('Doit à : '),1,0,'L');
    $pdf->cell(45,5,$acheteur,1,1,'L');

    $pdf->Ln(4);
    $pdf->SetFont('Arial','',9);

    $pdf->cell(45,5,utf8_decode('Description'),1,0,'L');
    $pdf->cell(30,5,utf8_decode('Montant total'),1,0,'C');
    


    $pdf->SetFont('Arial','',6);
    $montant_total = 0;

    foreach($ligne_factures as $ligne_facture) {
      //$pdf->cell(25,5,utf8_decode($value['code']),1,0,'C');
      //$pdf->cell(70,5,utf8_decode($ligne_facture[''],0,30)),1,0,'L');

      if(!empty($ligne_facture['nombre'])){
        $pdf->Ln();
        $pdf->cell(45,5,$ligne_facture['nombre'].' x '.$ligne_facture['libelle'],1,0,'L');
        $pdf->cell(30,5,number_format($ligne_facture['nombre']*$ligne_facture['prixUnitaire'], 2, ',', ' '),1,0,'R');

        $montant_total += $ligne_facture['prixUnitaire'] * $ligne_facture['nombre'];  
      }    
    }
    

    $pdf->Ln(3);

    $pdf->Ln();
    $pdf->SetFont('Arial','B',7);
    $pdf->cell(45,5,utf8_decode('Net à Payer'),1,0,'L');
    $pdf->cell(30,5,number_format($montant_total, 2, ',', ' '),1,1,'R');

    $pdf->SetFont('Arial','',5);
    $pdf->Ln(1);
    $pdf->cell(80,5,'www.pharmacie-itokiana.mg',0,0,'L',1); //VO8C Manakambahiny

    //$pdf->Ln(3);
    //$ligne_depart=$pdf->GetY();
    //$pdf->SetXY(125,$ligne_depart);
    

    //$pdf->ln(5);
    //$pdf->cell(-2);
    //$pdf->MultiCell(195, 5,utf8_decode("Arrêtée la présente facture à la somme de :") , false, 'R', 1, 0, '', '', true);
    //$pdf->SetFont('Arial','B',11);
    //$pdf->MultiCell(195, 5, '44500 Ariary', false, 'R', 1, 0, '', '', true);


    //$pdf->SetFont('Arial','B',12);
    //$pdf->Text(20,240,utf8_decode('Responsable'));
    //$pdf->Text(175,240,utf8_decode('Client'));

    $file_name = 'documents/facture_n '.substr($numero_facture,0,5).'.pdf';

    $pdf->Output($file_name,'F');

    return $file_name;

}



$new_location = generer_facture($ligne_factures,$nombre_facture);

header('location:'.$new_location);