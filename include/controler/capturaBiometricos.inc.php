<?php

//echo FOLDER_MODEL . "extend/model.producto.inc.php";
require_once FOLDER_MODEL_EXTEND . "model.persona_biometrico.inc.php";
require_once FOLDER_MODEL_EXTEND . "model.biometrico.inc.php";
require_once FOLDER_MODEL . "extend/model.turno.inc.php";
require_once FOLDER_MODEL . "extend/model.persona_documento.inc.php";
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
$objTurno = new ModeloTurno();
$objTurno->setIdTurno($_SESSION['idTurno']);
$idPersona = $objTurno->getIdPersona();

#----------------------------------------------------------------------------------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#
#-----------------------------------------------------Seccion AJAX-----------------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#

$xajax=new xajax();

function capturar()
{
    global $_NOW_,$_HOST_,$_PORT_,$_ERRNO_,$ERRSTR,$_X_;
    global $objSession;
    $r=new xajaxResponse();
    
    $fp = fsockopen("189.229.26.118",1225,$_ERRNO_,$ERRSTR,$_X_);
    
    if (!$fp)
    {
        $r->mostrarError("Error: $errstr ($errno)");
    }
    else
    {
        $idturno = "7"; // parametro que recibe la app de escritorio
        fwrite($fp, $out);
        $datos="";
        while (!feof($fp))
        {
            $datos.= fgets($fp, 50000);
            //echo $datos;
            //echo "\n";
            
        }
        fclose($fp);
        
        $datosArray =explode('nombreImagen',$datos) ;
        $data = base64_decode($datosArray[0]);
        
        $archivoCS = "images/huellas/temp.bmp";//.$datosArray[1];
        //$fotoJPG = substr(explode(";",$fotoJPG)[0], 7);
        //file_put_contents('imagenes/img.bmp', base64_decode($data));
        $pf2 = fopen ( $archivoCS, "w" );
        if (! $pf2)
            die ( returnAppError ( "Imposible abrir archivo" ) );
            
            fwrite ( $pf2, $data );
            fclose ( $pf2 );
            
            
            $r->assign("divImagen", "innerHTML", "<img src=".$archivoCS." border='10' />");
            //		        $r->assign("divImagen", "innerHTML", '<img class="media-object" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAACWCAYAAACb3McZAAAC0klEQVR4nO3ZQc6aQACA0d7/BixZu+YAXoAbeBa7aMYgwa+iTdqkb/GSX+fHYTEfDPrjdrvdgWM//vYJwL9MIBAEAkEgEAQCQSAQBAJBIBAEAkEgEAQCQSAQBAJBIBAEAkEgEAQCQSAQBAJBIBAEAkEgEAQCQSAQBAJBIBAEAkEgEAQCQSAQBAJBIBAEAkEgEAQCQSAQBAJBIBAEAkEgEAQCQSAQBAJBIBAEAkEgEAQCQSAQBAJBIBAEAkEgEAQCQSAQBAJBIBAEAkEgEAQCQSAQBAJBIBAEAkEgEAQCQSAQBAJBIBAEctLlcrlP0/RwvV4fY+u6Po1tj6uxs3Nv37ter0+fO03TfV3XPzbn/04gJyzL8hTFWLBjQc7zfL9cLo+/53l+HFtj75jn+XChj3Ma57A/5ps5EchXxtV7WZbH1XpZlvvt9rxwa+ydefZ3iO3YCGd/zLdz8otAvrC9o4xYxt1l+7rGttug8blj0Y/FPMaOYtjHczTH0WveI5AvbBf2fvu1vbvU2PbYo//d2gey/5ztlu93c/IegXxoLMaxAL8J5HZ7fsYYzw17r7ZTw9k5+T2BfGB7xR/vfbrFGsdvt1qvnhPOBGKL9WcI5KSx0PZX+VfbpnVdc2wcP03Ty2+qhk8C8ZD+HYGcVFf5T7/m3T47vApwHPfOM8g7c/IegZwwrsJ7261W/TB3NHYUxP75Zji6g+zPaR+uHwq/IxAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCAKBIBAIAoEgEAgCgSAQCD8BhL2ml0nGYXAAAAAASUVORK5CYII=" alt="Firma" style=" width: 500px; height: 250px;" data-src="holder.js/200x150/karma-grey">');
            
            
            
            
            $r->mostrarAviso("Captura correcta");
            return $r;
            
            
    }
}
$xajax->registerFunction("capturar");

