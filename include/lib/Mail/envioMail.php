<?php
	if(ENVIOMAIL_SMTP)
	{
		require_once FOLDER_LIB . 'Mail/class.phpmailer.php';
	}
	/**
	 *
	 * Clase para el envio de mail preestablecidos
	 * @author Antonio
	 * @version 1
	 * @since 2012-MAR-12
	 * @example
	 * <pre>
	 * $email=new envioMail();
	 * $email->addAddress("antonio@madmind.mx","Antonio Pacheco");
	 * $email->envioRescateContra("jpacheco","XyXyXyXy");
	 * </pre>
	 *
	 */
	class envioMail
	{
		private $to=array();
		private $from=array("mail"=>"soporte@simplificados.la","name"=>"Soporte");
		private $subject="";
		private $body="";

		/**
		 *
		 * Funcion para enviar el mail, una ves establecidos los parametros de subject, body, to
		 * @return boolean
		 */

		public function enviarMail()
		{
			if(ENVIOMAIL_SMTP){
				return $this->enviarMailSMTP();
			}
			return $this->enviarMailPHP();
		}

		private function enviarMailSMTP()
		{
				$mail=new phpmailer();
				$mail->From         = ENVIOMAIL_SMTP_FROM;
				$mail->FromName     = ENVIOMAIL_SMTP_NAME;
				$mail->Mailer       = "smtp";
				$mail->Host        	= "smtp.gmail.com:465";
				$mail->Port        	= 465;
				$mail->ssl			= true;
				$mail->SMTPAuth     = true;
				$mail->Username     = ENVIOMAIL_SMTP_USERNAME;
				$mail->Password     = ENVIOMAIL_SMTP_PASS;
				$mail->SMTPDebug=false;
				$mail->IsHTML(true);

				foreach($this->to AS $k=>$dato)
					$mail->AddAddress($dato['mail'],$dato['name']);
				$mail->Subject = $this->subject;
				$mail->Body    =$this->body;
				if($mail->Send()){
					return TRUE;
				}
				throw new madException("Error en el envio de email [" . $mail->ErrorInfo . "]");
		}

		private function enviarMailPHP()
		{
			$To=array();
			$i=0;
			foreach($this->to as $dato)
			{
				if(isset($dato['name'])&&$dato['name']!=""){
					$To[]=$dato['name'] . " <" . $dato['mail'] . ">";
				}
				else{
					$dato['mail'];
				}
				$i++;
			}
			$To=implode(",",$To);
			$headers  = "From: " . $this->from['mail'] . "\r\n";
			$headers .= $i>1?"Bcc: " . $To . "\r\n":"";
			$headers .= "Reply-To: " . $this->from['mail'] . "\r\n";
			$headers .= "Return-Path: " . $this->from['mail'] . "\r\n";
			$headers .= "X-Mailer: PHP\n";
			$headers .= 'MIME-Version: 1.0' . "\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			if(@mail($i==1?$To:"", $this->subject, $this->body, $headers)){
				return TRUE;
			}
			throw new madException(L_ENVIOMAIL_ERRORENVIO);
		}

		/**
		 *
		 * Metodo para agregar destinatarios
		 * @param string $mail
		 * @param string $name
		 */
		public function addAddress($mail,$name="")
		{
			if(trim($mail)==""){
				throw new madException(L_ENVIOMAIL_ERRORADDADDRESS);
			}
			$this->to[]=array("mail"=>$mail,"name"=>$name);
		}

		/**
		 *
		 * Metodo para limpiar el arreglo de destinatarios
		 */

		public function clearAddress()
		{
			$this->to=array();
		}

		/**
		 *
		 * Metodo para setear el Subject del Mail
		 * @param string $Subject
		 */

		public function setSubject($Subject)
		{
			$this->subject=$Subject;
		}

		/**
		 *
		 * Metodo para setear el Body del mensaje, debe de ser contenido HTML, ahi va todo el cuerpo del Mail
		 * @param unknown_type $Body
		 */
		public function setBody($Body)
		{
			$this->body=$Body;
		}

		/**
		 *
		 * Metodo especifico para el envio de rescate de contras, ya tiene el body preestablecido, agrega al destinatario con addAddress
		 * @see $this->addAddress
		 * @param string pass $usuario usuario de sistema
		 * @param string $pass nuevo password establecido sin encriptar
		 * @throws Exception
		 * @return bool
		 */


		public function envioRescateContra($usuario,$pass)
		{
			if(count($this->to)>1)
				throw new  madException(L_ENVIOMAIL_CAPTURARSOLOUNO);
			$this->setSubject(L_ENVIOMAIL_REESTABLECERPASSWORD);
			$this->setBody("<html>
				<head>
				</head>
				<body>Estimado <b>" . $this->to[0]['name'] . "</b>, se reestablecio el password en tu cuenta de Kduceo Michoacan<br />
					<table>
						<tr>
							<td>Usuario:</td>
							<td>" . $usuario . "</td>
						</tr>
						<tr>
							<td>Password:</td>
							<td>" . $pass. "</td>
						</tr>
						<tr>
						</tr>
					</table>
				</body>
			</html>");
			return $this->enviarMail();
		}

		public function envioBienvenida($numTarjeta, $usuario, $folio,$pass)
		{
			if(count($this->to)>1)
				throw new  madException(L_ENVIOMAIL_CAPTURARSOLOUNO);
			$this->setSubject("Bienvenido al Programa de Apoyo Social Integral!");
			$this->setBody("<html>
						<head>
						</head>
						<body>Estimado <b>" . $this->to[0]['name'] . "</b>, estos son los datos para acceso a tu cuenta del Programa <br />
							<table>
								<tr>
									<td>N&uacute;mero de tarjeta:</td>
									<td>" . $numTarjeta . "</td>
								</tr>
								<tr>
									<td>Usuario del sistema:</td>
									<td>" . $usuario . "</td>
								</tr>
								<tr>
									<td>Contrase&ntilde;a:</td>
									<td>" . $pass. "</td>
								</tr>
								<tr>
									<td>N&uacute;mero de contrato:</td>
									<td>" . $folio . "</td>
								</tr>
							</table>
						</body>
					</html>");
			return $this->enviarMail();
		}

		public function envioActivarPerfil($code)
		{
			if(count($this->to)>1)
				throw new  madException(L_ENVIOMAIL_CAPTURARSOLOUNO);
			$this->setSubject("Activa tu cuenta en la Red Productiva Social!");
			$this->setBody("<html>
								<head>
								</head>
								<body>Estimado <b>" . $this->to[0]['name'] . "</b>, Este es tu codigo de activacion para tu cuenta en Kduceo Michoacan<br />
									<table>
										<tr>
											<td>Codigo:</td>
											<td><b>" . $code . "</b></td>
										</tr>
										<tr>
											<td colspan='2'><a href='" . DOMINIO . "/redServer/confirm/index.php?C=" . $code . "'>Da clic aqu&iacute; para activar tu cuenta.</a></td>
										</tr>
									</table>
								</body>
							</html>");
			return $this->enviarMail();
		}
	}
?>