<?php
namespace App\Helpers;

function monthToSpanish($x, $short = false ) 
{
	$meses = array("", "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	$x = (int)$x;
	
	if(!$short) return $meses[$x];
	else return substr($meses[$x], 0, 3);
}