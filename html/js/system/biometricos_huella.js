$(document).ready(function() {
	inicializarControles()
});

var ini = 0, limiteI=0, limiteS=3, numBio=0;
var arr, huellas={};


var verTurno=function(idT,nombre,CURP)
{
    $('html,body').animate({
        scrollTop: $("#verificaC").offset().top
    }, 2000);

//mostrarEspera('Proceso de captura de biom&eacute;tricos...');
$("#widBio").show();
$("#divCapturaH").show();
//$("#hdnIdTurno").val(idT);

var infoTurno='<div class="inner-padding"><p><strong>ID Turno: &ensp;</strong><label class="text-muted">'+idT+'</label></p>'+
'<p><strong>Nombre: &ensp;</strong><label class="text-muted">'+nombre+'</label></p>'+
'<p><strong>CURP: &ensp;</strong><label class="text-muted">'+CURP+'</label></p></div>';

//$("#datosPersona").html(infoTurno);
infoTurno='';

$("#divCapturaH").html('		<div class="col-sm-6" class="img-responsive"> 	'+infoTurno+'  	<div class="spacer-50"></div><div class="col-sm-12 text-center img-responsive"" id="divBiomH" style="display: ;"> 					<img alt="" src="images/captura_0.png" class="img-responsive" height="300" /> 				</div> 	<div class="col-sm-12 img-responsive" id="divIm"></div>				</div>  		<div class="col-sm-6" id="divContenidoH" class="img-responsive"> '+
	'<div class="spacer-50"></div> 			<div class="spacer-50"></div>'+
		'<div class=""> 		<div class="pull-right" id="divButtonsDedo"> 				<!--	<a type="button" class="btn btn-success" onclick="siguiente(\'h\');" id="btnIniciar">Iniciar</a> -->				</div> 			</div></div> 	</div> </div>');


}

var inicializarControles = function() {
	$.ajax({
		method : "post",
		url : "adminFunciones.php",
		data : {
			getKeyHuellas : ''
		},
		success : function(data) {
			arr=JSON.parse(data);
	
			siguiente('h') ;
			
		}
	});
	
	var idtVigente=parseInt($("#hdnIdT").val());
	var nombre=$("#hdnPersona").val();
	var CURP=$("#hdnCURP").val();
  	//alert(idtVigente);
	if(idtVigente>0){
		verTurno(idtVigente, nombre, CURP);
	} 

	
}

