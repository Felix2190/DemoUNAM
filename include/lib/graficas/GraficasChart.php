<?php
/*
 * define("DEVELOPER", ' ');
 * require_once '../Conexion/Conexion.inc.php';
 * /
 */
class DatosGraficaChart {
	var $aleatorio = false;
	var $error = false;
	var $strError = "";
	var $query = '';
	var $COLORES = array (
			'495b7c',
			'a0cddb',
			'08726f',
			'080b72',
			'dc06c0',
			'c0290b',
			'6b497c',
			'd6d850',
			'b0a0db',
			'ead9f9',
			'720840',
			'7c5149',
			'dba0ac',
			'f9dad9',
			'747c49',
			'723908',
			'dbcea0',

			'FF0000',
			'00FF00',
			'0000FF',
			'FF00FF',
			'00FFFF',
			'FFFF00',
			'000000',
			'70DB93',
			'5C3317 ',
			'9F5F9F ',
			'B5A642 ',
			'D9D919 ',
			'A62A2A ',
			'8C7853 ',
			'A67D3D ',
			'5F9F9F ',
			'D98719 ',
			'B87333 ',
			'FF7F00 ',
			'42426F ',
			'5C4033 ',
			'2F4F2F ',
			'4A766E ',
			'4F4F2F ',
			'9932CD ',
			'871F78 ',
			'6B238E ',
			'2F4F4F ',
			'97694F ',
			'7093DB ',
			'855E42 ',
			'545454 ',
			'856363 ',
			'D19275 ',
			'8E2323 ',
			'238E23 ',
			'CD7F32 ',
			'DBDB70 ',
			'C0C0C0 ',
			'527F76 ',
			'93DB70 ',
			'215E21 ',
			'4E2F2F ',
			'9F9F5F ',
			'C0D9D9 ',
			'A8A8A8 ',
			'8F8FBD ',
			'E9C2A6 ',
			'32CD32 ',
			'E47833 ',
			'8E236B ',
			'32CD99 ',
			'3232CD ',
			'6B8E23 ',
			'EAEAAE ',
			'9370DB ',
			'426F42 ',
			'7F00FF ',
			'7FFF00	',
			'70DBDB ',
			'DB7093 ',
			'A68064 ',
			'2F2F4F ',
			'23238E ',
			'4D4DFF ',
			'FF6EC7 ',
			'00009C ',
			'EBC79E ',
			'CFB53B ',
			'FF7F00 ',
			'FF2400 ',
			'DB70DB 	',
			'8FBC8F 	',
			'BC8F8F 	',
			'EAADEA 	',
			'D9D9F3 	',
			'5959AB 	',
			'6F4242 	',
			'8C1717 	',
			'238E68 	',
			'6B4226 	',
			'8E6B23 	',
			'E6E8FA 	',
			'3299CC 	',
			'007FFF 	',
			'FF1CAE 	',
			'00FF7F 	',
			'236B8E 	',
			'38B0DE 	',
			'DB9370 	',
			'D8BFD8 	',
			'ADEAEA 	',
			'5C4033 	',
			'CDCDCD 	',
			'4F2F4F 	',
			'CC3299 	',
			'D8D8BF 	',
			'99CC32	'	)
	;
	var $valores = array ();
	var $tipoGrafica = 'Pie';
	var $array = array (), $EjeX_estatus = array (), $EjeY_estatus = array ();
	var $dbLink = '';
	var $multibarra=false;
	var $arrayMulti = array ();
	function __construct() {
		global $dbLink;
		if (is_null ( $dbLink )) {
			trigger_error ( "La coneccion a la base de datos no esta establecida.", E_ERROR );
			
			return;
		}
		$this->dbLink = $dbLink;
	}
	public function setAleaotorio($aleatorio) {
		$this->aleatorio = $aleatorio;
	}
	public function setTipoGrafica($tipoGrafica) {
		$this->tipoGrafica = $tipoGrafica;
	}
	public function setQuery($query) {
		$this->query = $query;
	}
	public function setEjeX($EjeX_estatus) {
		$this->EjeX_estatus = $EjeX_estatus;
	}
	public function getError() {
		return $this->error;
	}
	public function getStrError() {
		return $this->strError;
	}
	public function setMultibarra($v) {
		$this->multibarra = $v;
	}
	public function setArrayMulti($array) {
		$this->arrayMulti = $array;
	}
	public function setEjeY($EjeY_estatus) {
		$this->EjeY_estatus = $EjeY_estatus;
	}
	
