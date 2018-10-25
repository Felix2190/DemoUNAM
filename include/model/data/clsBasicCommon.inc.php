<?php
class clsBasicCommon
{
	#-----------------------------------------------------------------------------------------------#
	#-------------------------------------------Variables-------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	var $error=false;
	var $strError="";
	var $warning=false;
	var $arrWarning=array();

	var $debug=false;
	var $debugFile=false;
	var $debugFileName="";

	var $__s=array();

	#-----------------------------------------------------------------------------------------------#
	#------------------------------------Constructor Destructor-------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	public function __construct()
	{

	}

	public function __destruct()
	{
	}

	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------Setter Getter-----------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	public function clearError()
	{
		$this->error=false;
		$this->strError="";
	}

	public function setError($msg)
	{
		$this->error=true;
		$this->strError=$msg;
		return false;
	}

	public function getError()
	{
		return $this->error;
	}

	public function getStrError()
	{
		return $this->strError;
	}

	public function setWarning($msg)
	{
		$this->warning=true;
		$this->arrWarning[]=$msg;
	}

	public function getWarning()
	{
		return $this->warning;
	}
	public function getArrWarning()
	{
		return $this->arrWarning;
	}

	public function getStrWarning($s="<br />")
	{
		return implode($s,$this->arrWarning);
	}

	public function clearWarning()
	{
		$this->warning=false;
		$this->arrWarning=array();
	}

	#-----------------------------------------------------------------------------------------------#
	#-----------------------------------------------------------------------------------------------#


	#-----------------------------------------------------------------------------------------------#
	#---------------------------------------------Otras---------------------------------------------#
	#-----------------------------------------------------------------------------------------------#

	public function serialize()
	{
		$valores=array();
		foreach($this->__s AS $k=>$v)
		{
			$valores[$v]=$this->$v;
		}
		return serialize($valores);
	}

	public function unserialize($v)
	{

		$valores=unserialize($v);
		foreach($valores AS $k=>$v)
		{
			$this->$k=$v;
		}
	}






}