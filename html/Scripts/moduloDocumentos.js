var CurrentPath;
function Dynamsoft_OnReady() {
	document.getElementById("DW_TotalImage").value = 0;
	document.getElementById("DW_CurrentImage").value = 0;
	DWObject = Dynamsoft.WebTwainEnv.GetWebTwain('dwtcontrolContainer'); 
	if(DWObject){
		DWObject.Height = 600;
		DWObject.Width = 385;
		DWObject.IfAutoScroll = false;
		(function (obj) {
			var _view_cfg = {
				DWObject: obj,
				containerID: 'dwtViewerContainer',
				onRefreshUI: updateViews,
				onMouseClick: updateViews,
				onMouseRightClick: updateViews,
				onViewerItemsChanged: AddDragDrop,
				ifautoscroll: false, /*set aut scroll to false*/
				width: 182,
				height: 602
			}
			obj._IndependentViewer = new DynamsoftViewerInner.UI.ImageUIView(_view_cfg);
			obj._IndependentViewer.SetViewMode(1, 5);
		})(DWObject);
		DWObject.SetViewMode(-1, -1);
		DWObject.MouseShape = true;
		
		var CurrentPathName = unescape(location.pathname),PDFDLLDownloadURL;
		CurrentPath = CurrentPathName.substring(0, CurrentPathName.lastIndexOf("/") + 1);
		
		
		/*
		* Make sure the PDF Rasterizer add-on is already installed, please note that the file Pdf.zip is already part of the sample
		*/
		/*
		if(!Dynamsoft.Lib.env.bMac) {			
			PDFDLLDownloadURL = CurrentPath + '/Resources/addon/Pdf.zip';
			
			DWObject.Addon.PDF.Download(
				PDFDLLDownloadURL,
				function() 
				{
					//console.log('PDF dll is installed');
				},
				function(errorCode, errorString) {
					console.log(errorString);
				}
			);
		}
		*/
		for(var i=0;i<DWObject.SourceCount;i++){
			var srcnameItem = DWObject.GetSourceNameItems(i);
			var checkedOrNot = '<div class="ds-demo-div-src-hoverable"><input ';
			if(srcnameItem == DWObject.CurrentSourceName || srcnameItem == DWObject.DefaultSourceName){
				DWObject.selectedSourceIndex = i;
				checkedOrNot = '<div class="ds-demo-div-src-hoverable ds-demo-selected"><input checked="checked"';
			}
			$('#dialog-source').append(checkedOrNot + ' class="dwt-sourceitem-radio" type="radio" name="dwt-sourceitem" value="' + i.toString() + '" id="ds-source-radio-' + i.toString() + '" ><label for="ds-source-radio-' + i.toString() + '">' + srcnameItem + '</lable></div>');
		}
		DWObject.sourceDlg = $("#dialog-source").dialog({
			title: 'Selecciona el escaner',
			autoOpen: false,
			height: 220,
			width: 348,
			modal: true,
			resizable:false,
			buttons: [
				{
					text: "Escanear Documentos",
					click: function() {
						$( this ).dialog( "close" );
						AcquireImage_inner(DWObject.selectedSourceIndex);
					}
				}
			]
		});
		$('.dwt-sourceitem-radio').click(function(){
			$('.ds-demo-div-src-hoverable').removeClass("ds-demo-selected");
			DWObject.selectedSourceIndex = parseInt(this.id.toString().substr(16));
			$($('.ds-demo-div-src-hoverable')[parseInt(this.id.toString().substr(16))]).addClass("ds-demo-selected");
		});
	}
}
function updatePageInfo() {
	document.getElementById("DW_TotalImage").value = DWObject.HowManyImagesInBuffer;
	document.getElementById("DW_CurrentImage").value = DWObject.CurrentImageIndexInBuffer + 1;
}

