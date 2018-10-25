var mostrarErrorSegundo=function(mensaje)
{
	bootbox.dialog({
		message: '<div class="row"><div class="col-sm-3"><i class="fa fa-warning fa-4x"></i> </div><div class="col-sm-9 ">' + mensaje + '</div>',
		title: "Error",
		locale:"es",
		onEscape:true,
		buttons: 
		{	
			main: 
			{
				label: "Enterado",
				className: "btn-default pull-right"
				//callback: function(){window.location.href=linkSiguiente;}  
			}
		}
	});
};


var mostrarAvisoSegundo=function(msg)
{
	
	bootbox.dialog({
		message: '<div class="row"><div class="col-sm-3"><i class="fa fa-info-circle fa-4x" ></i> </div><div class="col-sm-9 ">' + msg + '</div>',
		
		title: "Aviso",
		locale:"es",
		onEscape:true,
		buttons: 
		{
			main: 
			{
				label: "Enterado",
				className: "btn-default pull-right"
				//callback: function(){window.location.href=linkSiguiente;}  
			}
		}
	});
	
};

var impresionImpresa=function(idTurno)
{
	bootbox.confirm("El proceso finalizar&aacute;.", function(result)
	{ 
		if(result)
		{
			mostrarAviso("Enviando informaci&oacute;n...");
			xajax_impresionImpresa(idTurno);
		}
	});
	
};

var preguntarImpresionCorrecta=function()
{
	bootbox.confirm("&iquest;La impresi&oacute;n se realiz&oacute; correctamente?", function(result)
	{ 
		if(result)
		{
			//mostrarAviso("Enviando informaci&oacute;n...");
			//xajax_impresionImpresa(idTurno);
			window.location.replace("dashboard.php?call=true");
		}
	});
};

var mostrarExitoSegundo=function(mensaje)
{
	bootbox.dialog({
		message: '<div class="row"><div class="col-sm-3"><i class="fa fa-thumbs-o-up fa-4x" ></i> </div><div class="col-sm-9 ">' + mensaje + '</div>',
		
		title: "Operaci&oacute;n exitosa.",
		locale:"es",
		onEscape:true,
		buttons: 
		{
			main: 
			{
				label: "Genial!",
				className: "btn-default pull-right"
				//callback: function(){window.location.href=linkSiguiente;}  
			}
		}
	});
};


var activarConfirmacion=function(idTurno,folioPVC)
{
	mostrarAvisoSegundo("Activando licencia...");
	xajax_activarConfirmacion(idTurno,folioPVC);
	return false;
};


var impresionValidar=function(idTurno)
{
	bootbox.prompt("Captura el folio del pl&aacute;stico PVC.", function(result)
	{ 
		if(result)
		{
			activarConfirmacion(idTurno,result);
		}
	});
};

var enviarCancelacionReimpresion=function(idTurno)
{
	var slcMotivo=$("#slcMotivoReimpresion").val();
	var txtPVCAnterior=$("#txtPVCAnterior").val().trim();
	var txtPVCNuevo=$("#txtPVCNuevo").val().trim();
	var txtAutoriza=$("#txtAutoriza").val().trim();
	var txtPass=$("#txtPass").val().trim();
	
	console.log("[slcMotivo][" + slcMotivo + "]");
	console.log("[txtPVCAnterior][" + txtPVCAnterior + "]");
	console.log("[txtPVCNuevo][" + txtPVCNuevo + "]");
	console.log("[txtAutoriza][" + txtAutoriza + "]");
	console.log("[txtPass][" + txtPass + "]");
	
	
	
	
	switch(slcMotivo)
	{
		case "2":
		case "4":
		case "5":
			if(txtPVCAnterior==""||txtPVCNuevo==""||txtAutoriza==""||txtPass=="")
			{
				mostrarAvisoSegundo("Todos los campos son obligatorios.");
				return false;
			}
			break;
		case "6":
		case "7":
		
			if(txtPVCAnterior=="")
			{
				mostrarAvisoSegundo("Captura el folio del PVC anterior.");
				return false;
			}
			break;
		case "3":
			if(txtPVCAnterior=="")
			{
				mostrarAvisoSegundo("Captura el folio del PVC anterior.");
				return false;
			}
			txtPVCNuevo=txtPVCAnterior;
			break;
		case "8":
			if(txtPVCNuevo=="")
			{
				mostrarAvisoSegundo("Captura el folio del PVC nuevo.");
				return false;
			}
			txtPVCAnterior="0";
			break;
		default:
			mostrarAvisoSegundo("Selecciona la opci&oacute;n de cancelaci&oacute;n / reimpresi&oacute;n.");
			return false;
	}	
	
	
	if(txtAutoriza=="")
	{
		mostrarAvisoSegundo("Ingresa el usuario para autorizaci&oacute;n.");
		return false;
	}
	if(txtPass=="")
	{
		mostrarAvisoSegundo("Ingresa la contrase&ntilde;a de usuario que autoriza.");
		return false;
	}
	

	xajax_enviarCancelacionReimpresion(idTurno,slcMotivo, txtPVCAnterior, txtPVCNuevo, txtAutoriza, txtPass);
	
	
	console.log("Enviando");
	//console.log(slcMotivo);
};

