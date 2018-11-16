<?php
session_start();
require('mc_table.php');
require('../../header.php');


$pdf=new PDF_MC_Table();
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
//Table de 20 lignes et 4 colonnes
$pdf->SetWidths(array(30,30,30,30,30,30));
srand(microtime()*1000000);
foreach($_SESSION["table"] as $row){
    $pdf->Row($row);
}
    
$pdf->Output();
?>