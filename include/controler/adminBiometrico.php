<?php

/**
 * @author Alexander Mayorga
 * @copyright 2017
 */


function obtenerBiometricos()
{
    
    	global $dbLink;
	
	$sql = "SELECT * FROM biometrico WHERE keyAware!=''";
	$res = mysqli_query ( $dbLink, $sql );
	$arrBiometrico = array ();
	if ($res && mysqli_num_rows ( $res ) > 0) {
	
		while ( $row_inf = mysqli_fetch_assoc ( $res ) ) {
			$biometrico = array(
					'idBiometrico'=>$row_inf['idBiometrico'],
					'clave'=>$row_inf['clave'],
					'keyAware'=>$row_inf['keyAware'],
					'nombre'=>$row_inf['nombre']
					
			);
			$arrBiometrico[]=$biometrico;
		}
	
	}
	return $arrBiometrico;
	
}


?>