function AddDragDrop() {
	$('.thumbContainer').sortable({
		helper: 'clone',
		opacity: 0.5,
		tolerance: 'pointer',
		placeholder: 'ChangeItToMatch',
		sort: function (event, ui) {
			if ($('.thumb')[0]) {
				$('.ChangeItToMatch')[0].style.height = $('.thumb')[0].style.height;
				$('.ChangeItToMatch')[0].style.width = $('.thumb')[0].style.width;
				$('.ChangeItToMatch')[0].style.margin = $('.thumb')[0].style.margin;
				$('.ChangeItToMatch')[0].style.float = $('.thumb')[0].style.float;
				$('.ChangeItToMatch')[0].style.backgroundColor = '#fbec88';
				$('.ChangeItToMatch')[0].style.display = 'block';
			}
		},
		stop: function (event, ui) {
			var iIndex = getCurrentIndex(ui.item, true);
			var endIndex = findEndIndex(iIndex);
			iIndex = parseInt(iIndex) - 1;
			$('.thumbContainer').sortable('cancel');
			if (iIndex != endIndex) {
				DWObject.MoveImage(iIndex, endIndex);
				DWObject._IndependentViewer.MoveImage(iIndex, endIndex);
				DWObject._IndependentViewer.go(endIndex, true);
				updateViews();
			}
		}
	});
	$('.thumbContainer').disableSelection();
	updatePageInfo();
}
function updateViews(){
	DWObject.CurrentImageIndexInBuffer = DWObject.GetSelectedImageIndex(0);
	updatePageInfo();
}
function findEndIndex(iIndex) {
	var n = $('.thumb').length;
	for (var i = 0; i < n; i++) {
		var temp;
		Dynamsoft.Lib.env.bFirefox
		?temp = $('.thumb')[i].lastChild.textContent
		:temp = $('.thumb')[i].lastChild.innerText
		if (temp == iIndex) {
			return i;
		}
	}
}

function getCurrentIndex(objCurrentThumb, isLI) {
	var iIndex;
	Dynamsoft.Lib.env.bFirefox
		?iIndex = objCurrentThumb[0].parentNode.lastChild.textContent
		:iIndex = objCurrentThumb[0].parentElement.lastChild.innerText;
	if (isLI) {
		Dynamsoft.Lib.env.bFirefox
		?iIndex = objCurrentThumb[0].lastChild.textContent
		:iIndex = objCurrentThumb[0].lastChild.innerText;
	}
	return iIndex;
}

function LoadImages() {
	if (DWObject) {
		DWObject.IfShowFileDialog = true;
        DWObject.Addon.PDF.SetResolution(300);
        DWObject.Addon.PDF.SetConvertMode(EnumDWT_ConverMode.CM_RENDERALL);
        DWObject.LoadImageEx("", 5, 
			function() 
			{
				console.log('success');				
			},
			function (errorCode, errorString) {
				alert(errorString);
			}
		);
	}
}

function AcquireImage() {
	if(DWObject.SourceCount == 1){
		AcquireImage_inner(0);
	}
	else {
		DWObject.sourceDlg.dialog( "open" );
	}
}

function AcquireImage_inner(index) {
	DWObject.IfDisableSourceAfterAcquire = true;
	if(DWObject.SelectSourceByIndex(index)){
		DWObject.OpenSource();      
		DWObject.AcquireImage();    
	}
}

function btnFirstImage_onclick(){
	DWObject._IndependentViewer.go(0);
	DWObject.SelectedImagesCount = 1;
	DWObject.SetSelectedImageIndex(0,0);
	updateViews();
}

