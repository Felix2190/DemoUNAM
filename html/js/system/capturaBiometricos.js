/************************ HUELLA ***********************************************************/

var ini = 0, limiteI=0, limiteS=3, numBio=0, numHuellasCapturadas=0;
var arr, huellas={};


var mostrarRecuadrosBio=function(idT)
{

$("#divCapturaH").show();
$("#divCapturaI").show();
$("#divCapturaR").show();
//$("#hdnIdTurno").val(idT);

var infoTurno='';
$("#divCapturaH").html('		<div class="col-sm-7" class="img-responsive"> 	'+infoTurno+'  	<div class="col-sm-12 text-center img-responsive"" id="divBiomH" style="display: ;"> 					<img alt="" src="images/captura_0.png" class="img-responsive" /> 				</div> 	<div class="col-sm-12 img-responsive" id="divIm"></div>				</div>  		<div class="col-sm-6" id="divContenidoH" class="img-responsive"> '+
	''+
		'<div class=""> 		<div class="pull-right" id="divButtonsDedo"> 				<!--	<a type="button" class="btn btn-success" onclick="siguiente(\'h\');" id="btnIniciar">Iniciar</a> -->				</div> 			</div></div> 	</div> </div>');

$("#divCapturaI").html('<div class="col-sm-6" class="img-responsive"> '+infoTurno+'		<div class="spacer-50"></div><div class="col-sm-12 text-center img-responsive"" id="divBiomI" style="display: ;" > 	'+
		'<img alt="" src="images/capturaI_0.png" class="img-responsive"  height="300px"/> '+
		'<div id="i_OD" style="display: none; position:absolute; top:14%; left:15%; width: 100px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
		'<div id="i_OI" style="display: none; position:absolute; top:14%; left:65%; width: 100px; height: 60px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
		'</div> '+
		'	<div class="col-sm-12 img-responsive" id="divIm"></div>		</div> 	</div> 				<div class="col-sm-6" id="divContenidoI"> 			<div class="spacer-50"></div> 			<div class="spacer-50"></div>'+
	'<div class=""> 				<div class="pull-right" id="divButtonsOjo"> 			<!--		<a type="button" class="btn btn-success" onclick="siguiente(\'i\');" id="btnIniciar">Iniciar</a> -->				</div> 			</div></div> 	</div> </div></div>');

$("#divCapturaR").html('<div class="col-sm-6"> '+infoTurno+'<div class="inner-padding"> 	<div class="spacer-50"></div><div class="col-sm-12 align-center" id="divBiomR" style="display: ;"> 					<img alt="" src="images/capturaR_0.png" class="img-responsive" width="300px" /> 				</div> 			</div> 		</div> 		 		<div class="col-sm-6" id="divContenidoR"> '+
		'<div id="divExitosaRostro" class="alert alert-success" style="display: none;"><button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-check-circle"></i>Captura exitosa!</div>'+
		'			<div class="spacer-50"></div> 			<div class="spacer-50"></div> '+
		'<div class=""> 				<div class="pull-right" id="divButtonsRostro"> 					<a type="button" class="btn btn-info" onclick="capturar(\'Rostro\')" style="display: none;">Capturar</a>				</div> 			</div></div> 	</div> </div>');

$('html,body').animate({
    scrollTop: $("#divBiomH").offset().top
}, 2000);

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
	$("#divBiomH").html(
		    '<img id="previewImage" style="max-width:100%; max-height:100%"></div>'+
		    '<div id="imagenCaptura" style=" position:relative;"><img alt="" src="images/captura_'+ini+'.png" />'+
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
			'<div id="i_NIM" style="display: none; position:absolute; top:28%; left:89%; width: 31px; height: 27px;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div></div><div id="imagenHuellas"  style="border:1px solid lightgray; display: none; ">');
	//mostrarEspera('Capturaci&oacute;n '+ini+' de 3...');
//	alert(arr);
	$.each(arr, function(key, arrDedo) {
		if(key>=limiteI&&key<=limiteS){ 
			texto+='<tr class="columnatdD_'+key+'"><td>'+arrDedo[0]+'</td><td colspan="2">'+arrDedo[1]+'</td><input type="hidden" id="hdn'+key+'" value="'+arrDedo[0]+'"/>'+
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
	'<div class="inner-padding" id="divTabla">'+
	'<table class="table table-bordered table-condensed"><thead>'+
	'<tr id="columnath'+bio+'"><th scope="col">ID</th><th scope="col" colspan="2">'+bio+'</th><th scope="col">Opci&oacute;n</th></tr>'+
	'</thead><tbody>'+contenido+'</tbody></table>'+
	'</div><div class="spacer-20"></div><div class=""><div class="pull-right" id="divButtons'+bio+'">'+
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

function finCapturaHuellasSeccion(){
	numHuellasCapturadas++;
	console.log('num '+numHuellasCapturadas+'   ');
	var b=false;
	switch(ini){
	case 1:
		if(numHuellasCapturadas>4){
			numHuellasCapturadas=0;
			return false;
		}else finCaptura();
		break;
	case 2:
		if(numHuellasCapturadas>4){
			numHuellasCapturadas=0;
			return false;
		}else finCaptura();
		break;
	case 3:
		if(numHuellasCapturadas>2){
			numHuellasCapturadas=0;
			return false;
		} else finCaptura();
		break;
	}	
//	return false;
	
}

function finCaptura(){
	mostrarAviso('Huellas guardadas correctamente...');
	setTimeout(function(){
		var t=$('.extratdD').length, iconCapt, iconStatus='';
		if(t==0){
		$("#columnathDedo").append('<th>Captura</th>');
		
		for(i=limiteI;i<=limiteS;i++){
			iconCapt='fa fa-check ';
			iconStatus='success';
			console.log($("#slcOpc"+arr[i][0]).val());
			switch($("#slcOpc"+arr[i][0]).val()){
			case 'dedovenda': iconStatus='warning'; iconCapt='fa fa-info-circle '; break;
			case 'nodisponible': iconStatus='danger'; iconCapt='fa fa-times-circle '; break;
			}
		$(".columnatdD_"+i).append('<td class="extratdD"><div class="btn btn-default btn-circle btn-'+iconStatus+'"><i class="'+iconCapt+'"></i></div></td>');
		}
	
		if(ini<3)
			$("#divButtonsDedo").append('<a type="button" class="btn btn-success" onclick="siguiente(\'h\')" >Siguiente Paso</a>');
		else
			$("#divButtonsDedo").append('<a type="button" class="btn btn-success" onclick="terminar()" >Guardar</a>');
		}
		console.log('terminar');
		ocultarMensaje();
	},1500);

	
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
    /*
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
 //     var impression = FingerprintCaptureApi.Impression.PLAIN_LEFT_THUMB;
//        return captureComponent.startAutoCapture(impression, FingerprintCaptureApi.ImageFormat.JPG)
//    	window.location='demo/demo.php';
    	$("#imagenCaptura").hide();
    	startPreview();
    	$("#imagenHuellas").show();
    }).then(function () {
//        statusElement.innerText = "Previewing image...";
    }).catch(function (error_code) {
    	mostrarError( "Error en el dispositivo biom&eacute;trico: " + error_code);
    });
    */
    createFingerprintCapture(transport, "FingerprintCapture").then(function (captureComponentValue) {
        captureComponent = captureComponentValue;
        statusElement.innerText = "Creating setComponent...";
        return createFingerprintSet(transport, "FingerprintSet")
    }).then(function (setComponentValue) {
        setComponent = setComponentValue;
        registerCallbacks();
        statusElement.innerText = "Loading autocapture config...";
        return loadConfig();
    }).then(function () {
        statusElement.innerText = "Opening Device...";
        return captureComponent.openDevice(deviceName);
    }).then(function () {
        statusElement.innerText = "Starting preview...";
        //$("#imagenCaptura").hide();
    	startPreview();
    	$("#imagenHuellas").show()
//    	ocultarMensaje();
    }).catch(function (error) {
        console.log(error);
        mostrarError("Error en el dispositivo biom&eacute;trico:  " + error);
//      showMessage("Failed to opened device");
		  $("#divButtonsDedo").html('<a type="button" class="btn btn-success" onclick="avanzaTemporal();" >Siguiente</a>');
    });
}



/************************ FIRMA ***********************************************************/        
        var imgWidth;
	var imgHeight;
	function StartSign()
	 {   
	    var isInstalled = document.documentElement.getAttribute('SigPlusExtLiteExtension-installed');  
	    if (!isInstalled) {
	        mostrarAviso("SigPlusExtLite no está instalado o se encuentra deshabilitado.");
			return;
	    }	
	    var canvasObj = document.getElementById('cnv');
		canvasObj.getContext('2d').clearRect(0, 0, canvasObj.width, canvasObj.height);
		//document.FORM1.sigStringData.value = "SigString: ";
		//document.FORM1.sigRawData.value = "Base64 String: ";
		imgWidth = canvasObj.width;
		imgHeight = canvasObj.height;
		var message = { "firstName": "", "lastName": "", "eMail": "", "location": "", "imageFormat": 1, "imageX": imgWidth, "imageY": imgHeight, "imageTransparency": false, "imageScaling": false, "maxUpScalePercent": 0.0, "rawDataFormat": "ENC", "minSigPoints": 25 };
			
		top.document.addEventListener('SignResponse', SignResponse, false);
		var messageData = JSON.stringify(message);
		var element = document.createElement("MyExtensionDataElement");
		element.setAttribute("messageAttribute", messageData);
		document.documentElement.appendChild(element);
		var evt = document.createEvent("Events");
		evt.initEvent("SignStartEvent", true, false);				
		element.dispatchEvent(evt);		
    }
	function SignResponse(event)
	{	
		var str = event.target.getAttribute("msgAttribute");
		var obj = JSON.parse(str);
		SetValues(obj, imgWidth, imgHeight);
	}
	function SetValues(objResponse, imageWidth, imageHeight)
	{
        var obj = null;
		if(typeof(objResponse) === 'string'){
			obj = JSON.parse(objResponse);
		} else{
			obj = JSON.parse(JSON.stringify(objResponse));
		}		
		
	    var ctx = document.getElementById('cnv').getContext('2d');

			if (obj.errorMsg != null && obj.errorMsg!="" && obj.errorMsg!="undefined")
			{
                mostrarError(obj.errorMsg);
            }
            else
			{
                if (obj.isSigned)
		{
                    $("#base64").val(obj.imageData);
                    var idPersona = $("#idPersona").val();
                    var img = new Image();
                    img.onload = function () 
                    {
			ctx.drawImage(img, 0, 0, imageWidth, imageHeight);
                    }
                    img.src = "data:image/png;base64," + obj.imageData;
                    
                    var fs = require('fs');
                    var data = img.replace(/^data:image\/\w+;base64,/, "");
                    var buf = new Buffer(data, 'base64');
                    fs.writeFile('images/firma/Firma_' + idPersona + '.png', buf);
                }
            }
    }

	function uploadFiles(event)
	{
		
		 var canvas = document.getElementById('cnv');
		 var dataURL = canvas.toDataURL();
		 			
		event.stopPropagation(); // Stop stuff happening
	    event.preventDefault(); // Totally stop stuff happening
	    
	    $.ajax({
	        url: 'capturarFirma.php?files',
	        type: 'POST',
	        data:  {      		imgBase64: dataURL}
	        ,
	        dataType: 'json',	      
	        success: function(dat)
	        {
	        	for(i=0; i<dat.length;i++){
	        		data = dat[i];
	        	if(!data.error)
	            {	            	
	            	$("#divFileDownload").show();	            	
	            	$("#lblFileName").html(data.fileName);
	            	switch(data.tipo){
	            	case 'acta':            				            	
		            	mostrarAviso("Se subi&oacute; el archivo correctamente.");		            	 
	            		break;
	            	default:
	            		mostrarAviso("Error al subi&oacute; el archivo.");
	            		break;	            		
	            	}            		                
	            }
	            else
	            {
	            	switch(data.tipo){
	            	case 'acta':
	            		
		            	 mostrarAviso("Error. "+data.mensajeError);
	            		break;
	            	default:
	            		mostrarAviso("Error. "+data.mensajeError);          			            		
	            	}
	            }	        
	        }
	        },
	        error: function()
	        {
	           
	        },
	        complete: function()
	        {
	        	
	        }
	    });    	    
		
	}
function sig(){    	    
    cargar('documentos.php,accordion-7,acc-7');	
}
  
function siguiente_huellas(){  
  cargar('iris,accordion-4,acc-4');
}  
function siguiente_iris(){
  cargar('foto,accordion-5,acc-5');
} 
function siguiente_foto(){  
  cargar('firma,accordion-6,acc-6');
} 
var inicializarControles=function()
{ 
	mostrarEspera('Captura de huella d&aacute;ctilares');
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
		mostrarRecuadrosBio(idtVigente);

	
	
  $('.licencias_menu').removeClass('page-arrow');
  $('.licencias_menu').removeClass('active-page');
  $('#licencias_paso_3').addClass('page-arrow');
  $('#licencias_paso_3').addClass('active-page');	 
	$("#btnFirmar").click(function(){
		StartSign();
	});
	
	$('.btnSubir').on('click', uploadFiles);
	
	$("#btnSig").click(sig);
};
$(document).ready(function(){inicializarControles()});