function guardarHuella($key,$base64)
{
    global $objSession;
    $r = new xajaxResponse();
    
    $turno = new ModeloTurno();
    $turno->setIdTurno($_SESSION['idTurno']);
    
    $img64 = str_replace('data:image/png;base64,', '', $base64);
    $img64 = str_replace(' ', '+', $img64);
    
    $dir_subida = '../html/images/tmp/huellas/';
    try { // guarda nuevo documento //$fichero_subido = $dir_subida . basename($_FILES['actaConstitutiva']['name']);///actaConstitutiva
        
        $fileNameTmp = $key."_" . date(YmdHis) . "_" . rand(100, 999) . ".bmp";
        $ifp = fopen($dir_subida . $fileNameTmp, "wb");
        fwrite($ifp, base64_decode($img64));
        fclose($ifp);
        
        $Bio = new ModeloBiometrico();
        
        $biometrico=new ModeloPersona_biometrico();
        $biometrico->setIdBiometrico($Bio->getIdBiometricoByClave($key));
        $biometrico->setArchivo($fileNameTmp);
        $biometrico->setIdPersona($turno->getIdPersona());
        $biometrico->Guardar();
        if ($biometrico->getError()){
            $r->mostrarError('Error al guardar la informaci&oacute;n biom&eaccute;trica');
            return $r;
        }
        
    } catch (Exception $e) { // echo "¡Posible ataque de subida de ficheros!\n";
    }
    
    $r->call("finCapturaHuellasSeccion");
    return $r;
}

$xajax->registerFunction("guardarHuella");

$xajax->processRequest();


#----------------------------------------------------------------------------------------------------------------------#
#---------------------------------------------Procesamiento de formulario----------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#




#----------------------------------------------------------------------------------------------------------------------#
#---------------------------------------------Inicializacion de variables----------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#

#----------------------------------------------------------------------------------------------------------------------#
#-------------------------------------------------Salida de Javascript-------------------------------------------------#
#----------------------------------------------------------------------------------------------------------------------#

if(isset($_GET['files'])){
    if(isset($_SESSION['idTurno'])){
        $_SESSION['etapa']='documentos';
        
        $img64 = $_POST['imgBase64'];
        $img64 = str_replace('data:image/png;base64,', '', $img64);
        $img64 = str_replace(' ', '+', $img64);
        
        $dir_subida = '../html/images/firma/';
        $archivoFirma  = 'images/firma/';
        $t = new ModeloTurno();
        $t->setIdTurno($_SESSION['idTurno']);
        $documentos = new ModeloPersona_documento();
        $documentos->setIddocumento(3);
        $documentos->setIdpersona($t->getIdPersona());
        $documentos->setFechacaptura(date("Y-m-d H:i:s"));
        if (!file_exists($dir_subida))
            mkdir($dir_subida,0777);
            
            $error=false;
            $mensajeError="";
            $mensajeExito="";
            $archivo="";
            if ( is_writable($dir_subida)) {//checa que exista el archivo y que se pueda escribir en el dir
                try {//guarda nuevo documento	//$fichero_subido = $dir_subida . basename($_FILES['actaConstitutiva']['name']);///actaConstitutiva
                    
                    $fileNameTmp="firma_" . date(YmdHis) . rand(100,999) . ".jpg";
                    $ifp = fopen( $dir_subida.$fileNameTmp, "wb" );
                    fwrite( $ifp, base64_decode( $img64) );
                    fclose( $ifp );
                    
                    
                    if (file_exists($dir_subida.$fileNameTmp)){//checar si movio el archivo correctamente
                        $mensajeExito=" Archivo subido con exito.";
                    }else{
                        $error=true;
                        $mensajeError=" Error al subir el archivo al servidor (0x1).";//error en rename
                    }
                    if($error){
                        //error al guardar
                    }else{
                        $mensajeExito=" Archivo  subido con exito.";
                        $documentos->setDocumentoimagen($archivoFirma.$fileNameTmp);
                        $documentos->Guardar();
                        $error=false;
                        $archivo= $fileName;
                    }
                } catch (Exception $e) {				//echo "¡Posible ataque de subida de ficheros!\n";
                    $error=true;
                    $mensajeError .= "Error ";
                }
            }else{//no se encontro el archivo en la nueva ubicacion
                $error=true;
                $mensajeError=" Error al subir el archivo al servidor (0x2).";//error en rename
            }
            $resultado = array(
                "error" => $error,
                "mensajeError" => $mensajeError,
                "mensajeExito" => $mensajeExito,
                "tipo" => "acta",
                "archivo" => $archivo
            );
            $res[]=$resultado;
            //}//fin foreach  $key
            die(json_encode($res));
    }else{
        //no hay variable se session idturno
        
        
        $_JAVASCRIPT_OUT .= '
			 					$(document).ready(function()
			 					{
			 						mostrarError("No se encontro el id Turno");
			 					});
			 					';
        
        //header("Location : generarTurnos.php");
        
        
    }
}
    