	public function GraficaValores($array) {
		$this->error = false;
		$this->strError = '';
		$this->array = $array;
		if ($this->aleatorio)
			shuffle ( $this->COLORES );
		
		$contador = 0;
		$arrayDatosJSON = array ();
		
		if (!$this->multibarra){
		
		$result2 = mysqli_query ( $this->dbLink, $this->query );
		
		if (! $result2) {
			$this->strError = "Ocurrio un error en la consulta ";
			$this->error = true;
		} else {
			$valores = $this->obtenerCampos ();
			if ($valores != null) {
				while ( $REGISTRO = mysqli_fetch_assoc ( $result2 ) ) {
					if (! array_key_exists ( $REGISTRO [$valores [0]], $this->array )) {
						$this->array [$REGISTRO [$valores [0]]] = 'Sin especificar';
					}
					switch ($this->tipoGrafica) {
						case 'Pie' :
							$objetoJSON = array (
									'value' => intval ( $REGISTRO [$valores [1]] ),
									'color' => "#" . $this->COLORES [$contador],
									'highlight' => "#8FBC8F",
									'label' => ($this->array [$REGISTRO [$valores [0]]]) 
							);
							break;
						case 'Barras' :
							$objetoJSON = array (
									'label' => $this->array [$REGISTRO [$valores [0]]],
									'fillColor' => "#" . $this->COLORES [$contador],
									'strokeColor' => "#ffffff",
									'highlightFill' => "#" . $this->COLORES [$contador],
									'highlightStroke' => "#ffffff",
									'data' => [ 
											intval ( $REGISTRO [$valores [1]] ) 
									] 
							);
							break;
						default :
							$this->strError = "Error en el tipo de gr&aacute;fica";
							$this->error = true;
							return null;
					}
					$arrayDatosJSON [] = ($objetoJSON);
					$contador ++;
				}
				if ($arrayDatosJSON == null) {
					$this->strError = "No hay datos para graficar";
					$this->error = true;
					return null;
				}
				switch ($this->tipoGrafica) {
					case 'Pie' :
						return array (
								json_encode ( $arrayDatosJSON ),
								$contador,
								$this->tipoGrafica 
						);
						break;
					case 'Barras' :
						return array (
								json_encode(( $arrayDatosJSON )),
								$contador,
								$this->EjeX_estatus,
								$this->tipoGrafica 
						);
						break;
				}
		
		}
		}
		
		}else {
			
			foreach ($this->arrayMulti as $serv=>$valores){
				$valoresM=array();
//				return json_encode($valores);
				foreach ($array as $key=>$v){
					if (isset($this->arrayMulti[$serv][$key]))
						$valoresM[]=$this->arrayMulti[$serv][$key];
					else
						$valoresM[]=0;
				}
				$objetoJSON = array (
						'label' => $this->EjeY_estatus [$serv],
						'fillColor' => "#" . $this->COLORES [$contador],
						'strokeColor' => "#ffffff",
						'highlightFill' => "#" . $this->COLORES [$contador],
						'highlightStroke' => "#ffffff",
						'data' => $valoresM);
				$arrayDatosJSON [] = ($objetoJSON);
				$contador ++;
//				return json_encode($objetoJSON);
			}
			return array (
					json_encode(( $arrayDatosJSON )),
					$contador,
					$this->EjeX_estatus,
					$this->tipoGrafica
			);
				
			
		
		}
		
		
	}
	private function obtenerCampos() {
		$texto = stristr ( $this->query, ' from ', true ); // substring hasta el from
		
		$AS = array (
				'as',
				'As',
				'aS',
				'AS' 
		);
		
		$texto = str_replace ( $AS, " AS ", $texto );
		$array = explode ( " AS ", substr ( $texto, 7 ) ); // array del substring sin el SELECT
		if (count ( $array ) == 3) { // solo se permiten 2 campos: etiqueta y count
			$auxArr = explode ( ",", $array [1] );
			$this->valores [] = str_replace ( ' ', '', $auxArr [0] );
			$this->valores [] = str_replace ( ' ', '', $array [2] );
			/* echo $this->valores[0].' '.$this->valores[1];/ */
			return $this->valores;
		} else {
			$this->strError = "Error en la consulta, solo se permiten 2 campos x1";
			$this->error = true;
			return null;
		}
	}
	private function obtenerCampos2() {
		$texto = stristr ( $this->query, ' from ', true ); // substring hasta el from
		$array = explode ( ",", substr ( $texto, 7 ) ); // array del substring sin el SELECT
		if (count ( $array ) == 2) { // solo se permiten 2 campos: etiqueta y count
			foreach ( $array as $tx ) {
				$tmpArray = explode ( ' ', $tx ); // array de cada campo
				if (count ( $tmpArray ) > 1) {
					$this->valores [] = str_replace ( ' ', '', $tmpArray [count ( $tmpArray ) - 1] ); // contiene AS
				} else {
					$this->valores [] = str_replace ( ' ', '', $tmpArray [0] ); // sin el AS
				}
			}
			// echo $this->valores [0] . ' ' . $this->valores [1];
			return $this->valores;
		} else {
			$this->strError = "Error en la consulta, solo se permiten 2 campos x2";
			$this->error = true;
			return null;
		}
	}
}
/*
 * $year = 2016;
 * $mes = 01;
 * $diafin = 30;
 * $query = ' S.fechaAtencio>="' . $year . '-' . $mes . '-01" and S.fechaAtencio<"' . $year . '-12-' . $diafin . '" group bY GRUPO';
 *
 * $query = 'SELECT IFNULL( O.CVE_ENT ,"") as GRUPO, COUNT(IFNULL( O.CVE_ENT ,"")) AS NUM FROM solicitudatencion AS S
 * INNER JOIN otros as O ON S.idOtro=O.idOtros WHERE S.tipoPersona="otro" and 1=1 and ' . $query;
 * $g = new DatosGraficaChart ();
 * $g->setQuery ( $query );
 * $arrayEtiquetas = array (
 * 'H' => 'Hombre',
 * 'M' => 'Mujer'
 * );
 *
 * $valores = $g->GraficaValores ( $arrayEtiquetas );
 * echo '<br />';
 * if ($g->getError ()) {
 * echo 'error ..- ' . $g->getStrError ();
 * } else {
 * echo "exito";
 * }
 * /
 */
?>