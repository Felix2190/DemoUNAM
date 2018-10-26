var deviceName = "GB_DACTY84C,CROSSMATCH_GUARDIAN,IB_WATSONMINI,EXTERNAL";
var impressionsToCapture = [
];
var impressionsIndex = -1;
var qualityScores = new Map();
var collectedImages = new Map();
var imgElement = document.getElementById("previewImage");
var statusElement = document.getElementById("status");
var resetElement = document.getElementById("reset");

var captureComponent;
var setComponent;

var missingFingers = [];
var multiImpressionMapping =
{
    1:32,
    2:15,
    3:16,
    4:17,
    5:18,
    6:33,
    7:19,
    8:20,
    9:21,
    10:22
};
var impressionKeys={
	1:'DP',
	2:'DI',
	3:'DE',
	4:'DA',
	5:'DM',
	6:'IP',
	7:'II',
	8:'IE',
	9:'IA',
	10:'IM'
	};

var arrKeysAware={
		'II':FingerprintCaptureApi.Finger.LEFT_INDEX_FINGER,
		'IE':FingerprintCaptureApi.Finger.LEFT_MIDDLE_FINGER,
		'IA':FingerprintCaptureApi.Finger.LEFT_RING_FINGER,
		'IM':FingerprintCaptureApi.Finger.LEFT_LITTLE_FINGER,
		'DI':FingerprintCaptureApi.Finger.RIGHT_INDEX_FINGER,
		'DE':FingerprintCaptureApi.Finger.RIGHT_MIDDLE_FINGER,
		'DA':FingerprintCaptureApi.Finger.RIGHT_RING_FINGER,
		'DM':FingerprintCaptureApi.Finger.RIGHT_LITTLE_FINGER,
		'DP':FingerprintCaptureApi.Finger.RIGHT_THUMB,
		'IP':FingerprintCaptureApi.Finger.LEFT_THUMB
	};


var arrImpressions=[
		FingerprintSetApi.Impression.LEFT_SLAP_INDEX_FINGER,
		FingerprintSetApi.Impression.LEFT_SLAP_MIDDLE_FINGER,
    		FingerprintSetApi.Impression.LEFT_SLAP_RING_FINGER,
    		FingerprintSetApi.Impression.LEFT_SLAP_LITTLE_FINGER,
    		FingerprintSetApi.Impression.RIGHT_SLAP_INDEX_FINGER,
    		FingerprintSetApi.Impression.RIGHT_SLAP_MIDDLE_FINGER,
    		FingerprintSetApi.Impression.RIGHT_SLAP_RING_FINGER,
    		FingerprintSetApi.Impression.RIGHT_SLAP_LITTLE_FINGER,
    		FingerprintSetApi.Impression.PLAIN_DUAL_THUMBS_RIGHT,
    		FingerprintSetApi.Impression.PLAIN_DUAL_THUMBS_LEFT
];

function resetearVariables(){
	 impressionsIndex = -1;
	 qualityScores = new Map();
	collectedImages = new Map();
	 imgElement = document.getElementById("previewImage");
	 statusElement = document.getElementById("status");
	 resetElement = document.getElementById("reset");
}

// Handler for receiving the preview image
function onPreviewImage(base64Image) {
	console.log('onpreviewimagen ');
	
    imgElement.src = "data:image/jpg;base64," + base64Image;
    captureComponent.requestNextPreviewImage();
}

// Handler for receiving autocapture status
function onAutocaptureStatus(status) {
//console.log('onAutocaptureStatus');
    // Finger out this message for now
    if (status === FingerprintCaptureApi.AutocaptureStatus.SOFTWAREAUTOCAPTURECONFIG_HANDEDNESS_NOT_RECOMMENDED) {
        return;
    }

    if (status === FingerprintCaptureApi.AutocaptureStatus.SOFTWAREAUTOCAPTURE_CAPTURE_INITIATED) {
      //  markMissingElement.disabled = true;
    }
    autocaptureStatus.innerText = FingerprintCaptureApi.AutocaptureStatus[status];
}


