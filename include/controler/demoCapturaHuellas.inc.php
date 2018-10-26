<?php

//echo FOLDER_MODEL . "extend/model.producto.inc.php";
require_once FOLDER_MODEL_EXTEND . "model.persona_biometrico.inc.php";
require_once FOLDER_MODEL_EXTEND . "model.biometrico.inc.php";
require_once FOLDER_MODEL_EXTEND . "model.persona.inc.php";

#-------------------------------------------------------Includes-------------------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#

#----------------------------------------------------------------------------------------------------------------------#
#-------------------------------------------------------Funciones------------------------------------------------------#
/*
if(!isset($_SESSION['idTurno']))
{
    header("Location: dashboard.php");
    die();
}
*/

#----------------------------------------------------------------------------------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#
#-----------------------------------------------------Seccion AJAX-----------------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#

$xajax=new xajax();
/*
	function enrolarFingerPrint()
	{
		$r=new xajaxResponse();
		$aw=new AWFingerPrint();
	


		
		$mapeo=array("DM"=>"RIGHT_LITTLE",
					"DA"=>	"RIGHT_RING",
					"DE"=>	"RIGHT_MIDDLE",
					"DI"=>	"RIGHT_INDEX",
					"IM"=>	"LEFT_LITTLE",
					"IA"=>	"LEFT_RING",
					"IE"=>	"LEFT_MIDDLE",
					"II"=>	"LEFT_INDEX",
					"DP"=>	"RIGHT_THUMB",
					"IP"=>	"LEFT_THUMB");
		
		foreach($_SESSION['huellasEnrolar'] AS $k=>$path)
		{
			if(!is_file($path))
			{
				$r->mostrarError("No ruta[" . $path . "]");
				return $r;
			}
			$metodo="set" . $mapeo[$k];
			$aw->$metodo(base64_encode(file_get_contents($path)));
		}
		
		$aw->add($_SESSION['curp']);
		#$aw->add("GASM671116MTSCLN06");
				  #PASA830727HGTCLN06
		if($aw->getError())
		{
			$r->mostrarError($aw->getStrError());
			return $r;
		}
		
		$r->mostrarExito("Correcto.");
		$r->call("cargar","capturarIris.php,accordion-4,acc-4");
		unset($_SESSION["huellasEnrolar"]);	
		
		return $r;
	}
	$xajax->registerFunction("enrolarFingerPrint");
*/


function guardarHuella($key,$estatus,$base64,$nombre)
{
    global $objSession;
    $r = new xajaxResponse();
    
    //$turno = new ModeloTurno();
///    $turno->setIdTurno($_SESSION['idTurno']);
    $persona = new ModeloPersona();
    
    $persona->setIdPersona(1);
    
    $Bio = new ModeloBiometrico();
    
    $biometrico = new ModeloPersona_biometrico();
    $biometrico->setIdBiometrico($Bio->getIdBiometricoByClave($key));
    $Bio->setIdBiometrico($biometrico->getIdBiometrico());
    
    $estatus ="disponible";
    
    if ($estatus=='disponible'){
        $img64 = str_replace('data:image/png;base64,', '', $base64);
        $img64 = str_replace(' ', '+', $img64);
        $dir_subida = $persona->getPathIdentidadHuellas($nombre);
    }
    try { // guarda nuevo documento //$fichero_subido = $dir_subida . basename($_FILES['actaConstitutiva']['name']);///actaConstitutiva
        if ($estatus=='disponible')
		{
			if($img64!="")
			{
				$fileNameTmp = "0000000_" .$Bio->getControlID() . ".bmp";
				$ifp = fopen($dir_subida . $fileNameTmp, "wb");
				fwrite($ifp, base64_decode($img64));
				fclose($ifp);
//				$_SESSION['huellasEnrolar'][$key]=$dir_subida . $fileNameTmp;    
			}
       }
        //$autorizacion = new ModeloOperacionAutorizada();
//        $autorizacion->transaccionIniciar();
        
        
        if ($estatus == 'disponible')
            $biometrico->setArchivo('images/tmp/huellas/' . $fileNameTmp);
        else {
   /*/         $autorizacion->setIdAutorizacion(1);
            $autorizacion->setIdUsuarioAutoriza(0);
            $autorizacion->setFecha(date('Y-m-d H:i:s'));
            $autorizacion->setIdUbicacion($objSession->getIdUbicacion());
            $autorizacion->setUserNameAutoriza($_SESSION['excepcionBiometrico'][$key]);
            $autorizacion->setTramite('tramite');
            $autorizacion->Guardar();
            if ($autorizacion->getError()) {
                $r->mostrarError($autorizacion->getStrError());
                return $r;
            }
   
            $biometrico->setIdOperacionAutoriza($autorizacion->getIdOperacionAutoriza());
            /*/
        }
        $biometrico->setIdPersona(1);
        $biometrico->setEstatusCaptura($estatus);
        $biometrico->Guardar();
        if ($biometrico->getError()) {
            $r->mostrarError('Error al guardar la informaci&oacute;n biom&eaccute;trica');
            return $r;
        }
  //      $autorizacion->transaccionCommit();
    } catch (Exception $e) { // echo "Posible ataque de subida de ficheros!\n";
    }
    
    $r->call("finCapturaHuellasSeccion");
    return $r;
}
$xajax->registerFunction("guardarHuella");

