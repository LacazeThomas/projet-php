<?php
require('fpdf181/fpdf.php');
class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;
function Header (){
			//Defini la police du header
			$this->SetFont("Arial","",10);
			//Defini les couleur du headers
			$this->SetFillColor(0,0,255);
			//affiche le logo de l'uvsq 
			$this->Image('uvsq.jpg',162,5,35);
			//Perme d'afficher et possitioner la date en temps réele
			$this->Cell(2,10,date("d/m/Y"),0,0);
			//Saut de ligne
			$this->Cell(100,10,'',0,1); 
			$this->Cell(100,10,'',0,1); 
			//On redefini la taille de la police
			$this->SetFont("Arial","b",13);
			//On ecrit le titre et on le met en gras et en encadre
			$this->Cell(185,10,utf8_decode('Tableau récapitulatif de l\'avis des étudiants'),1,1,'C');
			$this->Cell(100,10,'',0,1); 
		}
		
function Footer (){
			//Defnie la police et la positions
			
			$this->SetFont("Arial","b",10);
			$this->SetY(270);
			$fill = 1;
			
			
			//Permet dafficher le numeros de table en focntions de la pages et le nombre de feuille totalq
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}','B',0,'C');
			//On ecrit nos noms et on définis la police 
			$this->SetFont("Arial","",7);
			$this->Write(10, 'Thomas Lacaze, Jibril Zioui, Aurelien Brunet, Steven Kerautret, Noe Meric de Bellefon, Benjamin Ngogo, Projet PHP 2018 ');

			
			
		}
function SetWidths($w)
{
	//Tableau des largeurs de colonnes
	$this->widths=$w;
}
function SetAligns($a)
{
	//Tableau des alignements de colonnes
	$this->aligns=$a;
}
function Row2($data)
{
	//Calcule la hauteur de la ligne
	
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Effectue un saut de page si n�cessaire
	$this->CheckPageBreak($h);
	//Dessine les cellules
	for($i=0;$i<count($data);$i++)
	{
		
		$this->SetFillColor('144', '146', '150');
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
		//Sauve la position courante
		$x=$this->GetX();
		$y=$this->GetY();
		//Dessine le cadre
		$this->Rect($x,$y,$w,$h);
		//Imprime le texte
		$this->MultiCell($w,5,utf8_decode($data[$i]),1,$a,1);
		//Repositionne � droite
		$this->SetXY($x+$w,$y);
	}
	//Va � la ligne
	$this->Ln($h);
}
function Row($data)
{
	//Calcule la hauteur de la ligne
	
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Effectue un saut de page si n�cessaire
	$this->CheckPageBreak($h);
	//Dessine les cellules
	$compteur = 0;
	for($i=0;$i<count($data);$i++)
	{
		if($compteur==0)
		//ici sont instanciers les cases de couleurs gris : ces a dire les cases exterieurs
		$this->SetFillColor('144', '146', '150');
		else
		//ici sont instanciers les cases de couleurs blanches : ces a dire les cases intérieurs
		$this->SetFillColor('255', '255', '255');
		
		//On aligne les case du tableau
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
		//Sauve la position courante
		$x=$this->GetX();
		$y=$this->GetY();
		//Dessine le cadre
		$this->Rect($x,$y,$w,$h);
		//Imprime le texte
		$this->MultiCell($w,5,utf8_decode($data[$i]),1,$a,1);
		//Repositionne � droite
		$this->SetXY($x+$w,$y);
		$compteur = $compteur + 1;
	}
	//Va � la ligne
	$this->Ln($h);
}
function CheckPageBreak($h)
{
	//Si la hauteur h provoque un d�bordement, saut de page manuel
	if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
}
function NbLines($w,$txt)
{
	//Calcule le nombre de lignes qu'occupe un MultiCell de largeur w
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}
}
?>