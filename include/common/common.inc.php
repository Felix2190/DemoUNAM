<?php
	session_start();

	date_default_timezone_set('America/Mexico_City');

	if(!file_exists(BASE_INCLUDE . "conf/constantes.php"))
	{
		die("El constantes no existe");

	}




	require_once(BASE_INCLUDE . "conf/constantes.php");


	require_once(CLASS_COMUN);
	require_once(CLASS_SESSION);



	$objSession=new clsSession();

	#print_r($_REQUEST);

	if(isset($_revisarSiExisteSession)&&$_revisarSiExisteSession)
	{
		if(!isset($_SESSION['objSession']))
		{
			header("Location: index.php");
			die();
		}
		$objSession=unserialize($_SESSION['objSession']);

		if(!$objSession->isSessionActive())
		{
			unset($objSession);
			session_destroy();
			header("Location: index.php");
			die();
		}
		$objSession->updateTime();
		$_SESSION['objSession']=serialize($objSession);
	}

	//require_once(LIB_CONEXION);
	//require_once(LIB_CONEXION_INT);
	require_once(LIB_TRANSLATE);
	require_once(LIB_XAJAX);
	//require_once(LIB_UTILS);
	//require_once(LIB_IMAGE);
	require_once(LIB_EXCEPTION);

	//require_once(CLASS_COMUN);
	//require_once(CLASS_COMUN_CONSULTA);


	#-----------------------------------------------------------------------------------------------#
	#----------------Inicializo las conecciones a las BD necesarias, segun el Script----------------#
	#-----------------------------------------------------------------------------------------------#

	/*

	$_DB=new PDOConfig();

	if(isset($_USEDBINT))
		$_DBI=new PDOConfigIntegrantes();

	*/

	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------#


	#require_once $_SERVER['DOCUMENT_ROOT'] . '/redServer/protected/Configuracion/i18n/' . $_SESSION['lang'] . '.php';

	/*

	if(isset($__incluirPerfil))
	{
		require_once (FOLDER_MODEL_NEW . "/model.perfil.inc.php");
	}

	*/





	$pedazos=explode("/", $_SERVER['PHP_SELF']);
	$__FILE_NAME__=str_replace(array("/",".php"),"",$pedazos[count($pedazos)-1]);
	if(is_file(BASE_INCLUDE . "controler/" . $__FILE_NAME__ . ".inc.php"))
	{
		require_once(BASE_INCLUDE . "controler/" . $__FILE_NAME__ . ".inc.php");

	}



	if(!isset($_JAVASCRIPT_CSS))
		$_JAVASCRIPT_CSS="";

	if(isset($xajax))
		$_JAVASCRIPT_CSS.=$xajax->getJavascript("js/lib/");

	$_JAVASCRIPT_CSS.='<script type="text/javascript" src="' . URL_JAVASCRIPT . '../lib/common.js"></script>';

	if(isset($_JAVASCRIPT_OUT))
		$_JAVASCRIPT_CSS.='<script type="text/javascript">' . $_JAVASCRIPT_OUT . '</script>';

	/*
	if(isset($objSession)&&$objSession->ejecucionPendiente())
		$_JAVASCRIPT_CSS.='<script type="text/javascript">setTimeout(revisarPendientes,3000)</script>';
	*/

	
	if(is_file(FOLDER_JS . $__FILE_NAME__ . ".js"))
		$_JAVASCRIPT_CSS.='<script type="text/javascript" src="' . URL_JAVASCRIPT . $__FILE_NAME__ . '.js"></script>';
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

	/*------------------------------------------------------------------------------------------------------------------------------*/
	/*----------------------------------FUNCIONES PARA CREAR EL WIZARD Y LOS PASOS DE MENU LATERAL----------------------------------*/
	/*------------------------------------------------------------------------------------------------------------------------------*/
		
	
	/*
	 * Posibles Pasos: turno, tramite, pago, datos, documentos,verificacion, examen, impresion
	 * */
	function armarPasos($pasoActual="")
	{
		$Elementos=array("turno"=>array("Turno","fa-ticket"),
			"pago"=>array("Pago","fa-money"),
			"datos"=>array("Datos","fa-user"),
			"documentos"=>array("Documentos","fa-files-o"),
			"verificacion"=>array("Verificaci&oacute;n","fa-check"),
			"examen"=>array("Examen","fa-list-ol"),
			"impresion"=>array("Impresi&oacute;n","fa-print"));
	
		$htmlBotones='';
	
		$i=1;
		foreach($Elementos AS $paso=>$datos)
		{
			$htmlBotones.='
				<div class="" style="float:left;margin-right:20px;">
					<div  class="' . ($pasoActual==$paso?"text-success":"") . '" disabled>
						&gt; <i class="fa ' . $datos[1] . '" ' . ($pasoActual==$paso?'style="color:green"':"") . '"></i>
						' . $i . ".". $datos[0] . '
					</div>
				</div>
			';
			$i++;
		}
	
		$htmlBotones='
			<div class="" style="margin:5px">
				' . $htmlBotones . '
			<hr />
			</div>
		';
		return $htmlBotones;
	}
	
	function armarPasosContenido($pasoActual, $subseccion="")
	{
		$salida='';
		$TitulosVacios=array("turno"=>"Turno",
			"pago"=>"Pago",
			"datos"=>"Datos",
			"documentos"=>"Documentos",
			"verificacion"=>"Verificaci&oacute;n",
			"examen"=>"Examen",
			"impresion"=>"Impresi&oacute;n");
	
		$Elementos=array(
			"turno"=>array(""),
			"pago"=>array("resumen","impresion"),
			"datos"=>array("biograficos","domicilio","extra","contacto","huellas","iris"),
			"documentos"=>array(""),
			"verificacion"=>array("datos","firma"),
			"examen"=>array(""),
			"impresion"=>array("impresion","verificacion","activacion"));
		$Titulos=array(
			"turno"=>array(""),
			"pago"=>array("resumen"=>"Resumen","impresion"=>"Impresi&oacute;n Recibo"),
			"datos"=>array("biograficos"=>"Biogr&aacute;ficos","domicilio"=>"Domicilio","huellas"=>"Huellas","iris"=>"Iris","extra"=>"Datos Extra","contacto"=>"Datos de Contacto"),
			"documentos"=>array(""),
			"verificacion"=>array("datos"=>"Verificaci&oacute;n de Datos","firma"=>"Firma"),
			"examen"=>array(""),
			"impresion"=>array("impresion"=>"Impresi&oacute;n","verificacion"=>"Verificaci&oacute;n","activacion"=>"Activaci&oacute;n"));
	
	
		$i=1;
		$I=0;
		foreach($Elementos AS $k=>$datos)
		{
			if($k==$pasoActual)
			{
				$I=$i;
				break;
			}
			$i++;
		}
	
		$Elementos=$Elementos[$pasoActual];
		if($subseccion=="")
		{
			$subseccion=$Elementos[0];
		}
		$encontrado=false;
		$i=1;
		foreach($Elementos AS $seccion)
		{
			$titulo=isset($Titulos[$pasoActual][$seccion])?$Titulos[$pasoActual][$seccion]:$TitulosVacios[$pasoActual];
			if($seccion==$subseccion)
			{
				$encontrado=true;
				$salida.='
				<div class="col-sm-12 m-5">
					<span class="strong text-primary ">&nbsp;&nbsp;<strong><i class="fa fa-caret-square-o-right  text-primary"></i> ' .$I . "." . $i.".&nbsp;".  $titulo . '</strong></span>
				</div>';
			}
			else
			{
				if($encontrado)
				{
					$salida.='
					<div class="col-sm-12 m-5">
						<span class="strong"><i class="fa fa-square-o"></i> ' .$I . "." . $i.".&nbsp;".  $titulo . '</span>
					</div>';
				}
				else
				{
					$salida.='
					<div class="col-sm-12 m-5">
						<span class="strong"><strong><i class="fa fa-check-square-o"></i> ' .$I . "." . $i.".&nbsp;".  $titulo . '</strong></span>
					</div>';
						
				}
			}
			$i++;
		}
		return $salida;
	
	}
	
	
	
	if(!isset($_SESSION['datos'])||$_SESSION['datos']!='biograficos')
	{
	    $_SESSION['_biograficos']=1;
	}
	/*------------------------------------------------------------------------------------------------------------------------------*/
	/*------------------------------------------------------------------------------------------------------------------------------*/