function btnPreImage_onclick(){
	DWObject._IndependentViewer.previous();
	updateViews();
}
function btnNextImage_onclick(){
	DWObject._IndependentViewer.next();
	updateViews();
}
function btnLastImage_onclick(){
	DWObject._IndependentViewer.go(DWObject.HowManyImagesInBuffer - 1);
	DWObject.SetSelectedImageIndex(0,DWObject.HowManyImagesInBuffer - 1);
	updateViews();
}
function btnZoomIn_onclick(){
	var oldZoom = DWObject.Zoom;
	DWObject.IfFitWindow = false;
	DWObject.Zoom = oldZoom*1.1;
}
function btnZoomOut_onclick(){
	var oldZoom = DWObject.Zoom;
	DWObject.IfFitWindow = false;
	DWObject.Zoom = oldZoom*0.9;
}
var menuPos = { x: 0, y: 0 }, copiedIndexes = [];
(function(){
	$.contextMenu({
		selector: '.imgwrap',
		build: function ($trigger, e) {
			menuPos.x = e.pageX;
			menuPos.y = e.pageY;
			if (document.getElementsByClassName('D-CategorizeDIV-RunTime').length == 1) {
				$('.D-CategorizeDIV-RunTime').hide();
			}
			return {
				callback: function (key, options) {
					var m = "clicked: " + key;
					//console.log(m);
					switch (key) {
						case "selectAll": selectAllImages(); break;
						case "rotateleft": if (_editImage('rotateleft')) options.$menu.trigger("contextmenu:hide"); break;
						case "rotateright": if (_editImage('rotateright')) options.$menu.trigger("contextmenu:hide"); break;
						case "mirror": if (_editImage('mirror')) options.$menu.trigger("contextmenu:hide"); break;
						case "flip": if (_editImage('flip')) options.$menu.trigger("contextmenu:hide"); break;
						case "copy": if (_editImage('copy')) options.$menu.trigger("contextmenu:hide"); break;
						case "paste": if (_editImage('paste')) options.$menu.trigger("contextmenu:hide"); break;
						case "delete": if (_editImage('delete')) options.$menu.trigger("contextmenu:hide"); break;
						case "upload": if (_editImage('upload')) options.$menu.trigger("contextmenu:hide"); break;
						case "quit": options.$menu.trigger("contextmenu:hide"); break;
						default: break;
					}
				},
				items: {
					"selectAll": { name: "Seleccionar todo", icon: "add" },
					"sep1": "---------",
					"rotateleft": { name: "Girar Izq", icon: "rotateleft" },
					"rotateright": { name: "Girar Der", icon: "rotateright" },
					"mirror": { name: "Reflejo", icon: "mirror" },
					"flip": { name: "Voltear", icon: "flip" },
					"sep2": "---------",
					//"copy": { name: "Copiar", icon: "copy" },
					//"paste": { name: "Pegar", icon: "paste" },
					"delete": { name: "Borrar", icon: "delete" },
					"sep3": "---------",
					"upload": { name: "Subir", icon: "upload" },
					"sep4": "---------",
					"quit": { name: "Cancelar", icon: "quit" }
				}
			};
		}
	});
})();
function selectAllImages() {
	var _indexes = [];
	for (var i = 0; i < DWObject._IndependentViewer.count() ; i++) {
		_indexes.push(i);
	}
	_indexes.sort(function (a, b) { return a - b; })
	DWObject._IndependentViewer.selectedIndexes = _indexes;
	DWObject._IndependentViewer.highlight(_indexes);
}
function _editImage(typeOfOperation) {
	if (!checkIfImagesInBuffer()) {
		return;
	}
	var _selectedIndexes = DWObject._IndependentViewer.selectedIndexes;
	var _breakOutOfForLoop = false;
	for (var n = 0; n < _selectedIndexes.length; n++) {
		var m = _selectedIndexes[n];
		switch (typeOfOperation) {
			case "rotateleft": DWObject.RotateLeft(m); break;
			case "rotateright": DWObject.RotateRight(m); break;
			case "mirror": DWObject.Mirror(m); break;
			case "flip": DWObject.Flip(m); break;
			case "copy": copiedIndexes.push(m); break;
			case "paste": pasteInner(); _breakOutOfForLoop = true; break;
			case "upload": uploadInner(); _breakOutOfForLoop = true; break;
			case "delete": DWObject.RemoveAllSelectedImages(); _breakOutOfForLoop = true; break;
			default: break;
		}
		checkErrorString();
		if (_breakOutOfForLoop) break;
	}
}
function pasteInner() {
	copiedIndexes.sort(function (a, b) { return a - b });
	for (var n = 0; n < copiedIndexes.length; n++) {
		var m = copiedIndexes[n];
		DWObject.CopyToClipboard(m);
		DWObject.LoadDibFromClipboard();
	}
	copiedIndexes = [];
}
function OnHttpUploadSuccess() 
{
		console.log('successful');
		cargarSinPestana('verImpresion.php,accordion-8,acc-8');
}