/*/
function eliminarHuellas($keys)
{
    global $objSession;
    $r = new xajaxResponse();
    
    $turno = new ModeloTurno();
    $turno->setIdTurno($_SESSION['idTurno']);
    
    foreach ($keys as $key){
        $Bio = new ModeloBiometrico();
        
        $biometrico=new ModeloPersona_biometrico();
        $biometrico->setIdBiometrico($Bio->getIdBiometricoByClave($key));
        $biometrico->setIdPersona($turno->getIdPersona());
        if ($biometrico->verificaHuellaByIdBiometrico()){
            $biometrico->Borrar();
        }
        
    }
    return $r;
}

$xajax->registerFunction("eliminarHuellas");

function omiteTotalHuellas($arrKey,$ini)
{
    global $objSession;
    $r = new xajaxResponse();
    
    $turno = new ModeloTurno();
    $turno->setIdTurno($_SESSION['idTurno']);
    //$r->mostrarEspera("Espere un momento...");
    foreach ($arrKey as $key=>$Estatus){
        $autorizacion = new ModeloOperacionAutorizada();
        $autorizacion->transaccionIniciar();
        
        $Bio = new ModeloBiometrico();
        
        $biometrico=new ModeloPersona_biometrico();
        $biometrico->setIdBiometrico($Bio->getIdBiometricoByClave($key));
            $biometrico->setArchivo('');
                $autorizacion->setIdAutorizacion(1);
                $autorizacion->setIdUsuarioAutoriza(0);
                $autorizacion->setFecha(date('Y-m-d H:i:s'));
                $autorizacion->setIdUbicacion($objSession->getIdUbicacion());
                $autorizacion->setUserNameAutoriza($_SESSION['excepcionBiometrico'][$key]);
                $autorizacion->setTramite('tramite');
                $autorizacion->Guardar();
                if ($autorizacion->getError()){
                    $r->mostrarError($autorizacion->getStrError());
                    return $r;
                }
                
                $biometrico->setIdOperacionAutoriza($autorizacion->getIdOperacionAutoriza());
             
            $biometrico->setIdPersona($turno->getIdPersona());
            $biometrico->setEstatusCaptura($Estatus);
            $biometrico->Guardar();
            if ($biometrico->getError()){
                $r->mostrarError('Error al guardar la informaci&oacute;n biom&eaccute;trica');
                return $r;
            }
            $autorizacion->transaccionCommit();
    }
    $r->ocultarMensaje();
    if (intval($ini)<=2)
        $r->call("siguiente","h");
    else 
        $r->call("sig");
    return $r;
}
$xajax->registerFunction("omiteTotalHuellas");

/*/
$xajax->processRequest();


#----------------------------------------------------------------------------------------------------------------------#
#---------------------------------------------Procesamiento de formulario----------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#




#----------------------------------------------------------------------------------------------------------------------#
#---------------------------------------------Inicializacion de variables----------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#

$_SESSION['huellasEnrolar']=array();

#----------------------------------------------------------------------------------------------------------------------#
#-------------------------------------------------Salida de Javascript-------------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#
    