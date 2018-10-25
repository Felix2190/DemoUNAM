<?php
	require_once 'masterInclude.inc.php';
	require_once LIB_APP_FUNCTIONS;
	require_once APP_MATCHEO;
	require_once APP_VALIDACION;
	
	if(!isset($_POST['request'])) // verificar si existe la petición
	{
		returnAppError("Error en la peticion. No existe parametro.");
	}
/*	
	$pf=fopen(FOLDER_INCLUDE . "tmp/app.log", "a+");
	fwrite($pf,$_POST['request'] . "\n\n----------------------------------------------------------------------\n\n");
	fclose($pf);
*/			
	$request=json_decode($_POST['request'],true); //decodifica el JSON
	
//	var_dump($request);
	
	
	if(!isset($request["cmd"])||trim($request["cmd"])=="") //valida el parametro cmd
	{
		returnAppError("Error en la peticion. No existe comando.");
	}
	
	$cmd=trim($request["cmd"]);
	
	if(!isset($request["param"])) //verifica si existe el parametro param (que contiene la información biométrica) 
	{
	    returnAppError("Error en la peticion. No existen par&aacute;metros.");
	}
	
	$param=$request["param"];
	
	if(!is_file(FOLDER_APP_WS . $cmd . '.inc.php')) // verifica si existe el php de la petición a ejecutar
		returnAppError("Error en la peticion. Comando [" . $cmd . "] sin controlador.");
	
	$arrDatos=validarEstructura($param, $cmd); //validar la estructura de la información biométrica
	
	$result=ws_aware($arrDatos['biometrico'], $arrDatos['operacion'], $arrDatos['parametros']); //enviar la información al server de Aware
	
	//resultado
	$R=new clsAppGenericResponse();
	$R->setResult("OK");
	$R->setMsg($result);
	$R->setData($arrDatos['parametros']['workflow']);
	die($R->getJSONResponse());
	
	// acciones segun el comando solicitado
	switch($cmd)
	{
		case "identificar": // 1:N
			require_once FOLDER_APP_WS . 'identificar.inc.php';
		case "verificar": // 1:1
			require_once FOLDER_APP_WS . 'verificar.inc.php';
		case "agregar":
			require_once FOLDER_APP_WS . 'guardar.inc.php';
		default:
			returnAppError("Error en la peticion. Comando [". $cmd ."] no definido.");
	}