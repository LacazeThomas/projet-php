<?php
session_start();
require 'mc_table.php';

$pdf = new PDF_MC_Table();
$pdf->AliasNbPages(); // affiche le nombre de page sous le "/"
$pdf->AddPage();
$pdf->SetFont('Arial', '', 11);
//Table de 20 lignes et 4 colonnes
$pdf->SetWidths(array(32, 36, 25, 21, 21, 28, 21));

srand(microtime() * 1000000);
$first_line = true;
foreach ($_SESSION["table_rep"] as $row) {

    if ($first_line == true) {
		$pdf->Row2($row);
        $first_line = false;
    } else {
        $pdf->Row($row);
    }
}

$pdf->Cell(100,10,'',0,1); 
$pdf->Cell(100,10,'',0,1); 
$pdf->SetFont("Arial","b",13);
$pdf->Cell(185,10,utf8_decode('Statistiques'),1,1,'C');
$pdf->Cell(100,10,'',0,1); 

$pdf->SetFont('Arial', '', 11);
$first_line = true;
foreach ($_SESSION["table_stat"] as $row) {

    if ($first_line == true) {
		$pdf->Row2($row);
        $first_line = false;
    } else {
        $pdf->Row($row);
    }
}


$pdf->Output();