function siguiente(bio) {
	var texto='';
	switch(bio){
	case 'h':
	ini++;
	if(ini<4){
		if(ini==2){
			limiteI=4;
			limiteS=7;
		}
		if(ini==3){
			limiteI=8;
			limiteS=9;
		}
		$("#divIm").html(''); // div huellas capturadas
	$("#divBiomH").html('<div style=" position:relative;"><img alt="" src="images/captura_'+ini+'.png" />'+
			'<div id="i_VDM" style="display: none; position:absolute; top:28%; left:3%; width: 31px; height: 27px;"> <img border="0"  src="images/venda_DM.png"  class="img-responsive"/> </div>'+
			'<div id="i_NDM" style="display: none; position:absolute; top:28%; left:2%; width: 31px; height: 27px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VDA" style="display: none; position:absolute; top:12%; left:14%; width: 29px; height: 25px;"> <img border="0"  src="images/venda_DA.png"  class="img-responsive"/> </div>'+
			'<div id="i_NDA" style="display: none; position:absolute; top:12%; left:14%; width: 31px; height: 27px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VDE" style="display: none; position:absolute; top:8%; left:24%; width: 29px; height: 22px;"> <img border="0"  src="images/venda_DE.png"  class="img-responsive"/> </div>'+
			'<div id="i_NDE" style="display: none; position:absolute; top:8%; left:24%; width: 31px; height: 27px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VDI" style="display: none; position:absolute; top:11%; left:33%; width: 29px; height: 22px;"> <img border="0"  src="images/venda_DI.png"  class="img-responsive"/> </div>'+
			'<div id="i_NDI" style="display: none; position:absolute; top:11%; left:33%; width: 31px; height: 27px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VDP" style="display: none; position:absolute; top:45%; left:43%; width: 32px; height: 25px;"> <img border="0"  src="images/venda_DP.png"  class="img-responsive"/> </div>'+
			'<div id="i_NDP" style="display: none; position:absolute; top:45%; left:43%; width: 31px; height: 27px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VIP" style="display: none; position:absolute; top:45%; left:51%; width: 32px; height: 25px;"> <img border="0"  src="images/venda_IP.png"  class="img-responsive"/> </div>'+
			'<div id="i_NIP" style="display: none; position:absolute; top:45%; left:51%; width: 31px; height: 27px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VII" style="display: none; position:absolute; top:11%; left:60%; width: 29px; height: 22px;"> <img border="0"  src="images/venda_II.png"  class="img-responsive"/> </div>'+
			'<div id="i_NII" style="display: none; position:absolute; top:11%; left:59%; width: 31px; height: 27px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VIE" style="display: none; position:absolute; top:8%; left:67.5%; width: 32px; height: 22px;"> <img border="0"  src="images/venda_IE.png"  class="img-responsive"/> </div>'+
			'<div id="i_NIE" style="display: none; position:absolute; top:8%; left:67.5%; width: 31px; height: 27px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VIA" style="display: none; position:absolute; top:12%; left:79.2%; width: 29px; height: 22px;"> <img border="0"  src="images/venda_IA.png"  class="img-responsive"/> </div>'+
			'<div id="i_NIA" style="display: none; position:absolute; top:12%; left:79.2%; width: 31px; height: 27px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VIM" style="display: none; position:absolute; top:28%; left:89%; width: 29px; height: 25px;"> <img border="0"  src="images/venda_IM.png"  class="img-responsive"/> </div>'+
			'<div id="i_NIM" style="display: none; position:absolute; top:28%; left:89%; width: 31px; height: 27px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div></div>');
	mostrarEspera('Capturaci&oacute;n '+ini+' de 3...');
//	alert(arr);
	$.each(arr, function(key, arrDedo) {
		if(key>=limiteI&&key<=limiteS){ 
			texto+='<tr class="columnatdD"><td>'+arrDedo[0]+'</td><td colspan="2">'+arrDedo[1]+'</td><input type="hidden" id="hdn'+key+'" value="'+arrDedo[0]+'"/>'+
			'<td><select id="slcOpc'+arrDedo[0]+'" onchange="comboDedo(\''+arrDedo[0]+'\');" class="form-control"><option value="disponibleH">Disponible</option><option value="nodisponible">No disponible</option><option value="dedovenda">Vendado</option></select></td></tr>';
			 }
		});
	$("#divContenidoH").html(creaTabla(texto,'Dedo'));
	}
	setTimeout(function(){
	ocultarMensaje();
	},1500);
	break;
	}
}

function creaTabla(contenido,bio){
	return '<div id="divExitosa'+bio+'" class="alert alert-success" style="display: none;"><button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-check-circle"></i>Captura exitosa!</div>'+
	'<div class="spacer-30"></div><div class="inner-padding" id="divTabla">'+
	'<table class="table table-bordered table-condensed"><thead>'+
	'<tr id="columnath'+bio+'"><th scope="col">ID</th><th scope="col" colspan="2">'+bio+'</th><th scope="col">Opci&oacute;n</th></tr>'+
	'</thead><tbody>'+contenido+'</tbody></table>'+
	'</div><div class="spacer-50"></div><div class="spacer-20"></div><div class=""><div class="pull-right" id="divButtons'+bio+'">'+
	'<a type="button" class="btn btn-warning" id="btnCancelar" onclick="empezarCiclo();">Cancelar</a><a type="button" class="btn btn-info" onclick="capturar(\''+bio+'\')" >Capturar</a></div></div>';
}

function capturar(bio){
	mostrarEspera('Espere un momento...');
	setTimeout(function(){
		createWebsocket();
	},1500);
	
	/*
	switch(bio){
	case 'Dedo':
	setTimeout(function(){
	var imgD='<div class="spacer-50"></div><div style="position:relative; " class="img-responsive">';
	letf=0;
	for(i=limiteI;i<=limiteS;i++){
		imgD+='<div style="position:absolute; left:'+letf+'%; width: 120px; ;" > <img  alt="" src="images/'+$("#slcOpc"+arr[i][0]).val()+'.png"  class="img-responsive"/></div>';
//		alert($("#slcOpc"+arr[i][0]).val());
		if($("#slcOpc"+arr[i][0]).val()=='disponibleH')
			huellas[(i+1)]='/biometricos/huellas/'+$("#slcOpc"+arr[i][0]).val()+arr[i][0]+'.png';
		letf+=25;
	}
	//$("#divBiomH").removeClass('img-responsive');
	$("#divIm").html(imgD+'<br /></div><div id="finDiv" class="spacer-50"></div><div class="spacer-50"></div><div class="spacer-50"></div>');
	var t=$('.extratdD').length;
	if(t==0){
	$("#columnathDedo").append('<th>Captura</th>');
	
	$(".columnatdD").append('<td class="extratdD"><div class="btn btn-default btn-circle btn-success"><i class="fa fa-check "></i><input type="hidden" name="bol_user" value="true" /></div></td>');
	
	if(ini<3)
		$("#divButtonsDedo").append('<a type="button" class="btn btn-success" onclick="siguiente(\'h\')" >Siguiente</a>');
	else
		$("#divButtonsDedo").append('<a type="button" class="btn btn-success" onclick="terminar(\''+bio+'\')" >Guardar</a>');
	}
	$('html,body').animate({
        scrollTop: $("#finDiv").offset().top
    }, 2000);

	ocultarMensaje();
	},2000);
	
	break;
	

	}
	*/
	
}

