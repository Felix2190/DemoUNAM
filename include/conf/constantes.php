<?php

	define("DEVELOPER",true);

	#-----------------------------------------------------------------------------------------------------------------------#
	#------------------------------------------------CONSTANTES DE SISTEMA--------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------------#

	//define("SYSTEM_ID",1);
	//define("SYSTEM_NAME","Damaka");

	#-----------------------------------------------------------------------------------------------------------------------#
	#-----------------------------------------------CONSTANTES DE PRODUCCION------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------------#

	if(!DEVELOPER)
	{
		if(defined("SUBDIR"))
		{
			define("FOLDER_HTDOCS",$_SERVER['DOCUMENT_ROOT'] . "/" . SUBDIR . "/");
			define("DOMINIO","http://localhost/DemoUNAM/html/" . SUBDIR . "/");
		}
		else
		{
			define("FOLDER_HTDOCS",$_SERVER['DOCUMENT_ROOT'] . "/");
			define("DOMINIO","http://localhost/DemoUNAM/html/");
		}
		//define("FOLDER_OSTICKET","/var/www/html/admin/osticket/");
		//define("DOMINIO","http://vps-1152682-20296.manage.myhosting.com/admin/");

		#define("WEBSERVICE_URL","https://zonea.amadeocloud.com/axis2/services/DamakaServer/");
		#define("WEBSERVICE_KEY","20APR8710JUL8810MAY87");
		#define("CPANEL_URL","https://cpanel.amadeocloud.com");

		//define("ENVIOMAIL_SMTP",false);
		define("ERR_DEBUG",false);

		define("SESSION_TIME",1800);
		define("SOPORTE_TIME",600);

	}

	#-----------------------------------------------------------------------------------------------------------------------#
	#------------------------------------------------CONSTANTES DE DESARROLLO-----------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------------#

	if(DEVELOPER)
	{

		if(defined("SUBDIR"))
		{
			define("FOLDER_HTDOCS",$_SERVER['DOCUMENT_ROOT'] . "/" . SUBDIR . "/");
			define("DOMINIO","http://DemoUNAM/" . SUBDIR . "/");
		}
		else
		{
			define("FOLDER_HTDOCS","./");
			define("DOMINIO","http://localhost/DemoUNAM/html/");
		}

		
		#define("WEBSERVICE_URL","https://zonea.amadeocloud.com/axis2/services/DamakaServer/");
		#define("CPANEL_URL","https://zonea.amadeocloud.com/cpanel/");		
		#define("WEBSERVICE_KEY","20APR8710JUL8810MAY87");
		
		define("ERR_DEBUG",true);
	}
	else{
		define("FOLDER_HTDOCS",$_SERVER['DOCUMENT_ROOT'] . "/");
	}

	#---------------------------------------------------------------------------------------------------------------------------#
	#-----------------------------------------------CONSTANTES PARA BASE DE DATOS-----------------------------------------------#
	#---------------------------------------------------------------------------------------------------------------------------#

	if(DEVELOPER)
	{
		define("CONFIGURACION_DBMS","mysql");
		define("CONFIGURACION_DBMS_HOST","localhost");
		define("CONFIGURACION_DBMS_DB","emision");
		define("CONFIGURACION_DBMS_USER","root");
		define("CONFIGURACION_DBMS_PASS","");
		define("CONFIGURACION_DBMS_PREFIX","");
		define("ISEARCH_ADMIN_PASSWORD","123456789");
	}
	else
	{

		#$username = '';
		#$password = 'QV?pPti$=P#2';
		#$hostname = 'localhost';
		#$database = '';

		define("CONFIGURACION_DBMS","mysql");
		define("CONFIGURACION_DBMS_HOST","localhost");
		define("CONFIGURACION_DBMS_DB","licenciastam3");
		define("CONFIGURACION_DBMS_USER","lic_tam");
		define("CONFIGURACION_DBMS_PASS","L1ct4m$018");
		define("CONFIGURACION_DBMS_PREFIX","");
		define("ISEARCH_ADMIN_PASSWORD","hJzCCNed8FmAT5dq");
	}

	#-----------------------------------------------------------------------------------------------------------------------#
	#--------------------------------------------------CONSTANTES DE KDUCEO-------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------------#


	/*
	define("DAMAKA_URL_WS","http://soap.1161.my-online-check.com/avavoip_gate.php?wsdl");
	define("DAMAKA_USER","soap_external");
	define("DAMAKA_PASS",'s0@padwscrm161');
	*/


	define("DAMAKA_URL_WS","http://soap.1161.my-online-check.com/avavoip_gate.php?wsdl");
	#define("DAMAKA_URL_WS","http://http://216.224.186.54/avavoip_gate.php?wsdl");
	
	define("DAMAKA_USER","soap_external");
	define("DAMAKA_PASS",'s0@padwscrm161');

	/*
	<soap:Header>
		<user xsi:type="xsd:string">soap_external</user>
		<password xsi:type="xsd:string">fe02d097ffa37983dccf75d11ac06aad</password>
	</soap:Header>
	*/

	#-----------------------------------------------------------------------------------------------------------------------#
	#--------------------------------------------------CONSTANTES DE DIDWW--------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------------#

	//define("DIDWW_URL_WS","https://api.didww.com/api2/?wsdl");
	//define("DIDWW_USER","htmoff@hotmail.com");
	//define("DIDWW_PASS",'GIU9ENBQ1R0UEJX2A9XQBZB');

	
	
	#-----------------------------------------------------------------------------------------------------------------------#
	#-------------------------------------------------CONSTANTES DE FOLDERS-------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------------#

	define("FOLDER_INCLUDE",BASE_INCLUDE);
	define("FOLDER_LIB",FOLDER_INCLUDE . "lib/");
	define("FOLDER_COMMON",FOLDER_INCLUDE . "common/");
	define("FOLDER_CONF",FOLDER_INCLUDE . "conf/");
	define("FOLDER_MODEL",FOLDER_INCLUDE . "model/");
  define("FOLDER_MODEL_BASE",FOLDER_MODEL . "base/");
	define("FOLDER_MODEL_EXTEND",FOLDER_MODEL . "extend/");
  
	define("FOLDER_MODEL_DATA",FOLDER_INCLUDE . "model/data/");
	define("FOLDER_MODEL_WS",FOLDER_INCLUDE . "model/ws/");
	define("FOLDER_MODEL_WSTAM",FOLDER_INCLUDE . "model/WSTamaulipas/");
	define("FOLDER_MODEL_WSDIDWW",FOLDER_INCLUDE . "model/wsdidww/");
	define("FOLDER_MODEL_SUPPDESK",FOLDER_INCLUDE . "model/suppdesk/");
	define("FOLDER_MODEL_WSAMADEOCLOUD",FOLDER_INCLUDE . "model/wsamadeocloud/");
	define("FOLDER_CONTROLLER",FOLDER_INCLUDE . "controler/");


	//define("FOLDER_DATOS",FOLDER_HTDOCS . "datos/");

	define("FOLDER_JS",$_SERVER['DOCUMENT_ROOT'] . "/DemoUNAM/html/js/system/");
	define("FOLDER_LOG",FOLDER_INCLUDE . 'log/');
	define("FOLDER_CDR",FOLDER_INCLUDE . 'cdr/');
	define("FOLDER_CDR_TMP",FOLDER_INCLUDE . 'cdrTMP/');
	define("FOLDER_AUTHORIZE",FOLDER_INCLUDE . "lib/anet_php_sdk/");

	#-----------------------------------------------------------------------------------------------------------------------#
	#------------------------------------------------CONSTANTES DE LIBRERIAS------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------------#

	define("LIB_AUTHORIZE",FOLDER_LIB . "anet_php_sdk/lib/");
	define("LIB_TRANSLATE",FOLDER_LIB . "Translate/translate.inc.php");
	//define("LIB_CONEXION",FOLDER_LIB . "Conexion/Conexion.php");
	define("LIB_CONEXION",FOLDER_LIB . "Conexion/mysql.inc.php");
	define("LIB_EXCEPTION",FOLDER_LIB . "Excepciones/Exception.php");
	//define("LIB_IMAGE",FOLDER_LIB . "Image/class.clsImagen.inc.php");
	//define("LIB_EMAIL",FOLDER_LIB . "Mail/envioMail.php");
	define("LIB_NUSOAP",FOLDER_LIB . "nuSOAP/nusoap.php");
	define("LIB_UTILS",FOLDER_LIB . "Utilidades/Utils.php");
	define("LIB_XAJAX",FOLDER_LIB . "xajax_core/xajax.inc.php");
	//define("LIB_CHART",FOLDER_LIB . "phpgraphlib_v2.31/phpgraphlib.php");
	define("LIB_CSV",FOLDER_LIB . "csv/csv2mysql.inc.php");
	//define("FILE_PAGINACION",FOLDER_COMMON . "paginacion.inc.php");
	define("LIB_REVISAR_PENDIENTES_XAJAX",FOLDER_LIB . "Utilidades/xajaxRevisarPendientes.inc.php");
	
	define("LIB_FPDF",FOLDER_INCLUDE . "lib/pdf/fpdf.php");
	define("LIB_PDFRECIBOCAJA",FOLDER_INCLUDE . "lib/pdf/pdfImpresionReciboCaja.inc.php");

	#-----------------------------------------------------------------------------------------------------------------------#
	#--------------------------------------------------CONSTANTES DE CLASES-------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------------#


	//define("CLASS_COMUN",FOLDER_MODEL_DATA . "clsBasicCommon.inc.php");
	define("CLASS_COMUN",FOLDER_MODEL . "clsBasicCommon.inc.php");
	define("CLASS_COMUN_CONSULTA",FOLDER_MODEL_DATA . "common.consulta.inc.php");
	define("CLASS_SESSION",FOLDER_MODEL_DATA . "clsSession.inc.php");

	#-----------------------------------------------------------------------------------------------------------------------#
	#--------------------------------------------------CONSTANTES DE URLS---------------------------------------------------#
	#-----------------------------------------------------------------------------------------------------------------------#


	define("URL_JAVASCRIPT",  "js/system/");
	define("URL_TMP", "datos/tmp/");

	#define("URL_JAVASCRIPT_AJAX_UPLOAD", DOMINIO . "javascripts/lib/AjaxUpload.2.0.min.js");
	#define("URL_JAVASCRIPT_DEFAULT", DOMINIO . "javascripts/lib/default.js");

	#define("URL_JAVASCRIPT_COMMON", DOMINIO . "javascripts/common/");
	#define("URL_JAVASCRIPT_COMMON_LIB", URL_JAVASCRIPT_COMMON . "common.js");

	/*
	define("URL_FILES_ALERT",'<script language="javascript" src="' . DOMINIO . 'js/lib/jquery.alerts-1.1/jquery.alerts.js"></script>
			<link rel="stylesheet" type="text/css" href="js/lib/jquery.alerts-1.1/jquery.alerts.css" />
			<script language="javascript" src="' . DOMINIO . 'js/lib/common.js"></script>');
	*/

	define("URL_XAJAX_JS",  "js/lib/");

	#define("URL_CSS_JQUERY_UI", DOMINIO . "css/blitzer/jquery-ui-1.9.0.custom.min.css");
	#define("URL_JAVASCRIPT_JQUERY", DOMINIO . "javascripts/lib/jquery-1.8.2.js");
	#define("URL_JAVASCRIPT_JQUERY", DOMINIO . "js/jquery-1.7.2.min.js");
	#define("URL_JAVASCRIPT_JQUERY_UI", DOMINIO . "javascripts/lib/jquery-ui-1.9.0.custom.min.js");
	#define("URL_JAVASCRIPT_JQUERY_DATAPICKER_ESP", DOMINIO . "javascripts/lib/jquery.numeric.js");
	define("URL_JAVASCRIPT_NUMERIC", DOMINIO . "js/lib/jquery.numeric.js");
	#define("URL_JAVASCRIPT_NUMERIC", DOMINIO . "javascripts/lib/ui.datepicker-es.2.js");
	#define("URL_JAVASCRIPT_TINYMCE", DOMINIO . "javascripts/lib/tinymce/tiny_mce.js");

	#---------------------------------------------------------------------------------------------------------------------------#
	#------------------------------------------------CONSTANTES PARA URLs RUTAS-------------------------------------------------#
	#---------------------------------------------------------------------------------------------------------------------------#

	define("DIR_SEPARATOR","/");


	#---------------------------------------------------------------------------------------------------------------------------#
	#--------------------------------------------------NOMBRES DE FOLDERS-------------------------------------------------------#
	#---------------------------------------------------------------------------------------------------------------------------#

	#---------------------------------------------------------------------------------------------------------------------------#
	#--------------------------------------------------CONSTANTES PARA SESSION--------------------------------------------------#
	#---------------------------------------------------------------------------------------------------------------------------#




	#---------------------------------------------------------------------------------------------------------------------------#
	#------------------------------------------------CONSTANTES PARA DEPURACION-------------------------------------------------#
	#---------------------------------------------------------------------------------------------------------------------------#


	//define("DEBUG_FILE",true);
	//define("DEBUG_MOSTRAR_JSON",true);
	//define("DEBUG_PATH_FILE",FOLDER_LOG . "error.log");
	//define("ERR_AUTOR",999999);



	#---------------------------------------------------------------------------------------------------------------------------#
	#------------------------------------------------------OTRAS----------------------------------------------------------------#
	#---------------------------------------------------------------------------------------------------------------------------#

	define("_NOW_",date("Y-m-d H:i:s"));
	define("_CURDATE_",date("Y-m-d"));
	//define("EMAIL_SYSTEM","soporte@kduceo.com");

