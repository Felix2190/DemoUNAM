<?php

$dbLink=null;

/*
if(!function_exists("ConectarBD"))
{
	function ConectarBD()
	{
		mysql_connect(CONFIGURACION_DBMS_HOST,CONFIGURACION_DBMS_USER,CONFIGURACION_DBMS_PASS) or die("controler:lib:Conexion:Error en la conexion a la BD");
		mysql_select_db(CONFIGURACION_DBMS_DB) or die("controler:lib:Conexion:Error en la seleccion de la BD");
	}
	ConectarBD();
}
*/

$dbLink=mysqli_connect(CONFIGURACION_DBMS_HOST,CONFIGURACION_DBMS_USER,CONFIGURACION_DBMS_PASS,CONFIGURACION_DBMS_DB);
mysqli_set_charset($dbLink,"utf8");
