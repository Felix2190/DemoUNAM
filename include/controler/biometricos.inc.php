<?php

	require_once FOLDER_MODEL_EXTEND . "model.persona_biometrico.inc.php";
	require_once FOLDER_MODEL_EXTEND . "model.turno.inc.php";
	
	#-------------------------------------------------------Includes-------------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#

	#----------------------------------------------------------------------------------------------------------------------#
	#-------------------------------------------------------Funciones------------------------------------------------------#

	#----------------------------------------------------------------------------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
	#-----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#

	$xajax=new xajax();

	 function guardarHuellas($id,$huellas,$bio)
	{
		global $objSession;
		$r=new xajaxResponse();
		
		$arrH=json_decode($huellas);
		
		$turno=new ModeloTurno();
		//$turno->transaccionIniciar();
		$turno->setIdTurno($id);
		
		
		foreach ($arrH as $key=>$img){
			$biometrico=new ModeloPersona_biometrico();
			$biometrico->setIdBiometrico($key);
			$biometrico->setArchivo($img);
			$biometrico->setIdPersona($turno->getIdPersona());
			$biometrico->Guardar();
			if ($biometrico->getError()){
				$r->mostrarError('Error al guardar la informaci&oacute;n biom&eaccute;trica');
				return $r;
			}
			
		}
		
		
		$turno->setIdEtapa(7);
		
		$turno->setFechaHora(date('Y-m-d H:i:s'));
		//$turno->Guardar();
		if ($turno->getError()){
			$r->mostrarError('Error al actualizar turno');
			return $r;
		}
		
		$turno->transaccionCommit() ;
		$r->assign('divButtons'.$bio, 'innerHTML','');
		$r->mostrarAviso("Informaci&oacute;n guardada con exito.");
		$r->call('next');
		
//		$r->redirect("biometricos.php",2);
		
		return $r;

	}
	$xajax->registerFunction("guardarHuellas");

	
	
	function siguienteTurno($id)
	{
		global $objSession;
		$r=new xajaxResponse();
	
		$turno=new ModeloTurno();
		$turno->transaccionIniciar();
		$turno->setIdTurno($id);
	
		$turno->setIdEtapa(7);
	
		$turno->setFechaHora(date('Y-m-d H:i:s'));
		$turno->Guardar();
		if ($turno->getError()){
			$r->mostrarError('Error al actualizar turno');
			return $r;
		}
		$turno->transaccionCommit() ;
		$r->redirect("examenUpload.php?idPersona=".$turno->getIdPersona(),2);
		
		return $r;
		
		}
		$xajax->registerFunction("siguienteTurno");
		
	$xajax->processRequest();


	#----------------------------------------------------------------------------------------------------------------------#
	#---------------------------------------------Procesamiento de formulario----------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#




	#----------------------------------------------------------------------------------------------------------------------#
	#---------------------------------------------Inicializacion de variables----------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
	$nombrePersona=$CURP='';
	if (isset($_GET['id'])){
	    $IDT=$_GET['id'];
	    $turno=new ModeloTurno();
	    $existeTurno=$turno->existsTurnoInEtapa($IDT, 6);
	    //var_dump($existeTurno);
	    
	    if (!$existeTurno[0]){
	        header("Location: biometricos.php");
	    }
	    
	    $nombrePersona=$existeTurno[1];
	    $CURP=$existeTurno[2];
    }else{
	   $IDT=0;
	 }
	    
	
		#----------------------------------------------------------------------------------------------------------------------#
	#-------------------------------------------------Salida de Javascript-------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
