<?php
$seccion="";
$subseccion="";
$arrSeccionesPagina=array(

		"dashboard"=>"inicio",
		
		"listadoTurnos"=>"turnos",
		"generarTurnos"=>"turnos",
		"asignaTramite"=>"turnos",
		"buscarTurnos"=>"turnos",
		"verificacionBiografica"=>"turnos",
		"verificacionBiometrica"=>"turnos",
		
		"biograficos"=>"licencias",
		"biometricos"=>"licencias",
		"documentos"=>"licencias",
		"listadoIdentidades"=>"licencias",
		"listadoUsuarios"=>"licencias",
		"examenMedico"=>"licencias",
		"examenTeorico"=>"licencias",
		
		"listadoPagos"=>"licencias",
		"generarPago"=>"licencias",
    
    "listadoReglas"=>"reglas",
    "generarReglaLicencia"=>"reglas",
    "listadoReglasLicencia"=>"reglas",
    "reglaLicencia"=>"reglas",
    "generarReglaDescuento"=>"reglas",
    "listadoReglasDescuento"=>"reglas",
    "reglaDescuento"=>"reglas",   
		
		
		"comparativoOficinas"=>"reportes",
		"busquedaProductos"=>"reportes",
		"altaProducto"=>"reportes",
		"registroEntrada"=>"reportes",
		"registroSalida"=>"reportes",
		"registroTraslado"=>"reportes",
		"historial"=>"reportes",
		
//		""=>"",
		"ticket"=>"soporte",
		"ticketadd"=>"soporte",
		"ticketasg"=>"soporte",
		"ticketrev"=>"soporte",
		"tickethis"=>"soporte",
		"ticketroot"=>"soporte",
		
		"generalReportes"=>"reportes",
		"busquedaProductos"=>"reportes",
		
		"cotizacionesListado"=>"Ventas",
		"cotizador"=>"Ventas",
		"busquedaProd"=>"Ventas",
		"listadoProd"=>"Ventas",
);


$idOp='';

$seccion=isset($arrSeccionesPagina[$__FILE_NAME__])?$arrSeccionesPagina[$__FILE_NAME__]:"";
$subseccion=$__FILE_NAME__;



//echo "[" . $seccion . "][" . $subseccion . "]";

?>
