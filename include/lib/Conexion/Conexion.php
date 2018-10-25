<?php
/*
 * Contiene la configuracion de la base de datos para poder llevar a cabo la conexion
 */
class PDOConfig extends PDO
{
    private $engine;
    private $host;
    private $database;
    private $user;
    private $pass;

    protected $transactionCounter = 0;

    public function __construct()
    {
        $this->engine = CONFIGURACION_DBMS;
        $this->host = CONFIGURACION_DBMS_HOST;
        $this->database = CONFIGURACION_DBMS_DB;
        $this->user = CONFIGURACION_DBMS_USER;
        $this->pass = CONFIGURACION_DBMS_PASS;
        $dns = $this->engine.':dbname='.$this->database.";host=".$this->host;
        parent::__construct( $dns, $this->user, $this->pass, array(
      	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
      	PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING
   		));

        $this->exec("SET NAMES UTF8");

    }


	function beginTransaction()
	{
		if(!$this->transactionCounter++)
			return parent::beginTransaction();
		return $this->transactionCounter >= 0;
	}

	function commit()
	{
		if(!--$this->transactionCounter)
			return parent::commit();
		return $this->transactionCounter >= 0;
	}

	function rollback()
	{
		if($this->transactionCounter >= 0)
		{
			$this->transactionCounter = 0;
			return parent::rollback();
		}
		$this->transactionCounter = 0;
		return false;
	}

	function __destruct()
	{
		#if($this->inTransaction())
		#{
			#if($this->transactionCounter>1)
			#	parent::rollBack();
			#parent::commit();
		#}
	}


}
?>