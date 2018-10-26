/************************ HUELLA ***********************************************************/

var ini = 0, limiteI=0, limiteS=3, numBio=0, numHuellasCapturadas=0, capt,nombre;
var arr, huellas={}, arrAutorizaciones={}, tempHuellas={},dedo={};


var mostrarRecuadrosBio=function(idT)
{

$("#divCapturaH").show();
$("#hdnIdTurno").val(idT);

var infoTurno='';
$("#divCapturaH").html('		<div class="col-sm-6" class="img-responsive"> 	'+infoTurno+'  	<div class="col-sm-12 text-center img-responsive"" id="divBiomH" style="display: ;"> 					<img alt="" src="images/captura_0.png" class="img-responsive" /> 				</div> 	<div class="col-sm-12 img-responsive" id="divIm"></div>				</div>  		<div class="col-sm-6" id="divContenidoH" class="img-responsive"> '+
	'<div class="spacer-20"></div>'+
		'<div class=""> 		<div class="pull-right" id="divButtonsDedo"> 				<!--	<a type="button" class="btn btn-success" onclick="siguiente(\'h\');" id="btnIniciar">Iniciar</a> -->				</div> 			</div></div> 	</div> </div>');

$('html,body').animate({
    scrollTop: $("#divBiomH").offset().top
}, 2000);

}

function imprimeImgs(){
	$("#divBiomH").html(
		    '<img id="previewImage" style="max-width:60%; max-height:50%"></div>'+
		    '<div id="imagenCaptura" style=" position:relative;"><img alt="" src="images/captura_'+dedo[ini]+'.png" />'+
		    '<div id="i_VDM" style="display: none; position:absolute; top:28%; left:2%; width: 7%; height: 7%;"> <img border="0"  src="images/venda_DM.png"  class="img-responsive"/> </div>'+
			'<div id="i_NDM" style="display:  none; position:absolute; top:28%; left:1%; width: 7%; height: 7%;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VDA" style="display:  none; position:absolute; top:11%; left:9%; width: 6%; height: 7%;"> <img border="0"  src="images/venda_DA.png"  class="img-responsive"/> </div>'+
			'<div id="i_NDA" style="display:  none; position:absolute; top:12%; left:8%; width: 7%; height: 7%;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VDE" style="display:  none; position:absolute; top:8%; left:15.4%; width: 6%; height: 6%;"> <img border="0"  src="images/venda_DE.png"  class="img-responsive"/> </div>'+
			'<div id="i_NDE" style="display:  none; position:absolute; top:8%; left:15.2%; width: 7%; height: 7%;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VDI" style="display:  none; position:absolute; top:11%; left:21.2%; width: 7%; height: 7%;"> <img border="0"  src="images/venda_DI.png"  class="img-responsive"/> </div>'+
			'<div id="i_NDI" style="display:  none; position:absolute; top:11%; left:22%; width: 7%; height: 7%;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VDP" style="display:  none; position:absolute; top:44%; left:27%; width: 7%; height: 7%;"> <img border="0"  src="images/venda_DP.png"  class="img-responsive"/> </div>'+
			'<div id="i_NDP" style="display:  none; position:absolute; top:44%; left:27%; width: 7%; height: 7%;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VIP" style="display:  none; position:absolute; top:44%; left:33%; width: 7%; height: 7%;"> <img border="0"  src="images/venda_IP.png"  class="img-responsive"/> </div>'+
			'<div id="i_NIP" style="display:  none; position:absolute; top:44%; left:33%; width: 7%; height: 7%;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VII" style="display:  none; position:absolute; top:11%; left:38.4%; width: 7%; height: 6%;"> <img border="0"  src="images/venda_II.png"  class="img-responsive"/> </div>'+
			'<div id="i_NII" style="display:  none; position:absolute; top:11%; left:38%; width: 7%; height: 7%;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VIE" style="display:  none; position:absolute; top:8%; left:43.5%; width: 7%; height: 7%;"> <img border="0"  src="images/venda_IE.png"  class="img-responsive"/> </div>'+
			'<div id="i_NIE" style="display:  none; position:absolute; top:8%; left:43.5%; width: 7%; height: 7%;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VIA" style="display:  none; position:absolute; top:12%; left:51%; width: 6%; height: 7%;"> <img border="0"  src="images/venda_IA.png"  class="img-responsive"/> </div>'+
			'<div id="i_NIA" style="display:  none; position:absolute; top:12%; left:51%; width: 7%; height: 7%;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div>'+
			'<div id="i_VIM" style="display:  none; position:absolute; top:27%; left:57.6%; width: 7%; height: 7%;"> <img border="0"  src="images/venda_IM.png"  class="img-responsive"/> </div>'+
			'<div id="i_NIM" style="display:  none; position:absolute; top:26%; left:58%; width: 7%; height: 7%;"> <img border="0"  src="images/nodisponible.png"  class="img-responsive"/> </div></div>');
		
}

