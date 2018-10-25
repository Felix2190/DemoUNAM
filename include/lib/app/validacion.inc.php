<?php
//
function validarEstructura($parametros,$cmd){
    // validar el parametro tipoBiometrico
    if(!isset($parametros["tipoBiometrico"])||trim($parametros["tipoBiometrico"])==""){
        returnAppError("Error en los par&aacute;metros. Falta definir el tipo de biom&eacute;trico.");
    }
    $biometrico=trim($parametros["tipoBiometrico"]);
    // validar el parametro tipoMatch
    if(!isset($parametros["tipoMatch"])||trim($parametros["tipoMatch"])==""){
        returnAppError("Error en los par&aacute;metros. Falta definir el tipo de match.");
    }
    $match=trim($parametros["tipoMatch"]);
    // validar si existe el parametro biometricos
    if(!isset($parametros["biometricos"])){
        returnAppError("Error en los par&aacute;metros. Falta agregar los archivos.");
    }
    $arrBio=$parametros["biometricos"];
    // estructura  base para validar la información biométrica
    $arrEstructura=array('huella'=>array('huellas_izq'=>array('LEFT_INDEX','LEFT_MIDDLE','LEFT_RING','LEFT_LITTLE'),
        'huellas_der'=>array('RIGHT_INDEX','RIGHT_MIDDLE','RIGHT_RING','RIGHT_LITTLE'),
        'pulgares'=>array('LEFT_THUMB','RIGHT_THUMB')),
        'iris'=>array('iris'=>array('LEFT_','RIGHT_'),
        'iris_izq'=>array('LEFT_'),
        'iris_der'=>array('RIGHT_')),
        'rostro'=>array('rostro'=>array('FACE'))
    );
    
    
    if ($cmd=='identificar'||$cmd=='agregar'){ // agregar 2 tipos de grupos de biométricos.
        array_push($arrEstructura['huella'],array('indice_izq'=>array('LEFT_INDEX')));
        array_push($arrEstructura['huella'],array('indice_der'=>array('RIGHT_INDEX')));
    }
    
    if ($cmd=='verificar'){ // validar si existe el parametro id, si la petición verificar
        if(!isset($parametros["id"])||trim($parametros["id"])==""){
            returnAppError("Error en los par&aacute;metros. Falta definir el id de persona");
        }
        
    }
    if (!key_exists($biometrico, $arrEstructura)){ //validar el tipo de biometrico
        returnAppError("Error en la estructura JSON. Incorrecto tipo de biom&eacute;trico. ");
    }
    $arrEstructura=$arrEstructura[$biometrico];
    
    if (!key_exists($match, $arrEstructura)){ // validar el tipo de match
        returnAppError("Error en la estructura JSON. Incorrecto tipo de match.");
    }
    $arrEstructura=$arrEstructura[$match];

    // validar la estructura la información biometrica por cada id de biométrico
    
    foreach ($arrEstructura as $id){ 
        if (!key_exists($id, $arrBio)){
            returnAppError("Error en la estructura JSON. Falta ID biom&eacute;trico [$id]");
        }
        //verificar que contiene información
        if(!isset($arrBio[$id]["file"])||trim($arrBio[$id]["file"])==""){
            returnAppError("Error en la estructura JSON. No se encuentra informaci&oacute;n para [$id]");
        }
        if(!isset($arrBio[$id]["extension"])||trim($arrBio[$id]["extension"])==""){
            returnAppError("Error en la estructura JSON. No se encuentra informaci&oacute;n para [$id]");
        }
        
        
        // guarda imagen y convierte de PNG A BMP
        $arrBio[$id]['file']=procesar_biometrico($arrBio[$id]['file'],$arrBio[$id]['extension']);
    }
    
    
    // crear json para enviarlo al server de aware
    $probe=array();
    $encounter=array();
    switch ($biometrico) {
        
        case "huella":
        
            switch ($cmd) {
            
                case "identificar": // 1:N
                    foreach ($arrBio as $id => $archivo) {
                        $probe[$id] = array(
                            'image' => $archivo['file'],
                            'impression_type' => 'PLAIN'
                        );
                    }
                    $INPUT = array(
                        'probe' => $probe,
                        'workflow' => array(
                            'filters' => [
                                array(
                                    'algorithm' => 'D350',
                                    'percentage' => 0.1,
                                    'minimum' => 100000,
                                    'fingerprint_types' => $arrEstructura
                                ),
                                array(
                                    'algorithm' => 'D600',
                                    'fixed' => 50,
                                    'fingerprint_types' => $arrEstructura
                                )
                            ],
                            'comparator' => array(
                                'algorithm' => 'D900',
                                'fingerprint_types' => $arrEstructura
                            )
                        ),
                        'candidate_list_size'=>3
                    );
                    break;
                
                case "verificar": // 1:1
                    foreach ($arrBio as $id => $archivo) {
                        $probe[$id] = array(
                            'image' => $archivo['file'],
                            'impression_type' => 'PLAIN'
                        );
                    }
                    $INPUT = array(
                        'probe' => $probe,
                        'workflow' => array(
                            'comparator' => array(
                                'algorithm' => 'D900',
                                'fingerprint_types' => $arrEstructura
                            )
                        ),
                        'id' => $parametros['id']
                    );
                    break;
                
                case "agregar":
                    foreach ($arrBio as $id => $archivo) {
                        $encounter[$id] = array(
                            'image' => $archivo['file'],
                            'impression_type' => 'PLAIN'
                        );
                    }
                    if (isset($parametros['id'])&&trim($parametros['id'])!='')
                        $encounter['id']=$parametros['id'];
                        
                    $INPUT = array(
                        'encounter' => $encounter
                        );
                    break;
            }
            break;
    }
    
    return array('biometrico'=>$biometrico,'operacion'=>$cmd,'parametros'=>$INPUT);
        
}

// procesar cada archivo de la información biometrica
function procesar_biometrico($file_biometrico,$extension){
    require_once LIB_IMAGEN;
    // Huella en PNG base64
    $InfoBio = str_replace(' ', '+', $file_biometrico);
    
    // Escribir archivo PNG
    $textoCSV = base64_decode($InfoBio);
    $archivoCS = FOLDER_INCLUDE . "tmp/" . uniqid() . ".".$extension;
    $pf = fopen($archivoCS, "w");
    if (! $pf)
        die(returnAppError("Imposible abrir archivo"));
    
    fwrite($pf, $textoCSV);
    fclose($pf);
    
    if ($extension!='bmp'){
    // Escribe archivo en BMP
    $magicianObj = new imageLib($archivoCS);
    $fileBMPName = FOLDER_INCLUDE . "tmp/" . uniqid() . ".bmp";
    $magicianObj->saveImage($fileBMPName);
    
    // regresa a base64
    $InfoBio= base64_encode(file_get_contents($fileBMPName));
    }
    
    return $InfoBio;
}
