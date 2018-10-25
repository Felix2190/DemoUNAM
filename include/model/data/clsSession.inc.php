<?php

	require_once(LIB_CONEXION);
//	require_once FOLDER_MODEL_DATA . "clsAddSupportOSTicket.inc.php";

class clsSession extends clsBasicCommon
{
	#-----------------------------------------------------------------------------------------------#
	#-------------------------------------------Variables-------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	private $account_id;
	private $first_name;
	private $status_id;
	private $last_name;
	private $user_name;
	private $email;
	private $company_name;
	private $type_id;
	private $taxable;
	private $date_created;
	private $payment_method_id;
	private $currency_id;
	private $currency_name;
	private $bill_address;
	private $bill_city;
	private $bill_country_id;
	private $bill_country_name;
	private $bill_state_id;
	private $bill_state_name;
	private $bill_zip;
	private $bill_first_name;
	private $bill_last_name;
	private $bill_email;
	private $bill_phone;
	private $address;
	private $country_id;
	private $country_name;
	private $zip;
	private $phone;
	private $city;
	private $state_id;
	private $state_name;
	private $balance;
	private $realBalance;
	private $id_login;
	private $id_usuario;
	private $id_rol;
  private $idUbicacion;
  private $permisos;
    
	private $_soporteIniciado=false;

	private $tieneDetallesPlan=false;
	public $detallesPlan;
	public $_lastTime;
	public $_lastTimeSoporte;


	public $_ejecucionPendiente=array();

