<?php
	$_SESSION['lang']="es_mx";
	class UtilsModel
	{
		private $db=null;
		public function __construct($conexion=null)
		{
			if($conexion!=null){
				$this->db=$conexion;
			}
			else{
				$this->db=new PDOConfig();
				$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}
		}

		#---------------------------------------------------------------------------------------------------------------------------#
		#------------------------------------------------------Entidades------------------------------------------------------------#
		#---------------------------------------------------------------------------------------------------------------------------#
		function charset($cadena)
		{
			return mb_detect_encoding($cadena,"UTF-8,ISO-8859-1");
		}
		function entidades($cadena)
		{
			return htmlentities($cadena,ENT_QUOTES,$this->charset($cadena));
		}
		function sin_entidades($cadena)
		{
			return html_entity_decode(rawurldecode($cadena),ENT_QUOTES,$this->charset($cadena));
		}

		function arreglo_sin_entidades($arreglo)
		{
			if(isset($arreglo) && count($arreglo)>0){
				foreach ($arreglo AS $k=>$datos)
				{
					if(is_array($datos)){
						$arreglo[$k]=$this->arreglo_sin_entidades($datos);
					}
					elseif(is_string($datos)){
						$arreglo[$k]=$this->sin_entidades($datos);
					}
				}
			}
			return $arreglo;
		}

		function arreglo_urldecode($array){
			$arrayNuevo=array();
			if(isset($array) && count($array)>0){
				for($i=0;$i<count($array);$i++){
					$arrActual=$array[$i];
					foreach ($arrActual as $k => $v) {
						$arrActual[$k]=rawurldecode($v);
					}
					$arrayNuevo[$i]=$arrActual;
				}
			}
			return $arrayNuevo;
		}
		#---------------------------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Sesion---------------------------------------------------------------------#
		#---------------------------------------------------------------------------------------------------------------------------#
		//Inicia la sesion del usuario
		public function activaSesionUsuario($idUsuario)
		{
			$_SESSION['ID_USER']=$idUsuario;
			$_SESSION["SESSION_TIME"] = time();
		}
		#---------------------------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Archivos-Directorios-------------------------------------------------------#
		#---------------------------------------------------------------------------------------------------------------------------#
		/**
		 * Elimina el contenido de un directorio
		 */
		function destroy($path,$incluirBase=false)
		{
			if(is_dir($path)){
				$dir=scandir($path);
				foreach($dir AS $k=>$elemento)
				{
					if($elemento!="."&&$elemento!="..")
					{
						$ruta=$path . "/" . $elemento;
						if(is_dir($ruta))
						{
							$this->destroy($ruta);
							rmdir($ruta);
						}
						else{
							unlink($ruta);
						}
					}
				}
				if($incluirBase){
					rmdir($path);
				}
			}
			return TRUE;
		}
		/**
		 * Obtiene el directorio raiz del usuario
		 * @param idUsuario
		 */
		function getDirectorioUsuario($idUsuario){
			return PATH_ARCHIVOS.$idUsuario.DIR_SEPARATOR;
		}
		/**
		 * Obtiene el directorio de imagenes del usuario
		 * @param idUsuario
		 */
		function getDirectorioImagenesUsuario($idUsuario){
			$dirUsuario=$this->getDirectorioUsuario($idUsuario);
			return $dirUsuario.FOLDER_IMAGENES_USUARIO.DIR_SEPARATOR;
		}
		/**
		 * Obtiene el directorio temporal del usuario
		 * @param idUsuario
		 */
		function getDirectorioTemporalUsuario($idUsuario){
			$dirUsuario=$this->getDirectorioUsuario($idUsuario);
			return $dirUsuario.FOLDER_TEMPORAL_USUARIO.DIR_SEPARATOR;
		}
		/**
		 * Obtiene el directorio de archivos del usuario
		 * @param idUsuario
		 */
		function getDirectorioArchivosUsuario($idUsuario){
			$dirUsuario=$this->getDirectorioUsuario($idUsuario);
			return $dirUsuario.FOLDER_ARCHIVOS_USUARIO.DIR_SEPARATOR;
		}
		/**
		 * Genera todos los tipos de imagenes para un perfil y borra el archivo tomado para generarlas
		 * @param directorioDestino
		 * @param nombreImagen
		 * @param rutaFileOriginal
		 */
		function generaTiposImagenes($directorioDestino,$nombreImagen,$rutaFileOriginal,$x=0,$y=0,$W=0,$eliminaOrigen=true)
		{
			if(!file_exists($directorioDestino)){
				$this->creaDirectorioSiNoExiste($directorioDestino);
			}
			$imagen=new clsImagen($rutaFileOriginal);
			if($imagen->getError()){
				Throw new madException($imagen->getStrError());
			}
			$imagen->setCalidadJPG(CALIDAD_JPG);
			$imagen->setJPG();
			$imagen->setCarpetaSalida($directorioDestino);
			//Imagen grande
			$imagen->setMax(ANCHO_IMAGEN_BIG,ALTO_IMAGEN_BIG);
			$imagen->setNombreSalida($nombreImagen. PREFIJO_BIG);
			$imagen->Crear();
			if($imagen->getError()){
				Throw new madException($imagen->getStrError());
			}
			//Imagen mediana
			$imagen->setMax(ANCHO_IMAGEN_MED,ALTO_IMAGEN_MED);
			$imagen->setNombreSalida($nombreImagen . PREFIJO_MED);
			$imagen->Crear();
			if($imagen->getError()){
				Throw new madException($imagen->getStrError());
			}
			//Imagen miniatura

			if($x!=0&&$y!=0&&$W!=0)
				$imagen->setRecorte($x,$y,$W,$W);
			else
				$imagen->setRelleno();
			$imagen->forzarRedimension();

			$imagen->setMax(ANCHO_IMAGEN_MINI,ALTO_IMAGEN_MINI);
			$imagen->setNombreSalida($nombreImagen . PREFIJO_MINI);
			$imagen->Crear();
			if($imagen->getError()){
				Throw new madException($imagen->getStrError());
			}
			if($eliminaOrigen)
				unlink($rutaFileOriginal);
			$mini=$imagen->getNombre();
			$resultado=array();
			$resultado['estatus']=STATUS_UPLOAD_SUCCESS;
			$resultado['datos']=$directorioDestino. $mini;
			return $resultado;
		}
		/**
		 * Crea un directorio con toda su descendencia verificando que no exista
		 */
		function creaDirectorioSiNoExiste($directorio,$base="")
		{

			$directorio=str_replace ($base,"",$directorio);



			$directorios=explode("/", $directorio);
			$directorioActual=$base;
			for($i=0;$i<count($directorios);$i++)
			{
				$directorioActual.=$directorios[$i]."/";
				if(!file_exists($directorioActual)&&!mkdir($directorioActual, 0777))
					throw new madException('No se logro crear el directorio [' .$directorioActual . ']');
			}
			return TRUE;
		}
		#---------------------------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Generadores----------------------------------------------------------------#
		#---------------------------------------------------------------------------------------------------------------------------#
		public function generarCadenaAleatoria($lenght=20,$caracteresPermitidos="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789")
		{
			$retorno="";
			for($i=0;$i<$lenght;$i++)
				$retorno.=substr($caracteresPermitidos,rand(1,strlen($caracteresPermitidos))-1,1);
			return $retorno;

		}
		/**
		 * Obtiene un nombre unico para una imgen
		 */
		function obtenerNombreUnicoParaImagen(){
			$nombreImagen = uniqid("",true);
			$nombreImagen = str_replace(".", "", $nombreImagen);
			return $nombreImagen;
		}
		#---------------------------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Fechas---------------------------------------------------------------------#
		#---------------------------------------------------------------------------------------------------------------------------#
		public function esFecha($fecha)
		{
			$PedazosFecha=explode("/",$fecha);
			if(count($PedazosFecha)!=3)
				return FALSE;
			$A=$PedazosFecha[2];
			$M=$PedazosFecha[1];
			$D=$PedazosFecha[0];
			if(($M)<1||($M)>12)
				return FALSE;
			switch(($M))
			{
				case 1:
				case 3:
				case 5:
				case 7:
				case 8:
				case 10:
				case 12:
					if(($D)>31)
						return FALSE;
					break;
				case 2:
					if(($A%400==0||($A%4==0&&$A%100!=0))&&$D>29)
						return FALSE;
					if($D>28)
						return FALSE;
					break;
				default:
				if($D>30)
					return FALSE;
			}
			return TRUE;
		}

		public function fechaMySQL($fecha)
		{
			$PedazosFecha=explode("-",$fecha);
			return $PedazosFecha[2] . "/" . $PedazosFecha[1] . "/" . $PedazosFecha[0];
		}
		#---------------------------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Logs-----------------------------------------------------------------------#
		#---------------------------------------------------------------------------------------------------------------------------#
		public function Log($txt)
		{
			$pf=fopen(DEBUG_PATH_FILE,"a");
			fwrite($pf,"\n" . date("Y-m-d H:i:s") . "---->" . $txt);
			fclose($pf);
		}
		#---------------------------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Validators-----------------------------------------------------------------#
		#---------------------------------------------------------------------------------------------------------------------------#

		public function soloCaracteresPermitidos($str,$permitidos="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789.-_",$blancoPorGuion=true)
		{
			if($blancoPorGuion)
				$str=str_replace(" ","_",$str);
			$cadena="";
			for($i=0;$i<strlen($str);$i++)
			{
				$caracter=substr($str, $i,1);
				$pos=strpos($permitidos, $caracter);
				if($pos!==false)
					$cadena.=$caracter;
			}
			return $cadena;
		}

		public function file_upload_error_message($error_code)
		{
			switch ($error_code)
			{
				case UPLOAD_ERR_INI_SIZE:
					return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
				case UPLOAD_ERR_FORM_SIZE:
					return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
				case UPLOAD_ERR_PARTIAL:
					return 'The uploaded file was only partially uploaded';
				case UPLOAD_ERR_NO_FILE:
					return 'No file was uploaded';
				case UPLOAD_ERR_NO_TMP_DIR:
					return 'Missing a temporary folder';
				case UPLOAD_ERR_CANT_WRITE:
					return 'Failed to write file to disk';
				case UPLOAD_ERR_EXTENSION:
					return 'File upload stopped by extension';
				default:
					return 'Unknown upload error';
			}
		}

		#---------------------------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Base de datos--------------------------------------------------------------#
		#---------------------------------------------------------------------------------------------------------------------------#


		/**
		*
		* Funcion para creas enlaces simbolicos para las rutas de las fotos de perfil.
		* @param INT $idPerfil
		* @param STR $rutaFoto ruta de la imagen foto de perfil, completa, pero sin _min.jpg, _med.jpg y _big_jpg
		*/


		public function crearEnlaceSimbolicoFotoPerfil($idPerfil,$rutaFoto)
		{
			$sufijos=array(PREFIJO_BIG,PREFIJO_MED,PREFIJO_MINI);
			$rutaDestino=PATH_ARCHIVOS . $idPerfil . "/";
			foreach($sufijos AS $k=>$sufijo)
			{
				@unlink($rutaDestino . "profile" . $sufijo . ".jpg");

				if(!is_file($rutaFoto . $sufijo . ".jpg"))
					die("!Error!![" . $rutaFoto . $sufijo . ".jpg]");
				symlink($rutaFoto . $sufijo . ".jpg",$rutaDestino . "profile" . $sufijo . ".jpg");
			}
		}


		/**
		 * Guarda la imagen de un perfil en BD
		 * @param idPerfil
		 * @param imagen
		 * @param isTransactionAlreadyStarted (por default siempre es true lo que significa que usualmente es llamada cuando ya se inicio una transaccion)
		 */
		function guardaImagenPerfilBD($nombreImagen,$idGaleria, $descripcion,$isTransactionAlreadyStarted=true)
		{
			$retorno=array();
			try
			{
				if(!$isTransactionAlreadyStarted)
				{
					$this->db->beginTransaction();
				}
				$NOW=date("Y-m-d H:i:s");

				$SQL="UPDATE fotos SET orden=orden+1 WHERE idGaleria=:idGaleria";
				$consulta=$this->db->prepare($SQL);
				$consulta->bindParam(":idGaleria",$idGaleria);
				$consulta->execute();

				$SQL="	INSERT INTO fotos(nombre,orden,fechaCreacion,idGaleria,descripcion)
						VALUES(:imagen,1,'" . $NOW . "',:idGaleria,:descripcion
						)";
				$consulta=$this->db->prepare($SQL);
				$consulta->bindParam(":imagen",$nombreImagen);
				$consulta->bindParam(":idGaleria",$idGaleria);
				$consulta->bindParam(":descripcion",$descripcion);
				$consulta->execute();
				if(!$isTransactionAlreadyStarted){
					$this->db->commit();
				}
				$retorno=$this->retorno("",true);
			}
			catch(madException $e)
			{
				if(!$isTransactionAlreadyStarted){
					$this->db->rollBack();
				}
				$retorno = $this->retorno($e->getMessage());
			}
			catch (Exception $e)
			{
				if(!$isTransactionAlreadyStarted){
					$this->db->rollBack();
				}
				$retorno = $this->retorno($e->getMessage());
			}
			return $retorno;
		}
		#---------------------------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otros----------------------------------------------------------------------#
		#---------------------------------------------------------------------------------------------------------------------------#
		public function arrayFiles($files)
		{
			#print_r($files);
			$archivos=array();
			foreach($files AS $name=>$file)
			{
				if(is_array($file['name']))
				{
					for($i=0;$i<count($file['name']);$i++)
					{
						$fileAux['name']=$file['name'][$i];
						$fileAux['type']=$file['type'][$i];
						$fileAux['tmp_name']=$file['tmp_name'][$i];
						$fileAux['error']=$file['error'][$i];
						$fileAux['size']=$file['size'][$i];
						$archivos[$name][$i]=$fileAux;
					}
				}
				else
					$archivos[$name][0]=$file;
			}
			return $archivos;
		}

		function retorno($msj="", $success=false, $datos=array(), $numreg=0){


			$retorno['success']=$success;
			if($success){
				$retorno['msj']=$msj;
			}
			else{
				$retorno['msj']=DEBUG_MOSTRAR_JSON?$msj:STR_ERR_PROBLEMAS_TECNICOS;
			}
			$retorno['datos']=$this->arreglo_sin_entidades($datos);
			$retorno['numreg']=$numreg!=0 ? $numreg : count($datos);
			return $retorno;
		}
	}
?>