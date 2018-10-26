<?php

	require FOLDER_MODEL_BASE . "model.base.persona.inc.php";

	class ModeloPersona extends ModeloBasePersona
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBasePersona";
		
		

		var $strPathIdentidad="";

		var $__ss=array("strPathIdentidad");

		#------------------------------------------------------------------------------------------------------#
		#--------------------------------------------Inicializacion--------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		function __construct()
		{
			parent::__construct();
		}

		function __destruct()
		{
			
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Setter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

        public function getNombreCompleto()
        {
            return $this->getNombres() . ' ' .$this->getPrimerAp(). ' ' . $this->getSegundoAp();
        }

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		public function calculaEdad($fecha)
        {
        	$query="select timestampdiff(year,'" . $fecha . "',curdate()) AS edad";
        	$result=mysqli_query($this->dbLink, $query);
        	$row=mysqli_fetch_assoc($result);
        	return $row['edad'];
        }
		
        public function esMenor()
        {
        	$query="select timestampdiff(year,'" . $this->fechaNacimiento . "',curdate()) AS edad";
        	$result=mysqli_query($this->dbLink, $query);
        	
        	
        	$row=mysqli_fetch_assoc($result);
        	
        	
        	$resultado=$row["edad"]<"18";
        	
        	return $resultado;
        }
		
		/*
		getPathIdentidadTmp
		getPathIdentidadFirma
		getPathIdentidadDocumentos
		getPathIdentidadHuellas
		getPathIdentidadIris
		getPathIdentidadRostro
		*/
		public function getPathIdentidadTmp()
        {
        	if(!$this->makeFolders()) return false;
        	return $this->strPathIdentidad . "tmp/";
        	
        }
        
        public function getPathIdentidadFirma()
        {
        	if(!$this->makeFolders()) return false;
        	return $this->strPathIdentidad . "firma/";
        	 
        }
        
        public function getPathIdentidadDocumentos()
        {
        	if(!$this->makeFolders()) return false;
        	return $this->strPathIdentidad . "documentos/";
        	 
        }
        
        public function getPathIdentidadHuellas($nombre)
        {
        	if(!$this->makeFolders($nombre)) return false;
        	return $this->strPathIdentidad . "biometricos/huellas/";
        	 
        }
        
        public function getPathIdentidadIris()
        {
        	if(!$this->makeFolders()) return false;
        	return $this->strPathIdentidad . "biometricos/iris/";
        	 
        }
        
        public function getPathIdentidadRostro()
        {
        	if(!$this->makeFolders()) return false;
        	return $this->strPathIdentidad . "biometricos/rostro/";
        	 
        }
        
        
        public function getPathIdentidad()
        {
        	if(!$this->makeFolders())
        		return false;
        	return $this->strPathIdentidad;
        }
        
        public function makeFolders($nombre)
        {
            if(!is_dir($_SERVER['DOCUMENT_ROOT'] . "DemoUNAM/html/tmp/"))
            {
                mkdir($_SERVER['DOCUMENT_ROOT'] . "DemoUNAM/html/tmp/",0762);
            }
            
            if(!is_dir($_SERVER['DOCUMENT_ROOT'] . "DemoUNAM/html/tmp/$nombre/"))
        	{
        	    mkdir($_SERVER['DOCUMENT_ROOT'] . "DemoUNAM/html/tmp/$nombre/",0762);
        	}
        		
        		$directorios=array();
        		$directorios[]=$_SERVER['DOCUMENT_ROOT'] . "DemoUNAM/html/tmp/$nombre/biometricos/";
        		$directorios[]=$_SERVER['DOCUMENT_ROOT'] . "DemoUNAM/html/tmp/$nombre/biometricos/huellas/";
        		
        		foreach($directorios As $k=>$directorio)
        		{
        			if(!is_dir($directorio))
        			{
        				mkdir($directorio,0762);
        			}
        			
        		}
        		$this->strPathIdentidad=$_SERVER['DOCUMENT_ROOT'] . "DemoUNAM/html/tmp/$nombre/";
        		return true;
        }
		
		public function validarDatos()
		{
			
			
			/*--------------------------------------------------------------------------------*/
			/*---------------------Validacion de Fecha FM3 y nacionalidad---------------------*/
			/*--------------------------------------------------------------------------------*/
			
			if($this->getNacionalidad()!="mex"&&$this->getNacionalidad()!="mexicana"&&$this->getFM3()<=date("Y-m-d")) // Es extranjero
			{
				$this->setError("El contribuyente es extranjero y su fecha de estadia (FM3) es menor a la fecha actual.");
			}
			
			/*--------------------------------------------------------------------------------*/
			/*-------------------------------Validacion de CURP-------------------------------*/
			/*--------------------------------------------------------------------------------*/
			
			$this->CURP=trim($this->CURP);			
			$this->primerAp=trim($this->primerAp);
			$this->segundoAp=trim($this->segundoAp);
			$this->nombres=trim($this->nombres);
			$this->nacCveEnt=trim($this->nacCveEnt);
			$this->fechaNacimiento=trim($this->fechaNacimiento);
			$this->genero=trim($this->genero);
			
			if(strlen($this->CURP)!=18)
			{
				return $this->setError("La CURP debe ser de 18 caracteres.");
			}
			
			if(strlen($this->nacCveEnt)!=2)
			{
				return $this->setError("La entidad de nacimiento es incorrecta.");
			}
			
			if($this->primerAp==""&&$this->segundoAp=="")
			{
				return $this->setError("Captura el primer o el segundo apellido.");
			}
			
			if(strlen($this->fechaNacimiento)!=10)
			{
				return $this->setError("La fecha de nacimiento es incorrecta.");
			}
			
			if($this->nombres=="")
			{
				return $this->setError("El nombre es necesario.");
			}
			
			$query="SELECT COUNT(*) AS cuenta FROM estado_nacimiento WHERE codigo='" . $this->nacCveEnt . "'";
			$result=mysqli_query($this->dbLink, $query);
			if(!$result)
			{
				return $this->setSystemError("Ocurrio un error en la busqueda de clave de estado de nacimiento.", "[" . $this->_nombreClase . ":LN254][" . $query . "][" . mysqli_error($this->dbLink) . "]");
			}
			$row=mysqli_fetch_assoc($result);
			if($row["cuenta"]!="1")
			{
				return $this->setError("La clave de la entidad de nacimiento es incorrecta.");
			}
			
			if(!in_array($this->genero,array("H","M")))
			{
				return $this->setError("El genero es incorrecto.");
			}
			
			$fechaPedazos=explode("-",$this->fechaNacimiento);
			if(trim($fechaPedazos[0])==""||!ctype_digit(trim($fechaPedazos[0]))||strlen(trim($fechaPedazos[0]))!=4)
			{
				return $this->setError("La fecha de nacimiento tiene formato erroneo [primera seccion].");
			}
			
			if(trim($fechaPedazos[1])==""||!ctype_digit(trim($fechaPedazos[1]))||strlen(trim($fechaPedazos[1]))!=2)
			{
				return $this->setError("La fecha de nacimiento tiene formato erroneo [segunda seccion].");
			}
		
			if(trim($fechaPedazos[2])==""||!ctype_digit(trim($fechaPedazos[2]))||strlen(trim($fechaPedazos[2]))!=2)
			{
				return $this->setError("La fecha de nacimiento tiene formato erroneo [tercera seccion].");
			}
			
			if(!in_array(trim($fechaPedazos[1]),array("01","02","03","04","05","06","07","08","09","10","11","12")))
			{
				return $this->setError("La fecha de nacimiento tiene formato erroneo [mes incorrecto].");
			}
			
			$anio=trim($fechaPedazos[0])+0;
			$mes=trim($fechaPedazos[1])+0;
			$dia=trim($fechaPedazos[2])+0;
			if(trim($fechaPedazos[1])=="02")
			{
				if($anio%400==0||($anio%100!=0&&$anio%4==0))//bisiesto
				{
					if($dia>29)
					{
						return $this->setError("La fecha de nacimiento tiene formato erroneo [dia incorrecto].");
					}
				}
				else
				{
					if($dia>28)
					{
						return $this->setError("La fecha de nacimiento tiene formato erroneo [dia incorrecto].");
					}
				}
			}
			else
			{
				switch($mes)
				{
					case 1:
					case 3:
					case 5:
					case 7:
					case 8:
					case 10:
					case 12:
						if($dia>31)
						{
							return $this->setError("La fecha de nacimiento tiene formato erroneo [dia incorrecto].");
						}
						break;
					default:
						if($dia>30)
						{
							return $this->setError("La fecha de nacimiento tiene formato erroneo [dia incorrecto].");
						}
				}
			}
			
			if($this->calculaEdad($this->fechaNacimiento)<15)
			{
				return $this->setError("La fecha de nacimiento es erronea.");
			}
			
			
			
			$inicial = substr($this->CURP,0,4);
			$nacimiento = substr($this->CURP,4,6);
			$sexo = substr($this->CURP,10,1);
			$entidad = substr($this->CURP,11,2);
			$quinta = substr($this->CURP,13,3);
			$diferenciador = substr($this->CURP,16,1);
			$verificador = substr($this->CURP,17,1);
			
			
			//echo "[" . $inicial . "][" . $nacimiento . "][" . $sexo . "][" . $entidad . "][" . $quinta . "][" . $diferenciador . "][" . $verificador . "]";
			//die();
			
			
			
			if(!ctype_alpha($inicial))
			{
				return $this->setError("Estructura de la CURP es incorrecta (los primeros 4 caracteres deben ser letras [" . $inicial . "]).");
			}
			
			if(!ctype_digit($nacimiento))
			{
				return $this->setError("Estructura de la CURP es incorrecta (fecha de nacimiento deben ser numeros [" . $nacimiento . "]).");
			}
			
			if(strtoupper($this->genero)!=strtoupper($sexo))
			{
				return $this->setError("Estructura de la CURP es incorrecta (el genero no coincide, genero registrado:[" . $this->genero . "] , genero en la CURP:[" . $sexo . "]).");
			}
			
			if(strtoupper($this->nacCveEnt)!=strtoupper($entidad))
			{
				return $this->setError("Estructura de la CURP es incorrecta (la entidad de nacimiento no coincide, entidad registrada:[" . $this->nacCveEnt . "] , entida en la CURP:[" . $entidad. "]).");
			}
			
			$fechaRegistrada=str_replace("-", "", substr($this->fechaNacimiento, 2));
			
			if($fechaRegistrada!=$nacimiento)
			{
				return $this->setError("Estructura de la CURP es incorrecta (la fecha de nacimiento no coincide, fecha registrada:[" . $fechaRegistrada . "] , entida en la CURP:[" . $nacimiento. "]).");
			}
			
			if(!preg_match("/^[BCDFGHJKLMNPQRSTVWXYZ]{3}$/", strtoupper($quinta)))
			{
				return $this->setError("Estructura de la CURP es incorrecta [" . $quinta . "] solo deberian de ser letras consonantes.");
			}
			
			if(($this->fechaNacimiento<'2000-01-01'&&!ctype_digit($diferenciador))||($this->fechaNacimiento>='2000-01-01'&&!ctype_alpha(diferenciador)))
			{
				return $this->setError("Estructura de la CURP es incorrecta. Digito diferenciador de homonomia y siglo es incorrecto.");
			}
			
			if(!ctype_digit($verificador))
			{
				return $this->setError("Estructura de la CURP es incorrecta. Digito verificador es incorrecto.");
			}
			
			
			$query="SELECT COUNT(*) AS cuenta FROM palabra WHERE palabra='" . $inicial . "'";
			$result=mysqli_query($this->dbLink, $query);
			if(!$result)
			{
				return $this->setSystemError("Ocurrio un error en la busqueda de palabra inapropiada.", "[" . $this->_nombreClase . ":LN404][" . $query . "][" . mysqli_error($this->dbLink) . "]");
			}
			$row=mysqli_fetch_assoc($result);
			if($row["cuenta"]!="0")
			{
				return $this->setError("Estructura de la CURP es incorrecta. Palabra inapropiada.");
			}	
			
			
			/*--------------------------------------------------------------------------------*/
			/*----------------Validacion de Entidad Nacimiento vs Nacionalidad----------------*/
			/*--------------------------------------------------------------------------------*/
			
			/*
			#Se retira validacion a peticion de Juan Diego
			if(($this->getNacionalidad()=="mex"||$this->getNacionalidad()=="mexicana")&&$this->nacCveEnt=="NE")
			{
				return $this->setError("La CURP del contribuyente no coincide con su nacionalidad.");
			}
			*/
			
			return true;
		}
		
		public function validaCurp($curp)
		{
			$sql='select idPersona, concat_ws(" ", nombres, primerAp, segundoAp) as nombre, fechaNacimiento, genero, email, CURP from persona where CURP="'.$curp.'"';
			$result=mysqli_query($this->dbLink, $sql);
			$arrInfo=array();
			if ($result&&mysqli_num_rows($result))
			{
				$arrInfo=mysqli_fetch_assoc($result);
			}
			return $arrInfo;
		}
		
		public function existeCURP($curp)
		{
			$sql='SELECT IFNULL(COUNT(*),0) AS cuenta FROM persona WHERE CURP="'.mysqli_real_escape_string($this->dbLink, $curp).'"';
			$result=mysqli_query($this->dbLink, $sql);
			if(!$result)
			{
				return $this->setSystemError("Ocurrio un error en la consulta del CURP.", "[" . $this->_nombreClase . ":LN192][" . $sql . "][" . mysqli_error($this->dbLink) . "]");
			}
			$row=mysqli_fetch_assoc($result);
			return $row['cuenta']>0;
		}
		
		public function getDatosByCURP($curp)
		{
			$query="SELECT idPersona FROM persona WHERE curp='" . mysqli_real_escape_string($this->dbLink, $curp) . "'";
			$result=mysqli_query($this->dbLink, $query);
			if(mysqli_num_rows($result)==0)
			{
				return $this->setError("CURP inexistente.");
			}
			
			$row=mysqli_fetch_assoc($result);
			return $this->setIdPersona($row['idPersona']);
		}


	}

