var deviceName = "GB_DACTY84C,CROSSMATCH_GUARDIAN,IB_WATSONMINI,EXTERNAL";
var impressionsToCapture = [
    FingerprintCaptureApi.Impression.PLAIN_RIGHT_FOUR_FINGERS,
    FingerprintCaptureApi.Impression.PLAIN_LEFT_FOUR_FINGERS,
    FingerprintCaptureApi.Impression.PLAIN_DUAL_THUMBS
];
var impressionsIndex = 0;
var qualityScores = new Map();
var collectedImages = new Map();
var imgElement = document.getElementById("previewImage");
var statusElement = document.getElementById("status");
//var promptElement = document.getElementById("prompt");
//var markMissingElement = document.getElementById("markMissing");
var resetElement = document.getElementById("reset");
//var previewScoreElement = document.getElementById("previewScore");

var captureComponent;
var setComponent;

function resetearVariables(){
	 impressionsIndex = 0;
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

function appendImage(imageData)
{
	//	console.log('appendImage');
/*    document.body.appendChild(document.createElement("br"));
    var img = document.createElement("img");
    img.src = "data:image/jpg;base64," + imageData;
    document.body.appendChild(img);*/
}

// Handler for receiving the final captured image
function onCapturedImage(base64Image) {
	//	console.log('onCapturedImage');
  //  markMissingElement.disabled = true;
    statusElement.innerText = "Received final image.";
    imgElement.src = "data:image/jpg;base64," + base64Image;
    var impression = impressionsToCapture[impressionsIndex];
    collectedImages[impression] = base64Image;
    setComponent.setFingerprintCaptureImage(impression, captureComponent).then(function () {

        if (impression === FingerprintCaptureApi.Impression.PLAIN_LEFT_FOUR_FINGERS)
        {
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_INDEX_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                appendImage(imageData);
                xajax_guardarHuella('II',$("#slcOpcII").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_MIDDLE_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                appendImage(imageData);
                xajax_guardarHuella('IE',$("#slcOpcIE").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_RING_FINGER,
            FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                appendImage(imageData);
                xajax_guardarHuella('IA',$("#slcOpcIA").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.LEFT_SLAP_LITTLE_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                appendImage(imageData);
                xajax_guardarHuella('IM',$("#slcOpcIM").val(),imageData);
            });
        }
        else if (impression === FingerprintCaptureApi.Impression.PLAIN_RIGHT_FOUR_FINGERS)
        {
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_INDEX_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                appendImage(imageData);
                xajax_guardarHuella('DI',$("#slcOpcDI").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_MIDDLE_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                appendImage(imageData);
                xajax_guardarHuella('DE',$("#slcOpcDE").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_RING_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
                appendImage(imageData);
                xajax_guardarHuella('DA',$("#slcOpcDA").val(),imageData);
            });
            setComponent.getSegmentedImage(FingerprintSetApi.Impression.RIGHT_SLAP_LITTLE_FINGER,
                FingerprintSetApi.ImageFormat.PNG).then( function(imageData){
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
	//	console.log('getPositions');
    var impression = impressionsToCapture[impressionsIndex];
    if (impression === FingerprintCaptureApi.Impression.PLAIN_RIGHT_FOUR_FINGERS){
       return [
           FingerprintCaptureApi.Finger.RIGHT_INDEX_FINGER,
           FingerprintCaptureApi.Finger.RIGHT_MIDDLE_FINGER,
           FingerprintCaptureApi.Finger.RIGHT_RING_FINGER,
           FingerprintCaptureApi.Finger.RIGHT_LITTLE_FINGER
       ];
    }
    else if (impression === FingerprintCaptureApi.Impression.PLAIN_LEFT_FOUR_FINGERS){
        return [        
            FingerprintCaptureApi.Finger.LEFT_LITTLE_FINGER,
            FingerprintCaptureApi.Finger.LEFT_RING_FINGER,
            FingerprintCaptureApi.Finger.LEFT_MIDDLE_FINGER,
            FingerprintCaptureApi.Finger.LEFT_INDEX_FINGER
        ];
    }
    else if (impression === FingerprintCaptureApi.Impression.PLAIN_DUAL_THUMBS){
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
            statusElement.innerText = "Previewing image...";
            EnableMarkMissing(true);
        }).catch(function (error_code) {
            statusElement.innerText = "An error occurred: " + error_code;
        });
    } else {
    //    promptElement.innerText = "";
        statusElement.innerText = "Done Capturing.";
    }
}

function onMarkMissing() {
	//	console.log('onMarkMissing');
    EnableMarkMissing(false);
    captureComponent.endAutoCapture().then(function () {
        var impression = impressionsToCapture[impressionsIndex];
        setComponent.setFingerMissing(impression, true).then(function () {
            return captureComponent.setFingerMissing(impression, true)
        }).then(function () {
            statusElement.innerText = "Marked as missing.";
            impressionsIndex++;
            startPreview();
        });
    });
}

// Only enable for single fingers
function EnableMarkMissing(enable) {
	//	console.log('EnableMarkMissing');
    var impression = impressionsToCapture[impressionsIndex];
    if (impression > FingerprintCaptureApi.Finger.LEFT_LITTLE_FINGER){
  //      markMissingElement.disabled = true;
    } else {
//       markMissingElement.disabled = !enable;
    }
}

function onReset() {
    statusElement.innerText = "Resetting...";
    EnableMarkMissing(false);
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
