<?php

	class ModeloBasePersona extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBasePersona";

		
		var $idPersona=0;
		var $idResponseWSFTOFRM=0;
		var $primerAp='';
		var $segundoAp='';
		var $nombres='';
		var $segundoNombre='';
		var $fechaNacimiento='';
		var $genero='';
		var $CURP='';
		var $email='';
		var $codigoPais='';
		var $ladaTel='';
		var $telCasa='';
		var $telMovil='';
		var $estadoCivil=0;
		var $RFC='';
		var $homoclave='';
		var $nacionalidad='mex';
		var $nacCveEnt='';
		var $nacCveMun='';
		var $nacCveLoc='';

		var $__s=array("idPersona","idResponseWSFTOFRM","primerAp","segundoAp","nombres","segundoNombre","fechaNacimiento","genero","CURP","email","codigoPais","ladaTel","telCasa","telMovil","estadoCivil","RFC","homoclave","nacionalidad","nacCveEnt","nacCveMun","nacCveLoc");
		var $__ss=array();

		#------------------------------------------------------------------------------------------------------#
		#--------------------------------------------Inicializacion--------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		function __construct()
		{
			global $dbLink;
			if(is_null($dbLink))
			{
				trigger_error("La coneccion a la base de datos no esta establecida.",E_ERROR);
				return;
			}
			$this->dbLink=$dbLink;
			$this->link=$dbLink;
		}

		function __destruct()
		{
			
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Setter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function setIdPersona($idPersona)
		{
			if($idPersona==0||$idPersona==""||!is_numeric($idPersona)|| (is_string($idPersona)&&!ctype_digit($idPersona)))return $this->setError("Tipo de dato incorrecto para idPersona.");
			$this->idPersona=$idPersona;
			$this->getDatos();
		}
		public function setIdResponseWSFTOFRM($idResponseWSFTOFRM)
		{
			
			$this->idResponseWSFTOFRM=$idResponseWSFTOFRM;
		}
		public function setPrimerAp($primerAp)
		{
			
			$this->primerAp=$primerAp;
		}
		public function setSegundoAp($segundoAp)
		{
			
			$this->segundoAp=$segundoAp;
		}
		public function setNombres($nombres)
		{
			
			$this->nombres=$nombres;
		}
		public function setSegundoNombre($segundoNombre)
		{
			
			$this->segundoNombre=$segundoNombre;
		}
		public function setFechaNacimiento($fechaNacimiento)
		{
			$this->fechaNacimiento=$fechaNacimiento;
		}
		public function setGenero($genero)
		{
			
			$this->genero=$genero;
		}
		public function setGeneroM()
		{
			$this->genero='M';
		}
		public function setGeneroH()
		{
			$this->genero='H';
		}
		public function setCURP($CURP)
		{
			
			$this->CURP=$CURP;
		}
		public function setEmail($email)
		{
			
			$this->email=$email;
		}
		public function setCodigoPais($codigoPais)
		{
			
			$this->codigoPais=$codigoPais;
		}
		public function setLadaTel($ladaTel)
		{
			
			$this->ladaTel=$ladaTel;
		}
		public function setTelCasa($telCasa)
		{
			
			$this->telCasa=$telCasa;
		}
		public function setTelMovil($telMovil)
		{
			
			$this->telMovil=$telMovil;
		}
		public function setEstadoCivil($estadoCivil)
		{
			
			$this->estadoCivil=$estadoCivil;
		}
		public function setRFC($RFC)
		{
			
			$this->RFC=$RFC;
		}
		public function setHomoclave($homoclave)
		{
			
			$this->homoclave=$homoclave;
		}
		public function setNacionalidad($nacionalidad)
		{
			
			$this->nacionalidad=$nacionalidad;
		}
		public function setNacionalidadMex()
		{
			$this->nacionalidad='mex';
		}
		public function setNacionalidadExt()
		{
			$this->nacionalidad='ext';
		}
		public function setNacCveEnt($nacCveEnt)
		{
			
			$this->nacCveEnt=$nacCveEnt;
		}
		public function setNacCveMun($nacCveMun)
		{
			
			$this->nacCveMun=$nacCveMun;
		}
		public function setNacCveLoc($nacCveLoc)
		{
			
			$this->nacCveLoc=$nacCveLoc;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdPersona()
		{
			return $this->idPersona;
		}
		public function getIdResponseWSFTOFRM()
		{
			return $this->idResponseWSFTOFRM;
		}
		public function getPrimerAp()
		{
			return $this->primerAp;
		}
		public function getSegundoAp()
		{
			return $this->segundoAp;
		}
		public function getNombres()
		{
			return $this->nombres;
		}
		public function getSegundoNombre()
		{
			return $this->segundoNombre;
		}
		public function getFechaNacimiento()
		{
			return $this->fechaNacimiento;
		}
		public function getGenero()
		{
			return $this->genero;
		}
		public function getCURP()
		{
			return $this->CURP;
		}
		public function getEmail()
		{
			return $this->email;
		}
		public function getCodigoPais()
		{
			return $this->codigoPais;
		}
		public function getLadaTel()
		{
			return $this->ladaTel;
		}
		public function getTelCasa()
		{
			return $this->telCasa;
		}
		public function getTelMovil()
		{
			return $this->telMovil;
		}
		public function getEstadoCivil()
		{
			return $this->estadoCivil;
		}
		public function getRFC()
		{
			return $this->RFC;
		}
		public function getHomoclave()
		{
			return $this->homoclave;
		}
		public function getNacionalidad()
		{
			return $this->nacionalidad;
		}
		public function getNacCveEnt()
		{
			return $this->nacCveEnt;
		}
		public function getNacCveMun()
		{
			return $this->nacCveMun;
		}
		public function getNacCveLoc()
		{
			return $this->nacCveLoc;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idPersona=0;
			$this->idResponseWSFTOFRM=0;
			$this->primerAp='';
			$this->segundoAp='';
			$this->nombres='';
			$this->segundoNombre='';
			$this->fechaNacimiento='';
			$this->genero='';
			$this->CURP='';
			$this->email='';
			$this->codigoPais='';
			$this->ladaTel='';
			$this->telCasa='';
			$this->telMovil='';
			$this->estadoCivil=0;
			$this->RFC='';
			$this->homoclave='';
			$this->nacionalidad='mex';
			$this->nacCveEnt='';
			$this->nacCveMun='';
			$this->nacCveLoc='';
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO persona(idResponseWSFTOFRM,primerAp,segundoAp,nombres,segundoNombre,fechaNacimiento,genero,CURP,email,codigoPais,ladaTel,telCasa,telMovil,estadoCivil,RFC,homoclave,nacionalidad,nacCveEnt,nacCveMun,nacCveLoc)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idResponseWSFTOFRM) . "','" . mysqli_real_escape_string($this->dbLink,$this->primerAp) . "','" . mysqli_real_escape_string($this->dbLink,$this->segundoAp) . "','" . mysqli_real_escape_string($this->dbLink,$this->nombres) . "','" . mysqli_real_escape_string($this->dbLink,$this->segundoNombre) . "','" . mysqli_real_escape_string($this->dbLink,$this->fechaNacimiento) . "','" . mysqli_real_escape_string($this->dbLink,$this->genero) . "','" . mysqli_real_escape_string($this->dbLink,$this->CURP) . "','" . mysqli_real_escape_string($this->dbLink,$this->email) . "','" . mysqli_real_escape_string($this->dbLink,$this->codigoPais) . "','" . mysqli_real_escape_string($this->dbLink,$this->ladaTel) . "','" . mysqli_real_escape_string($this->dbLink,$this->telCasa) . "','" . mysqli_real_escape_string($this->dbLink,$this->telMovil) . "','" . mysqli_real_escape_string($this->dbLink,$this->estadoCivil) . "','" . mysqli_real_escape_string($this->dbLink,$this->RFC) . "','" . mysqli_real_escape_string($this->dbLink,$this->homoclave) . "','" . mysqli_real_escape_string($this->dbLink,$this->nacionalidad) . "','" . mysqli_real_escape_string($this->dbLink,$this->nacCveEnt) . "','" . mysqli_real_escape_string($this->dbLink,$this->nacCveMun) . "','" . mysqli_real_escape_string($this->dbLink,$this->nacCveLoc) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePersona::Insertar]");
				
				$this->idPersona=mysqli_insert_id($this->dbLink);
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		protected function Actualizar()
		{
			try
			{
				$SQL="UPDATE persona SET idResponseWSFTOFRM='" . mysqli_real_escape_string($this->dbLink,$this->idResponseWSFTOFRM) . "',primerAp='" . mysqli_real_escape_string($this->dbLink,$this->primerAp) . "',segundoAp='" . mysqli_real_escape_string($this->dbLink,$this->segundoAp) . "',nombres='" . mysqli_real_escape_string($this->dbLink,$this->nombres) . "',segundoNombre='" . mysqli_real_escape_string($this->dbLink,$this->segundoNombre) . "',fechaNacimiento='" . mysqli_real_escape_string($this->dbLink,$this->fechaNacimiento) . "',genero='" . mysqli_real_escape_string($this->dbLink,$this->genero) . "',CURP='" . mysqli_real_escape_string($this->dbLink,$this->CURP) . "',email='" . mysqli_real_escape_string($this->dbLink,$this->email) . "',codigoPais='" . mysqli_real_escape_string($this->dbLink,$this->codigoPais) . "',ladaTel='" . mysqli_real_escape_string($this->dbLink,$this->ladaTel) . "',telCasa='" . mysqli_real_escape_string($this->dbLink,$this->telCasa) . "',telMovil='" . mysqli_real_escape_string($this->dbLink,$this->telMovil) . "',estadoCivil='" . mysqli_real_escape_string($this->dbLink,$this->estadoCivil) . "',RFC='" . mysqli_real_escape_string($this->dbLink,$this->RFC) . "',homoclave='" . mysqli_real_escape_string($this->dbLink,$this->homoclave) . "',nacionalidad='" . mysqli_real_escape_string($this->dbLink,$this->nacionalidad) . "',nacCveEnt='" . mysqli_real_escape_string($this->dbLink,$this->nacCveEnt) . "',nacCveMun='" . mysqli_real_escape_string($this->dbLink,$this->nacCveMun) . "',nacCveLoc='" . mysqli_real_escape_string($this->dbLink,$this->nacCveLoc) . "'
					WHERE idPersona=" . $this->idPersona;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBasePersona::Update]");
				
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		public function Borrar()
		{
			if($this->getError())
				return false;
			try
			{
				$SQL="DELETE FROM persona
				WHERE idPersona=" . mysqli_real_escape_string($this->dbLink,$this->idPersona);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBasePersona::Borrar]");
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		public function getDatos()
		{
			try
			{
				$SQL="SELECT
						idPersona,idResponseWSFTOFRM,primerAp,segundoAp,nombres,segundoNombre,fechaNacimiento,genero,CURP,email,codigoPais,ladaTel,telCasa,telMovil,estadoCivil,RFC,homoclave,nacionalidad,nacCveEnt,nacCveMun,nacCveLoc
					FROM persona
					WHERE idPersona=" . mysqli_real_escape_string($this->dbLink,$this->idPersona);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePersona::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

				if(mysqli_num_rows($result)==0)
				{
					$this->limpiarPropiedades();
				}
				else
				{
					$datos=mysqli_fetch_assoc($result);
					foreach($datos as $k=>$v)
					{
						$campo="" . $k;
						$this->$campo=$v;
					}
				}
				return true;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		

		
		public function Guardar()
		{
			if(!$this->validarDatos())
				return false;
			if($this->getError())
				return false;
			if($this->idPersona==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>