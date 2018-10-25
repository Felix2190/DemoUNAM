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

mostrarAviso('Proceso de captura de biom&eacute;tricos...');
$("#widBio").show();
$("#divCapturaH").show();
$("#divCapturaI").show();
$("#divCapturaR").show();
//$("#hdnIdTurno").val(idT);

var infoTurno='<div class="inner-padding"><p><strong>ID Turno: &ensp;</strong><label class="text-muted">'+idT+'</label></p>'+
'<p><strong>Nombre: &ensp;</strong><label class="text-muted">'+nombre+'</label></p>'+
'<p><strong>CURP: &ensp;</strong><label class="text-muted">'+CURP+'</label></p></div>';

//$("#datosPersona").html(infoTurno);


$("#divCapturaH").html('		<div class="col-sm-6"> 	'+infoTurno+' <div class="inner-padding"> 	 	<div class="spacer-50"></div><div class="col-sm-12 text-center" id="divBiomH" style="display: ;"> 					<img alt="" src="images/captura_0.png" class="img-responsive" height="300" /> 				</div> 			</div> 		</div> 		<span class="breakpoint-sm ext-raster-line-6"></span> 		<div class="col-sm-6" id="divContenidoH"> '+
	'<div class="spacer-50"></div> 			<div class="spacer-50"></div>'+
		'<div class=""> 		<div class="pull-right" id="divButtonsDedo"> 					<a type="button" class="btn btn-success" onclick="siguiente(\'h\');" id="btnIniciar">Iniciar</a> 				</div> 			</div></div> 	</div> </div>');

$("#divCapturaI").html('<div class="col-sm-6"> '+infoTurno+'	<div class="inner-padding">  	<div class="spacer-50"></div><div class="col-sm-12 text-center" id="divBiomI" style="display: ;"> 					<img alt="" src="images/capturaI_0.png" class="img-responsive" height="180" /> 				</div> 			</div> 		</div> 		<span class="breakpoint-sm ext-raster-line-6"></span> 		<div class="col-sm-6" id="divContenidoI"> 			<div class="spacer-50"></div> 			<div class="spacer-50"></div>'+
	'<div class=""> 				<div class="pull-right" id="divButtonsOjo"> 					<a type="button" class="btn btn-success" onclick="siguiente(\'i\');" id="btnIniciar">Iniciar</a> 				</div> 			</div></div> 	</div> </div></div>');

$("#divCapturaR").html('<div class="col-sm-6"> '+infoTurno+'<div class="inner-padding"> 	<div class="spacer-50"></div><div class="col-sm-12 text-center" id="divBiomR" style="display: ;"> 					<img alt="" src="images/capturaR_0.png" class="img-responsive" height="300" /> 				</div> 			</div> 		</div> 		<span class="breakpoint-sm ext-raster-line-6"></span> 		<div class="col-sm-6" id="divContenidoR"> '+
		'<div id="divExitosaRostro" class="alert alert-success" style="display: none;"><button type="button" class="close" data-dismiss="alert">×</button> <i class="fa fa-check-circle"></i>Captura exitosa!</div>'+
		'			<div class="spacer-50"></div> 			<div class="spacer-50"></div> '+
		'<div class=""> 				<div class="pull-right" id="divButtonsRostro"> 					<a type="button" class="btn btn-info" onclick="capturar(\'Rostro\')" >Capturar</a>				</div> 			</div></div> 	</div> </div>');


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
		}
	});
	
	var idtVigente=parseInt($("#hdnIdT").val());
	var nombre=$("#hdnPersona").val();
	var CURP=$("#hdnCURP").val();
  	//alert(idtVigente);
	if(idtVigente>0){
		verTurno(idtVigente, nombre, CURP);
	} else{
		
	
	$('#tablesorting-1').tablesorter({
  		theme          : "bootstrap", // this will 
  		widthFixed     : true,
  		headerTemplate : '{content} {icon}', // new in v2.7. Needed to add the bootstrap icon!
  		widgets        : [ "uitheme", "filter", "zebra" ],
      serverSideSorting : true,
  		widgetOptions  : {
  			zebra : ["even", "odd"],
  			filter_reset : ".reset",
  		}
  	}).tablesorterPager({
            serverSideSorting : true,
            ajaxUrl: 'getTurnosCapturaBio.php?page={page}&size={size}&{sortList:col}&{filterList:filter}',
            customAjaxUrl: function (table, url) {
                return url;
            },
            ajaxProcessing: function (ajax, table) {
            	$("#tablesorting-1").trigger("update");
            	$("#tablesorting-1").find('tbody').empty();
                if (ajax) {
                	$.each(ajax[1], function (i, item) {  
                    	var html = "<td>" + item.idTurno+ "</td>" +
                    	"<td>" + item.turnoExterno+ "</td>" +
                    	"<td colspan='2'>" + item.nombre+ "</td>" +
                    	"<td>" + item.fechaHora+ "</td>" +
                    	//"<td><a href='javascript:verTurno("+item.idTurno+",\""+item.nombre+"\");' class='btn btn-default' name='btnPreview'><i class='fa fa-folder-open'></i></a> </td>" ;
                    	"<td><a href='biometricos.php?id="+item.idTurno+"' class='btn btn-default' name='btnPreview'><i class='fa fa-folder-open'></i></a> </td>" ;
	                  "</td>";
                        $("<tr/>").html(html).appendTo(table);
                    });
                    return [ajax[0]];                                        
                }                
            },
            container: $(".pager"),
            cssGoto: $(".pagenum"),
            cssPageSize: $(".pagesize"),
            cssPageDisplay: $(".pagedisplay"),
            removeRows: false,
            output: '{startRow} - {endRow} | {totalRows} [ {originalTotal} ]',
            savePages: false,
            fixedHeight: true
        }); 
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
	
	$("#divBiomH").html('<img alt="" src="images/captura_'+ini+'.png" height="300" class="img-responsive"/>');
	mostrarAviso('Capturaci&oacute;n '+ini+' de 3...');
	$.each(arr, function(key, arrDedo) {
		if(key>=limiteI&&key<=limiteS){
			texto+='<tr class="columnatdD"><td>'+arrDedo[0]+'</td><td colspan="2">'+arrDedo[1]+'</td><input type="hidden" id="hdn'+key+'" value="'+arrDedo[0]+'"/>'+
			'<td><select id="slcOpc'+arrDedo[0]+'" class="form-control"><option value="disponibleH">Disponible</option><option value="nodisponible">No disponible</option><option value="dedovenda">Vendado</option></select></td></tr>';
			 }
		});
	$("#divContenidoH").html(creaTabla(texto,'Dedo'));
	}
	break;
	case 'i':
		texto+='<tr class="columnatdI"><td>OD</td><td colspan="2">Iris derecho</td><input type="hidden" id="hdn11" value="OD"/>'+
		'<td><select id="slcOpcOD" class="form-control"><option value="disponibleO">Disponible</option><option value="nodisponible">No disponible</option></select></td></tr>';
		texto+='<tr class="columnatdI"><td>OI</td><td colspan="2">Iris izquierdo</td><input type="hidden" id="hdn12" value="OI"/>'+
		'<td><select id="slcOpcOI" class="form-control"><option value="disponibleO">Disponible</option><option value="nodisponible">No disponible</option></select></td></tr>';
		
	$("#divContenidoI").html(creaTabla(texto,'Ojo'));

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
	'<a type="button" class="btn btn-warning" id="btnCancelar">Cancelar</a><a type="button" class="btn btn-info" onclick="capturar(\''+bio+'\')" >Capturar</a></div></div>';
}

