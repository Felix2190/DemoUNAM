<?php

	require FOLDER_MODEL_BASE . "model.base.persona_biometrico.inc.php";

	class ModeloPersona_biometrico extends ModeloBasePersona_biometrico
	{
		#------------------------------------------------------------------------------------------------------#
		#----------------------------------------------Propiedades---------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		var $_nombreClase="ModeloBasePersona_biometrico";

		var $__ss=array();

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



		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Querys------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
public function verificaHuellaByIdBiometrico()
		{
			try
			{
				$SQL="SELECT
						idPersonaBiometrico,idPersona,idBiometrico,archivo
					FROM persona_biometrico
					WHERE idBiometrico=" . mysqli_real_escape_string($this->dbLink,$this->idBiometrico) . ' AND idPersona ='. mysqli_real_escape_string($this->dbLink,$this->idPersona);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePersona_biometrico::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

				if(mysqli_num_rows($result)==0)
				{
					//$this->limpiarPropiedades();
                    return false;
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
        
        public function verificaExisteHuellaByIdPersona()
		{
			try
			{
				$SQL="SELECT COUNT(*) AS contador FROM persona_biometrico WHERE idPersona=". mysqli_real_escape_string($this->dbLink,$this->idPersona);
					
				$result=mysqli_query($this->dbLink,$SQL);
				if(!$result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.","[ModeloBasePersona_biometrico::verificaExisteHuellaByIdPersona][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				

				if(mysqli_num_rows($result)==0)
				{
					//$this->limpiarPropiedades();
                    return 0;
				}
				else
				{
					while ( $row_inf = mysqli_fetch_assoc ( $result ) ) {
					   $contador =$row_inf['contador']; 
			        }
                    return $contador;
				}
				
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		#------------------------------------------------------------------------------------------------------#
		#------------------------------------------------Otras-------------------------------------------------#
		#------------------------------------------------------------------------------------------------------#
		
		public function validarDatos()
		{
			return true;
		}
		
		public function bioHuellaByIdPersona($idPersona)
    {
        $SQL = "SELECT b.clave, b.nombre from biometrico as b
                    inner join persona_biometrico as pb on b.idBiometrico=pb.idBiometrico
                    where idPersona=$idPersona and tipo ='huella' order by b.prioridad";
        
        $arrBio = array();
        
        $result = mysqli_query($this->dbLink, $SQL);
        
        if ($result&&mysqli_num_rows($result)> 0) {
            while ($datos=mysqli_fetch_assoc($result)){
                $arrBio[$datos['clave']]=$datos['nombre'];
            }
        }
        return $arrBio;
    }
		

	}

