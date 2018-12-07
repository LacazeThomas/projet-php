<?php
session_start();
require 'mc_table.php';

$pdf = new PDF_MC_Table();
$pdf->AliasNbPages(); // affiche le nombre de page sous le "/"
$pdf->AddPage();
$pdf->SetFont('Arial', '', 11);
//Table de 20 lignes et 4 colonnes
$pdf->SetWidths(array(32, 36, 25, 21, 21, 28, 21));

//srand(microtime() * 1000000);
$first_line = true;
//On rentre dans la premieres boucle d'affichage qui affiche le tableau récapitulatif 
//des etudiants
//Il est sépare en deux partie pour pouvoir appliquer la couleurs sur la premiers 
//ligne et sur la premiers collones 
//Car sinon la couleur va remplir tout le tableau ou bien une collone sur deux 
//Car cest la dernier couleur qui est prioritaire et ainsi efface l'ancienne
//En effets la creations du tableau se fait dans le fichier index.php en lignes
//tandis que dans le MC tables il se fait en collones

//Se tableau s'acctualise en fonctions des notes grace a un tableau de sessions

foreach ($_SESSION["table_rep"] as $row) {

    if ($first_line == true) {
		//Creer et affiche la premiers ligne de notre tableau
		$pdf->Row2($row);
		//permet de sortir de la conditions et donc de ne plus mettre de couleurs
        $first_line = false;
    } else {
		//Affiche les cinsq autre ligne 
		// math,anglais,programtions,algo,eco
		//grace a la fonction row
        $pdf->Row($row);
    }
}
//on creer des retour a la ligne
$pdf->Cell(100,10,'',0,1); 
$pdf->Cell(100,10,'',0,1); 
//On parametre la police pour notre titre statistique
$pdf->SetFont("Arial","b",13);
$pdf->Cell(185,10,utf8_decode('Statistiques'),1,1,'C');
$pdf->Cell(100,10,'',0,1); 
//On parametre la police pour notre tableau des statisqtique
$pdf->SetFont('Arial', '', 11);
$first_line = true;

//On utilise encore une boucle for et une conditions pour pouvoir appliquer
//la couleur a a premier ligne et premier collones meme problematique que la boucle précedentes
foreach ($_SESSION["table_stat"] as $row) {

    if ($first_line == true) {
		$pdf->Row2($row);
        $first_line = false;
    } else {
        $pdf->Row($row);
    }
}
//Ici on resaute des lignes
$pdf->Cell(100,10,'',0,1); 
$pdf->Cell(100,10,'',0,1); 
//On colorie le tire en gras ,encadrer et de taille 13 avec la police Arial
$pdf->SetFont("Arial","b",13);
$pdf->Cell(185,10,utf8_decode('Barème'),1,1,'C');
$pdf->Cell(100,10,'',0,1); 

//Creeations "tableau" a l'aide de ligne tout simpls les une apres les autre
$pdf->SetFont('Arial', '', 11);
$pdf->Row(array("1","Très mécontent"));
$pdf->Row(array("2","Mécontent"));
$pdf->Row(array("3","Moyen"));
$pdf->Row(array("4","Satisfait"));
$pdf->Row(array("5","Très satisfait"));

//on quitte la fonction pdf

$pdf->Output();