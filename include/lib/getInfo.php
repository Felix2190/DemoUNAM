<?php

	function setError($mensaje)
	{
		$respuesta=array("response"=>array("status"=>"ERROR","errormessage"=>$mensaje));
		return json_encode($respuesta);
	}
	
	
	#$_POST['apikey']=$_GET['key'];
	
	#if(isset($_GET['idE']))
	#	$_POST['idEntrada']=$_GET['idE'];
	#if(isset($_GET['idC']))
	#	$_POST['idCategria']=$_GET['idC'];

	if(!isset($_POST['apikey']))
		die(setError("Error en el pase de parametros apikey."));
	
	if(!isset($_POST['idEntrada'])&&!isset($_POST['idCategoria']))
		die(setError("Error en el pase de parametros."));
		
	if($_POST['apikey']!="03e718b2581a1d83d045b8b51d4b294d")
		die(setError("El APIKEY es incorrecta."));
	
	
	if(isset($_POST['idCategoria'])&&(trim($_POST['idCategoria'])==""||!ctype_digit($_POST['idCategoria'])))
		die(setError("El idCategoria es incorrecto."));
	
	if(isset($_POST['idEntrada'])&&(trim($_POST['idEntrada'])==""||!ctype_digit($_POST['idEntrada'])))
		die(setError("El idEntrada es incorrecto."));
		
	
	if(!mysql_connect("localhost","makko","MkKoOk1640"))
		die(setError("Error al conectar con BD."));
	
	if(!mysql_select_db("admin_la"))
		die(setError("Error al seleccionar la BD."));
	
	
	if(isset($_POST['idEntrada']))
	{
		$SQL="SELECT 
					parent_entry_id AS padre,title AS titulo,content AS contenido,datecreated AS fechaCreacion,datechanged AS fechaModificacion
				FROM qu_la_kb_entries
				WHERE kb_entry_id='" . mysql_real_escape_string($_POST['idEntrada']) . "' AND access='P' AND deleted='N' AND rtype='A'";
		$record=mysql_query($SQL);
		if(!$record)
			die(setError("Error al consultar BD."));
		$row=mysql_fetch_assoc($record);
		foreach($row AS $k=>$v)
			$row[$k]=utf8_encode($v);
		die(json_encode(array("response"=>$row)));
	}
	
	
	
	$SQL="SELECT 
				kb_entry_id AS id,rtype AS tipo,title AS titulo
			FROM qu_la_kb_entries
			WHERE parent_entry_id='" . mysql_real_escape_string($_POST['idCategoria']) . "' AND access='P' AND deleted='N'
			ORDER BY rtype DESC,rorder ASC";
	$record=mysql_query($SQL);
	if(!$record)
		die(setError("Error al consultar BD."));
		
	$Datos=array();
	
	while($row=mysql_fetch_assoc($record))
	{
		foreach($row AS $k=>$v)
			$row[$k]=utf8_encode($v);
		$Datos['datos'][]=$row;
	}
	die(json_encode(array("response"=>$Datos)));