// Handler for receiving the final captured image
function onCapturedImage(base64Image) {
	console.log('onCapturedImage');
	  //  markMissingElement.disabled = true;
	    statusElement.innerText = "Captura final.";
	    imgElement.src = "data:image/jpg;base64," + base64Image;
	    console.log('onCapturedImage1');
	    var impression = impressionsToCapture[impressionsIndex];
	    console.log('onCapturedImage2');
	    collectedImages[impression] = base64Image;
	    console.log('onCapturedImage3   '+impression);
//	    console.log('>>> '+FingerprintCaptureApi.Impression.PLAIN_DUAL_THUMBS);
		
		if(impression == FingerprintCaptureApi.Impression.PLAIN_DUAL_THUMBS)
		{
//			sig();
		}
		
	    setComponent.setFingerprintCaptureImage(impression, captureComponent).then(function () 
		{
		console.log('>>> >>> entra');
        if (impression === FingerprintCaptureApi.Impression.PLAIN_LEFT_FOUR_FINGERS)
        {console.log('>>> >>> > izq');
            getSegments();
        }
        else if (impression === FingerprintCaptureApi.Impression.PLAIN_RIGHT_FOUR_FINGERS)
        {console.log('>>> >>> > der');
            getSegments();
        }
        else if (impression === FingerprintCaptureApi.Impression.PLAIN_DUAL_THUMBS)
        {console.log('>>> >>> > pulgares');
            getSegments();
        }



  //      impressionsIndex++;
//        startPreview();
    });
}

function getSegments (){
	console.log('get ssegments');
    var positions = getPositions();
    var fingerCapturados=[];
//    console.log('-- for ---- '+positiona);
    for (i = 0; i < positions.length; i++) {
        var impression = positions[i];
   //     console.log('----> '+impression);
        var key=impressionKeys[impression];
        if (missingFingers.indexOf(impression) === -1)
        { 
        	//console.log(i+' ----> 	'+impression+'----- > '+key);
            // Translate single finger code to finger in slap code
            impression = multiImpressionMapping[impression];
            fingerCapturados.push(impression);
/*            setComponent.getSegmentedImage(impression,
                FingerprintSetApi.ImageFormat.BMP).then( function(imageData,key){
//                appendImage(imageData);
                	xajax_guardarHuella(key,$("#slcOpc"+key).val(),imageData);
            }); */
        }else{
 //       	xajax_guardarHuella(key,$("#slcOpc"+key).val(),'');
        }
    }
    imprimeHuella(fingerCapturados);
}

function imprimeHuella(fingerCapturados){
	$.each(fingerCapturados, function(key, impression) {
		console.log('imprime huella----> '+impression);
		if (impression === FingerprintSetApi.Impression.RIGHT_SLAP_INDEX_FINGER)
        setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_INDEX_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                	console.log('RIGHT IN '+nombre);
                xajax_guardarHuella('DI',$("#slcOpcDI").val(),imageData,nombre);
            });
		if (impression === FingerprintSetApi.Impression.RIGHT_SLAP_MIDDLE_FINGER)
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_MIDDLE_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                	console.log('RIGHT MIDD');
                xajax_guardarHuella('DE',$("#slcOpcDE").val(),imageData,nombre);
            });
		if (impression === FingerprintSetApi.Impression.RIGHT_SLAP_RING_FINGER)
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_RING_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                	console.log('RIGHT RING');
                xajax_guardarHuella('DA',$("#slcOpcDA").val(),imageData,nombre);
            });
		if (impression === FingerprintSetApi.Impression.RIGHT_SLAP_LITTLE_FINGER)
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_LITTLE_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                	console.log('RIGHT LIT');
                xajax_guardarHuella('DM',$("#slcOpcDM").val(),imageData,nombre);
            });
   
		if (impression === FingerprintSetApi.Impression.LEFT_SLAP_INDEX_FINGER)
		 setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_INDEX_FINGER,
	                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
	                	console.log('LEFT IN '+nombre);
	                xajax_guardarHuella('II',$("#slcOpcII").val(),imageData,nombre);
	            });
		if (impression === FingerprintSetApi.Impression.LEFT_SLAP_MIDDLE_FINGER)
	            setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_MIDDLE_FINGER,
	                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
	                	console.log('LEFT MI');
	                xajax_guardarHuella('IE',$("#slcOpcIE").val(),imageData,nombre);
	            });
		if (impression === FingerprintSetApi.Impression.LEFT_SLAP_RING_FINGER)
	            setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_RING_FINGER,
	            FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
	            	console.log('LEFT RING');
	                xajax_guardarHuella('IA',$("#slcOpcIA").val(),imageData,nombre);
	            });
		if (impression === FingerprintSetApi.Impression.LEFT_SLAP_LITTLE_FINGER)
	            setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_LITTLE_FINGER,
	                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
	               xajax_guardarHuella('IM',$("#slcOpcIM").val(),imageData,nombre);
	            });
		if (impression === FingerprintSetApi.Impression.PLAIN_DUAL_THUMBS_RIGHT)
		    setComponent.getSegmentedImage(FingerprintSetApi.Impression.PLAIN_DUAL_THUMBS_RIGHT,
	                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
	                xajax_guardarHuella('DP',$("#slcOpcDP").val(),imageData,nombre);
	            });
		if (impression === FingerprintSetApi.Impression.PLAIN_DUAL_THUMBS_LEFT)
		    setComponent.getSegmentedImage(FingerprintSetApi.Impression.PLAIN_DUAL_THUMBS_LEFT,
	                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
	                xajax_guardarHuella('IP',$("#slcOpcIP").val(),imageData,nombre);
	            });
	        
	});
}

