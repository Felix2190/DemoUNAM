<?php

	#-----------------------------------------------------------------------------------------------------------------#
	#---------------------------------------Archivos necesarios Require Include---------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------#

	require_once(LIB_CONEXION);

	#-----------------------------------------------------------------------------------------------------------------#
	#--------------------------------------------Inicializacion de control--------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------#



	#-----------------------------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------#

	#-----------------------------------------------------------------------------------------------------------------#
	#----------------------------------------------------Funciones----------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------#
	function TildesHtml($cadena)
	{
		return str_replace(array("á","é","í","ó","ú","ñ","Á","É","Í","Ó","Ú","Ñ"),
				array("&aacute;","&eacute;","&iacute;","&oacute;","&uacute;","&ntilde;",
						"&Aacute;","&Eacute;","&Iacute;","&Oacute;","&Uacute;","&Ntilde;"), $cadena);
	}

	#-----------------------------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------#


	#-----------------------------------------------------------------------------------------------------------------#
	#---------------------------------------------------Seccion AJAX--------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------#

	$xajax=new xajax();
	
	function reiniciarTurnos()
	{
		
		global $objSession;
		global $dbLink;
		$r=new xajaxResponse();
		
		
		$r->mostrarAviso("Reiniciado");
		return $r;
		
	}
	
	$xajax->registerFunction("reiniciarTurnos");
	
	function actualizar($fIni,$fFin)
	{
		global $objSession;
		global $dbLink;
		$r=new xajaxResponse();
		
		
		/*Procesos cancelados*/
		$query="SELECT count(*) AS cuenta
			FROM turno T
			LEFT JOIN licencia L ON T.idLicencias=L.idLicencias
			WHERE T.idUbicacion=" . $objSession->getIdUbicacion()  . " AND ((DATE(T.fechaHoraCierre)>='" . $fIni . "' AND  DATE(T.fechaHoraCierre)<='" . $fFin . "' AND T.idLicencias<>0 AND L.estatus='baja') )";
		
		$result=mysqli_query($dbLink,$query)or die("Erorr en consulta 1");
		$row=mysqli_fetch_assoc($result);
		$canceladas=$row['cuenta'];
		
		
		$query="SELECT count(*) AS cuenta
			FROM turno T
			WHERE T.idUbicacion=" . $objSession->getIdUbicacion()  . " AND DATE(T.fechaHoraCreacion)>='" . $fIni . "' AND  DATE(T.fechaHoraCreacion)<='" . $fFin . "' AND T.idLicencias=0 AND DATE(T.fechaHoraCreacion)<CURDATE()";
		
		$result=mysqli_query($dbLink,$query)or die("Erorr en consulta 1.1");
		$row=mysqli_fetch_assoc($result);
		$canceladas+=$row['cuenta'];
		
		
		/*Procesos tramite*/
		$query="SELECT count(*) AS cuenta
			FROM turno T
			WHERE T.idUbicacion=" . $objSession->getIdUbicacion()  . " AND DATE(T.fechaHoraCreacion)=CURDATE() AND DATE(T.fechaHoraCreacion)>='" . $fIni . "' AND  DATE(T.fechaHoraCreacion)<='" . $fFin . "' AND T.idLicencias=0";
		
		$result=mysqli_query($dbLink,$query)or die("Erorr en consulta 2");
		$row=mysqli_fetch_assoc($result);
		$tramite=$row['cuenta'];
		
		
		/*Procesos atendidos*/
		$query="SELECT count(*) AS cuenta
			FROM turno T
			INNER JOIN licencia L ON T.idLicencias=L.idLicencias
			WHERE T.idUbicacion=" . $objSession->getIdUbicacion()  . " AND DATE(T.fechaHoraCierre)>='" . $fIni . "' AND  DATE(T.fechaHoraCierre)<='" . $fFin . "' AND T.idLicencias<>0 AND L.estatus='activo'";
		
		$result=mysqli_query($dbLink,$query)or die("Erorr en consulta 3");
		$row=mysqli_fetch_assoc($result);
		$atendido=$row['cuenta'];
		
		$r->assign("lblAtendidos", "innerHTML", $atendido);
		$r->assign("lblProceso", "innerHTML", $tramite);
		$r->assign("lblCancelados", "innerHTML", $canceladas);
		
		
		$r->ocultarMensaje();
		
		return $r;
	}
	$xajax->registerFunction("actualizar");

	

	$xajax->processRequest();

	#-----------------------------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------#

	#-----------------------------------------------------------------------------------------------------------------#
	#-------------------------------------------Inicializacion de variables-------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------#
	
	
	
	$fecha=getdate();
	$a=$fecha['year'];
	$m=$fecha['mon']<0?"0" . $fecha['mon']:$fecha['mon'];
	$diaActual=$fecha['mday']<0?"0" . $fecha['mday']:$fecha['mday'];
	$cantidadDias=$fecha["mday"]-1;
	
	
	$strFilas='';
	global $objSession;
	
	$query="SELECT COUNT(*) Total, UPPER(E.Descripcion) Descripcion , UPPER(U.nombre) nombre
			FROM `turno` AS T
			INNER JOIN `etapa` AS E ON E.idEtapa=T.idEtapa
			LEFT JOIN persona as P ON P.idPersona=T.idPersona
			LEFT JOIN tipolicencia AS tp ON tp.idTipoLicencia=T.idTipoLicencia
			LEFT JOIN ubicacion as U ON U.idUbicacion=T.idUbicacion
			WHERE T.idUbicacion=".$objSession->getIdUbicacion()." GROUP BY E.Descripcion ORDER BY 1 DESC ";
	
	/**SELECT
	(SELECT COUNT(*) AS 5min
			FROM `turno`
			WHERE  TIMESTAMPDIFF(MINUTE,fechahora,now()) BETWEEN 0 AND 15) AS Hasta15,
			(SELECT COUNT(*) AS 10min
					FROM `turno`
					WHERE  TIMESTAMPDIFF(MINUTE,fechahora,now()) BETWEEN 16 AND 30) AS Hasta30,
					(SELECT COUNT(*) AS 20min
							FROM `turno`
							WHERE  TIMESTAMPDIFF(MINUTE,fechahora,now()) BETWEEN 31 AND 45) AS Hast45,
							(SELECT COUNT(*) AS 30min
									FROM `turno`
									WHERE  TIMESTAMPDIFF(MINUTE,fechahora,now()) >=46) AS Mas45***/
	$result=mysqli_query($dbLink, $query);
	if($result->num_rows == 0)
		$strFilas.='<tr><td colspan="3"> Sin turnos</td></tr>';
	else {
		while($r=mysqli_fetch_assoc($result))
		{
			
			$strFilas.='<tr>
								<td>' . $r['Total'] . '</td>
								<td>' . TildesHtml( $r['Descripcion']) . '</td>
								<td>' . $r['nombre'] . '</td>
								
								
							</tr>';
		}
	}
	
	$strTiempo='';
	$query="SELECT (SELECT COUNT(*) AS 5min FROM `turno` WHERE TIMESTAMPDIFF(MINUTE,fechahora,now()) BETWEEN 0 AND 15 AND idUbicacion=".$objSession->getIdUbicacion().") AS Hasta15,
			(SELECT COUNT(*) AS 10min FROM `turno` WHERE TIMESTAMPDIFF(MINUTE,fechahora,now()) BETWEEN 16 AND 30 AND idUbicacion=".$objSession->getIdUbicacion().") AS Hasta30,
			(SELECT COUNT(*) AS 20min FROM `turno` WHERE TIMESTAMPDIFF(MINUTE,fechahora,now()) BETWEEN 31 AND 45 AND idUbicacion=".$objSession->getIdUbicacion().") AS Hast45,
			(SELECT COUNT(*) AS 30min FROM `turno` WHERE TIMESTAMPDIFF(MINUTE,fechahora,now()) >=46) AS Mas45";
	$result=mysqli_query($dbLink, $query);
	if($result->num_rows == 0)
		$strTiempo.='<tr><td colspan="4"> Sin turnos</td></tr>';
	else{
		while($r=mysqli_fetch_assoc($result))
		{
			
				$strTiempo.='<tr>
								<td>' . $r['Hasta15'] . '</td>
								<td>' . $r['Hasta30'] . '</td>
								<td>' . $r['Hast45'] . '</td>
								<td>' . $r['Mas45'] . '</td>
					
							</tr>';
		}
	}
	#-----------------------------------------------------------------------------------------------------------------#
	#------------------------------------- JavaScript array initialization     ---------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------#
	$_JAVASCRIPT_OUT="";

	#-----------------------------------------------------------------------------------------------------------------#
	#---------------------------------------------Translate on JavaScript---------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------#


	if(!isset($_JAVASCRIPT_OUT))
		$_JAVASCRIPT_OUT="";


