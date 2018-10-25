/* Copyright (C) 2017 Aware, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 *
 * Allows Javascript running in a browser to present to the user a dialog box to save a binary data to a file
 *
 * For a much more comprehensive solution, see https://github.com/eligrey/FileSaver.js/
 */

'use strict';

var BinaryFileSaver = (function () {

    /**
     * Decodes the base64 data and cause the browser to put a window to save the data to a file
     * @param {string} base64 String of base64 data
     * @param {string} filename Default name to save the file as
     *
     * Example: BinaryFileSaver.saveBase64(base64DataInString, "image.png");
     */
    var saveBase64 = function (base64, filename) {
        //var sampleBytes = base64ToArrayBuffer(self.captureSet[self.impressionToCapture].image);
        var binaryArray = base64ToArrayBuffer(base64);
        saveByteArray(binaryArray, filename);

        // Example code for using FileSaver.js
        //var blob = new Blob([binaryArray], {type: "octet/stream"});
        //saveAs(blob, filename);
    };

    // Converts a base64 string to Uint8Array typed array
    var base64ToArrayBuffer = function (base64) {
        var binaryString = window.atob(base64.replace(/\s/g, ''));
        var binaryLen = binaryString.length;
        console.log("Size:" + binaryLen);
        var bytes = new Uint8Array(binaryLen);
        for (var i = 0; i < binaryLen; i++) {
            var ascii = binaryString.charCodeAt(i);
            bytes[i] = ascii;
        }
        return bytes;
    };

    var saveByteArray = (function () {
        var useSaveBlob = typeof navigator !== "undefined" && navigator.msSaveOrOpenBlob;
        if (useSaveBlob) {
            // Code for IE
            return function (data, name) {
                var blob = new Blob([data], {type: "octet/stream"});
                navigator.msSaveOrOpenBlob(blob, name);
            };
        }
        else {
            // Code for other browsers

            // Adds a hidden link to the document. It then returns a function that
            // can be called to set the data to the link and dispatches a click
            // on the link to start a download
            var a = document.createElement("a");
            document.body.appendChild(a);
            a.style.display = "none";

            return function (data, name) {
                var blob = new Blob([data], {type: "octet/stream"});
                var url = window.URL.createObjectURL(blob);
                a.href = url;
                a.download = name;
                a.click();
                // Frees the URL and its data
                window.URL.revokeObjectURL(url);
            };
        }
    }());

    return {
        saveBase64: saveBase64,
        saveByteArray: saveByteArray,
        base64ToArrayBuffer: base64ToArrayBuffer
    };

})();