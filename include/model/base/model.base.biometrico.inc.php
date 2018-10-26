<?php

	class ModeloBaseBiometrico extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBaseBiometrico";

		
		var $idBiometrico=0;
		var $clave='';
		var $keyAware='';
		var $nombre='';
		var $tipo='huella';
		var $controlID=0;

		var $__s=array("idBiometrico","clave","keyAware","nombre","tipo","controlID");
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

		
		public function setIdBiometrico($idBiometrico)
		{
			if($idBiometrico==0||$idBiometrico==""||!is_numeric($idBiometrico)|| (is_string($idBiometrico)&&!ctype_digit($idBiometrico)))return $this->setError("Tipo de dato incorrecto para idBiometrico.");
			$this->idBiometrico=$idBiometrico;
			$this->getDatos();
		}
		public function setClave($clave)
		{
			
			$this->clave=$clave;
		}
		public function setKeyAware($keyAware)
		{
			
			$this->keyAware=$keyAware;
		}
		public function setNombre($nombre)
		{
			
			$this->nombre=$nombre;
		}
		public function setTipo($tipo)
		{
			
			$this->tipo=$tipo;
		}
		public function setTipoHuella()
		{
			$this->tipo='huella';
		}
		public function setTipoIris()
		{
			$this->tipo='iris';
		}
		public function setTipoRostro()
		{
			$this->tipo='rostro';
		}
		public function setControlID($controlID)
		{
			
			$this->controlID=$controlID;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdBiometrico()
		{
			return $this->idBiometrico;
		}
		public function getClave()
		{
			return $this->clave;
		}
		public function getKeyAware()
		{
			return $this->keyAware;
		}
		public function getNombre()
		{
			return $this->nombre;
		}
		public function getTipo()
		{
			return $this->tipo;
		}
		public function getControlID()
		{
			return $this->controlID;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idBiometrico=0;
			$this->clave='';
			$this->keyAware='';
			$this->nombre='';
			$this->tipo='huella';
			$this->controlID=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO biometrico(clave,keyAware,nombre,tipo,controlID)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->clave) . "','" . mysqli_real_escape_string($this->dbLink,$this->keyAware) . "','" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "','" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "','" . mysqli_real_escape_string($this->dbLink,$this->controlID) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBaseBiometrico::Insertar]");
				
				$this->idBiometrico=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE biometrico SET clave='" . mysqli_real_escape_string($this->dbLink,$this->clave) . "',keyAware='" . mysqli_real_escape_string($this->dbLink,$this->keyAware) . "',nombre='" . mysqli_real_escape_string($this->dbLink,$this->nombre) . "',tipo='" . mysqli_real_escape_string($this->dbLink,$this->tipo) . "',controlID='" . mysqli_real_escape_string($this->dbLink,$this->controlID) . "'
					WHERE idBiometrico=" . $this->idBiometrico;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseBiometrico::Update]");
				
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
				$SQL="DELETE FROM biometrico
				WHERE idBiometrico=" . mysqli_real_escape_string($this->dbLink,$this->idBiometrico);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBaseBiometrico::Borrar]");
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
						idBiometrico,clave,keyAware,nombre,tipo,controlID
					FROM biometrico
					WHERE idBiometrico=" . mysqli_real_escape_string($this->dbLink,$this->idBiometrico);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBaseBiometrico::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idBiometrico==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>