function OnHttpUploadFailure() {
		console.log('Error');
}

function OnHttpServerReturnedSomething(errorCode, errorString, sHttpResponse) {
	var textFromServer = sHttpResponse;
	if(textFromServer.indexOf('DS-DWT-Upload-Success') != -1)
	{
		var url = 'http://' + location.hostname + ':' + location.port + CurrentPath + 'UploadedImages/' + textFromServer.substr(22);
		document.getElementById('uploadedFile').innerHTML = "Uploaded File: <a href='" + url + "' target='_blank'>" + textFromServer.substr(22) + "</a>";
	}
}





var i = 0;
function asyncFailureFunc(errorCode, errorString) 
{
	alert("ErrorCode: " + errorCode + "\r" + "ErrorString:" + errorString);
}
function convertImage(_index) 
{
	DWObject.ConvertToBlob([_index], EnumDWT_ImageType.IT_JPG,
	function (result) 
	{
		DWObject.SetHTTPFormField('image_' + _index, result, 'JPG_image_' + _index);
		
		i++;
		if (i < DWObject.HowManyImagesInBuffer) {
		convertImage(i);
		}
		else 
		{
			
			DWObject.HTTPUpload('http://' + location.hostname + ':' + location.port + CurrentPath + "saveModuloDocumentos.php?filename=FileName", OnHttpUploadSuccess, OnHttpUploadFailure);
		}
	}, asyncFailureFunc);
};


var curp="";
function subirDocumentos()
{
	
	
	if (DWObject) 
	{
		DWObject.ClearAllHTTPFormField();
		DWObject.SetHTTPFormField('claves', claves);		
		
		
		
		DWObject.SetHTTPFormField('curp', curp);		
		
		DWObject.SetHTTPFormField("UploadedImagesCount", DWObject.HowManyImagesInBuffer);

		console.log("Subiendo documentos.");
		convertImage(0);
	}
}

function uploadInner()
{
	
	if(contarImagenes())
	{
		if(pedirAutorizacion)
		{
			PasswordConfirmacion(verificaPassword);
			
		}
		else
		{
			subirDocumentos();
		}
	}
	return;
}
function checkIfImagesInBuffer() {
	if (DWObject.HowManyImagesInBuffer == 0) {
		console.log("There is no image in buffer.");
		return false;
	}
	else
		return true;
}
function checkErrorString() {
	var iErrorCode = DWObject.ErrorCode,
		strErrorString = DWObject.ErrorString;
	return checkErrorStringInner(iErrorCode, strErrorString);
}
function checkErrorStringInner(iErrorCode, strErrorString) {
	if (iErrorCode == 0) {
		console.log(strErrorString + '<br />');
		return true;
	}
	if (iErrorCode == -2115) //Cancel file dialog
		return true;
	else {
		if (iErrorCode == -2003) {
			var ErrorMessageWin = window.open("", "ErrorMessage", "height=500,width=750,top=0,left=0,toolbar=no,menubar=no,scrollbars=no, resizable=no,location=no, status=no");
			ErrorMessageWin.document.writeln(DWObject.HTTPPostResponseString);
		}
		console.log("<span style='color:#cE5E04'><b>" + strErrorString + "</b></span><br />");
		return false;
	}
}