function terminar(bio){
	mostrarEspera('Espere un momento...');
	$("#tab"+bio).css("background-color","inactivecaption");
	$("#divExitosa"+bio).show();
	xajax_guardarHuellas($("#hdnIdTurno").val(), JSON.stringify(huellas),bio);
}

function next(){
	numBio++;
	 huellas={};
	 if(numBio==3)
		 xajax_siguienteTurno($("#hdnIdTurno").val());
}

function comboDedo(opc){

	$("#divIm").html('');
	$("#i_N"+opc).hide();
	$("#i_V"+opc).hide();
	
	switch($("#slcOpc"+opc).val()){
	case 'dedovenda': $("#i_V"+opc).show(); break;
	case 'nodisponible': $("#i_N"+opc).show(); break;
	}
	
//	alert(opc+' '+$("#slcOpc"+opc).val());
}

function empezarCiclo(){
	ini=0;
	limiteI=0;
	limiteS=3;
	siguiente('h') ;
//	alert('aqui');
}


function avanzaTemporal(){
	//alert('ju');
	window.location="biometricos_iris.php";
//	xajax_avanzaSinGuardar();
	return false;
}

//------------------------- AWARE COMPONENTES-----------------

var deviceName = "GB_DACTY84C, CROSSMATCH_GUARDIAN, IB_WATSONMINI, EXTERNAL";
var imgElement = document.getElementById("previewImage");
var statusElement = document.getElementById("status");
var captureComponent;

// Creates the websocket
function createWebsocket()
{
    var hasError = false;
//    statusElement.innerText = "Opening Websocket...";
    //alert('juu');
    websocket = new WebSocket("ws://localhost:2080");
    websocket.onerror = function (event) {
        hasError = true;
      mostrarError( "Error al conectarse con el servidor BioComponentServer, por favor verifique si est&aacute; en ejecuci&oacute;n.");
      return ;
    };
    websocket.onclose = function (event) {
        if (!hasError)
        	  mostrarError("Websocket closed. Refresh page to start over.");
    };
    websocket.onopen = function (event) {
        connectToServer(websocket);
    };
}

// Creates and connects to FingerprintCaptureComponent on the BioComponent server
function connectToServer(websocket) {
//    statusElement.innerText = "Connecting to FingerprintCaptureComponent...";
    var transport = createWebsocketTransport(websocket);
    createFingerprintCapture(transport, "FingerprintCapture").then(function (captureComponentValue) {
        captureComponent = captureComponentValue;
    //    captureComponent.setPreviewImageUpdated(onPreviewImage);
//        captureComponent.setCapturedImageUpdated(onCapturedImage);
//         captureComponent.setAutocaptureStatusUpdated(onAutocaptureStatus);
 //       statusElement.innerText = "Opening device...";
        console.log("aqui:");
        captureComponent.openDevice(deviceName).then(
        		function (){},function (error) {
        			  mostrarError("Error en el dispositivo biom&eacute;trico:  " + error);
//                    showMessage("Failed to opened device");
        			  $("#divButtonsDedo").html('<a type="button" class="btn btn-success" onclick="avanzaTemporal();" >Siguiente</a>');
                //    autoConnect = false;
                 //   setState(State.CONNECTED);
                //    showOpenFailure();
              //      reject(error);
                }
            );
  //      console.log("aqui 2:");
    }).then(function () {
    //    statusElement.innerText = "Starting preview...";
    //    var impression = FingerprintCaptureApi.Impression.PLAIN_LEFT_THUMB;
///        return captureComponent.startAutoCapture(impression, FingerprintCaptureApi.ImageFormat.JPG)
    	window.location='demo/demo.php';
    }).then(function () {
//        statusElement.innerText = "Previewing image...";
    }).catch(function (error_code) {
    	mostrarError( "Error en el dispositivo biom&eacute;trico: " + error_code);
    });
}