function siguiente(bio) {
	var texto='';
	missingFingers = [];
	if(typeof(impressionsIndex)!='undefined')
		impressionsIndex++;
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
		imprimeImgs();
				
//	mostrarEspera('Capturaci&oacute;n '+ini+' de 3...');
//	alert(arr);
		/*
	$.each(arr, function(key, arrDedo) {
		if(key>=limiteI&&key<=limiteS){ 
			texto+='<tr class="columnatdD_'+key+'"><!--<td>'+arrDedo[0]+'</td>--><td colspan="2">'+arrDedo[1]+'</td><input type="hidden" id="hdn'+key+'" value="'+arrDedo[0]+'"/>'+
			'<td><select id="slcOpc'+arrDedo[0]+'" onchange="comboDedo(\''+arrDedo[0]+'\');" class="form-control"><option value="disponible">Disponible</option><option value="nodisponible">No disponible</option><option value="dedovenda">Vendado</option></select></td></tr>';
			 }
		});
	
	
	*/
		$("#divContenidoH").html(creaTabla('','Dedo'));
	}
	setTimeout(function(){
		ocultarMensaje();
	},1500);

	break;
	}
}

function creaTabla(contenido,bio){
	return '<div id="divExitosa'+bio+'" class="alert alert-success" style="display: none;"><button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-check-circle"></i>Captura exitosa!</div>'+
	'<div class="" id="divTabla">'+
	'</div><div class="spacer-30"></div><div class="spacer-20"></div><div class=""><div class="pull-right" id="divButtons'+bio+'">'+
	'<a id="btnCapturar" type="button" class="btn btn-info" onclick="capturar(\''+bio+'\')" >Capturar</a></div></div>';
}

function capturar(bio){
	//mostrarEspera('Espere un momento...');
	
	$("#btnCapturar").attr('disabled',true);
	
	if(typeof(websocket)=='undefined'||websocket==null){
	setTimeout(function(){
		ocultarMensaje();
		createWebsocket();
	},1500);
	}else{
		setTimeout(function(){
			ocultarMensaje();
	        //$("#imagenCaptura").hide();

//	    	$("#imagenHuellas").show()
//	    	$("#imagenHuellas").html('<img id="previewImage" style="max-width:50%; max-height:50%">');
	    	imgElement = document.getElementById("previewImage");
	 /*   	$.each(arr, function(key, arrDedo) {
	    		if(key>=limiteI&&key<=limiteS){
	    			$("#slcOpc"+arrDedo[0]).attr('disabled',true);
	    			 }
	    		});
	  */  	
			
	    	startPreview();
	    	
	    },1500);
	}
		
}

function terminar(bio){
	//mostrarEspera('Espere un momento...');
	$("#tab"+bio).css("background-color","inactivecaption");
	$("#divExitosa"+bio).show();
//	xajax_guardarHuellas($("#hdnIdTurno").val(), JSON.stringify(huellas),bio);
}

function next(){
	numBio++;
	 huellas.length = 0;
	 if(numBio==3)
		 xajax_siguienteTurno($("#hdnIdTurno").val());
}

