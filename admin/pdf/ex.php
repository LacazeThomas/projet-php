<?php
require('mc_table.php');

function GenererMot()
{
    //Renvoie un mot aléatoire
    $nb=rand(3,10);
    $mot='';
    for($i=1;$i<=$nb;$i++)
        $mot.=chr(rand(ord('a'),ord('z')));
    return $mot;
}

function GenererPhrase()
{
    //Renvoie une phrase aléatoire
    $nb=rand(1,10);
    $p='';
    for($i=1;$i<=$nb;$i++)
        $p.=GenererMot().' ';
    return substr($p,0,-1);
}

$pdf=new PDF_MC_Table();
$pdf->AddPage();
$pdf->SetFont('Arial','',14);
//Table de 20 lignes et 4 colonnes
$pdf->SetWidths(array(30,50,30,40));
srand(microtime()*1000000);
for($i=0;$i<20;$i++)
    $pdf->Row(array(GenererPhrase(),GenererPhrase(),GenererPhrase(),GenererPhrase()));
$pdf->Output();
?>