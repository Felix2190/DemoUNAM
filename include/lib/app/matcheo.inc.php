<?php

function ws_aware($biometrico,$operacion,$parametros){ // recibe tipo de biometrico, operación e información biometrica
    // switch del tipo de biométrico
    switch ($biometrico) {
        
        case "huella":
            $server='nexafp';
            switch ($operacion) { // switch para el tipo de operación biométtrica
                
                case "identificar": // 1:N
                    $resultado =consulta_ws_aware(get_url($server, 'identify'), $parametros);
                    return $resultado;
                    
                    break;
                    
                case "verificar": // 1:1
                    //return get_url($server, 'verify') ;
                    $resultado =consulta_ws_aware(get_url($server, 'verify'), $parametros);
                    return $resultado;
                    break;
                    
                case "agregar":
                    $resultado =consulta_ws_aware(get_url($server, 'add'), $parametros);
                    return $resultado;
                    break;
            }
            break;
    }
    
}

function get_url($server,$operacion){ //generar url de acceso al server
    return "http://localhost:8080/$server/$operacion/cache1";
}

//petición POST al server Aware
function consulta_ws_aware($url,$data){ // recibe url y datos de envío
    $data=json_encode($data);
    
    $curl = curl_init ( $url );
    curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, "POST" );
    curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
    curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
    curl_setopt ( $curl, CURLOPT_HTTPHEADER, array (
        'Content-Type: application/json',
        'Content-Length: ' . strlen ( $data )
    ) );
    $json_response = curl_exec ( $curl );
    $status = curl_getinfo ( $curl, CURLINFO_HTTP_CODE );
    curl_close ( $curl );
    //$response = json_decode ( $json_response, true );
    return array('estatus'=>$status,'result'=>$json_response);
    
}

// método no utilizado
function getValidacionHuella($huella) {  
	$Biometrico = str_replace ( ' ', '+', $huella );
	$url = "http://216.58.174.68/nexafp/identify/mh";
	$huellas = array (
			'RIGHT_INDEX' => array (
					'image' => $Biometrico 
			) 
	);
	$data = json_encode ( array (
			'probe' => $huellas,
			'workflow' => array (
					'filters' => [ 
							array (
									'algorithm' => 'D350',
									'percentage' => 0.1,
									'minimum' => 100000,
									'fingerprint_types' => [ 
											'RIGHT_THUMB',
											'RIGHT_INDEX',
											'RIGHT_MIDDLE',
											'RIGHT_RING',
											'RIGHT_LITTLE',
											'LEFT_THUMB',
											'LEFT_INDEX',
											'LEFT_MIDDLE',
											'LEFT_RING',
											'LEFT_LITTLE' 
									] 
							) 
					],
					'comparator' => array (
							'algorithm' => 'D600',
							'fingerprint_types' => [ 
									'RIGHT_THUMB',
									'RIGHT_INDEX',
									'RIGHT_MIDDLE',
									'RIGHT_RING',
									'RIGHT_LITTLE',
									'LEFT_THUMB',
									'LEFT_INDEX',
									'LEFT_MIDDLE',
									'LEFT_RING',
									'LEFT_LITTLE' 
							] 
					) 
			),
			'candidate_list_size' => 3 
	) );
	
	$curl = curl_init ( $url );
	curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, "POST" );
	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
	curl_setopt ( $curl, CURLOPT_HTTPHEADER, array (
			'Content-Type: application/json',
			'Content-Length: ' . strlen ( $data ) 
	) );
	$json_response = curl_exec ( $curl );
	$status = curl_getinfo ( $curl, CURLINFO_HTTP_CODE );
	curl_close ( $curl );
	$response = json_decode ( $json_response, true );
	
	
	//var_dump ( $response );
	//var_dump ( $status );
	
	if ($status == 200) {
		if (! is_null ( json_decode ( $json_response ) )) {
			//var_dump(json_decode($json_response));
			//var_dump(json_decode($response));
			if (!is_object(json_decode($json_response))) {
			//if (is_object( json_decode ( $response ) )) {
				$objetError = json_decode ( $response );
				$objetError=$objetError->error;
				$codeError=$objetError->code;
				$descError=$objetError->description;
				if($codeError==1014)
					return array(false);
				returnAppError($descError);
			} else {
				$str = json_decode ( $json_response );
				
				if (json_encode ( $str->candidate_list )) {
					foreach ( $response as $respuesta => $candidatos ) {
						foreach ( $candidatos as $num => $arraInfo ) {
							$id = $arraInfo ['id'];
							$score = $arraInfo ['score'];
							$score_fmr = $arraInfo ['score_fmr'];
							if ($score > 0) {
								return array (
										true,
										$id 
								);
							}
							return array (
									false 
							);
						}
					}
				}
				returnAppError ( $response ['error'] );
			}
		}
	} else {
		if (! is_null ( json_decode ( $json_response ) )) {
			returnAppError ( $response ['error'] );
		} else {
			returnAppError ( $json_response );
		}
	}
}
// método no utilizado
function getValidacionRostro($Rostro) {
	//$Biometrico = str_replace ( ' ', '+', $Rostro );
	$url = "http://216.58.174.68:8081/nexaface/identify";
	$face = array (
			'VISIBLE_FRONTAL' => $Rostro 
	);
	$data = json_encode ( array (
			'probe' => $face,
			'workflow' => array (
					'comparator' => array (
							'algorithm' => 'F200',
							'face_types' => [ 
									'VISIBLE_FRONTAL' 
							] 
					) 
			),
			'candidate_list_size' => 3 
	) );
	
	$curl = curl_init ( $url );
	curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, "POST" );
	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
	curl_setopt ( $curl, CURLOPT_HTTPHEADER, array (
			'Content-Type: application/json',
			'Content-Length: ' . strlen ( $data ) 
	) );
	$json_response = curl_exec ( $curl );
	$status = curl_getinfo ( $curl, CURLINFO_HTTP_CODE );
	curl_close ( $curl );
	$response = json_decode ( $json_response, true );
	
	// var_dump (json_decode($data) );
	//var_dump ( $response );
	//var_dump($status);
	if ($status == 200) {
		/*
		 * if (! is_null ( json_decode ( $json_response ) )) {
		 * $str = json_decode ( $json_response );
		 * var_dump($str->operation_error);
		 * if (json_encode ( $str->candidate_list )) {
		 */
		if (array_key_exists ( "operation_error", $response )) {
			if ($response ['operation_error'] == 1014)
				return array (
						false 
				);
			//returnAppError ( " error " . $response ['operation_error'] );
		} else if (array_key_exists ( "candidate_list", $response )) {
			foreach ( $response as $respuesta => $candidatos ) {
				foreach ( $candidatos as $num => $arraInfo ) {
					$id = $arraInfo ['external_id'];
					$score = $arraInfo ['compare_score'];
					if ($score > 10) {
						return array (
								true,
								$id 
						);
					}
					return array (
							false 
					);
				}
			}
		}
	} else {
		if (! is_null ( json_decode ( $json_response ) )) {
			returnAppError ( $response ['error'] );
		} else {
			returnAppError ( $json_response );
		}
	}
}
?>
