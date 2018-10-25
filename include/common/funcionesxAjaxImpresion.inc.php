<?php


	require_once FOLDER_MODEL_EXTEND . "model.turno.inc.php";
	require_once FOLDER_MODEL_EXTEND . "model.impresion.inc.php";
	require_once FOLDER_MODEL_EXTEND . "model.persona.inc.php";
	require_once FOLDER_MODEL_EXTEND . "model.response_wsFTOFRM.inc.php";
	require_once FOLDER_MODEL_WSTAM . "ws.class.WSTMdoLicCapturaImagenes.inc.php";
	
	require_once FOLDER_MODEL_WSTAM . "ws.class.WSTMdoLicCancelaReimprime.inc.php";
	
	#----------------------------------------------------------------------------------------------------------------------#
	#-------------------------------------------------------Funciones------------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
	
	function PNG_to_JPGBase64($file)
	{
		$image = imagecreatefrompng($file);
		imagejpeg($image, $file . '.jpg', 100);
		imagedestroy($image);
		return base64_encode(file_get_contents($file . '.jpg'));
	}
	
	function base64BMP_to_JPG600DPI($base64Data,$fileName)
	{
    $arreglo = explode(",",$base64Data);
		$img1 = base64_decode($arreglo[1]);		
    $original = fopen($fileName, 'wb');
    fwrite($original, $img1);
    fclose($original);
    /*$archivoBMP = "tmp/Foto_" .date("YmdHis") . "_" . rand(100, 999) .".bmp";//.$datosArray[1];
		
    $pf2 = fopen ( $archivoBMP, "w" );
		
    fwrite ( $pf2, $img1 );
		fclose ( $pf2 );
		$img=new clsBasicImageGD($archivoBMP);
		$archivoJPG=$archivoBMP . ".jpg";
		imagejpeg ($img->getRecurso(),$archivoJPG ,100);
    */                
    $archivoJPG=$fileName;
		$image=substr_replace(file_get_contents($archivoJPG), pack("cnn", 1, 600, 600), 13, 5);
		$pf=fopen($fileName,"w");
		fwrite($pf,$image);
		fclose($pf);       
	}
	
	#----------------------------------------------------------------------------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
	
	
	
	
				
	
	
	
	
	
	function insertImpresion($idTurno,$ip,$activa)
	{
	
	#die("X".$idTurno);
		$objTurno = new ModeloTurno();
		$objTurno->setIdTurno($idTurno);
		$objTurno->setIdTipoLicencia(1);
		$objTurno->setIdEtapa(11);
		$objTurno->Guardar();
		if($objTurno->getError())
		{
			return $objTurno->getStrError();
		}
	
	
		$objImpresion = new ModeloImpresion();
		#if (!$objImpresion->getDatosByIdTurno($idTurno)) {
			$objImpresion->setIdTurno($idTurno);
			$objImpresion->setActivada($activa);
			$objImpresion->setEstatusImprimir();
			$objImpresion->setIdModuloImpresion(1);
			$objImpresion->setNombreEquipo('');
			$objImpresion->setFechaHora(date('Y-m-d H:i:s'));
			$objImpresion->Guardar();
	
			if($objImpresion->getError())
			{
				return $objImpresion->getStrError();
			}
	
			return '';
		#}
		#else
		#{
		#	return '';
	
		#}
	
	}
	
	function get_client_ip() {
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
			else if(getenv('HTTP_X_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
				else if(getenv('HTTP_X_FORWARDED'))
					$ipaddress = getenv('HTTP_X_FORWARDED');
					else if(getenv('HTTP_FORWARDED_FOR'))
						$ipaddress = getenv('HTTP_FORWARDED_FOR');
						else if(getenv('HTTP_FORWARDED'))
							$ipaddress = getenv('HTTP_FORWARDED');
							else if(getenv('REMOTE_ADDR'))
								$ipaddress = getenv('REMOTE_ADDR');
								else
									$ipaddress = 'UNKNOWN';
									return $ipaddress;
	}
	
	#----------------------------------------------------------------------------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
	#-----------------------------------------------------Seccion AJAX-----------------------------------------------------#
	#----------------------------------------------------------------------------------------------------------------------#
	
	
	
	function imprimirLicencia($idTurno,$activa="NO")
	{
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
			else if(getenv('HTTP_X_FORWARDED_FOR'))
				$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
				else if(getenv('HTTP_X_FORWARDED'))
					$ipaddress = getenv('HTTP_X_FORWARDED');
					else if(getenv('HTTP_FORWARDED_FOR'))
						$ipaddress = getenv('HTTP_FORWARDED_FOR');
						else if(getenv('HTTP_FORWARDED'))
							$ipaddress = getenv('HTTP_FORWARDED');
							else if(getenv('REMOTE_ADDR'))
								$ipaddress = getenv('REMOTE_ADDR');
								else
									$ipaddress = 'UNKNOWN';
	
									if($ipaddress =="::1")  {
										$ipaddress = "10.10.3.115";
									}
									
									
									
	
									//$idTurno = $_SESSION['idTurno'];
									$r = new xajaxResponse();
									#$r->mostrarAviso($ipaddress);
									$error =insertImpresion($idTurno,$ipaddress,$activa);
									
									
									if(trim($error)!="")
									{
									
										$r->mostrarError($error);
									}
									else
									{
									
										ini_set('max_execution_ime', 60);
										// echo $ipaddress;
										$fp = fsockopen($ipaddress, 12000 , $errno, $errstr, 30);
										try
										{
											if (!$fp)
											{
												$r->mostrarDenegado("Error al abrir la aplicaci&oacute;n de impresi&oacute;n");
												$r->ocultarMensaje();
												return $r;
												//echo "Error: $errstr ($errno)<br />";
											}
											else
											{
	
												$out = $_SESSION['user'].','.$_SESSION['pass'].',';
	
												$out = "MMD,DAADMEMA,".$idTurno.','; // parametro que recibe la app de escritorio
												//echo 'salida '.$out;
	
												fwrite($fp, $out);
												$datos="";
												
												/*
												while (!feof($fp))
												{
													$datos.= fgets($fp, 50000);
												}
												fclose($fp);
												//   $r->mostrarAviso($datos);
	
												if ($datos=="NOK") {
													$r->mostrarDenegado("Error al realizar la impresi&oacute;n.");
													$r->ocultarMensaje();
													return $r;
												}
												*/
												
												//$r->assign("divBiomR", "innerHTML", "<img src=".$archivo1." border='10'width='300px' class='img-responsive' />");
												//$r->assign('rutaFoto',"value",$archivo1);
												// $r->call("sig");
												//$r->mostrarAviso("Pro");
	
												//$r->mostrarExito("Trabajo de impresi&oacute;n enviado.");
												
												$r->call("preguntarImpresionCorrecta");
												
												//            $r->redirect("dashboard.php");
	
											}
										} catch (Exception $e) { // echo "�Posible ataque de subida de ficheros!\n";
											 
											$r->mostrarDenegado("Error al abrir la aplicaci&oacute;n de impresi&oacute;n");
											$r->ocultarMensaje();
	
										}
	
									}
									return $r;
	}
	$xajax->registerFunction("imprimirLicencia");
	
	
	
	
	
	function enviarCancelacionReimpresion($idTurno,$slcMotivo, $txtPVCAnterior, $txtPVCNuevo, $txtAutoriza, $txtPass)
	{
		
		//die("[$idTurno,$slcMotivo, $txtPVCAnterior, $txtPVCNuevo, $txtAutoriza, $txtPass]");
		global $objSession;
		global $dbLink;
		$r=new xajaxResponse();
		
		$Turno=new ModeloTurno();
		$Turno->setIdTurno($idTurno);
		
		
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		/*--------------------------------------------Buscar el num de licencia en nuestra BD y comparar folios de PVC-------------------------------------------*/		
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
			$query="SELECT folioPVC FROM licencia WHERE numero='" . $Turno->getNumLicencia() . "' AND estatus='activo'";
			$result=mysqli_query($dbLink,$query);			
			if(mysqli_num_rows($result)!=0)
			{
				$row=mysqli_fetch_assoc($result);
				if($row['folioPVC']!=$txtPVCAnterior)
				{
					$r->call("mostrarErrorSegundo","La licencia est&aacute; registrada en BD pero el folio PVC anterior no es correcto, verifica los datos.");
					return $r;
				}
			}
		
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
		
		
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		/*-------------------------------------------------Validar que el folio no se esté usando en una licencia------------------------------------------------*/
		/*--------------------------------------------------------Siempre y cuando el motivo sea 2, 4,5,8--------------------------------------------------------*/
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
		$motivosPermitidos=array(2,4,5,8);
		if(in_array($slcMotivo,$motivosPermitidos))
		{
			$query="SELECT count(*) as cuenta FROM licencia WHERE folioPVC='" . $txtPVCNuevo . "'";
			$result=mysqli_query($dbLink,$query);
			$row=mysqli_fetch_assoc($result);
			if($row['cuenta']!=0)
			{
				$r->call("mostrarErrorSegundo","El folio del PVC nuevo ya est&aacute; registrado en base de datos.");
				return $r;
			}
		}
		
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
		
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		/*-----------------------------------Validar que el folio este asignado a la recaudadora en donde se hace la impresion-----------------------------------*/
		/*--------------------------------------------------------Siempre y cuando el motivo sea 2, 4,5,8--------------------------------------------------------*/
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
		
		if(in_array($slcMotivo,$motivosPermitidos))
		{
			#El folio esta en la recaudacion?
			$query="SELECT estatus,idUsuarioAsignado FROM folioplastico WHERE numfolio='" . $txtPVCNuevo . "' AND idRecaudacion='" . $objSession->getIdUbicacion() . "'";
			$result=mysqli_query($dbLink,$query);
			if(mysqli_num_rows($result)==0)
			{
				$r->call("mostrarErrorSegundo","El folio del PVC nuevo no est&aacute; registrado en la recaudaci&oacute;n.");
				return $r;
			}
			$row=mysqli_fetch_assoc($result);
			#El folio se puede usar?
			if($row['estatus']!="nuevo")
			{
				$r->call("mostrarErrorSegundo","El folio del PVC nuevo no puede ser usado.");
				return $r;
			}
			/*
			if($row['idUsuarioAsignado']!=$objSession->getIdLogin())
			{		
				$r->call("mostrarErrorSegundo","El folio del PVC no est&aacute; asignado al usuario que intenta usarlo.");
				return $r;		
			}
		
			*/
		}
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
		
		
		
		
		
		
		
		
		
		
		
		$Cancelacion=new WSTMdoLicCancelaReimprime();
		$Cancelacion->Param->setVar11(TAMAULIPAS_USER);
		$Cancelacion->Param->setVar22(TAMAULIPAS_PASS);
		$Cancelacion->Param->setVarUsuario($objSession->getUserName());
		$Cancelacion->Param->setVarPvcAnt($txtPVCAnterior);
		$Cancelacion->Param->setVarPvcNvo($txtPVCNuevo);		
		$Cancelacion->Param->setVarNumLicencia($Turno->getNumLicencia());		
		$Cancelacion->Param->setVarMotBaja($slcMotivo);		
		$Cancelacion->Param->setVarObsBaja("Motivos de Baja.");		
		$Cancelacion->Param->setVarUsuAutoriza($txtAutoriza);		
		$Cancelacion->Param->setVarPwdAutoriza($txtPass);
		
		$Cancelacion->debugEnable();		
		$Cancelacion->execute();
		$Cancelacion->makeDebugFile("tmp/algo" . date("YmdHis") . ".html");
		
		if($Cancelacion->getError())
		#if(false)
		{
			
			/*
				$Impresion=new ModeloImpresion();
				$Impresion->getDatosByIdTurno($idTurno);
				$Impresion->setEstatusProcesada();
				$Impresion->Guardar();
			*/
			//$r=imprimirLicencia($idTurno);
			$r->call("mostrarErrorSegundo","WS:" . $Cancelacion->getStrError());
		
		}
		else
		{
			$query="UPDATE impresion SET estatus='procesada' where idTurno=" . $idTurno;
			$result=mysqli_query($dbLink,$query);
			if(!$result)
			{
				$r->mostrarError("Ocurri&oacute; un error la actualizaci&oacute;n de la impresi&oacute;n.");
				return $r;
			}
		
			
			/*
			$Impresion=new ModeloImpresion();
			$Impresion->getDatosByIdTurno($idTurno);
			$Impresion->setEstatusProcesada();
			$Impresion->Guardar();
			*/
			if($slcMotivo!=6&&$slcMotivo!=7)
			{
				$r->mostrarExito("Se envi&oacute; una reimpresi&oacute;n...");
				$r=imprimirLicencia($idTurno,"SI");
				
				$query="UPDATE licencia SET estatus='baja' WHERE numero='" . $Turno->getNumLicencia() . "' AND folioPVC<>'' AND estatus='activo'";
				$result=mysqli_query($dbLink,$query);
				if(!$result)
				{
					$r->mostrarError("Ocurri&oacute; un error la actualizaci&oacute;n de la licencia.");
					return $r;
				}
				
				$query="UPDATE licencia SET folioPVC='" . $txtPVCNuevo . "' WHERE numero='" . $Turno->getNumLicencia() . "' AND folioPVC=''";
				$result=mysqli_query($dbLink,$query);
				if(!$result)
				{
					$r->mostrarError("Ocurri&oacute; un error la actualizaci&oacute;n de la licencia.");
					return $r;
				}
				
				$query="UPDATE folioplastico SET idUsuarioUsado='" . $objSession->getIdLogin() . "',estatus='usado',fechaUsado=NOW() WHERE numFolio='" . $txtPVCNuevo . "'";
				$result=mysqli_query($dbLink,$query);
				if(!$result)
				{
					$r->mostrarError("Ocurri&oacute; un error la actualizaci&oacute;n del pl&aacute;stico.");
					return $r;
				}				
			}
			else
			{
				
				$r->mostrarAviso("Cancelaci&oacute;n exitosa.");
			}
			
			#$r->ocultarMensaje();
				
	
		}
		
		return $r;
	}
	$xajax->registerFunction("enviarCancelacionReimpresion");
	
	function activarConfirmacion($idTurno,$folioPVC)
	{
	
		set_time_limit(60);
		global $objSession;
		global $dbLink;
		$r=new xajaxResponse();
		$Turno=new ModeloTurno();
		$Turno->setIdTurno($idTurno);
	
		if($Turno->getError())
		{
			$r->mostrarError($Turno->getStrError());
			return $r;
		}
	
		$Persona=new ModeloPersona();
		$Persona->setIdPersona($Turno->getIdPersona());
		if($Persona->getError())
		{
			$r->mostrarError($Persona->getStrError());
			return $r;
		}
	
		$ws=new ModeloResponse_wsFTOFRM();
		$ws->getLastDatosByCURP($Persona->getCURP());
		if($ws->getError())
		{
			$r->mostrarError($ws->getStrError());
			return $r;
		}
		
		
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		/*-------------------------------------------------Validar que el folio no se esté usando en una licencia------------------------------------------------*/
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
		
		$query="SELECT count(*) as cuenta FROM licencia WHERE folioPVC='" . $folioPVC . "'";
		$result=mysqli_query($dbLink,$query);
		$row=mysqli_fetch_assoc($result);
		if($row['cuenta']!=0)
		{
			$r->call("mostrarErrorSegundo","El folio del PVC ya est&aacute; registrado en base de datos.");
			return $r;
		}
		
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
		
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		/*-----------------------------------Validar que el folio este asignado a la recaudadora en donde se hace la impresion-----------------------------------*/
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
		
		#El folio esta en la recaudacion?
		$query="SELECT estatus,idUsuarioAsignado FROM folioplastico WHERE numfolio='" . $folioPVC . "' AND idRecaudacion='" . $objSession->getIdUbicacion() . "'";
		$result=mysqli_query($dbLink,$query);
		if(mysqli_num_rows($result)==0)
		{
			$r->call("mostrarErrorSegundo","El folio del PVC no est&aacute; registrado en la recaudaci&oacute;n.");
			return $r;
		}
		$row=mysqli_fetch_assoc($result);
		#El folio se puede usar?
		if($row['estatus']!="nuevo")
		{
			$r->call("mostrarErrorSegundo","El folio del PVC no puede ser usado.");
			return $r;
		}
		/*
		if($row['idUsuarioAsignado']!=$objSession->getIdLogin())
		{		
			$r->call("mostrarErrorSegundo","El folio del PVC no est&aacute; asignado al usuario que intenta usarlo.");
			return $r;		
		}
		*/
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		/*-------------------------------------------------------------------------------------------------------------------------------------------------------*/
		
		
	
		#if($ws->getTIPO_COBRO()=="EMISION")
		if($Turno->getTipoConsultaWS()=="I")
		{
			$enviarImagenes=new WSTMdoLicCapturaImagenes();
			$enviarImagenes->Param->setVar11(TAMAULIPAS_USER);
			$enviarImagenes->Param->setVar22(TAMAULIPAS_PASS);
			$enviarImagenes->Param->setVarNumLic($Turno->getNumLicencia());
			$enviarImagenes->Param->setVarIdContrib($ws->getID_CONTRIBUYENTE());
			$enviarImagenes->Param->setVarIdOfnaFiscal($objSession->getIdUbicacion());
			$enviarImagenes->Param->setVarIdUsuario($objSession->getUserName());
			$enviarImagenes->Param->setVarFolioReferencia($ws->getFOLIO_REFERENCIA());
			$enviarImagenes->Param->setVarPvc($folioPVC);
				
			$enviarImagenes->Param->setVarEjFiscal($Turno->getEjercicioFiscal());
			
			$Persona=new ModeloPersona();
			$Persona->setIdPersona($Turno->getIdPersona());
				
				
			//foto
			$query="SELECT documentoimagen FROM persona_documento WHERE idPersona=" . $Turno->getIdPersona() . " AND idDocumento=1 ORDER BY IdPersona_documento DESC LIMIT 1";
			$result=mysqli_query($dbLink, $query) or die("Error 1[" . $query . "]");
				
			$row=mysqli_fetch_assoc($result);
			$foto="./". $row['documentoimagen'];
			
			//$archivo1 = "images/persona/Foto_" .date(YmdHis) . "_" . rand(100, 999) .".jpg";//.$datosArray[1];
			//base64BMP_to_JPG600DPI($datos,$archivo1);
			
				
			//firma
			$query="SELECT documentoimagen FROM persona_documento WHERE idPersona=" . $Turno->getIdPersona() . " AND idDocumento=3 ORDER BY IdPersona_documento DESC LIMIT 1";
			$result=mysqli_query($dbLink, $query) or die("Error 2[" . $query . "]");
			$row=mysqli_fetch_assoc($result);
			$firma="./". $row['documentoimagen'];
	
				
				
			//huellaDer
			$query="SELECT archivo FROM persona_biometrico WHERE idPersona=" . $Turno->getIdPersona() . " AND idBiometrico IN(SELECT idBiometrico FROM biometrico WHERE clave='DI') ORDER BY IdPersonaBiometrico DESC LIMIT 1";
			$result=mysqli_query($dbLink, $query) or die("Error 3[" . $query . "]");
			$row=mysqli_fetch_assoc($result);
			$HD=$Persona->getPathIdentidadHuellas() . str_replace("images/tmp/huellas/","",$row["archivo"]);
	
				
			//huellaIzq
			$query="SELECT archivo FROM persona_biometrico WHERE idPersona=" . $Turno->getIdPersona() . " AND idBiometrico IN(SELECT idBiometrico FROM biometrico WHERE clave='DI') ORDER BY IdPersonaBiometrico DESC LIMIT 1";
			$result=mysqli_query($dbLink, $query) or die("Error 4[" . $query . "]");
			$row=mysqli_fetch_assoc($result);
			$HI=$Persona->getPathIdentidadHuellas() . str_replace("images/tmp/huellas/","",$row["archivo"]);
			
				
			
			
			
			
			//die(base64_encode(file_get_contents($foto)));
			
			//$enviarImagenes->Param->setVarFirma(base64_encode(file_get_contents($firma)));
			$enviarImagenes->Param->setVarFirma(PNG_to_JPGBase64($firma));
			$enviarImagenes->Param->setVarFoto(base64_encode(file_get_contents($foto)));	
			$enviarImagenes->Param->setVarHuellaDer(base64_encode(file_get_contents($HD)));
			$enviarImagenes->Param->setVarHuellaIzq(base64_encode(file_get_contents($HI)));
			$enviarImagenes->Param->setVarMinuciaDer(base64_encode(file_get_contents($HD)));
			$enviarImagenes->Param->setVarMinuciaIzq(base64_encode(file_get_contents($HI)));
				
			//die("[$foto][$firma][$HD][$HI]");
			
			
			
			//print_r($enviarImagenes->Param);
			//die();
				
			$enviarImagenes->debugEnable();
				
				
			$enviarImagenes->execute();
				
				
			$enviarImagenes->makeDebugFile("tmp/algo" . date("YmdHis") . ".html");
				
				
			if($enviarImagenes->getError()&&$enviarImagenes->getStrError()!="LICENCIA YA IMPRESA.")
			{
				$r->mostrarError("WS: " . $enviarImagenes->getStrError());
				return $r;
			}
			
			
				
			$query="UPDATE impresion SET estatus='procesada', activada='SI' where idTurno=" . $idTurno;
			$result=mysqli_query($dbLink,$query);
			if(!$result)
			{
				$r->mostrarError("Ocurri&oacute; un error la actualizaci&oacute;n de la impresi&oacute;n.");
				return $r;
			}
			
			$query="UPDATE licencia SET estatus='activo',folioPVC='" . $folioPVC . "' WHERE numero='" . $Turno->getNumLicencia() . "' AND folioPVC=''";
			$result=mysqli_query($dbLink,$query);
			if(!$result)
			{
				$r->mostrarError("Ocurri&oacute; un error la actualizaci&oacute;n de la licencia.");
				return $r;
			}
			
			
			$query="UPDATE folioplastico SET idUsuarioUsado='" . $objSession->getIdLogin() . "',estatus='usado',fechaUsado=NOW() WHERE numFolio='" . $folioPVC . "'";
			$result=mysqli_query($dbLink,$query);
			if(!$result)
			{
				$r->mostrarError("Ocurri&oacute; un error la actualizaci&oacute;n del plastico.");
				return $r;
			}
			
			if($enviarImagenes->getError()&&$enviarImagenes->getStrError()=="LICENCIA YA IMPRESA.")
			{
				$r->mostrarError("WS: " . $enviarImagenes->getStrError());
				return $r;
			}
			else
			{
					$r->mostrarExito("Licencia activada.");
			}
				
			
			
				
		}
		else
		{
			$r->call("impresionReimprimir",$Turno->getIdTurno());
		}
	
	
	
		return $r;
	
	}
	$xajax->registerFunction("activarConfirmacion");
	
	function getTrabajosImpresion()
	{
		global $objSession;
		global $dbLink;
		$r=new xajaxResponse();
		$query="SELECT DISTINCT(T.idTurno),I.estatus,I.activada,T.idTurno, T.tipoConsultaWS,T.idPersona,T.NumLicencia,CONCAT_WS(' ',P.nombres,P.primerAp) AS nombre
						FROM impresion I
						INNER JOIN turno T ON T.idTurno=I.idTurno
						INNER JOIN persona P ON T.idPersona=P.idPersona
						WHERE TRUE
							AND T.idUsuario=". $objSession->getIdLogin() . " AND T.idUbicacion=" . $objSession->getIdUbicacion() . "
							AND I.estatus='impresa' 
							AND I.activada='NO'
							-- AND T.tipoConsultaWS='I'
						GROUP BY T.idTurno
						ORDER BY I.idImpresion DESC";
	
	
		$result=mysqli_query($dbLink, $query);
		if(!$result)
		{
			$r->mostrarError("Ocurri&oacute; un error en la consulta de los trabajos de impresi&oacute;n.");
			return $r;
		}
	
		$tabla="";
		while($row=mysqli_fetch_assoc($result))
		{
		
			$Persona=new ModeloPersona();
			$Persona->setIdPersona($row["idPersona"]);
			if($Persona->getError())
			{
				$r->mostrarError($Persona->getStrError());
				return $r;
			}
		
			$ws=new ModeloResponse_wsFTOFRM();
			$ws->getLastDatosByCURP($Persona->getCURP());
			if($ws->getError())
			{
				$r->mostrarError($ws->getStrError());
				return $r;
			}

			#if($ws->getTIPO_COBRO()=="EMISION")
			$btnActivar='';
			$btnCancelar='';
			/*
			if($row['activada']=="NO")
			{
				$btnActivar='<button title="Activar" data="' . $row['idTurno'] . '" onclick="impresionValidar(' . $row['idTurno'] . ')" class="btn btn-default btn-md btnImpresionValidar"><i class="fa fa-exchange"></i></button>';
			}
			else
			{
				$btnActivar='<button title="Impresa" data="' . $row['idTurno'] . '" onclick="impresionImpresa(' . $row['idTurno'] . ')" class="btn btn-default btn-md btnImpresionValidar"><i class="fa fa-check"></i></button>';
				$btnCancelar='<button title="Cancelar" data="' . $row['idTurno'] . '" onclick="impresionReimprimir(' . $row['idTurno'] . ')" class="btn btn-default btn-md btnImpresionCancelar"><i class="fa fa-repeat"></i></button>';
			}
			*/
			
			if($row['tipoConsultaWS']=="I")
			{
				$btnActivar='<button title="Impresa" data="' . $row['idTurno'] . '" onclick="impresionValidar(' . $row['idTurno'] . ')" class="btn btn-default btn-md btnImpresionValidar"><i class="fa fa-check"></i></button>';
			}
			else
			{
				$btnCancelar='<button title="Cancelar" data="' . $row['idTurno'] . '" onclick="impresionReimprimir(' . $row['idTurno'] . ')" class="btn btn-default btn-md btnImpresionCancelar"><i class="fa fa-repeat"></i></button>';
			}
			
			
			#$btnCancelar='<button title="Cancelar" data="' . $row['idTurno'] . '" onclick="impresionReimprimir(' . $row['idTurno'] . ')" class="btn btn-default btn-md btnImpresionCancelar"><i class="fa fa-times"></i></button>';
		
		
			$tabla.='<div class="row">
						<div class="col-sm-6">
							<label>' . $row['NumLicencia'] . '</label>
						</div>
				
						<div class="col-sm-6">
							<div class="btn-group">
								' . $btnActivar . '
								' . $btnCancelar . '
							</div>
						</div>
					</div>
					';
	
		}
	
		if($tabla=="")
		{
			$tabla='
				<div class="row inner-padding">
					<div class="row">
						<div class="col-sm-4">&nbsp;</div>						
						<div class="col-sm-4">
							<label>No tienes trabajos de impresi&oacute;n</label>
						</div>
						<div class="col-sm-4">&nbsp;</div>
					</div>
				</div>
			';
		}
		else
		{
	
		$tabla='
			
				<div class="row inner-padding">
					<div class="row">
						<div class="col-sm-6 pull-left">
							<label>Licencia</label>
						</div>
						<div class="col-sm-6">
							<label>Acciones</label>
						</div>
					</div>
	
			
				' . $tabla . '
	
			
				</div>
			
			
				';
				
		}
		$r->call("printJobMostrarTabla",$tabla);
		return $r;
	};
	$xajax->registerFunction("getTrabajosImpresion");