function comboDedo(opc){
	
	if($("#slcOpc"+opc).val()=='dedovenda'||$("#slcOpc"+opc).val()=='nodisponible'){
		PasswordConfirmacion(verificaPassword,opc);
	}else{
		$("#divIm").html('');
		$("#i_N"+opc).hide();
		$("#i_V"+opc).hide();

		$.ajax({
			method : "post",
			url : "adminFunciones.php",
			data : {
				idBiometrico: opc,
				agrega: false,
				userName: ''
			},
			success : function(data) {
				if(data==true){
					omitirDedo(arrKeysAware[opc],false);
					//mostrarAviso('Excepci&oacute;n eliminada correctamente');
					$("#divButtonsDedo").html('<a id="btnCapturar" type="button" class="btn btn-info" onclick="capturar(\'h\')" >Capturar</a>');
					setTimeout(function(){
						ocultarMensaje();
						},1500);
				}
			}
		});
	}
//	alert(opc+' '+$("#slcOpc"+opc).val());
}
function verificaPassword(usuario,password,confirmar,opc){
	if(confirmar==true){
		$.ajax({
			method : "post",
			url : "adminFunciones.php",
			data : {
				 user:usuario,
				 pass:password
			},
			success : function(data) {
				respuesta=JSON.parse(data);
				
				if(respuesta['acceso']==true){
					if(respuesta['tipoUsuario']==1){
						$("#divIm").html('');
						$("#i_N"+opc).hide();
						$("#i_V"+opc).hide();

						switch($("#slcOpc"+opc).val()){
						case 'dedovenda': $("#i_V"+opc).show(); break;
						case 'nodisponible': $("#i_N"+opc).show(); break;
						}
						
						// array de autorizaciones

						$.ajax({
							method : "post",
							url : "adminFunciones.php",
							data : {
								idBiometrico: opc,
								agrega: true,
								userName: usuario
							},
							success : function(data) {
								if(data==true){
									omitirDedo(arrKeysAware[opc],true);
									//mostrarAviso('Excepci&oacute;n agregada correctamente');
									setTimeout(function(){
										ocultarMensaje();
										checarTotalMissings();
										},1500);
								}
							}
						});
						
					}else{
						mostrarError('Usuario no autorizado');
						setTimeout(function(){
							ocultarMensaje();
							PasswordConfirmacion(verificaPassword,opc);
						},1500);
						}
					

				}else{
					mostrarError('Datos de usuario incorrectos ');
					setTimeout(function(){
						ocultarMensaje();
						PasswordConfirmacion(verificaPassword,opc);
					},1500);
					
				}
			}
		});
		
			
	}else{
		$("#slcOpc"+opc).val('disponible');
		console.log('cancelar');
	}
}

function empezarCiclo(){
	ini=0;
	limiteI=0;
	limiteS=3;
	//siguiente('h') ;
	impressionsToCapture = [
		];
	dedo={};
	onReset();
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
	console.log('num '+numHuellasCapturadas+'   ini '+ini);
	var b=false;
	
	if(capt==1){

		if(numHuellasCapturadas>2){
			numHuellasCapturadas=0;
			return false;
		}else finCaptura();
		
	}else
	
	switch(ini){
	case 1:
		if(numHuellasCapturadas>1){
			numHuellasCapturadas=0;
			return false;
		}else finCaptura();
		break;
	case 2:
		if(numHuellasCapturadas>3){
			numHuellasCapturadas=0;
			return false;
		}else finCaptura();
		break;
	}	
//	return false;
	
}

function finCaptura(){
	//mostrarEspera('Huellas guardadas correctamente...');
	setTimeout(function(){
	//	var t=$('.extratdD').length, iconCapt, iconStatus='';
//		if(t==0){
/*		$("#columnathDedo").append('<th class="extratdD">Captura</th>');
		
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
*/
		if(capt==1){
			sig();
		}else
		if(ini<2)
			$("#divButtonsDedo").html('<a type="button" class="btn btn-warning" id="btnCancelar" onclick="empezarCiclo();">Cancelar</a>'+
					'<a type="button" class="btn btn-success" onclick="siguiente(\'h\')" >Siguiente Paso</a>');
		else
			sig();
			//$("#divButtonsDedo").html('<a type="button" class="btn btn-warning" id="btnCancelar" onclick="empezarCiclo();">Cancelar</a>'+
			//		'<a type="button" class="btn btn-info" onclick="volverCapturar()" >Volver a capturar</a>');
					
//		}
		console.log('terminar');
		ocultarMensaje();
	},1500);

	
}