function onCapturedImage2(base64Image) {
		console.log('onCapturedImage');
  //  markMissingElement.disabled = true;
    statusElement.innerText = "Received final image.";
    imgElement.src = "data:image/jpg;base64," + base64Image;
    console.log('onCapturedImage1');
    var impression = impressionsToCapture[impressionsIndex];
    console.log('onCapturedImage2');
    collectedImages[impression] = base64Image;
    console.log('onCapturedImage3');
    setComponent.setFingerprintCaptureImage(impression, captureComponent).then(function () {
    	console.log('onCapturedImage4');
        if (impression === FingerprintCaptureApi.Impression.PLAIN_LEFT_FOUR_FINGERS)
        {
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_INDEX_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                	console.log('LEFT IN');
                appendImage(imageData);
                xajax_guardarHuella('II',$("#slcOpcII").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_MIDDLE_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                	console.log('LEFT MI');
                appendImage(imageData);
                xajax_guardarHuella('IE',$("#slcOpcIE").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_RING_FINGER,
            FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
            	console.log('LEFT RING');
                appendImage(imageData);
                xajax_guardarHuella('IA',$("#slcOpcIA").val(),imageData);
            });
/*            setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_LITTLE_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
 ///               appendImage(imageData);
                xajax_guardarHuella('IM',$("#slcOpcIM").val(),'');
            });
  */      }
        else if (impression === FingerprintCaptureApi.Impression.PLAIN_RIGHT_FOUR_FINGERS)
        {
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_INDEX_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                	console.log('RIGHT IN');
                appendImage(imageData);
                xajax_guardarHuella('DI',$("#slcOpcDI").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_MIDDLE_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                	console.log('RIGHT MIDD');
                appendImage(imageData);
                xajax_guardarHuella('DE',$("#slcOpcDE").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_RING_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                	console.log('RIGHT RING');
                appendImage(imageData);
                xajax_guardarHuella('DA',$("#slcOpcDA").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_LITTLE_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                	console.log('RIGHT LIT');
                appendImage(imageData);
                xajax_guardarHuella('DM',$("#slcOpcDM").val(),imageData);
            });
        }
        else if (impression === FingerprintCaptureApi.Impression.PLAIN_DUAL_THUMBS)
        {
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.PLAIN_DUAL_THUMBS_RIGHT,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                appendImage(imageData);
                xajax_guardarHuella('DP',$("#slcOpcDP").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.PLAIN_DUAL_THUMBS_LEFT,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                appendImage(imageData);
                xajax_guardarHuella('IP',$("#slcOpcIP").val(),imageData);
            });
        }

//        impressionsIndex++;
//        startPreview();
    });
}


function onPreviewQualityScore (impressionString, afiqScore) {
	//	console.log('onPreviewQualityScore');
    var impression = parseInt(impressionString, 10);
    qualityScores.set(impression, afiqScore);
    var positions = getPositions();
    var sortedScores = [];
    for (i = 0; i < positions.length; i++) {
        var score = qualityScores.get(positions[i]);
        if (score === undefined)
            score = 0;
        sortedScores.push(score);
    }
    previewScoreElement.innerText = sortedScores.join(" ");
}

/**
 * Returns the finger positions that contained in the current impression
 * @returns {*}
 */