	private $_data=array();

	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	#-----------------------------------------------------------------------------------------------#
	#--------------------------------------------Control--------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	var $__s=array("_lastTimeSoporte","_soporteIniciado","_ejecucionPendiente","_lastTime","_data","detallesPlan","tieneDetallesPlan","account_id",
	"id_login","id_usuario", "id_rol",
		"first_name",
		"status_id",
		"last_name",
		"user_name",
		"email",
		"company_name",
		"type_id",
		"taxable",
		"date_created",
		"payment_method_id",
		"currency_id",
		"currency_name",
		"bill_address",
		"bill_city",
		"bill_country_id",
		"bill_country_name",
		"bill_state_id",
		"bill_state_name",
		"bill_zip",
		"bill_first_name",
		"bill_last_name",
		"bill_email",
		"bill_phone",
		"address",
		"country_id",
		"country_name",
		"zip",
		"phone",
		"city",
		"state_id",
		"state_name","balance","realBalance","idUbicacion");

	public function __construct()
	{

	}


	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	#-----------------------------------------------------------------------------------------------#
	#----------------------------------------Setter Getter------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	public function setData($k,$v)
	{
		$this->_data[$k]=$v;
	}

	public function getData($k)
	{
		return $this->_data[$k];
	}

	public function setBalance($balance)
	{
		$this->balance=$balance;
	}

	public function setRealBalance($realBalance)
	{
		$this->realBalance=$realBalance;
	}

	public function getRealBalance()
	{
		return $this->realBalance;
	}

	public function getBalance()
	{
		return $this->balance;
	}



	public function getAccountId()
	{
		return $this->account_id;
	}

	public function getFirstName()
	{
		return $this->first_name;
	}

	public function getStatusId()
	{
		return $this->status_id;
	}

	public function getLastName()
	{
		return $this->last_name;
	}

	public function getUserName()
	{
		return $this->user_name;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function getCompanyName()
	{
		return $this->company_name;
	}

	public function getTypeId()
	{
		return $this->type_id;
	}

	public function getTaxable()
	{
		return $this->taxable;
	}

	public function getDateCreated()
	{
		return $this->date_created;
	}

	public function getPaymentMethodId()
	{
		return $this->payment_method_id;
	}

	public function getCurrencyId()
	{
		return $this->currency_id;
	}

	public function getCurrencyName()
	{
		return $this->currency_name;
	}

	public function getBillAddress()
	{
		return $this->bill_address;
	}

	public function getBillCity()
	{
		return $this->bill_city;
	}

	public function getBillCountryId()
	{
		return $this->bill_country_id;
	}

	public function getBillCountryName()
	{
		return $this->bill_country_name;
	}

	public function getBillStateId()
	{
		return $this->bill_state_id;
	}

	public function getBillStateName()
	{
		return $this->bill_state_name;
	}

	public function getBillZip()
	{
		return $this->bill_zip;
	}

	public function getBillFirstName()
	{
		return $this->bill_first_name;
	}

	public function getBillLastName()
	{
		return $this->bill_last_name;
	}

	public function getBillEmail()
	{
		return $this->bill_email;
	}

	public function getBillPhone()
	{
		return $this->bill_phone;
	}

	public function getAddress()
	{
		return $this->address;
	}

	public function getCountryId()
	{
		return $this->country_id;
	}

	public function getCountryName()
	{
		return $this->country_name;
	}

	public function getZip()
	{
		return $this->zip;
	}

	public function getPhone()
	{
		return $this->phone;
	}

	public function getCity()
	{
		return $this->city;
	}

	public function getStateId()
	{
		return $this->state_id;
	}

	public function getStateName()
	{
		return $this->state_name;
	}

	public function getLastTime()
	{
		return $this->_lastTime;
	}

	public function getEjecucionPendienteJS()
	{
		return "revisarPendientes();";
	}
	
	public function getIdLogin()
	{
		return $this->id_login;
	}
	
	public function getIdUser()
	{
		return $this->id_usuario;
	}
	
	public function getIdRol(){
		return $this->id_rol;
	}
    
  public function setIdUbicacion($idUbicacion)
  {
      $this->idUbicacion = $idUbicacion;
  }
  public function getIdUbicacion()
  {
      return $this->idUbicacion;
  }
  
  public function setPermisos($permisos)
  {
      $this->permisos = $permisos;
  }
  public function getPermisos()
  {
      return $this->permisos;
  }    

	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	#-----------------------------------------------------------------------------------------------#
	#-------------------------------------------Acciones--------------------------------------------#
	#-----------------------------------------------------------------------------------------------#
	
	public function crearSoporte()
	{
		$add=new AddSupportSOTickect();
		if($add->getError())
		{
			$this->setError($this->_strErrorGenerico,"Impossible to initiate object for OS ticket support registration. [" . $add->getStrError() . "] [No se detiene proceso de alta de cuenta, solo no tiene soporte]");
			$this->error=false;
			ConectarBD();
			return true;
		}
		$add->setName($this->first_name . " " . $this->last_name);
		$add->setUserName($this->user_name);
		$add->setEmail($this->email);
		$add->setPass(OSTICKET_PASS);
		$add->exec();
		if($add->getError())
		{
			$this->setError("Ocurrio un error en la creacion del soporte.");
			return false;
		}
			

		//Se ejecuta la siguiente funcion para recuperar el enlace a la base de datos principal,
		//ya que la clase AddSupportSOTickect abre conexion a la base de datos de soporte.

		
		
		ConectarBD();
	}
	
	public function existeSoporte()
	{
		$add=new AddSupportSOTickect();
		if($add->getError())
		{
			$this->setError($this->_strErrorGenerico,"Impossible to initiate object for OS ticket support registration. [" . $add->getStrError() . "] [No se detiene proceso de alta de cuenta, solo no tiene soporte]");
			$this->error=false;
			ConectarBD();
			return true;
		}
		$add->setUserName($this->user_name);
		$r=$add->existUserName();
		ConectarBD();
		return $r;
	}	
	public function iniciarSoporte()
	{
		if(!$this->existeSoporte()&&$this->crearSoporte())
		{
			$this->_soporteIniciado=true;
			$this->_lastTimeSoporte=time();
		}
		else
		$this->_soporteIniciado=false;
	}

	public function isSoporteIniciado()
	{
		if(!$this->isSoporteActive())
			return false;
		$this->_lastTimeSoporte=time();
		return $this->_soporteIniciado;
	}

	public function addEjecucionPendiente($str)
	{
		$this->_ejecucionPendiente[]=$str;
	}

	public function ejecucionPendiente()
	{
		return $this->isSessionActive();
		return true;
		return count($this->_ejecucionPendiente)>0;
	}

	public function isSoporteActive()
	{
		return time()-$this->_lastTimeSoporte<SOPORTE_TIME;
	}

	public function isSessionActive()
	{
		return time()-$this->_lastTime<defined("SESSION_TIME")?SESSION_TIME:1800;
	}

	public function updateTime()
	{
		$this->_lastTime=time();
	}

	public function setObjetoDetallesPlan($detallesPlan)
	{
		$this->tieneDetallesPlan=true;
		$this->detallesPlan=$detallesPlan;
	}

	public function tieneDetallesPlan()
	{
		return $this->tieneDetallesPlan;
	}

	public function setObjetoGetInfo($oGI)
	{

		foreach($oGI as $k=>$v)
		{
			if(in_array($k, $this->__s))
			{
				$this->$k=$v;
			}
		}

	}


	public function resetError()
	{
		$this->error=false;
		$this->strError="";
	}




	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------#
}