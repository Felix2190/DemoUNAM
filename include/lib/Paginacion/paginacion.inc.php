<?php

function calculaPaginacion($pantalla,$total,$cantidadPantalla)
{
	$pantalla-=1;
	return paginar($pantalla,$total,$cantidadPantalla,13);
}

function paginar($paginaActual,$totalRegistros,$porPagina=10,$Espacios=10)
{
	$Variables=$Espacios-2;
	$Desplazamiento=floor($Variables/2);
	$totalPaginas=ceil($totalRegistros/$porPagina);
	$Enlaces=array();
	if($totalPaginas<=$Espacios)
	{
		for($i=1;$i<=$totalPaginas;$i++)
		{
		if($paginaActual+1==$i)
			$Enlaces[]='<span class="showpagePoint"><a onclick="javascript:return false;" href="#" class="">' . $i . '</a></span>';
			else
				$Enlaces[]='<span class="showpageNum"><a onclick="javascript:verPagina_(' . $i . ');return false;" href="#" class="">' . $i . '</a></span>';
		}
	}
	else
	{
		if($paginaActual==0)
			$Enlaces[0]='<span class="showpagePoint"><a onclick="javascript:return false;" class="" href="#">1</a></span>';
			else
		$Enlaces[0]='<span class="showpageNum"><a onclick="javascript:verPagina_(1);return false;" href="#" class="">1</a></span>';
		$x=$paginaActual;
		if($x-$Desplazamiento<=1)
			$y=2;
			else
		{
		if($x+$Desplazamiento>=$totalPaginas)
			$y=$totalPaginas-($Variables);
			else
			$y=$x-$Desplazamiento;
		}
		for($i=1;$i<$Espacios-1;$i++)
		{
		if($paginaActual+1==$y)
			$aux='<span class="showpagePoint"><a onclick="javascript:return false;" href="#" class="">' . $y . '</a></span>';
			else
			$aux='<span class="showpageNum"><a onclick="javascript:verPagina_(' . $y . ');return false;" href="#" class="">' . $y . '</a></span>';
			$Enlaces[$i]=$aux;
			$y++;
		}
		if($paginaActual+1==$totalPaginas)
			$aux='<span class="showpagePoint"><a onclick="javascript:return false;" href="#" class="">' . $totalPaginas . '</a></span>';
		else
			$aux='<span class="showpageNum"><a onclick="javascript:verPagina_(' . $totalPaginas . ');return false;" href="#" class="">' . $totalPaginas . '</a></span>';
			$Enlaces[$Espacios-1]=$aux;
	}
	return implode("",$Enlaces);
}
