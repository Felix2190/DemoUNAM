<?php
$seccion="";
$subseccion="";
$arrSeccionesPagina=array(

		"dashboard"=>"inicio",
		
		"crearturno"=>"turnos",
		"listadoTurnos"=>"turnos",
		"verturnos"=>"turnos",
		"atenderturno"=>"turnos",
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
		"listadoExamen"=>"licencias",
		"listadoImpresion"=>"licencias",
		"examenUpload"=>"licencias",
		"listadoPagos"=>"licencias",
		"generarPago"=>"licencias",

		"listadoPagosPendientes"=>"licencias",
		"corteCaja"=>"licencias",
		"corteHistorial"=>"licencias",
		

    
    
    
    "listadoReglas"=>"reglas",
    "generarReglaLicencia"=>"reglas",
    "listadoReglasLicencia"=>"reglas",
    "reglaLicencia"=>"reglas",
    "generarReglaDescuento"=>"reglas",
    "listadoReglasDescuento"=>"reglas",

    "reglaDescuento"=>"reglas",
    "listadoUsuarios"=>"reglas",
    "generarUsuario"=>"reglas",
    "usuario"=>"reglas",
    "listadoRoles"=>"reglas",
    "generarRol"=>"reglas",
    "rol"=>"reglas",

    "generarRecaudacion"=>"reglas",
    "listadoRecaudaciones"=>"reglas",
    "recaudacion"=>"reglas",
	
	"plastico"=>"reglas",
    "listadoPlasticos"=>"reglas",
    "busquedaPlastico"=>"reglas",
    "asignacionPlastico"=>"reglas",
    "busquedaFolio"=>"reglas",
	"listadoFolios"=>"reglas",

		
		"comparativoOficinas"=>"reportes",
		"busquedaProductos"=>"reportes",
		"altaProducto"=>"reportes",
		"registroEntrada"=>"reportes",
		"registroSalida"=>"reportes",
		"registroTraslado"=>"reportes",
		"historial"=>"reportes",
		"repComOfi"=>"reportes",
		"repLicenciasExportarSat"=>"reportes",
		"repLicenciasAvances"=>"reportes",
		
		"repLicenciaDetalladoMes"=>"reportes",
		"repLicenciaAcumuladoMes"=>"reportes",
		"repLicenciaEmitidas"=>"reportes",
		"repLicenciaResumenGeneral"=>"reportes",
		"repListadoLicenciasFechaUbicacion"=>"reportes",
		"verPersona"=>"reportes",
        "verPersonas"=>"reportes",
		
//		""=>"",
		"ticket"=>"soporte",
		"ticketadd"=>"soporte",
		"ticketasg"=>"soporte",
		"ticketrev"=>"soporte",
		"tickethis"=>"soporte",
		"ticketroot"=>"soporte",
		
		"generalReportes"=>"reportes",
		"busquedaProductos"=>"reportes",
    "reppadron"=>"reportes",
    "poa"=>"reportes",
    "repoficina"=>"reportes",
    "repoficinacom"=>"reportes",
    "repTipoLic"=>"reportes",
    "repdescuentos"=>"reportes",
    "repdescuentoscruz"=>"reportes",
    "repdescuentosdecreto"=>"reportes",
    "repactivas"=>"reportes",
    "repconstancias"=>"reportes",
    "repreportes"=>"reportes",
		"repLicenciasVigentes"=>"reportes",
		"repProximasVencer"=>"reportes",
		"repLicenciaTipo"=>"reportes",
		"busquedaPersona"=>"reportes",
		
		
		"cotizacionesListado"=>"Ventas",
		"cotizador"=>"Ventas",
		"busquedaProd"=>"Ventas",
		"listadoProd"=>"Ventas",
		
		

		
		"listadoImpresion"=>"Impresion",


);


$idOp='';

$seccion=isset($arrSeccionesPagina[$__FILE_NAME__])?$arrSeccionesPagina[$__FILE_NAME__]:"";
$subseccion=$__FILE_NAME__;



//echo "[" . $seccion . "][" . $subseccion . "]<br />";
if ($subseccion!='biograficos'){
    unset($_SESSION['idPersonaBio']);
    unset($_SESSION['idPersonaExtras']);
    unset($_SESSION['idDomicilio']);
    unset($_SESSION['idFilacion']);
    unset($_SESSION['idContacto']);
}
/*
if ($subseccion!='busquedaFolio'&&isset($_SESSION['idNumFolio']))
    unset($_SESSION['idNumFolio']);
*/