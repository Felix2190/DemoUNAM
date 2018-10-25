<?php
	require_once(FOLDER_MODEL_WS . "clsWSDB.inc.php");

	class CSV2MySQL extends WSBD
	{
		#--------------------------------------------------------------------------------------------------------#
		#--------------------------------------------- Propiedades ----------------------------------------------#
		#--------------------------------------------------------------------------------------------------------#

		var $file="";
		var $db=NULL;
		var $table="";
		var $map=array();
		var $fixed=array();

		#--------------------------------------------------------------------------------------------------------#
		#--------------------------------------------- Contructor -----------------------------------------------#
		#--------------------------------------------------------------------------------------------------------#

		public function __construct($file="")
		{
			parent::__construct();

			if($this->getError())
				return false;
			if($file!="")
			{
				$this->setFile($file);
				if($this->getError())
					return false;
			}
		}

		#--------------------------------------------------------------------------------------------------------#
		#----------------------------------------------- Setters ------------------------------------------------#
		#--------------------------------------------------------------------------------------------------------#

		public function setTabla($tabla)
		{
			if(trim($tabla)=="")
			{
				$this->setError("El nombre de la tabla no debe ser vacio.");
				return false;
			}
			$this->table=$tabla;
		}


		public function setFile($file)
		{
			if($file=="")
			{
				$this->setError("No se especifico en la ruta del archivo CSV.");
				return false;
			}

			if(!is_readable($file))
			{
				$this->setError("EL archivo no existe o no es posible leerlo.[" . $file . "]");
				return false;
			}
			$this->file=$file;
		}




		#--------------------------------------------------------------------------------------------------------#
		#----------------------------------------------- Getters ------------------------------------------------#
		#--------------------------------------------------------------------------------------------------------#



		#--------------------------------------------------------------------------------------------------------#
		#----------------------------------------------- Acciones -----------------------------------------------#
		#--------------------------------------------------------------------------------------------------------#



		public function addFixed($campo,$valor)
		{
			$this->fixed[$campo]=$valor;
		}

		public function addMapa($cabecera,$campoDB)
		{
			$this->map[$cabecera]=$campoDB;
		}

		public function execute()
		{

				if(!mysql_query("start transaction"))
					return $this->setError("Error en consulta: " . mysql_error());


				$pf=fopen($this->file,"r");
				if(!$pf)
				{
					$this->setError("El archivo no se puede abrir.");
					return false;
				}

				if(trim($this->table)=="")
				{
					$this->setError("No se especifico el nombre de la tabla.");
					return false;
				}


				$cabecera=fgetcsv($pf);
				$mapas=array();
				foreach($cabecera AS $k=>$v)
					$mapas[$v]=$k;
				$campos=array();
				$binds=array();


				foreach($this->fixed AS $campo=>$valor)
				{
					$campos[]=$campo;

				}
				foreach($this->map AS $c=>$campo)
				{
					$campos[]=$campo;

				}

				while($r=fgetcsv($pf))
				{
					$valores="'" . implode("','",$this->fixed) . "','" . implode("','", $r) . "'";
					$SQL="INSERT IGNORE INTO " . $this->table . "(" . implode(",",$campos) . ") VALUES(" . $valores . ")";
					if(!mysql_query($SQL))
						return $this->setError("Error en la consulta: " . mysql_error());
				}
				if(!mysql_query("COMMIT"))
					return $this->setError("Error en consulta: " . mysql_error());
		}
	}


