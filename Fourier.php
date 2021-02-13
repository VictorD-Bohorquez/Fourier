<?php
#Autor: Victor Daniel Bohorquez Toribio
#Analisis de Algoritmos 3CV4

include ("jpgraph/src/jpgraph.php");
include ("jpgraph/src/jpgraph_line.php");

	$numero= readline("Ingresa tu muestra separando por comas cada elemento \n");
	$muestras= explode(",", $numero);
	$k=array();
	$ki=array();
	$raices=array();
	$filas=array();
	for($p=0;$p<=count($muestras)-1;$p++){
		for($q=0;$q<=count($muestras)-1;$q++){
			if($p==0){
				$filas[$q]=0;
			}
			else{
				if($p!=0 && $q==0){
					$filas[$q]=0;
				}
				if($p!=0 && $q!=0){
					if($q<=$p){
						$filas[$q]=((2*$p*$q*pi())/count($muestras));
					}
					else{
						$filas[$q]=0;
					}
				}	
			}
		}
		$raices[$p]=$filas;
	}

	for($indice=1;$indice<=count($muestras)-1;$indice++){
		$kaux=0;
		$kiaux=0;
		for($n=1; $n<=count($muestras)-1;$n++)	{
			if($n<=$indice){
				$kaux= $kaux + ($muestras[$n]*(cos($raices[$indice][$n])));
				$kiaux= $kiaux + ((-1)*($muestras[$n]*(sin($raices[$indice][$n]))));
			}
			else{
				$kaux= $kaux + ($muestras[$n]*(cos($raices[$n][$indice])));
				$kiaux= $kiaux + ((-1)*($muestras[$n]*(sin($raices[$n][$indice]))));
			}
		}
		$k[$indice]=$kaux+$muestras[0];
		$ki[$indice]=$kiaux+0;
	}
	$k[0]=array_sum($muestras);
	$ki[0]=0;
	for($i=0;$i<count($muestras);$i++){
		echo round($k[$i],2).",".round($ki[$i],2)."i"."\n";
	}
//Grafica del tiempo
$graph2 = new Graph(700,500,"auto");
$graph2->SetScale("linlin");
$graph2->img->SetAntiAliasing();
$graph2->xgrid->Show();
$lineplot2=new LinePlot($muestras);
$lineplot2->SetColor("green");
$lineplot2->SetWeight(2);
$lineplot2->SetLegend("Funcion");
$graph2->img->SetMargin(60,40,40,60);
$graph2->title->Set("Dominio del Tiempo");
$graph2->title->SetColor("red");
$graph2->xaxis->title->Set("Eje X"); 
$graph2->xaxis->title->SetColor("red"); 
$graph2->yaxis->title->Set("Eje Y");
$graph2->yaxis->title->SetColor("red"); 
$graph2->ygrid->SetFill(true,'#00FA9A@0.5','#00FA9A@0.5');
$graph2->Add($lineplot2);
$graph2->Stroke(_IMG_HANDLER);
$fileName2 = "Tiempo.png";
$graph2->img->Stream($fileName2);
//Grafica de la frecuencia
$graph = new Graph(700,500,"auto");
$graph->SetScale("linlin");
$graph->img->SetAntiAliasing();
$graph->xgrid->Show();
$lineplot=new LinePlot($ki,$k);
$lineplot->SetColor("green");
$lineplot->SetWeight(2);
$lineplot->SetLegend("Fourier");
$graph->img->SetMargin(60,40,40,60);
$graph->title->Set("Dominio de la Frecuencia");
$graph->title->SetColor("red");
$graph->xaxis->title->Set("Eje X");
$graph->xaxis->title->SetColor("red");
$graph->yaxis->title->Set("Eje i");
$graph->yaxis->title->SetColor("red");
$graph->ygrid->SetFill(true,'#EE82EE@0.5','#EE82EE@0.5');
$graph->Add($lineplot);
$graph->Stroke(_IMG_HANDLER);
$fileName = "Frecuencia.png";
$graph->img->Stream($fileName);
?>