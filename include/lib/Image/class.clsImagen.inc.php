<?php
	class clsBasicImageGD
	{
		private $Alto=0;
		private $Ancho=0;
		private $Tipo;
		private $numTipo;
		private $Recurso=false;
		private $Ruta="";
		private $error=false;
		private $strError="";
		private $strErrores=array();

		private function ConvertBMP2GD($src, $dest = false)
		{
			if(!($src_f = fopen($src, "rb")))
			{
				return false;
			}
			if(!($dest_f = fopen($dest, "wb")))
			{
				return false;
			}
			$header = unpack("vtype/Vsize/v2reserved/Voffset", fread($src_f,14));
			$info = unpack("Vsize/Vwidth/Vheight/vplanes/vbits/Vcompression/Vimagesize/Vxres/Vyres/Vncolor/Vimportant",
			fread($src_f, 40));
			extract($info);
			extract($header);

			if($type != 0x4D42) // signature "BM"
				return false;

			$palette_size = $offset - 54;
			$ncolor = $palette_size / 4;
			$gd_header = "";
			// true-color vs. palette
			$gd_header .= ($palette_size == 0) ? "\xFF\xFE" : "\xFF\xFF";
			$gd_header .= pack("n2", $width, $height);
			$gd_header .= ($palette_size == 0) ? "\x01" : "\x00";
			if($palette_size)
				$gd_header .= pack("n", $ncolor);
			// no transparency
			$gd_header .= "\xFF\xFF\xFF\xFF";

			fwrite($dest_f, $gd_header);

			if($palette_size)
			{
				$palette = fread($src_f, $palette_size);
				$gd_palette = "";
				$j = 0;
				while($j < $palette_size)
				{
					$b = $palette{$j++};
					$g = $palette{$j++};
					$r = $palette{$j++};
					$a = $palette{$j++};
					$gd_palette .= "$r$g$b$a";
				}
				$gd_palette .= str_repeat("\x00\x00\x00\x00", 256 - $ncolor);
				fwrite($dest_f, $gd_palette);
			}

			$scan_line_size = (($bits * $width) + 7) >> 3;
			$scan_line_align = ($scan_line_size & 0x03) ? 4 - ($scan_line_size & 0x03) : 0;

			for($i = 0, $l = $height - 1; $i < $height; $i++, $l--)
			{
				// BMP stores scan lines starting from bottom
				fseek($src_f, $offset + (($scan_line_size + $scan_line_align) * $l));
				$scan_line = fread($src_f, $scan_line_size);
				if($bits == 24)
				{
					$gd_scan_line = "";
					$j = 0;
					while($j < $scan_line_size)
					{
						$b = $scan_line{$j++};
						$g = $scan_line{$j++};
						$r = $scan_line{$j++};
						$gd_scan_line .= "\x00$r$g$b";
					}
				}
				else if($bits == 8)
				{
					$gd_scan_line = $scan_line;
				}
				else if($bits == 4)
				{
					$gd_scan_line = "";
					$j = 0;
					while($j < $scan_line_size)
					{
						$byte = ord($scan_line{$j++});
						$p1 = chr($byte >> 4);
						$p2 = chr($byte & 0x0F);
						$gd_scan_line .= "$p1$p2";
					}
					$gd_scan_line = substr($gd_scan_line, 0, $width);
				}
				else if($bits == 1)
				{
					$gd_scan_line = "";
					$j = 0;
					while($j < $scan_line_size)
					{
						$byte = ord($scan_line{$j++});
						$p1 = chr((int) (($byte & 0x80) != 0));
						$p2 = chr((int) (($byte & 0x40) != 0));
						$p3 = chr((int) (($byte & 0x20) != 0));
						$p4 = chr((int) (($byte & 0x10) != 0));
						$p5 = chr((int) (($byte & 0x08) != 0));
						$p6 = chr((int) (($byte & 0x04) != 0));
						$p7 = chr((int) (($byte & 0x02) != 0));
						$p8 = chr((int) (($byte & 0x01) != 0));
						$gd_scan_line .= "$p1$p2$p3$p4$p5$p6$p7$p8";
					}
					$gd_scan_line = substr($gd_scan_line, 0, $width);
				}

				fwrite($dest_f, $gd_scan_line);
			}
			fclose($src_f);
			fclose($dest_f);
			return TRUE;
		}

		private function imagecreatefrombmp()
		{
			$tmp_name = tempnam("/tmp", "GD");
			if(!$tmp_name)
			{
				$this->setError("Fallo la creacion del archivo temporal para crear imagen GD desde BMP");
				return false;
			}
			if($this->ConvertBMP2GD($this->Ruta, $tmp_name))
			{
				$img = imagecreatefromgd($tmp_name);
				unlink($tmp_name);
				return $img;
			}
			return false;
		}

		private function Abrir()
		{
			switch($this->numTipo)
			{
				case 1:
					$this->Recurso=imagecreatefromgif($this->Ruta);
					break;
				case 2:
					$this->Recurso=imagecreatefromjpeg($this->Ruta);
					break;
				case 3:
					$this->Recurso=imagecreatefrompng($this->Ruta);
					break;
				case 6:
					$this->Recurso=$this->imagecreatefrombmp($this->Ruta);
			}
			if(!$this->Recurso)
			{
				setError("Fallo la creacion GD de la imagen");
				return;
			}
			imagealphablending($this->Recurso, true);
			imageSaveAlpha($this->Recurso, true);
		}

		private function setError($str)
		{
			$this->error=true;
			$this->strError=$str;
			$this->strErrores[]=$str;
		}

		function __construct($Ruta)
		{
			$this->setRuta($Ruta);
		}

		function getAlto()
		{
			return $this->Alto;
		}

		function getAncho()
		{
			return $this->Ancho;
		}

		function getSize()
		{
			return array($this->Ancho,$this->Alto);
		}

		function getTipoMIME()
		{
			return $this->Tipo;
		}

		function getTipo()
		{
			switch($this->numTipo)
			{
				case 1:
					return "gif";
				case 2:
					return "jpg";
				case 3:
					return "png";
				case 6:
					return "bmp";
				default:
					return "";
			}

		}

		function getRecurso()
		{
			return $this->Recurso;
		}

		function setRuta($Ruta)
		{
			if(!is_file($Ruta))
			{
				$this->setError("El archivo origen no existe [" . $Ruta . "].");
				return;
			}
			$Aux=getimagesize($Ruta);


			if($Aux[0]==0&&$Aux[1]==0)
			{
				$this->setError("Imagen no valida");
				return;
			}

			if($Aux[2]!=1&&$Aux[2]!=2&&$Aux[2]!=3&&$Aux[2]!=6)
			{
				$this->setError("El tipo de la imagen no es valido, solo se aceptan GIF,JPG,PNG y BMP numTipo[" . $Aux[2] . "] MIME[" . $Aux['mime'] . "]");
				return;
			}

			if($this->Recurso!==false)
				imagedestroy($this->Recurso);


			list($this->Ancho,$this->Alto,$this->numTipo)=$Aux;
			$this->Tipo=$Aux['mime'];

			$this->Ruta=$Ruta;
			$this->Abrir();
		}

		function getError()
		{
			return $this->error;
		}

		function getStrError()
		{
			return $this->strError;
		}
	};

	class clsImagen
	{
		private $anchoDestino;
		private $altoDestino;
		private $strOrigen="";
		#Alto maximo de la salida;
		#Integer
		private $maxAlto=600;

		#Ancho maximo de la salida
		#Integer
		private $maxAncho=400;

		#Con marca de agua
		#bool false
		private $marcaAgua=false;

		#Ruta del archivo de marca de agua en formato PNG
		#String
		private $rutaMarcaAgua="";

		#Ruta del directorio de slida
		#String
		private $directorioSalida="./";

		#Nombre del archivo de salida, sin extension
		#String
		private $nombreSalida="proccess";

		#Posicion de la marca de agua
		/*
			1 2 3
			4 5 6
			7 8 9
		*/
		#Integer
		private $marcaAguaPosicion=5;

		#salida en JPG
		#bool
		#Default true
		private $salidaJPG=true;

		private $calidadJPG=90;

		#salida en PNG
		#bool
		#Default false
		private $salidaPNG=false;

		#salida en GIF
		#bool
		#Default false
		private $salidaGIF=false;

		private $error=false;
		private $strError="";
		private $strErrores=array();

		private $Accion="proporcion";

		public $Origen;

		public $Destino;
		private $Marca;
		private $MarcaRedimensiona;
		private $siPequeNoHacerNada=true;
		
		
		private $recorte=false;
		private $recorteX=0;
		private $recorteY=0;
		private $recorteW=0;
		private $recorteH=0;

		function __construct($Origen="")
		{
			$this->setOrigen($Origen);

		}

		function calculaMedidasDestino()
		{
			if($this->Accion=="redimensionar")
				return;
			if($this->recorte)
			{
				if($this->siPequeNoHacerNada&&$this->recorteW<=$this->maxAncho&&$this->recorteH<=$this->maxAlto)
				{
					$this->anchoDestino=$this->recorteW;
					$this->altoDestino=$this->recorteH;
					return;
				}
				
				if($this->recorteW/$this->recorteH>=$this->maxAncho/$this->maxAlto)
				{
					$this->anchoDestino=$this->maxAncho;
					$this->altoDestino=round($this->maxAncho*$this->recorteH/$this->recorteW,0);
				}
				else
				{
					$this->altoDestino=$this->maxAlto;
					$this->anchoDestino=round($this->recorteW*$this->maxAlto/$this->recorteH,0);
				}
			}
			else
			{
				if($this->siPequeNoHacerNada&&$this->Origen->getAncho()<=$this->maxAncho&&$this->Origen->getAlto()<=$this->maxAlto)
				{
					$this->anchoDestino=$this->Origen->getAncho();
					$this->altoDestino=$this->Origen->getAlto();
					return;
				}
				
				if($this->Origen->getAncho()/$this->Origen->getAlto()>=$this->maxAncho/$this->maxAlto)
				{
					$this->anchoDestino=$this->maxAncho;
					$this->altoDestino=$this->maxAncho*$this->Origen->getAlto()/$this->Origen->getAncho();
				}
				else
				{
					$this->altoDestino=$this->maxAlto;
					$this->anchoDestino=$this->Origen->getAncho()*$this->maxAlto/$this->Origen->getAlto();
				}
			}
		}


		function setOrigen($RutaOrigen)
		{
			$this->Origen=new clsBasicImageGD($RutaOrigen);
			if($this->Origen->getError())
			{
				$this->setError("Error en el ojeto imagen origen [" . $this->Origen->getStrError() . "]");
				return;
			}

			$this->calculaMedidasDestino();

			return;
		}
		
		function setPorcentaje($porcentaje)
		{
			if(!(is_numeric($porcentaje)))
			{
				$this->setError("El porcentaje del destino es incorrecto [" . $porcentaje . "]");
				return;
			}
			$this->setMax(
				round($this->Origen->getAncho()*($porcentaje/100),0),
				round($this->Origen->getAlto()*($porcentaje/100),0)
				);
		}
		function setMax($Ancho,$Alto)
		{
			$this->setMaxAncho($Ancho);
			$this->setMaxAlto($Alto);

		}
		function setMaxAncho($Ancho)
		{
			if(!(is_numeric($Ancho)&&$Ancho>=1))
			{
				$this->setError("El ancho del destino es incorrecto [" . $Ancho . "]");
				return;
			}
			$this->maxAncho=$Ancho;
			$this->calculaMedidasDestino();
		}
		function setMaxAlto($Alto)
		{
			if(!(is_numeric($Alto)&&$Alto>=1))
			{
				$this->setError("El Alto del destino es incorrecto [" . $Alto . "]");
				return;
			}
			$this->maxAlto=$Alto;
			$this->calculaMedidasDestino();
		}
		function setRutaMarcaAgua($RutaMarcaAgua)
		{
			$this->rutaMarcaAgua=$RutaMarcaAgua;

			$this->Marca=new clsBasicImageGD($RutaMarcaAgua);
			if($this->Marca->getError())
			{
				$this->setError("Error en la creacion GD de marca de agua [" . $this->Marca->getStrError() . "]");
				return;
			}
			if($this->Marca->getTipo()!="png")
			{
				$this->setError("El tipo de archivo para la marca de agua debe de ser PNG");
				return;
			}
			$this->setMarcaAgua();
			return;
		}
		function setMarcaAgua()
		{
			$this->marcaAgua=true;
		}
		function unsetMarcaAgua()
		{
			$this->marcaAgua=false;
		}
		function setCarpetaSalida($Carpeta)
		{
			if($Carpeta==""||!is_dir($Carpeta))
			{
				$this->setError("El nombre del archivo de salida es incorrecto [" . $Carpeta . "]");
				return;
			}
			if(!is_writable($Carpeta))
			{
				$this->setError("La carpeta destino no tiene permisos de escritura [" . $Carpeta . "]");
				return;
			}
			$Ultimo=substr($Carpeta,-1,1);
			if($Ultimo!="/"&&$Ultimo!="\\")
				$this->directorioSalida=$Carpeta . DIRECTORY_SEPARATOR;
			else
				$this->directorioSalida=$Carpeta;
		}
		function setNombreSalida($Nombre)
		{
			if($Nombre==""||strpos($Nombre,DIRECTORY_SEPARATOR)!==false)
			{
				$this->setError("El nombre del archivo de salida es incorrecto [" . $Nombre . "]");
				return;
			}
			$this->nombreSalida=$Nombre;
		}
		function setGIF()
		{
			$this->salidaJPG=false;
			$this->salidaPNG=false;
			$sthis->alidaGIF=true;
		}
		function setJPG()
		{
			$this->salidaJPG=true;
			$this->salidaPNG=false;
			$this->salidaGIF=false;
		}
		function setPNG()
		{
			$this->salidaJPG=false;
			$this->salidaPNG=true;
			$this->salidaGIF=false;
		}
		function setCalidadJPG($Calidad)
		{
			if(!(is_numeric($Calidad)&&$Calidad>=10&&$Calidad<=100))
			{
				$this->setError("La calidad para salida JPG es incorrecta [" . $Calidad . "]");
				return;
			}
			$this->calidadJPG=$Calidad;
		}
		function setProporcion()
		{
			$this->Accion="proporcion";
		}
		function setRelleno()
		{
			$this->Accion="relleno";
		}

		private function setError($str)
		{
			$this->error=true;
			$this->strError=$str;
			$this->strErrores[]=$str;
		}
		
		function getErrores()
		{
			return implode("\n",$this->strErrores);
		}

		function setPosicionMarcaAgua($Posicion)
		{
			if(!(is_numeric($Posicion)&&$Posicion>=1&&$Posicion<=9))
			{
				$this->setError("La posicion para la marca de agua es incorrecto [" . $Posicion . "]");
				return;
			}
			$this->marcaAguaPosicion=$Posicion;
		}
		function getRutaSalida()
		{
			if($this->salidaJPG)
				$Extension="jpg";
			elseif($this->salidaPNG)
				$Extension="png";
			else
				$Extension="gif";

			return $this->directorioSalida . $this->nombreSalida . "." . $Extension;
		}
		function getError()
		{
			return $this->error;
		}
		function getStrError()
		{
			return $this->strError;
		}


		function Crear()
		{
			$this->calculaMedidasDestino();
			if($this->error)
				return false;

			if($this->Accion=="proporcion")
			{
				$this->redimensiona();
				$AltoM=$this->altoDestino;
				$AnchoM=$this->anchoDestino;
			}
			elseif($this->Accion=="redimensionar")
			{
				$this->_redimensionar();
			}
			else
			{
				$this->relleno();
				$AltoM=$this->maxAlto;
				$AnchoM=$this->maxAncho;
			}
			if($this->error)
				return false;

			if($this->marcaAgua)
			{
				if(is_resource($this->MarcaRedimensiona))
					imagedestroy($this->MarcaRedimensiona);

				if($this->Marca->getAncho()/$this->Marca->getAlto()>=$AnchoM/$AltoM)
				{
					$Ancho=$AnchoM;
					$Alto=$AnchoM*$this->Marca->getAlto()/$this->Marca->getAncho();
				}
				else
				{
					$Alto=$AltoM;
					$Ancho=$this->Marca->getAncho()*$AltoM/$this->Marca->getAlto();
				}

				$this->MarcaRedimensiona=imagecreate($Ancho,$Alto);
				imagealphablending($this->MarcaRedimensiona, true);
				imageSaveAlpha($this->MarcaRedimensiona, true);
				if(!$this->MarcaRedimensiona)
				{
					$this->setError("Error en la creacion de la marca de agua redimensionada");
					return;
				}

				if(!imagecopyresampled($this->MarcaRedimensiona,$this->Marca->getRecurso(),0,0,0,0,$Ancho,$Alto,$this->Marca->getAncho(),$this->Marca->getAlto()))
				{
					$this->setError("Error en el resampleo de la marca de agua redimensionada");
					return;
				}

				$Y=0;
				$X=0;
				switch($this->marcaAguaPosicion%3)
				{
					case 1:
						$X=0;
						break;
					case 2:
						$X=($AnchoM-$Ancho)/2;
						break;
					case 0:
						$X=($AnchoM-$Ancho);
						break;
				}
				switch(floor(($this->marcaAguaPosicion-1)/3))
				{
					case 0:
						$Y=0;
						break;
					case 1:
						$Y=($AltoM-$Alto)/2;
						break;
					case 2:
						$Y=($AltoM-$Alto);
						break;
				}

				if(!imagecopy($this->Destino,$this->MarcaRedimensiona,$X,$Y,0,0,$Ancho,$Alto))
				{
					$this->setError("Error copy de la marca de agua redimensionada");
					return;
				}
			}
			$this->generaSalida();
		}

		private function generaPNG()
		{
			if(!imagepng ($this->Destino,$this->getRutaSalida(),floor($this->calidadJPG/9)))
				$this->setError("Error en la creacion del archivo de imagen GIF desde GD");
			 return;

		}
		private function generaJPG()
		{
			 if(!imagejpeg ($this->Destino,$this->getRutaSalida(),$this->calidadJPG))
				$this->setError("Error en la creacion del archivo de imagen JPG desde GD");
			 return;
		}
		private function generaGIF()
		{
			if(!imagegif ($this->Destino,$this->getRutaSalida()))
				$this->setError("Error en la creacion del archivo de imagen GIF desde GD");
			 return;
		}
		
		private function _redimensionar()
		{
			if(is_resource($this->Destino))
				imagedestroy($this->Destino);
			$this->Destino=imagecreatetruecolor($this->anchoDestino,$this->altoDestino);
			imagefill ($this->Destino,0,0,imagecolorallocate ( $this->Destino, 255,255,255) );
			imagejpeg($this->Destino,"./tmp/algo.jpg");
			if(!$this->Destino)
			{
				$this->setError("No se logro crear la imagen GD del destino");
				return;
			}
			
			
			
			$dX=($this->anchoDestino-$this->Origen->getAncho())/2;
			$dY=($this->altoDestino-$this->Origen->getAlto())/2;
			
			if(!imagecopyresampled(
				$this->Destino,
				$this->Origen->getRecurso(),
				$dX,
				$dY,
				0,#
				0,#
				$this->Origen->getAncho(),
				$this->Origen->getAlto(),
				$this->Origen->getAncho(),
				$this->Origen->getAlto())
				)
			{
				$this->setError("Error en el copyresampled de redimensionar");
				return;
			}
		}

		private function redimensiona()
		{
			if(is_resource($this->Destino))
				imagedestroy($this->Destino);
			$this->Destino=imagecreatetruecolor($this->anchoDestino,$this->altoDestino);
			if(!$this->Destino)
			{
				$this->setError("No se logro crear la imagen GD del destino");
				return;
			}
			
			if($this->recorte)
			{
				if(!imagecopyresampled($this->Destino,$this->Origen->getRecurso(),0,0,$this->recorteX,$this->recorteY,$this->anchoDestino,$this->altoDestino,$this->recorteW,$this->recorteH))
				{
					$this->setError("Error en el copyresampled de redimensiona");
					return;
				}
			}
			else
			{
				if(!imagecopyresampled($this->Destino,$this->Origen->getRecurso(),0,0,0,0,$this->anchoDestino,$this->altoDestino,$this->Origen->getAncho(),$this->Origen->getAlto()))
				{
					$this->setError("Error en el copyresampled de redimensiona");
					return;
				}
			}
		}
		private function relleno()
		{
			$ImgOrg=$this->Origen->getRecurso();
			if($this->recorte)
			{
				$AnchoOrg=$this->recorteW;
				$AltoOrg=$this->recorteH;
			}
			else
			{
				list($AnchoOrg,$AltoOrg)=$this->Origen->getSize();
			}
			$AnchoMax=$this->maxAncho;
			$AltoMax=$this->maxAlto;

			if($AnchoOrg/$AltoOrg<$AnchoMax/$AltoMax)
			{
				$AnchoDest=$AnchoMax;
				$AltoDest=$AnchoMax*$AltoOrg/$AnchoOrg;
				$Y=($AltoDest-$AltoMax)/2;
				$X=0;
			}
			else
			{
				$AltoDest=$AltoMax;
				$AnchoDest=$AnchoOrg*$AltoMax/$AltoOrg;
				$X=($AnchoDest-$AnchoMax)/2;
				$Y=0;
			}
			$ImgDest2=imagecreatetruecolor($AnchoDest,$AltoDest);
			if(!$ImgDest2)
			{
				$this->setError("No se logro crear la imagen GD en relleno ImgDest2");
				return;
			}
			$ImgDest=imagecreatetruecolor($AnchoMax,$AltoMax);
			if(!$ImgDest)
			{
				$this->setError("No se logro crear la imagen GD en relleno ImgDest");
				return;
			}
			
			if($this->recorte)
			{
				if(!imagecopyresampled($ImgDest2,$ImgOrg,0,0,$this->recorteX,$this->recorteY,$AnchoDest,$AltoDest,$AnchoOrg,$AltoOrg))
				{
					$this->setError("Error en el copyresampled de relleno1");
					return;
				}
			}
			else
			{
				if(!imagecopyresampled($ImgDest2,$ImgOrg,0,0,0,0,$AnchoDest,$AltoDest,$AnchoOrg,$AltoOrg))
				{
					$this->setError("Error en el copyresampled de relleno1");
					return;
				}
			}
			if(!imagecopyresampled($ImgDest,$ImgDest2,0,0,$X,$Y,$AnchoMax,$AltoMax,$AnchoMax,$AltoMax))
			{
				$this->setError("Error en el copyresampled de relleno2");
				return;
			}
			
			$this->Destino=$ImgDest;
			return;
		
		}
		function getTipo()
		{
			if($this->salidaJPG)
				return "jpg";
			elseif($this->salidaPNG)
				return "png";
			return "gif";
		}
		function getNombre()
		{
			return $this->nombreSalida . "." . $this->getTipo();
		}
		
		function generaSalida()
		{
			if($this->salidaJPG)
				$this->generaJPG();
			elseif($this->salidaPNG)
				$this->generaPNG();
			else
				$this->generaGIF();
		}
		function forzarRedimension()
		{
			$this->siPequeNoHacerNada=false;
		}
		function noForzarRedimension()
		{
			$this->siPequeNoHacerNada=true;
		}
		
		function setRecorte($x,$y,$w,$h)
		{
			$this->recorte=true;
			
			if($x+$w>$this->Origen->getAncho())
			{
				$this->setError("Error en la puesta de recorte XW");
				return;
			}
			
			if($y+$h>$this->Origen->getAlto())
			{
				$this->setError("Error en la puesta de recorte YH");
				return;
			}
			
			$this->recorteX=$x;
			$this->recorteY=$y;
			$this->recorteW=$w;
			$this->recorteH=$h;
		}
		
		function resetSize()
		{
			$this->recorte=false;
		}
		
		function getAlto()
		{
			return $this->altoDestino;
		}
		
		function getAncho()
		{
			return $this->anchoDestino;
		}
		
		function redimensionar($ancho,$alto)
		{
			if(!(is_numeric($ancho))||!(is_numeric($ancho)))
			{
				$this->setError("las medidas son incorrectas [" . $ancho . "][" . $alto . "]");
				return;
			}
			$this->anchoDestino=$ancho;
			$this->altoDestino=$alto;
			$this->Accion="redimensionar";
		}
	};



	/*
	$img=new clsImagen($_FILES['uploadedfile_'.$i]['tmp_name']);
	$img->setNombreSalida("imagen");
	$img->setCarpetaSalida("../../fotos/" . $idProducto);
	$img->setPNG();

	$img->setMax(880,440);
	$img->setRutaMarcaAgua("../imagenes/marcaAgua.png");
	$Nombre=$img->getNombre();
	$img->Crear();

	$img->setNombreSalida("muestra");
	$img->setMax(212,132);
	$img->Crear();
	*/


	/*
	$im=new clsImagen("foto.jpg");
	if($im->getError())
	{
		echo $im->strError();
	}

	$im->setCarpetaSalida("./");
	$im->setNombreSalida("PRUEBA");

	$im->setJPG();
	$im->setRutaMarcaAgua("marcaAgua.png");

	$im->setMax(500,500);

	if($im->getError())
	{
		echo $im->strError();
	}
	$im->Crear();
	if($im->getError())
	{
		echo $im->getStrError();
	}


	$im->setMax(100,100);
	$im->setNombreSalida("MINI");

	if($im->getError())
	{
		echo $im->strError();
	}
	$im->Crear();
	if($im->getError())
	{
		echo $im->getStrError();
	}

	echo $im->getRutaSalida();
	*/
?>