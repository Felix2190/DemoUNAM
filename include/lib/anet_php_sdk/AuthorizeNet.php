<?php
/**
 * The AuthorizeNet PHP SDK. Include this file in your project.
 *
 * @package AuthorizeNet
 */
require LIB_AUTHORIZE . 'shared/AuthorizeNetRequest.php';
require LIB_AUTHORIZE . 'shared/AuthorizeNetTypes.php';
require LIB_AUTHORIZE . 'shared/AuthorizeNetXMLResponse.php';
require LIB_AUTHORIZE . 'shared/AuthorizeNetResponse.php';
require LIB_AUTHORIZE . 'AuthorizeNetAIM.php';
require LIB_AUTHORIZE . 'AuthorizeNetARB.php';
require LIB_AUTHORIZE . 'AuthorizeNetCIM.php';
require LIB_AUTHORIZE . 'AuthorizeNetSIM.php';
require LIB_AUTHORIZE . 'AuthorizeNetDPM.php';
require LIB_AUTHORIZE . 'AuthorizeNetTD.php';
require LIB_AUTHORIZE . 'AuthorizeNetCP.php';

if (class_exists("SoapClient")) {
    require LIB_AUTHORIZE . 'AuthorizeNetSOAP.php';
}
/**
 * Exception class for AuthorizeNet PHP SDK.
 *
 * @package AuthorizeNet
 */
class AuthorizeNetException extends Exception
{
}