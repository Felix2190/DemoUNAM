<?php
	require FOLDER_MODEL_BASE . "model.base.login_user.inc.php";
	
	class ModeloLogin_user extends ModeloBaseLogin_user
	{
		// ------------------------------------------------------------------------------------------------------#
		// ----------------------------------------------Propiedades---------------------------------------------#
		// ------------------------------------------------------------------------------------------------------#
		var $_nombreClase = "ModeloBaseLogin_user";
	
		var $__ss = array();
		
		// ------------------------------------------------------------------------------------------------------#
		// --------------------------------------------Inicializacion--------------------------------------------#
		// ------------------------------------------------------------------------------------------------------#
		function __construct()
		{
			parent::__construct();
		}
	
		function __destruct()
		{
		}
		
		// ------------------------------------------------------------------------------------------------------#
		// ------------------------------------------------Setter------------------------------------------------#
		// ------------------------------------------------------------------------------------------------------#
		
		// ------------------------------------------------------------------------------------------------------#
		// -----------------------------------------------Unsetter-----------------------------------------------#
		// ------------------------------------------------------------------------------------------------------#
		
		// ------------------------------------------------------------------------------------------------------#
		// ------------------------------------------------Getter------------------------------------------------#
		// ------------------------------------------------------------------------------------------------------#
		
		public function getDatosByUsername($username)
		{
			$query="SELECT id_login FROM login_user WHERE user_name='" . mysqli_real_escape_string($this->dbLink, $username) . "'";
			$result=mysqli_query($this->dbLink, $query);
			if(mysqli_num_rows($result)>0)
			{
				$row=mysqli_fetch_assoc($result);
				return$this->setId_login($row['id_login']);
			}
			return $this->setError("El nombre de usuario no esta registrado.");
		}
		
		function verificarUserName($userName)
		{
			$query = "SELECT count(*) As cuenta FROM login_user where user_name='" . $userName . "'";
			$result = mysqli_query($this->dbLink, $query);
			if(! $result)
				return $this->setSystemError("Error en una consulta a la base de datos, intentalo de nueva cuenta mas tarde.", "[model." . $this->_nombreTabla . "::LN36][" . $query . "][" . mysql_error() . "]");
			
			$r = mysqli_fetch_assoc($result);
			if($r['cuenta'] > 0)
				return true;
			return false;
		}
	
		public function getListadoUsuarios()
		{
			try
			{
				global $objSession;
				$SQL = "SELECT LU.*, R.nombre as rolNombre FROM login_user LU
	                LEFT JOIN rol R ON R.id_rol = LU.id_rol ORDER BY LU.first_name ASC";
				$result = mysqli_query($this->dbLink, $SQL);
				if(! $result)
					return $this->setSystemError("Error en la obtencion de detalles de registro.", "[ModeloBaseTurno::getDatos][" . $SQL . "][" . mysqli_error($this->dbLink) . "]");
				
				$cadena = '';
				if(mysqli_num_rows($result) > 0)
				{
					while ($row_inf = mysqli_fetch_assoc($result))
					{
						$cadena .= '<tr>';
						$cadena .= '<td>' . $row_inf['user_name'] . '</td>';						
						$cadena .= '<td>' . $row_inf['rolNombre'] . '</td>';
						$cadena .= '<td>' . ucfirst($row_inf['estatus']) . '</td>';
						$cadena .= '<td class="opciones"><form action="usuario.php" method="POST"><input type="hidden" name="id" value="' . $row_inf['id_login'] . '" /><button class="btn btn-default btn-circle" type="submit"><i class="fa fa-eye"></i></button></form></td>';
						$cadena .= '</tr>';
					}
				}
				return $cadena;
			}
			catch (Exception $e)
			{
				return $this->setErrorCatch($e);
			}
		}
		
		public function getUsuariosByUbicacion($idUbicacion)
		{
		    $arrUsuarios=array();
		        $SQL = "SELECT id_login, user_name FROM login_user where id_recaudacion=$idUbicacion";
		        $result = mysqli_query($this->dbLink, $SQL);
		        if($result&&mysqli_num_rows($result) > 0)
		                while ($row_inf = mysqli_fetch_assoc($result)){
		            $arrUsuarios[$row_inf['id_login']]=$row_inf['user_name'];
		                  }
		            
		            return $arrUsuarios;
		}
	
		public function getUsuarios()
		{
		    $arrUsuarios=array();
		    $SQL = "SELECT id_login, user_name FROM login_user ";
		    $result = mysqli_query($this->dbLink, $SQL);
		    if($result&&mysqli_num_rows($result) > 0)
		        while ($row_inf = mysqli_fetch_assoc($result)){
		            $arrUsuarios[$row_inf['id_login']]=$row_inf['user_name'];
		    }
		    
		    return $arrUsuarios;
		}
	
		function HashPassword($input)
		{
			$salt = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
			$hash = hash("sha256", $salt . $input);
			$final = $salt . $hash;
			return $final;
		}
		
		// ------------------------------------------------------------------------------------------------------#
		// ------------------------------------------------Querys------------------------------------------------#
		// ------------------------------------------------------------------------------------------------------#
		
		// ------------------------------------------------------------------------------------------------------#
		// ------------------------------------------------Otras-------------------------------------------------#
		// ------------------------------------------------------------------------------------------------------#
		public function validarDatos()
		{
			return true;
		}
		
		public function login ($user, $password)
		{
		    $query="SELECT id_login,password,salt from login_user where user_name ='" . mysqli_real_escape_string($this->dbLink,$user) . "' ";
		    
		    $result = mysqli_query($this->dbLink, $query);
		    if($result&&mysqli_num_rows($result)>0){
		        $row = mysqli_fetch_assoc ( $result );
		        $password = hash ( 'sha512', $password . $row ['salt'] );
		        if ($row ['password'] == $password) {
		        $this->setId_login($row['id_login']);
		        return true;
		        }
		    }
	            return false;
		}
		
	}

