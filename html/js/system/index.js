

	var enviar=function()
	{
			var txtUsuario='usuario@insha.com';
			var txtPass='emision123';
			mostrarEspera("Solicitando acceso...");
			xajax_ingresar(txtUsuario,txtPass);      
			return false;
	};
	
	$(document).ready(function()
	{	
		enviar();
	});
	 

