<?php
session_start();
require('mc_table.php');

$pdf=new PDF_MC_Table();
$pdf->AliasNbPages(); // affiche le nombre de page sous le "/"
$pdf->AddPage();
$pdf->SetFont('Arial','',11);
//Table de 20 lignes et 4 colonnes
$pdf->SetWidths(array(23,23,23,23,23,23,23,23));

//srand(microtime()*1000000);
$compteur = 1;
foreach($_SESSION["table"] as $row){
	
	if ($compteur == 1)
	{
	$pdf->SetFillColor('239', '125', '28');
	$pdf->Row($row);
	$compteur = $compteur + 1;
	}
	else
	{
	$pdf->SetFillColor('2', '255', '255');
	$pdf->Row($row);
	$compteur = $compteur + 1;
	}
}

$pdf->Output();
?>
