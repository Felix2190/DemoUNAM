<?php

require_once FOLDER_MODEL_WS . "ws.class.AccountServiceGetBalance.inc.php";

function revisarPendientes()
{
	global $objSession;
	$r=new xajaxResponse();

	$almacenarObjSession=false;


	#-------------------------------------------------------------------------------------------------#
	#--------------------------------------Preguntar por balance--------------------------------------#
	#-------------------------------------------------------------------------------------------------#

	#if(in_array("BALANCE", $objSession->_ejecucionPendiente))
	#{

		$wsBalance=new DAccountServiceGetBalance();
		$wsBalance->Param->setAccountId($objSession->getAccountId());
		$wsBalance->execute();

		if($wsBalance->Response->getBalance()!=$objSession->getBalance())
		{
			$objSession->setBalance($wsBalance->Response->getBalance());
			$r->assign("_aObtenerBalance", "innerHTML", "<span>Balance&nbsp; $&nbsp;" . $objSession->getBalance() . " " . $objSession->getCurrencyName() . "</span>");
			$almacenarObjSession=true;
		}
	#}

	#-------------------------------------------------------------------------------------------------#
	#-----------------------------------Fin de Preguntar por balance----------------------------------#
	#-------------------------------------------------------------------------------------------------#

	if($almacenarObjSession)
		$_SESSION['objSession']=serialize($objSession);
	return $r;
}
$xajax->registerFunction("revisarPendientes");