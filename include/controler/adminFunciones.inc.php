<?php
if (isset($_POST['getKeyHuellas'])) {
    require FOLDER_MODEL_EXTEND . 'model.biometrico.inc.php';
    $huellas = new ModeloBiometrico();
    echo json_encode($huellas->getKeyHuellas());
}

if (isset($_POST['idBiometrico']) && isset($_POST['userName']) && isset($_POST['agrega'])) {
    estableceAutorizacion($_POST['idBiometrico'], $_POST['userName'], $_POST['agrega']);
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