var cerrarDialogosReimpresion=function()
{
	console.log("Cerrar todo");
	bootbox.hideAll()
};

var impresionReimprimir=function(idTurno)
{
	bootbox.dialog({
		message:  '<div class="row">'+
        '	<div class="col-sm-4"><label>Motivo</label></div>'+
        '	<div class="col-sm-8">'+
        '		<select id="slcMotivoReimpresion" class="form-control" onchange="cambioMotivoCancelacionReimpresion()">'+
        '			<option value="2">TARJETA DA&Ntilde;ADA</option>'+
		'			<option value="3">TARJETA NO UTILIZADA</option>'+
		'			<option value="4">IMPRESI&Oacute;N DEFICIENTE</option>'+
		'			<option value="5">FALLA EL&Eacute;CTRICA</option>'+
		'			<option value="6">ERROR EN LOS DATOS</option>'+
		'			<option value="7">CANCELAR OP. DE PAGO</option>'+
		'			<option value="8">PAGO REIMPRESI&Oacute;N</option>'+
        '		</select>'+
		'	</div>'+
        '</div>'+
        '<div class="spacer-5"></div>'+
        ''+
        '<div class="row">'+
        '	<div class="col-sm-4"><label>PVC Anterior</label></div>'+
        '	<div class="col-sm-8">'+
        '		<input type="text" id="txtPVCAnterior" class="form-control"/>'+
		'	</div>'+
        '</div>'+
        '<div class="spacer-5"></div>'+
        ''+
        ''+
        '<div class="row">'+
        '	<div class="col-sm-4"><label>PVC Nuevo</label></div>'+
        '	<div class="col-sm-8">'+
        '		<input type="text" id="txtPVCNuevo" class="form-control"/>'+
		'	</div>'+
        '</div>'+
        '<div class="spacer-5"></div>'+
        ''+
        '<div class="row">'+
        '	<div class="col-sm-4"><label>Autoriza</label></div>'+
        '	<div class="col-sm-8">'+
        '		<input type="text" id="txtAutoriza" class="form-control"/>'+
		'	</div>'+
        '</div>'+
        '<div class="spacer-5"></div>'+
        ''+
        '<div class="row">'+
        '	<div class="col-sm-4"><label>Contrase&ntilde;a</label></div>'+
        '	<div class="col-sm-8">'+
        '		<input type="password" id="txtPass" class="form-control"/>'+
		'	</div>'+
        '</div>'+
        '<div class="spacer-5" ></div>'+
        
        '<div class="row " >'+
	        '<div class="col-sm-12">'+
			
			'	<button class="btn btn-primary pull-right" onclick="enviarCancelacionReimpresion(' + idTurno + ')">Enviar Informaci&oacute;n</button>'+
			'</div>'+
		'</div>'+
		''+
        '</div>',
		title: '<i class="fa fa-print " ></i>  Reimprimir',
		locale:"es",
		onEscape:false,
		size: "large",
		buttons: 
		{	
			main: 
			{
				label: "Cerrar",
				className: "btn-primary"  
			}
			
		}
	});
	
};

var impresionCancelar=function()
{
	
	
	
	bootbox.dialog({
		message: '<div class="row"><div class="col-sm-12">' + tabla + '</div></div>',
		title: '<i class="fa fa-print " ></i>  Trabajos de impresi&oacute;n',
		locale:"es",
		onEscape:false,
		size:"large",
		buttons: 
		{	
			main: 
			{
				label: "Listo",
				className: "btn-primary"  
			}
		}
	});
	
	
};


var printJobMostrarTabla=function(tabla)
{
	bootbox.dialog({
		message: '<div class="row"><div class="col-sm-12">' + tabla + '</div></div>',
		title: '<i class="fa fa-print " ></i>  Trabajos de impresi&oacute;n',
		locale:"es",
		onEscape:false,
		size:"large",
		buttons: 
		{	
			main: 
			{
				label: "Listo",
				className: "btn-primary"  
			}
		}
	});
	
	
	
};

var cambioMotivoCancelacionReimpresion=function()
{
	
	
	//alert(el);
	//console.log($(".slcMotivoReimpresion").val());
	//console.log($(this).val());
	
	console.log("Entro cambio");
	
	/*
	var slcMotivo=$("#slcMotivoReimpresion").val();
	var txtPVCAnterior=$("#txtPVCAnterior").val().trim();
	var txtPVCNuevo=$("#txtPVCNuevo").val().trim();
	var txtAutoriza=$("#txtAutoriza").val().trim();
	var txtPass=$("#txtPass").val().trim();
	*/
		
	
};

var inicializarControlesPrintJob=function()
{
	
	//$(".slcMotivoReimpresion").on("change",cambioMotivoCancelacionReimpresion);
	$("#btnVerListaJobsImpresion").click(function()
	{
		xajax_getTrabajosImpresion();
	});
	
};

$(document).ready(function(){inicializarControlesPrintJob()});