function capturar(bio){
	mostrarEspera('Espere un momento...');
	switch(bio){
	case 'Dedo':
	setTimeout(function(){
	var imgD='';
	for(i=limiteI;i<=limiteS;i++){
		imgD+='<img alt="" src="images/'+$("#slcOpc"+arr[i][0]).val()+'.png" height="100" />&nbsp;';
		huellas[(i+1)]='/biometricos/huellas/'+$("#slcOpc"+arr[i][0]).val()+arr[i][0]+'.png';
	}
	$("#divBiomH").html(imgD);
	var t=$('.extratdD').length;
	if(t==0){
	$("#columnathDedo").append('<th>Captura</th>');
	
	$(".columnatdD").append('<td class="extratdD"><div class="btn btn-default btn-circle btn-success"><i class="fa fa-check "></i><input type="hidden" name="bol_user" value="true" /></div></td>');
	
	if(ini<3)
		$("#divButtonsDedo").append('<a type="button" class="btn btn-success" onclick="siguiente(\'h\')" >Siguiente</a>');
	else
		$("#divButtonsDedo").append('<a type="button" class="btn btn-success" onclick="terminar(\''+bio+'\')" >Guardar</a>');
	}
	ocultarMensaje();
	},2000);
	
	break;
	
	case 'Ojo':
	
	setTimeout(function(){
		var imgD='<img alt="" src="images/'+$("#slcOpcOD").val()+'.png" height="100" />&nbsp;'+
			'<img alt="" src="images/'+$("#slcOpcOI").val()+'.png" height="100"  />&nbsp;';
		huellas[11]='/biometricos/huellas/'+$("#slcOpcOD").val()+'OD.png';
		huellas[12]='/biometricos/huellas/'+$("#slcOpcOI").val()+'OI.png';
		$("#divBiomI").html(imgD);
		ocultarMensaje();
	},2000);
	
	var t=$('.extratdI').length;
	if(t==0){
	$("#columnathOjo").append('<th>Captura</th>');
	
	$(".columnatdI").append('<td class="extratdI"><div class="btn btn-default btn-circle btn-success"><i class="fa fa-check "></i><input type="hidden" name="bol_user" value="true" /></div></td>');

	$("#divButtonsOjo").append('<a type="button" class="btn btn-success" onclick="terminar(\''+bio+'\')" >Guardar</a>');
	}
	break;

	case 'Rostro':
		
		setTimeout(function(){
			var imgD='<img alt="" src="images/rostro.jpg" height="100" class="img-responsive"/>&nbsp;';
			huellas[13]='/biometricos/huellas/disponibleR.png';

			$("#divBiomR").html(imgD);
			ocultarMensaje();
		},2000);

		$("#divButtonsRostro").html('<a type="button" class="btn btn-info" onclick="capturar(\'Rostro\')" >Capturar</a> <a type="button" class="btn btn-success" onclick="terminar(\''+bio+'\')" >Guardar</a>');
		
		break;

	}
	
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