function getPositions(){
	console.log('getPositions  '+impressionsIndex+'       ');
    var impression = impressionsToCapture[impressionsIndex];
    console.log('getPositions  '+impressionsIndex+'       '+impression);
    if (impression === FingerprintCaptureApi.Impression.PLAIN_RIGHT_FOUR_FINGERS){
    	console.log('mano der');
       return [
           FingerprintCaptureApi.Finger.RIGHT_INDEX_FINGER,
           FingerprintCaptureApi.Finger.RIGHT_MIDDLE_FINGER,
           FingerprintCaptureApi.Finger.RIGHT_RING_FINGER,
           FingerprintCaptureApi.Finger.RIGHT_LITTLE_FINGER
       ];
    }
    else if (impression === FingerprintCaptureApi.Impression.PLAIN_LEFT_FOUR_FINGERS){
    	console.log('mano izq ');
        return [        
            FingerprintCaptureApi.Finger.LEFT_LITTLE_FINGER,
            FingerprintCaptureApi.Finger.LEFT_RING_FINGER,
            FingerprintCaptureApi.Finger.LEFT_MIDDLE_FINGER,
            FingerprintCaptureApi.Finger.LEFT_INDEX_FINGER
        ];
    }
    else if (impression === FingerprintCaptureApi.Impression.PLAIN_DUAL_THUMBS){
    	console.log('plugares');
        return [
            FingerprintCaptureApi.Finger.LEFT_THUMB,
            FingerprintCaptureApi.Finger.RIGHT_THUMB
        ];
    }
    else {
        return [impression];
    }
}

function registerCallbacks() {
	//	console.log('registerCallbacks');
    captureComponent.setPreviewImageUpdated(onPreviewImage);
//    captureComponent.setPreviewQualityScoreUpdated(onPreviewQualityScore);
    captureComponent.setAutocaptureStatusUpdated(onAutocaptureStatus);
    captureComponent.setCapturedImageUpdated(onCapturedImage);
}

function startPreview() {
    qualityScores.clear();
   // previewScoreElement.innerText ="";
    if (impressionsIndex < impressionsToCapture.length) {
        var impression = impressionsToCapture[impressionsIndex];
  //      promptElement.innerText = FingerprintCaptureApi.Impression[impression];
        captureComponent.startAutoCapture(impression, FingerprintCaptureApi.ImageFormat.JPG).then(function () {
            statusElement.innerText = "Vista previa de la imagen ...";
  //          EnableMarkMissing(true);
        }).catch(function (error_code) {
            statusElement.innerText = "Ha ocurrido un error: " + error_code;
        });
    } else {
    //    promptElement.innerText = "";
        statusElement.innerText = "Fin de captura";
    }
}


function onReset() {
    statusElement.innerText = "Resetting...";
//    EnableMarkMissing(false);
    captureComponent.endAutoCapture().then(function () {
        setComponent.reset().then(function () {
            return captureComponent.resetMissingFingers();
        }).then(function () {
        	resetearVariables();
//	            startPreview();
        });
    });
}

function loadConfig() {
	console.log('loadConfig');
    return new Promise(function (resolve, reject) {
        var xhr = new XMLHttpRequest();
        xhr.addEventListener("load", function () {
            captureComponent.setAutoCaptureConfiguration(this.responseText)
                .then(function () {
                    resolve()
                });
        });
        xhr.open("GET", "js/lib/aware/autocapture_configuration.xml");
        xhr.send();
    });
}


var missingSet = new Map();
var CaptureStatus = {
        NOT_CAPTURED: "NOT_CAPTURED",
        CAPTURED: "CAPTURED",
        UNABLE_TO_PRINT: "UNABLE_TO_PRINT",
        AMPUTATED: "AMPUTATED",
        SKIPPED: "SKIPPED"
    };

var omitirDedo = function (impression, status) {
	if(status)
		missingFingers.push(impression);
	else{
		var pos=missingFingers.indexOf(impression);
		if(pos>-1)
			missingFingers.splice(pos,1);
	}
		console.log('total missing '+ missingFingers.length);
	
    setComponent.setFingerMissing(impression, status).then(function () {
        return captureComponent.setFingerMissing(impression, status)
    }).then(function () {
        //statusElement.innerText = "Marked as missing.";
        	//impressionsIndex++;
        //startPreview();
    });

};