function volverCapturar(){
	imprimeImgs();
	var arrTmp= new Array();
/*	$(".extratdD").remove();
	for(i=limiteI;i<=limiteS;i++){
		arrTmp[i]=arr[i][0];
		$("#slcOpc"+arr[i][0]).attr('disabled',false);
		switch($("#slcOpc"+arr[i][0]).val()){
		case 'dedovenda': 
			$('#i_V'+arr[i][0]).show();
			break;
		case 'nodisponible': 
		$('#i_N'+arr[i][0]).show();
		break;
		}
	}
*/	$("#divButtonsDedo").html('<a type="button" class="btn btn-warning" id="btnCancelar" onclick="empezarCiclo();">Cancelar</a><a id="btnCapturar" type="button" class="btn btn-info" onclick="capturar(\'h\')" >Capturar</a>');
	$("#btnCapturar").attr('disabled',false);
	//xajax_eliminarHuellas(arrTmp);
}

function checarTotalMissings(){
/*	console.log('ini='+ini);
	if(parseInt(ini)<=2){
		if(missingFingers.length==4){
			$("#divButtonsDedo").html('<a type="button" class="btn btn-success" onclick="omitirHuellas()" >Siguiente Paso</a>');
		}
	}else{
		console.log('fingers'+missingFingers.length);
		if(missingFingers.length==2){
			$("#divButtonsDedo").html('<a type="button" class="btn btn-primary" onclick="omitirHuellas()" >Terminar</a>');
		}
	}*/
}

function omitirHuellas(){
	tempHuellas.length = 0;
	$.each(arr, function(key, arrDedo) {
		if(key>=limiteI&&key<=limiteS){
			tempHuellas[arrDedo[0]]=$('#slcOpc'+arrDedo[0]).val();
			 }
		});
	xajax_omiteTotalHuellas(tempHuellas,ini);
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
        statusElement.innerText= "Error al conectarse con el servidor BioComponentServer, por favor verifique si está en ejecución.";
        $("#divButtonsDedo").html('<a type="button" class="btn btn-success" onclick="createWebsocket()" >Conectar</a>');
//      return ;
    };
    websocket.onclose = function (event) {
        if (!hasError)
        	  mostrarError("Websocket cerrado. Actualizar la página para comenzar de nuevo.");
    };
    websocket.onopen = function (event) {
        connectToServer(websocket);
    	$("#divButtonsDedo").html('<a id="btnCapturar" type="button" class="btn btn-info" onclick="capturar(\'h\')" >Capturar</a>');
    };
}

// Creates and connects to FingerprintCaptureComponent on the BioComponent server
function connectToServer(websocket) {
	
    statusElement.innerText = "Conexión al componente de captura de huellas dactilares...";
    var transport = createWebsocketTransport(websocket);
    createFingerprintCapture(transport, "FingerprintCapture").then(function (captureComponentValue) {
        captureComponent = captureComponentValue;
        statusElement.innerText = "Creando Componente...";
        return createFingerprintSet(transport, "FingerprintSet")
    }).then(function (setComponentValue) {
        setComponent = setComponentValue;
        registerCallbacks();
        statusElement.innerText = "Leyendo configuración de autocaptura...";
        return loadConfig();
    }).then(function () {
        statusElement.innerText = "Apertura del dispositivo...";
        $("#autocaptureStatus").html("");
        return captureComponent.openDevice(deviceName);
    }).then(function () {
        statusElement.innerText = "Iniciando vista previa...";
        //$("#imagenCaptura").hide();
//    	startPreview();
  //  	$("#imagenHuellas").show()
//    	ocultarMensaje();
    }).catch(function (error) {
        console.log(error);
        mostrarError("Error en el dispositivo biom&eacute;trico:  " + error);
//      showMessage("Failed to opened device");
		  $("#divButtonsDedo").html('<a type="button" style="display:none" class="btn btn-success" onclick="avanzaTemporal();" >Siguiente</a>');
    });
}



