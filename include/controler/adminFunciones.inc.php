<?php
if (isset($_POST['getKeyHuellas'])) {
    require FOLDER_MODEL_EXTEND . 'model.biometrico.inc.php';
    $huellas = new ModeloBiometrico();
    echo json_encode($huellas->getKeyHuellas());
}

if (isset($_POST['user']) && isset($_POST['pass'])) {
    verificarTipoUsuario($_POST['user'], $_POST['pass']);
}

if (isset($_POST['idBiometrico']) && isset($_POST['userName']) && isset($_POST['agrega'])) {
    estableceAutorizacion($_POST['idBiometrico'], $_POST['userName'], $_POST['agrega']);
}

if (isset($_POST['idDoc']) && isset($_POST['userName']) && isset($_POST['idPersona'])) {
    omitirDocumento($_POST['idPersona'], $_POST['userName'], $_POST['idDoc']);
}

function omitirDocumento($idPersona, $userName, $idDoc)
{
    global $objSession,$dbLink;
    require FOLDER_MODEL_EXTEND . 'model.persona_documento.inc.php';
    require_once FOLDER_MODEL_EXTEND . "model.operacionAutorizada.inc.php";
    
    $documentos = new ModeloPersona_documento($dbLink);
    $mxh = $documentos->getMaximoHistoricoByPersona($idPersona);
    
    $autorizacion = new ModeloOperacionAutorizada($dbLink);
    $autorizacion->setIdAutorizacion(3);
    $autorizacion->setIdUsuarioAutoriza(0);
    $autorizacion->setFecha(date('Y-m-d H:i:s'));
    $autorizacion->setIdUbicacion($objSession->getIdUbicacion());
    $autorizacion->setUserNameAutoriza($userName);
    $autorizacion->setTramite('tramite');
    $autorizacion->Guardar();
    if ($autorizacion->getError()) {
        echo json_encode(array(
            false,
            $autorizacion->getStrError()
        ));
    } else {
        
        $documentos->setIdpersona($idPersona);
        $documentos->setIddocumento($idDoc);
        $documentos->setEstatusVigente();
        $documentos->setDocumentoimagen('');
        $documentos->setFechacaptura(date('Y-m-d H:i:s'));
        $documentos->setHistorico($mxh + 1);
        $documentos->setIdOperacionAutoriza($autorizacion->getIdOperacionAutoriza());
        $documentos->Guardar();
        if ($documentos->getError())
            echo json_encode(array(
                false,
                $documentos->getStrError()
            ));
        else
            echo json_encode(array(
                true
            ));
    }
}

function verificarTipoUsuario($user, $pass)
{
    require_once FOLDER_MODEL_WSTAM . "ws.class.WSTMdoLicValidaUsuario.inc.php";
    
    $ws = new WSTMdoLicValidaUsuario();
    $ws->Param->setVar11(TAMAULIPAS_USER);
    $ws->Param->setVar22(TAMAULIPAS_PASS);
    $ws->Param->setVarUsuario($user);
    $ws->Param->setPassword($pass);
    
	$ws->debugEnable();
	$ws->execute();
	$ws->makeDebugFile("./tmp/");
    
    if ($ws->getError())
        
        echo json_encode(array(
            'acceso' => false
        ));
    else
        echo json_encode(array(
            'acceso' => true,
            'tipoUsuario' => $ws->Response->getTIPO_USUARIO(),
            'userName' => $user
        ));
}

function estableceAutorizacion($idBiometrico, $userName, $agrega)
{
    if ($agrega == true) {
        if (! $_SESSION['excepcionBiometrico'])
            $_SESSION['excepcionBiometrico'] = array();
        
        $arrTmp = $_SESSION['excepcionBiometrico'];
        $arrTmp[$idBiometrico] = $userName;
        $_SESSION['excepcionBiometrico'] = $arrTmp;
    } else {
        
        if (isset($_SESSION['excepcionBiometrico'][$idBiometrico]))
            unset($_SESSION['excepcionBiometrico'][$idBiometrico]);
    }
    echo true;
}