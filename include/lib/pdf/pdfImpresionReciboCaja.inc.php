<?php
require_once LIB_FPDF;

class PDFImpresionReciboCaja extends FPDF
{
	
	var $nombreOficinaRecaudadora="";
	var $FolioOperacion="";
	var $CURP="";
	var $NombreCompleto="";
	var $NumLicencia="";
	var $Total="";
	
	
	
	
	
	
	var $Direccion="";
	var $Colonia="";
	var $Postal="";
	var $Localidad="";
	var $Municipio="";
	var $FechaNacimiento="";
	var $TipoSangre="";
	var $TelAccidente="";
	var $Alergia="";
	var $Donador="";
	var $FinVigencia="";
	
	
	
	var $Conceptos=array();
	
	
	
	
	var $altoCelda=4;
	
	
	
	
	public function __construct()
	{
		parent::__construct('P','mm',array(80,150));
		$this->SetAutoPageBreak(false);
	}
	
	
	
	
	
	
	/*-----------------------------------------------------------*/
	/*--------------------------SETTERS--------------------------*/
	/*-----------------------------------------------------------*/
	
	public function setNombreOficina($strNombre)
	{
		$this->nombreOficinaRecaudadora=$strNombre;
	}
	
	
	
	public function setFolioOperacion($FolioOperacion)
	{
		$this->FolioOperacion=$FolioOperacion;
	}
	public function setCURP($Curp)
	{
		$this->CURP=$Curp;
	}
	public function setNombreCompleto($Nombre)
	{
		$this->NombreCompleto=$Nombre;
	}
	public function setNumLicencia($NumLicecia)
	{
		$this->NumLicencia=$NumLicecia;
	}
		
	
		
	public function setConceptos($conceptos)
	{
		$this->Conceptos=$conceptos;
	}
	
	public function setTotal($total)
	{
		$this->Total=$total;
	}
	
	
	
	public function setDireccion($Direccion)
	{
		$this->Direccion=$Direccion;
	}
	public function setColonia($Colonia)
	{
		$this->Colonia=$Colonia;
	}
	public function setPostal($Postal)
	{
		$this->Postal=$Postal;
	}
	public function setLocalidad($Localidad)
	{
		$this->Localidad=$Localidad;
	}
	public function setMunicipio($Municipio)
	{
		$this->Municipio=$Municipio;
	}
	public function setFechaNacimiento($FechaNacimiento)
	{
		$this->FechaNacimiento=$FechaNacimiento;
	}
	public function setTipoSangre($TipoSangre)
	{
		$this->TipoSangre=$TipoSangre;
	}
	public function setTelAccidente($TelAccidente)
	{
		$this->TelAccidente=$TelAccidente;
	}
	public function setAlergia($Alergia)
	{
		$this->Alergia=$Alergia;
	}
	public function setDonador($Donador)
	{
		$this->Donador=$Donador;
	}
	public function setFinVigencia($FinVigencia)
	{
		$this->FinVigencia=$FinVigencia;
	}
	
	
	/*-----------------------------------------------------------*/
	/*-----------------------------------------------------------*/
	
	
	
	
	/**
	 *	Metodo que sobreescribe al original para autoajustar el texto dentro de una celda
	 *
	 * {@inheritDoc}
	 * @see FPDF::Cell()
	 *
	 *
	 * @param integer $w Ancho de la celda expresada en las unidades del documento.
	 * @param integer $h Alto de la celda expresada en las unidades del documento.
	 * @param string $txt Cadena de texto que se mostrará en la celda.
	 * @param integer|string $b 0 para ocultar borde, 1 para mostrar borde. Se pueden usar las letras T,R,B,L para expresar respectivamente top, right, button, left. Ex "RB" mostraria los border derecho e inferior.
	 * @param integer $ln 0 para no dar salto de linea, 1 dar salto de linea.
	 * @param integer $ln 0 para no dar salto de linea, 1 dar salto de linea.
	 * @param integer $ln 0 para no dar salto de linea, 1 dar salto de linea.
	 * @param integer $ln 0 para no dar salto de linea, 1 dar salto de linea.
	 *
	 */

