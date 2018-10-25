<?php

	class ModeloBasePersona_biometrico extends clsBasicCommon
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="base.ModeloBasePersona_biometrico";

		
		var $idPersonaBiometrico=0;
		var $idPersona=0;
		var $idBiometrico=0;
		var $archivo='';
		var $estatusCaptura='disponible';
		var $idOperacionAutoriza=0;

		var $__s=array("idPersonaBiometrico","idPersona","idBiometrico","archivo","estatusCaptura","idOperacionAutoriza");
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

		
		public function setIdPersonaBiometrico($idPersonaBiometrico)
		{
			if($idPersonaBiometrico==0||$idPersonaBiometrico==""||!is_numeric($idPersonaBiometrico)|| (is_string($idPersonaBiometrico)&&!ctype_digit($idPersonaBiometrico)))return $this->setError("Tipo de dato incorrecto para idPersonaBiometrico.");
			$this->idPersonaBiometrico=$idPersonaBiometrico;
			$this->getDatos();
		}
		public function setIdPersona($idPersona)
		{
			
			$this->idPersona=$idPersona;
		}
		public function setIdBiometrico($idBiometrico)
		{
			
			$this->idBiometrico=$idBiometrico;
		}
		public function setArchivo($archivo)
		{
			
			$this->archivo=$archivo;
		}
		public function setEstatusCaptura($estatusCaptura)
		{
			
			$this->estatusCaptura=$estatusCaptura;
		}
		public function setEstatusCapturaDisponible()
		{
			$this->estatusCaptura='disponible';
		}
		public function setEstatusCapturaNodisponible()
		{
			$this->estatusCaptura='nodisponible';
		}
		public function setEstatusCapturaDedovenda()
		{
			$this->estatusCaptura='dedovenda';
		}
		public function setIdOperacionAutoriza($idOperacionAutoriza)
		{
			
			$this->idOperacionAutoriza=$idOperacionAutoriza;
		}

		#------------------------------------------------------------------------------------------------------#
		#-----------------------------------------------Unsetter-----------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Getter------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		
		public function getIdPersonaBiometrico()
		{
			return $this->idPersonaBiometrico;
		}
		public function getIdPersona()
		{
			return $this->idPersona;
		}
		public function getIdBiometrico()
		{
			return $this->idBiometrico;
		}
		public function getArchivo()
		{
			return $this->archivo;
		}
		public function getEstatusCaptura()
		{
			return $this->estatusCaptura;
		}
		public function getIdOperacionAutoriza()
		{
			return $this->idOperacionAutoriza;
		}

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#

		

		protected function limpiarPropiedades()
		{
			
			$this->idPersonaBiometrico=0;
			$this->idPersona=0;
			$this->idBiometrico=0;
			$this->archivo='';
			$this->estatusCaptura='disponible';
			$this->idOperacionAutoriza=0;
		}

		

		
		protected function Insertar()
		{
			try
			{
				$SQL="INSERT INTO persona_biometrico(idPersona,idBiometrico,archivo,estatusCaptura,idOperacionAutoriza)
						VALUES('" . mysqli_real_escape_string($this->dbLink,$this->idPersona) . "','" . mysqli_real_escape_string($this->dbLink,$this->idBiometrico) . "','" . mysqli_real_escape_string($this->dbLink,$this->archivo) . "','" . mysqli_real_escape_string($this->dbLink,$this->estatusCaptura) . "','" . mysqli_real_escape_string($this->dbLink,$this->idOperacionAutoriza) . "')";
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la insercion de registro.","[" . $SQL . "][" . mysqli_error($this->dbLink) . "][ModeloBasePersona_biometrico::Insertar]");
				
				$this->idPersonaBiometrico=mysqli_insert_id($this->dbLink);
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
				$SQL="UPDATE persona_biometrico SET idPersona='" . mysqli_real_escape_string($this->dbLink,$this->idPersona) . "',idBiometrico='" . mysqli_real_escape_string($this->dbLink,$this->idBiometrico) . "',archivo='" . mysqli_real_escape_string($this->dbLink,$this->archivo) . "',estatusCaptura='" . mysqli_real_escape_string($this->dbLink,$this->estatusCaptura) . "',idOperacionAutoriza='" . mysqli_real_escape_string($this->dbLink,$this->idOperacionAutoriza) . "'
					WHERE idPersonaBiometrico=" . $this->idPersonaBiometrico;
				
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la actualizacion de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBasePersona_biometrico::Update]");
				
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
				$SQL="DELETE FROM persona_biometrico
				WHERE idPersonaBiometrico=" . mysqli_real_escape_string($this->dbLink,$this->idPersonaBiometrico);
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en el borrado de registro.","[" . $SQL . "][" . mysqli_error() . "][ModeloBasePersona_biometrico::Borrar]");
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
						idPersonaBiometrico,idPersona,idBiometrico,archivo,estatusCaptura,idOperacionAutoriza
					FROM persona_biometrico
					WHERE idPersonaBiometrico=" . mysqli_real_escape_string($this->dbLink,$this->idPersonaBiometrico);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePersona_biometrico::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

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
			if($this->idPersonaBiometrico==0)
				$this->Insertar();
			else
				$this->Actualizar();
			if($this->getError())
				return false;
			return true;
		}
		
	}

?>