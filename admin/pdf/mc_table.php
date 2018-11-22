<?php
require('fpdf181/fpdf.php');

class PDF_MC_Table extends FPDF
{
var $widths;
var $aligns;

function Header (){
			$this->SetFont("Arial","b",15);
			$this->Image('uvsq.jpg',10,10,35);
			$this->Cell(100,10,'',0,1); 
			$this->Cell(100,10,'',0,1); 
			$this->Cell(185,10,'Tableau recapitulatif l\'avis des '.utf8_decode(é).'tudiants',1,1,'C');
			$this->Cell(100,10,'Mise '.utf8_decode(à).' jour le '.date("d/m/Y"),0,1); 

		}
		
function Footer (){
			$this->SetFont("Arial","b",10);
			$this->SetY(270);
			$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}','B',0,'C');
			
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
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Sauve la position courante
		$x=$this->GetX();
		$y=$this->GetY();
		//Dessine le cadre
		$this->Rect($x,$y,$w,$h);
		//Imprime le texte
		$this->MultiCell($w,5,utf8_decode($data[$i]),0,$a);
		//Repositionne � droite
		$this->SetXY($x+$w,$y);
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