function sig(){
	//onReset();
	if(typeof(websocket)!='undefined'){
		captureComponent.close();
		console.log('closed..............');
		websocket.onclose = function (event) {  	};
		ini = 0, limiteI=0, limiteS=3, numBio=0, numHuellasCapturadas=0, impressionsIndex = 0;;
		arr.length = 0; huellas.length = 0;
		arrAutorizaciones.length = 0;
	}
	mostrarEspera('Espere un momento...');
	 $("#txtNombre").val("");
	 $("#slcCapturar").val("1");
	
	 
	setTimeout(function(){
		$("#divCapturarHuellas").hide();
		$("#divCapturaH").hide();
		$("#txtNombre").attr('disabled',false);
		$("#slcCapturar").attr('disabled',false);
		$("#btnIniciar").attr('disabled',false);
		$("#btnReiniciar").attr('disabled',true);
		
		ocultarMensaje();
		mostrarAviso('Se capturaron las huellas d&aacute;ctilares correctamente');
	//	xajax_enrolarFingerPrint();
		//cargar('capturarIris.php,accordion-4,acc-4');
	},2000);
}

function inicializarControles()
{ 
	$("#btnIniciar").click(comenzar);
	$("#btnReiniciar").click(reiniciar);
	$("#btnOmitir").click(function(){
		mostrarAviso('No se capturaron las huellas d&aacute;ctilares');
		setTimeout(function(){
			ocultarMensaje();
			 $("#txtNombre").val("");
			 $("#slcCapturar").val("1");
			reiniciar();
		},2500);

		
		});
	//mostrarAviso('Captura de huella d&aacute;ctilares');
	/*
	
*/

};
$(document).ready(function(){inicializarControles()});


function comenzar(){
	nombre = $("#txtNombre").val();
	capt = $("#slcCapturar").val();
	dedo[0]='k';
	if(nombre!=""){
		
	
	
	
	$.ajax({
		method : "post",
		url : "adminFunciones.php",
		data : {
			getKeyHuellas : ''
		},
		success : function(data) {
			arr=JSON.parse(data);
			
			
			
		}
	});
	
 	var idtVigente=parseInt(1);
 	

		setTimeout(function(){
			//	ocultarMensaje();
				createWebsocket();	
				
				setTimeout(function(){
					$.each(arrKeysAware, function(key, impression) {
						setComponent.setFingerMissing(impression, true).then(function () {
							return captureComponent.setFingerMissing(impression, true)
						});
					});
					
					if(capt==1){
						impressionsToCapture.push(FingerprintCaptureApi.Impression.PLAIN_DUAL_THUMBS);
						omitirDedo(arrKeysAware['DP'],false);
						omitirDedo(arrKeysAware['IP'],false);
						dedo[1]='P';
					}else{
						impressionsToCapture.push(FingerprintCaptureApi.Impression.PLAIN_LEFT_FOUR_FINGERS);
						impressionsToCapture.push(FingerprintCaptureApi.Impression.PLAIN_RIGHT_FOUR_FINGERS);
						
						switch(parseInt(capt)){
						case 2:
							omitirDedo(arrKeysAware['II'],false);
							omitirDedo(arrKeysAware['DI'],false);
							dedo[1]='II';
							dedo[2]='DI';
							break;
						case 3:
							omitirDedo(arrKeysAware['IE'],false);
							omitirDedo(arrKeysAware['DE'],false);
							dedo[1]='IE';
							dedo[2]='DE';
							break;
						case 4:
							dedo[1]='IA';
							dedo[2]='DA';
							omitirDedo(arrKeysAware['IA'],false);
							omitirDedo(arrKeysAware['DA'],false);
							break;
						case 5:
							omitirDedo(arrKeysAware['IM'],false);
							omitirDedo(arrKeysAware['DM'],false);
							dedo[1]='IM';
							dedo[2]='DM';
							break;
						}
					}
						mostrarRecuadrosBio(idtVigente);
						siguiente('h') ;
				},1500);

			},500);

		
		$("#txtNombre").attr('disabled',true);
		$("#slcCapturar").attr('disabled',true);
		$("#btnIniciar").attr('disabled',true);
		$("#btnReiniciar").attr('disabled',false);
		
		
		$("#divCapturarHuellas").show();
		
	}else{
		mostrarError('Debe de ingresar el nombre de la persona');
	}
} 

function reiniciar(){
	$("#divCapturarHuellas").hide();
	$("#divCapturaH").hide();
	$("#txtNombre").attr('disabled',false);
	$("#slcCapturar").attr('disabled',false);
	$("#btnIniciar").attr('disabled',false);
	$("#btnReiniciar").attr('disabled',true);
	
	empezarCiclo();
} 