	function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = 0, $link = '')
	{
		//$txt = strtoupper(trim($txt));
		// Output a cell
		$k = $this->k;
		if($this->y + $h > $this->PageBreakTrigger and ! $this->InFooter and $this->AcceptPageBreak())
		{
			$x = $this->x;
			$ws = $this->ws;
			if($ws > 0)
			{
				$this->ws = 0;
				$this->_out('0 Tw');
			}
			$this->AddPage($this->CurOrientation);
			$this->x = $x;
			if($ws > 0)
			{
				$this->ws = $ws;
				$this->_out(sprintf('%.3f Tw', $ws * $k));
			}
		}
		if($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$s = '';
		// begin change Cell function 12.08.2003
		if($fill == 1 or $border > 0)
		{
			if($fill == 1)
				$op = ($border > 0) ? 'B' : 'f';
			else
				$op = 'S';
			if($border > 1)
			{
				$s = sprintf(' q %.2f w %.2f %.2f %.2f %.2f re %s Q ', $border, $this->x * $k, ($this->h - $this->y) * $k, $w * $k, - $h * $k, $op);
			}
			else
				$s = sprintf('%.2f %.2f %.2f %.2f re %s ', $this->x * $k, ($this->h - $this->y) * $k, $w * $k, - $h * $k, $op);
		}
		if(is_string($border))
		{
			$x = $this->x;
			$y = $this->y;
			if(is_int(strpos($border, 'L')))
				$s .= sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
			else if(is_int(strpos($border, 'l')))
				$s .= sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x * $k, ($this->h - $y) * $k, $x * $k, ($this->h - ($y + $h)) * $k);
			
			if(is_int(strpos($border, 'T')))
				$s .= sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
			else if(is_int(strpos($border, 't')))
				$s .= sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - $y) * $k);
			
			if(is_int(strpos($border, 'R')))
				$s .= sprintf('%.2f %.2f m %.2f %.2f l S ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
			else if(is_int(strpos($border, 'r')))
				$s .= sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', ($x + $w) * $k, ($this->h - $y) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
			
			if(is_int(strpos($border, 'B')))
				$s .= sprintf('%.2f %.2f m %.2f %.2f l S ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
			else if(is_int(strpos($border, 'b')))
				$s .= sprintf('q 2 w %.2f %.2f m %.2f %.2f l S Q ', $x * $k, ($this->h - ($y + $h)) * $k, ($x + $w) * $k, ($this->h - ($y + $h)) * $k);
		}
		if(trim($txt) != '')
		{
			$cr = substr_count($txt, "\n");
			if($cr > 0)
			{ // Multi line
				$txts = explode("\n", $txt);
				$lines = count($txts);
				// $dy=($h-2*$this->cMargin)/$lines;
				for($l = 0; $l < $lines; $l ++)
				{
					$txt = $txts[$l];
					$w_txt = $this->GetStringWidth($txt);
					if($align == 'R')
						$dx = $w - $w_txt - $this->cMargin;
					elseif($align == 'C')
						$dx = ($w - $w_txt) / 2;
					else
						$dx = $this->cMargin;
					
					$txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
					if($this->ColorFlag)
						$s .= 'q ' . $this->TextColor . ' ';
					$s .= sprintf('BT %.2f %.2f Td (%s) Tj ET ', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + (.7 + $l - $lines / 2) * $this->FontSize)) * $k, $txt);
					if($this->underline)
						$s .= ' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
					if($this->ColorFlag)
						$s .= 'Q ';
					if($link)
						$this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $w_txt, $this->FontSize, $link);
				}
			}
			else
			{ // Single line
				$w_txt = $this->GetStringWidth($txt);
				$Tz = 100;
				if($w_txt > $w - 2 * $this->cMargin)
				{ // Need compression
					$Tz = ($w - 2 * $this->cMargin) / $w_txt * 100;
					$w_txt = $w - 2 * $this->cMargin;
				}
				if($align == 'R')
					$dx = $w - $w_txt - $this->cMargin;
				elseif($align == 'C')
					$dx = ($w - $w_txt) / 2;
				else
					$dx = $this->cMargin;
				$txt = str_replace(')', '\\)', str_replace('(', '\\(', str_replace('\\', '\\\\', $txt)));
				if($this->ColorFlag)
					$s .= 'q ' . $this->TextColor . ' ';
				$s .= sprintf('q BT %.2f %.2f Td %.2f Tz (%s) Tj ET Q ', ($this->x + $dx) * $k, ($this->h - ($this->y + .5 * $h + .3 * $this->FontSize)) * $k, $Tz, $txt);
				if($this->underline)
					$s .= ' ' . $this->_dounderline($this->x + $dx, $this->y + .5 * $h + .3 * $this->FontSize, $txt);
				if($this->ColorFlag)
					$s .= 'Q ';
				if($link)
					$this->Link($this->x + $dx, $this->y + .5 * $h - .5 * $this->FontSize, $w_txt, $this->FontSize, $link);
			}
		}
		// end change Cell function 12.08.2003
		if($s)
			$this->_out($s);
		$this->lasth = $h;
		if($ln > 0)
		{
			// Go to next line
			$this->y += $h;
			if($ln == 1)
				$this->x = $this->lMargin;
		}
		else
			$this->x += $w;
	}

	function Header()
	{
		$this->SetFont('Arial', '', 8);
		
		$meses=array(
			"01"=>"ENE",
			"02"=>"FEB",
			"03"=>"MAR",
			"04"=>"ABR",
			"05"=>"MAY",
			"06"=>"JUN",
			"07"=>"JUL",
			"08"=>"AGO",
			"09"=>"SEP",
			"10"=>"OCT",
			"11"=>"NOV",
			"12"=>"DIC");
		$mes=date("m");
		$mes=$meses[$mes];
				
		$dimMitad=($this->w-($this->lMargin+$this->rMargin))/2;
		$this->Cell($dimMitad, $this->altoCelda, str_replace("XXXX",$mes, date("d/XXXX/Y")), 0, 0, "L");
		$this->Cell($dimMitad, $this->altoCelda, str_replace("XXXX",$mes, date("H:i:s")), 0, 0, "R");
		$this->Ln($this->altoCelda+1);
		
		//$this->SetFont('Arial', 'I', 12);
		$this->Cell(0, $this->altoCelda, 'GOBIERNO DEL ESTADO DE TAMAULIPAS', 0, 0, "C");
		$this->Ln($this->altoCelda);
		$this->Cell(0, $this->altoCelda, 'SECRETARÍA DE FINANZAS', 0, 0, "C");
		$this->Ln($this->altoCelda);
		$this->Cell(0, $this->altoCelda, $this->nombreOficinaRecaudadora, 0, 0, "C");
		$this->Ln($this->altoCelda);
		$this->Cell(0, $this->altoCelda, "SFG210216AJ9", 0, 0, "C");
		$this->Ln($this->altoCelda);
		$this->Line($this->x, $this->y, $this->w-$this->rMargin, $this->y);
		$this->Ln(1);
		$this->Cell(0, $this->altoCelda, 'LICENCIA DE MANEJO', 0, 0, "C");
		$this->Ln($this->altoCelda);
		//$this->Ln(10);
	}
	/*
	function Footer()
	{
		$this->SetY(- 25);
		$this->SetFont('Arial', 'I', 8);
		$this->Cell(0, 6, 'Página ' . $this->PageNo() . " de {nb}", 0, 0, 'C');
		$this->Ln(6);
		$this->Cell(0, 10, 'Fecha generación ' . date("Y-m-d H:i:s") . " [" . $this->username . "]", 0, 0, 'C');
	}
	*/
	
	// Una tabla más completa
	function ImprovedTable($w, $align, $header, $data)
	{
		
		// Cabeceras
		$this->SetFont('Arial', 'B', 12);
		for($i = 0; $i < count($header); $i ++)
		{
			$this->Cell($w[$i], 7, $header[$i], 1, 0, 'C');
		}
		$this->Ln();
		// Datos
		
		$this->SetFont('Arial', '', 11);
		foreach ($data as $row)
		{
			for($i = 0; $i < count($row); $i ++)
			{
				$this->Cell($w[$i], 6, utf8_decode($row[$i]), 'LR', 0, $align[$i]);
			}
			
			$this->Ln();
		}
		// Línea de cierre
		$this->Cell(array_sum($w), 0, '', 'T');
	}
	
	
	private function printConceptos()
	{
		
		/*--------------------------------*/
		/*------Seccion de conceptos------*/
		/*--------------------------------*/
		
		$this->Line($this->x, $this->y, $this->w-$this->rMargin, $this->y);
		$this->Cell(10,$this->altoCelda,"Cant.",0,0,"C");
		$this->Cell(40,$this->altoCelda,"Descripción",0,0,"C");
		$this->Cell(0,$this->altoCelda,"Importe",0,0,"C");
		$this->Ln($this->altoCelda);
		
		$this->Line($this->x, $this->y, $this->w-$this->rMargin, $this->y);
		$this->Ln(1);
		
		for($i=0;$i<count($this->Conceptos);$i++)
		{
			list($cantidad, $descripcion,$importe)=$this->Conceptos[$i];
				
			$this->Cell(10,$this->altoCelda,$cantidad,0,0,"C");
			$this->Cell(40,$this->altoCelda,$descripcion);
			$this->Cell(0,$this->altoCelda,number_format($importe,2,".",","),0,0,"R");
			$this->Ln($this->altoCelda);
		}
		
		$this->Line($this->x, $this->y, $this->w-$this->rMargin, $this->y);
		$this->Ln(1);
		$this->Cell(50,$this->altoCelda,"Total: $ ",0,0,"R");
		$this->Cell(0,$this->altoCelda,number_format($this->Total,2,".",","),0,0,"R");
		
		
		/*--------------------------------*/
		/*--------------------------------*/
		
	}
	
	
	public function generaPaginas()
	{
		
		
		
		$this->AddPage("",array(80,80+count($this->Conceptos)*$this->altoCelda));
		
		$this->Cell(0,$this->altoCelda,"FOLIO DE OPERACIÓN: " . $this->FolioOperacion,0,0,"C");
		$this->Ln($this->altoCelda);
		$this->Line($this->x, $this->y, $this->w-$this->rMargin, $this->y);
		$this->Ln(1);
		$this->Cell(0,$this->altoCelda,"CURP: " . $this->CURP);
		$this->Ln($this->altoCelda);
		$this->Cell(0,$this->altoCelda,"Nombre: " . $this->NombreCompleto);
		$this->Ln($this->altoCelda+2);
		$this->Cell(0,$this->altoCelda,"Num: " . $this->NumLicencia);
		$this->Ln($this->altoCelda+2);
		$this->printConceptos();

		
		
		/*
		
		$this->AddPage("",array(80,125+count($this->Conceptos)*$this->altoCelda));
		
		$this->Ln(1);
		$this->Cell(0,$this->altoCelda,$this->NumLicencia,0,0,"C");
		$this->Ln($this->altoCelda+1);
		$this->Cell(0,$this->altoCelda,"FOLIO DE OPERACIÓN: " . $this->FolioOperacion,0,0,"C");
		$this->Ln($this->altoCelda+2);
		$this->Cell(0,$this->altoCelda,"CURP: " . $this->CURP);
		$this->Ln($this->altoCelda);
		$this->Cell(0,$this->altoCelda,"Nombre: " . $this->NombreCompleto);
		$this->Ln($this->altoCelda+3);
		
		
		$this->Cell(0,$this->altoCelda,"Dirección: " . $this->Direccion);
		$this->Ln($this->altoCelda);
		
		$this->Cell(0,$this->altoCelda,"Colonia: " . $this->Colonia);
		$this->Ln($this->altoCelda);
		
		$this->Cell(0,$this->altoCelda,"Código Postal: " . $this->Postal);
		$this->Ln($this->altoCelda);
		
		$this->Cell(0,$this->altoCelda,"Localidad: " . $this->Localidad);
		$this->Ln($this->altoCelda);
		
		$this->Cell(0,$this->altoCelda,"Municipio: " . $this->Municipio);
		$this->Ln($this->altoCelda);
		
		$this->Cell(0,$this->altoCelda,"Fecha Nac.: " . $this->FechaNacimiento);
		$this->Ln($this->altoCelda);
		
		$this->Cell(0,$this->altoCelda,"Tipo Sang.: " . $this->TipoSangre);
		$this->Ln($this->altoCelda);
		
		$this->Cell(0,$this->altoCelda,"Tel. Accidente: " . $this->TelAccidente);
		$this->Ln($this->altoCelda);
		
		$this->Cell(0,$this->altoCelda,"Alergia: " . $this->Alergia);
		$this->Ln($this->altoCelda);
		
		$this->Cell(0,$this->altoCelda,"Donador: " . $this->Donador);
		$this->Ln($this->altoCelda);
		
		$this->Cell(0,$this->altoCelda,"Fin Vig.: " . $this->FinVigencia);
		$this->Ln($this->altoCelda+2);
		$this->printConceptos();
		
		$this->Ln($this->altoCelda+2);
		
		#$this->MultiCell(0, $this->altoCelda, "Favor de verificar la informacion de la licencia y su costo. No se realizaran cancelaciones por este concepto.");
		*/
		
		
	}
	
	
	
	
}