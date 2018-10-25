<?php



	if(!defined("DEVELOPER"))
	{
		DEFINE("BASE_INCLUDE",$_SERVER['DOCUMENT_ROOT'] . "/../include/");
		//require_once("/var/www/include/conf/constantes.php");
		require_once(BASE_INCLUDE . "conf/constantes.php");
	}
	require_once(LIB_CONEXION);


	$SQL="SELECT value FROM config WHERE name='translate'";
	$record=mysqli_query($dbLink,$SQL);
	if(mysqli_num_rows($record)==0)
	{
		define("TRANSLATE","no");
	}
	else
	{
		$row=mysqli_fetch_assoc($record);
		if($row['value']=="yes")
			define("TRANSLATE","yes");
		else
			define("TRANSLATE","no");

	}



	function detectaIdiomaNavegador()
	{
		//$pf=fopen(FOLDER_LOG . "idioma_" .time(),"a");
		//fwrite($pf,$_SERVER["HTTP_ACCEPT_LANGUAGE"] . "\n");
		//fclose($pf);
		return substr($_SERVER["HTTP_ACCEPT_LANGUAGE"],0,2);
	}

	#if(!function_exists("translate"))
	#{
		function translate($cadena,$regresar=0)
		{
			global $dbLink;
			if(!isset($_SESSION['clientLanguage'])||TRANSLATE=="no")
			{

				switch(detectaIdiomaNavegador())
				{
					case "es":
						$_SESSION['clientLanguage']="es_MX";
						break;
					case "fr":
						$_SESSION['clientLanguage']="fr_FR";
						break;
					case "pt":
						$_SESSION['clientLanguage']="pt_BR";
						break;
					default:
						$_SESSION['clientLanguage']="en_US";
				}


			}

			$SQL="SELECT
						T.string AS string
					FROM translate AS T
					INNER JOIN keytranslate AS K ON T.idKeyTranslate=K.idKeyTranslate
					INNER JOIN language AS L ON T.idLanguage=L.idLanguage
					WHERE L.code='" . $_SESSION['clientLanguage'] . "' AND K.string='" . $cadena . "'";
			$record=mysqli_query($dbLink,$SQL);
			if(mysqli_num_rows($record)==0)
			{
				$SQL="SELECT count(*) as cuenta FROM keytranslate WHERE string='" . $cadena . "'";
				$record=mysqli_query($dbLink,$SQL);
				$row=mysqli_fetch_assoc($record);
				if($row['cuenta']==0)
				{
					mysqli_query($dbLink,"INSERT INTO keytranslate(string) VALUES('" . $cadena . "')");
				}
				$retorno=$cadena;
			}
			else
			{
				$row=mysqli_fetch_assoc($record);
				if(trim($row['string'])=="")
					$retorno=$cadena;
				else
				$retorno=trim($row['string']);

			}
			if($regresar)
				return $retorno;
			echo $retorno;
		}

		function translateReturn($cadena)
		{
			return translate($cadena,1);
		}
	#}


	function generaTranslateJS($cadenas)
	{
		$translate=array();
		foreach($cadenas as $k=>$v)
			$translate[]=translateReturn($v);
		$js="
			var _translateOriginal=new Array('" . implode("','",$cadenas) . "');
			var _translate=new Array('" . implode("','",$translate) . "');";
		return $js;
	}