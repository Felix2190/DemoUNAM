<?php
class AWFingerPrint extends clsBasicCommon
{

	var $_URL="http://172.21.85.174:8080/nexafp/";
	var $_cache="cache1";
	var $_data;
	var $_operation="";#add|
	var $_jsonResponse;
	var $score=0;
	var $compared_fingerprint_count=0;


	var $RIGHT_THUMB;
	var $RIGHT_INDEX;
	var $RIGHT_MIDDLE;
	var $RIGHT_RING;
	var $RIGHT_LITTLE;
	var $LEFT_THUMB;
	var $LEFT_INDEX;
	var $LEFT_MIDDLE;
	var $LEFT_RING;
	var $LEFT_LITTLE;
		
	var $arIdentificadores=array("RIGHT_THUMB","RIGHT_INDEX","RIGHT_MIDDLE","RIGHT_RING","RIGHT_LITTLE","LEFT_THUMB","LEFT_INDEX","LEFT_MIDDLE","LEFT_RING","LEFT_LITTLE");
	var $arEnvio=array();
	var $id="";


	public function __construct()
	{
			
	}


	public function setRIGHT_THUMB($imagebase64)
	{
		if(in_array("RIGHT_THUMB", $this->arEnvio))
		{
			return $this->setError("Registro ya agregado.");
		}
		$this->arEnvio[]="RIGHT_THUMB";
		$this->RIGHT_THUMB=$imagebase64;
	}
	public function setRIGHT_INDEX($imagebase64)
	{
		if(in_array("RIGHT_INDEX", $this->arEnvio))
		{
			return $this->setError("Registro ya agregado.");
		}
		$this->arEnvio[]="RIGHT_INDEX";
		$this->RIGHT_INDEX=$imagebase64;
	}
	public function setRIGHT_MIDDLE($imagebase64)
	{
		if(in_array("RIGHT_MIDDLE", $this->arEnvio))
		{
			return $this->setError("Registro ya agregado.");
		}
		$this->arEnvio[]="RIGHT_MIDDLE";
		$this->RIGHT_MIDDLE=$imagebase64;
	}
	public function setRIGHT_RING($imagebase64)
	{
		if(in_array("RIGHT_RING", $this->arEnvio))
		{
			return $this->setError("Registro ya agregado.");
		}
		$this->arEnvio[]="RIGHT_RING";
		$this->RIGHT_RING=$imagebase64;
	}
	public function setRIGHT_LITTLE($imagebase64)
	{
		if(in_array("RIGHT_LITTLE", $this->arEnvio))
		{
			return $this->setError("Registro ya agregado.");
		}
		$this->arEnvio[]="RIGHT_LITTLE";
		$this->RIGHT_LITTLE=$imagebase64;
	}
	public function setLEFT_THUMB($imagebase64)
	{
		if(in_array("LEFT_THUMB", $this->arEnvio))
		{
			return $this->setError("Registro ya agregado.");
		}
		$this->arEnvio[]="LEFT_THUMB";
		$this->LEFT_THUMB=$imagebase64;
	}
	public function setLEFT_INDEX($imagebase64)
	{
		if(in_array("LEFT_INDEX", $this->arEnvio))
		{
			return $this->setError("Registro ya agregado.");
		}
		$this->arEnvio[]="LEFT_INDEX";
		$this->LEFT_INDEX=$imagebase64;
	}
	public function setLEFT_MIDDLE($imagebase64)
	{
		if(in_array("LEFT_MIDDLE", $this->arEnvio))
		{
			return $this->setError("Registro ya agregado.");
		}
		$this->arEnvio[]="LEFT_MIDDLE";
		$this->LEFT_MIDDLE=$imagebase64;
	}
	public function setLEFT_RING($imagebase64)
	{
		if(in_array("LEFT_RING", $this->arEnvio))
		{
			return $this->setError("Registro ya agregado.");
		}
		$this->arEnvio[]="LEFT_RING";
		$this->LEFT_RING=$imagebase64;
	}
	public function setLEFT_LITTLE($imagebase64)
	{
		if(in_array("LEFT_LITTLE", $this->arEnvio))
		{
			return $this->setError("Registro ya agregado.");
		}
		$this->arEnvio[]="LEFT_LITTLE";
		$this->LEFT_LITTLE=$imagebase64;
	}

	private function exec()
	{
		$url = $this->_URL . $this->_operation  . "/" . $this->_cache;
			
		$data=json_encode($this->_data);
			

		/*
			$data = json_encode ( array (
			'encounter' => $datosBiometricos
			) );
			*/
			
		$curl = curl_init ( $url );
		curl_setopt ( $curl, CURLOPT_CUSTOMREQUEST, "POST" );
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data );
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $curl, CURLOPT_HTTPHEADER, array (
			'Content-Type: application/json',
			'Content-Length: ' . strlen ( $data )
		) );
		$json_response = curl_exec ( $curl );
			
			
			
		$status = curl_getinfo ( $curl, CURLINFO_HTTP_CODE );
		curl_close ( $curl );
		$this->_jsonResponse = json_decode ( $json_response, true );
			
		//echo "[Status:" . $status . "]";
		if ($status != 200)
		{
			if (! is_null ( $this->_jsonResponse ))
			{
				return $this->setError("[1]" . $this->_jsonResponse ['error']['description']);
			}
			return $this->setError("response:". $json_response);

		}
			
		return true;
	}

	public function add($id)
	{
		if(trim($id)=="")
		{
			return $this->setError("Agrega la clave para enrolar la identidad");
		}
		$this->_operation="add";
			
		$huellas=array();
			
		foreach($this->arEnvio AS $v)
		{
			$huellas[$v]=array("image"=>$this->$v,
				"impression_type"=> "PLAIN"
			);
		}
		$huellas["id"]=$id;
			
		$this->_data=array("encounter"=>$huellas);
			
			
			
		$this->exec();
			
		$this->id=$this->_jsonResponse['id'];
			
	}

	public function verify($id)
	{
		if(trim($id)=="")
		{
			return $this->setError("Agrega la clave para enrolar la identidad");
		}
		$this->_operation="verify";

		$huellas=array();

		foreach($this->arEnvio AS $v)
		{
			$huellas[$v]=array("image"=>$this->$v,
				"impression_type"=> "PLAIN"
			);
		}
			
		$comparator=array("comparator"=>array("algorithm"=>"D900",
			"fingerprint_types"=>$this->arEnvio
		));

		$this->_data=array("probe"=>$huellas,"workflow"=>$comparator,"id"=>$id);
			


		$this->exec();
		if($this->getError())
		{
			return false;
		}
		$this->score=$this->_jsonResponse["score"];
		$this->compared_fingerprint_count=$this->_jsonResponse["compared_fingerprint_count"];
		#print_r($this->_jsonResponse);
		return true;
			
	}
	
	public function delete($id)
	{
		if(trim($id)=="")
		{
			return $this->setError("Agrega la clave para borrar del motor biometrico.");
		}
		$this->_operation="delete";
		$this->_data=array("id"=>$id);
		$this->exec();
		
		
	}


}
