/* Copyright (C) 2017 Aware, Inc All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */
 
/** @namespace
  */
var FingerprintCaptureApi =
{
    /** Current state of the device.
     *  @enum {number} */
    DeviceState : 
    (function()
    {
        var values = {};
        /** Device has not been opened. */
        values[values.NOT_OPENED = 0] = "CERRADO";

        /** Device is opened and operational, but not performing any action. */
        values[values.IDLE = 1] = "ESPERANDO";

        /** Device is scanning and collecting data. */
        values[values.SCANNING = 2] = "ESCANEANDO";

        /** Device is capturing the final image. */
        values[values.CAPTURING = 3] = "CAPTURANDO";

        return values;
    })(),

    /** Image format
     *  @enum {number} */
    ImageFormat : 
    (function()
    {
        var values = {};
        /** RAW format */
        values[values.RAW = 1] = "RAW";

        /** BMP format */
        values[values.BMP = 2] = "BMP";

        /** WSQ format */
        values[values.WSQ = 3] = "WSQ";

        /** JPEG format */
        values[values.JPG = 4] = "JPG";

        /** PNG format */
        values[values.PNG = 5] = "PNG";

        return values;
    })(),

    /** Autocapture status
     *  @enum {number} */
    AutocaptureStatus : 
    (function()
    {
        var values = {};
        /** Device Initialization Started */
        values[values.SCANNER_INITIALIZATION_STARTED = 10101] = "ESCANER INICIADO";

        /** Warning During Device Initialization */
        values[values.SCANNER_INITIALIZATION_WARNING_OCCURRED = 10102] = "ERROR AL INICIAR EL ESCANER";

        /** Device Initialization Failed */
        values[values.SCANNER_INITIALIZATION_FAILED = 10103] = "INICIALIZACION DEL ESCANER FALLIDA";

        /** Device Initialization Complete */
        values[values.SCANNER_INITIALIZATION_COMPLETED = 10104] = "INICIALIZACION COMPLETADA";

        /** Device Close Started */
        values[values.SCANNER_CLOSE_STARTED = 10201] = "CERRADO DEL ESCANER INICIADO";

        /** Warning During Device Close */
        values[values.SCANNER_CLOSE_WARNING_OCCURRED = 10202] = "ALERTA CON CERRADO DEL ESCANER";

        /** Device Close Failed */
        values[values.SCANNER_CLOSE_FAILED = 10203] = "CERRADO DEL ESCANER FALLIDO";

        /** Device Closed */
        values[values.SCANNER_CLOSE_COMPLETED = 10204] = "CERRADO DEL ESCANER COMPLETADO";

        /** Calibration Not Supported */
        values[values.SCANNER_CALIBRATION_NOT_SUPPORTED = 10301] = "CALIBRACION DEL ESCANER NO SOPORTADA";

        /** Calibrating Device */
        values[values.SCANNER_CALIBRATION_STARTED = 10302] = "CALIBRACION DEL ESCANER INICIADA";

        /** Error Calibrating Device */
        values[values.SCANNER_CALIBRATION_FAILED = 10303] = "CALIBRACION DEL ESCANER FALLIDA";

        /** Calibration Complete */
        values[values.SCANNER_CALIBRATION_COMPLETED = 10304] = "CALIBRACION DEL ESCANER COMPLETADA";

        /** Device Calibration Message */
        values[values.SCANNER_CALIBRATION_MESSAGE = 10310] = "MENSAJE DE LA CALIBRACION DEL ESCANER";

        /** Resetting Device */
        values[values.SCANNER_RESET_STARTED = 10401] = "RESET DEL ESCANER INICIADO";

        /** Warning During Device Reset */
        values[values.SCANNER_RESET_WARNING_OCCURRED = 10402] = "ALERTA CON EL RESET DEL ESCANER";

        /** Device Reset Failed */
        values[values.SCANNER_RESET_FAILED = 10403] = "RESET DEL ESCANER FALLIDO";

        /** Device Successfully Reset */
        values[values.SCANNER_RESET_COMPLETED = 10404] = "RESET DEL ESCANER COMPLETADO";

        /** Scanner Is Dirty Or Fingers On Scanner  */
        values[values.SCANNER_DIRTY = 10504] = "ESCANER SUCIO";

        /** Scanner is disconnected or not responding */
        values[values.SCANNER_DISCONNECTED = 10505] = "ESCANER DESCONECTADO";

        /** Preview Started */
        values[values.CAPTURE_PREVIEW_STARTED = 20101] = "CAPTURA DE VISTA PREVIA INICIADA";

        /** Capture Aborted */
        values[values.CAPTURE_ABORTED = 20102] = "CAPTURA CANCELADA";

        /** Capture Complete */
        values[values.CAPTURE_COMPLETED = 20103] = "CAPTURA COMPLETA";

        /** Use of handedness detection is not recommended when fingers are
         *  missing */
        values[values.SOFTWAREAUTOCAPTURECONFIG_HANDEDNESS_NOT_RECOMMENDED = 30001] = "NO RECOMENDADA";

        /** Auto-capture Session Started */
        values[values.SOFTWAREAUTOCAPTURE_STARTED = 30101] = "INICIADA";

        /** Auto-capture Initiated */
        values[values.SOFTWAREAUTOCAPTURE_CAPTURE_INITIATED = 30102] = "EN CURSO";

        /** Too Few Fingers */
        values[values.SOFTWAREAUTOCAPTURE_TOO_FEW_FINGERS = 30201] = "FALTAN DEDOS";

        /** Too Many Fingers */
        values[values.SOFTWAREAUTOCAPTURE_TOO_MANY_FINGERS = 30202] = "SOBRAN DEDOS";

        /** No Fingers */
        values[values.SOFTWAREAUTOCAPTURE_NO_FINGERS = 30203] = "NO HAY DEDOS";

        /** Incorrect Hand */
        values[values.SOFTWAREAUTOCAPTURE_INCORRECT_HAND = 30301] = "MANO INCORRECTA";

        /** Insufficient Finger Quality */
        values[values.SOFTWAREAUTOCAPTURE_INSUFFICIENT_FINGER_QUALITY = 30401] = "CALIDAD DE CAPTURA MUY BAJA";

        /** Finger Angle is Too Large */
        values[values.SOFTWAREAUTOCAPTURE_FINGER_ANGLE_TOO_LARGE = 30402] = "ANGULOS DEMASIADO LARGO";

        /** Finger Touching Image Edge */
        values[values.SOFTWAREAUTOCAPTURE_FINGER_TOUCHING_EDGE = 30501] = "EL DEDO ESTA TOCANDO EL BORDE";

        /** Finger Too Tall */
        values[values.SOFTWAREAUTOCAPTURE_FINGER_TOO_TALL = 30601] = "DEDO DEMASIADO ALTO";

        /** Finger Too Short */
        values[values.SOFTWAREAUTOCAPTURE_FINGER_TOO_SHORT = 30602] = "DEDO DEMASIADO CORTO";

        /** Finger Too Wide */
        values[values.SOFTWAREAUTOCAPTURE_FINGER_TOO_WIDE = 30603] = "DEDO DEMASIADO ANCHO";

        /** Finger Too Narrow */
        values[values.SOFTWAREAUTOCAPTURE_FINGER_TOO_NARROW = 30604] = "DEDO DEMASIADO ANGOSTO";

        /** Finger Movement Detected */
        values[values.SOFTWAREAUTOCAPTURE_FINGER_MOVEMENT_DETECTED = 30701] = "DETECCION DE MOVIMIENTO DE DEDOS";

        /** Passing Frames Collected */
        values[values.SOFTWAREAUTOCAPTURE_PASSING_FRAME_COLLECTED = 30801] = "ESTRUCTURA DE PASO CAPTURADA";

        /** Timeout Exceeded, Capturing */
        values[values.SOFTWAREAUTOCAPTURE_TIMEOUT_EXCEEDED_CAPTURING = 30901] = "TIEMPO DE CAPTURA EXCEDIDO";

        /** Timeout Exceeded, Aborting */
        values[values.SOFTWAREAUTOCAPTURE_TIMEOUT_EXCEEDED_ABORTED = 30902] = "TIEMPO DE ESPERA EXCEDIDO, ABORTANDO";

        return values;
    })(),

    /** How rolls should be captured.
     *  @enum {number} */
    RollCaptureMode : 
    (function()
    {
        var values = {};
        /** Edge to Edge. */
        values[values.EDGE_TO_EDGE = 0] = "BORDE A BORDE";

        /** Center and roll. */
        values[values.CENTER_AND_ROLL = 1] = "CENTRE Y RUEDE";

        return values;
    })(),

    /** How flats should be captured.
     *  @enum {number} */
    FlatCaptureMode : 
    (function()
    {
        var values = {};
        /** Fingers are angled to fit within a 2 inch platen. */
        values[values.TWO_INCH_FLATS = 0] = "PLANO DE DOS PULGADAS";

        /** Finger are straight to fit within a 3 inch platen. */
        values[values.THREE_INCH_FLATS = 1] = "PLANO DE TRES PULGADAS";

        return values;
    })(),

    /** Finger.
     *  @enum {number} */
    Finger : 
    (function()
    {
        var values = {};
        /** right thumb. */
        values[values.RIGHT_THUMB = 1] = "PULGAR DERECHO";

        /** right index finger. */
        values[values.RIGHT_INDEX_FINGER = 2] = "INDICE DERECHO";

        /** right middle finger. */
        values[values.RIGHT_MIDDLE_FINGER = 3] = "MEDIO DERECHO";

        /** right ring finger. */
        values[values.RIGHT_RING_FINGER = 4] = "ANULAR DERECHO";

        /** right little finger. */
        values[values.RIGHT_LITTLE_FINGER = 5] = "MENIQUE DERECHO";

        /** left thumb. */
        values[values.LEFT_THUMB = 6] = "PULGAR IZQUIERDO";

        /** left index finger. */
        values[values.LEFT_INDEX_FINGER = 7] = "INDICE IZQUIERDO";

        /** left middle finger. */
        values[values.LEFT_MIDDLE_FINGER = 8] = "MEDIO IZQUIERDO";

        /** left ring finger. */
        values[values.LEFT_RING_FINGER = 9] = "ANULAR IZQUIERDO";

        /** left little finger. */
        values[values.LEFT_LITTLE_FINGER = 10] = "MENIQUE IZQUIERDO";

        return values;
    })(),

    /** Impression.
     *  @enum {number} */
    Impression : 
    (function()
    {
        var values = {};
        /** Rolled right thumb. */
        values[values.ROLLED_RIGHT_THUMB = 1] = "RUEDE PULGAR DERECHO";

        /** Rolled right index finger. */
        values[values.ROLLED_RIGHT_INDEX_FINGER = 2] = "RUEDE INDICE DERECHO";

        /** Rolled right middle finger. */
        values[values.ROLLED_RIGHT_MIDDLE_FINGER = 3] = "RUEDE MEDIO DERECHO";

        /** Rolled right ring finger. */
        values[values.ROLLED_RIGHT_RING_FINGER = 4] = "RUEDE ANULAR DERECHO";

        /** Rolled right little finger. */
        values[values.ROLLED_RIGHT_LITTLE_FINGER = 5] = "RUEDE MENIQUE DERECHO";

        /** Rolled left thumb. */
        values[values.ROLLED_LEFT_THUMB = 6] = "RUEDE PULGAR IZQUIERDO";

        /** Rolled left index finger. */
        values[values.ROLLED_LEFT_INDEX_FINGER = 7] = "RUEDE INDICE IZQUIERDO";

        /** Rolled left middle finger. */
        values[values.ROLLED_LEFT_MIDDLE_FINGER = 8] = "RUEDE MEDIO IZQUIERDO";

        /** Rolled left ring finger. */
        values[values.ROLLED_LEFT_RING_FINGER = 9] = "RUEDE ANULAR IZQUIERDO";

        /** Rolled left little finger. */
        values[values.ROLLED_LEFT_LITTLE_FINGER = 10] = "RUEDE MENIQUE IZQUIERDO";

        /** Plain right thumb. */
        values[values.PLAIN_RIGHT_THUMB = 11] = "PULGAR DERECHO PLANO";

        /** Plain left thumb. */
        values[values.PLAIN_LEFT_THUMB = 12] = "PULGAR IZQUIERDO PLANO";

        /** Four fingered slap of the right hand. */
        values[values.PLAIN_RIGHT_FOUR_FINGERS = 13] = "CUATRO DEDOS DERECHOS";

        /** Four fingered slap of the left hand. */
        values[values.PLAIN_LEFT_FOUR_FINGERS = 14] = "CUATRO DEDOS IZQUIERDOS";

        /** Plain right index finger found within a plain right four finger
         *  slap */
        values[values.RIGHT_SLAP_INDEX_FINGER = 15] = "PEGAR INDICE DERECHO";

        /** Plain right middle finger found within a plain right four finger
         *  slap. */
        values[values.RIGHT_SLAP_MIDDLE_FINGER = 16] = "PEGAR MEDIO DERECHO";

        /** Plain right ring finger found within a plain right four finger
         *  slap. */
        values[values.RIGHT_SLAP_RING_FINGER = 17] = "PEGAR ANULAR DERECHO";

        /** Plain right little finger found within a plain right four finger
         *  slap. */
        values[values.RIGHT_SLAP_LITTLE_FINGER = 18] = "PEGAR MENIQUE DERECHO";

        /** Plain left index finger found within a plain left four finger
         *  slap. */
        values[values.LEFT_SLAP_INDEX_FINGER = 19] = "PEGAR INDICE IZQUIERDO";

        /** Plain left middle finger found within a plain left four finger
         *  slap. */
        values[values.LEFT_SLAP_MIDDLE_FINGER = 20] = "PEGAR MEDIO IZQUIERDO";

        /** Plain left ring finger found within a plain left four finger
         *  slap. */
        values[values.LEFT_SLAP_RING_FINGER = 21] = "PEGAR ANULAR IZQUIERDO";

        /** Plain left little finger found within a plain left four finger
         *  slap. */
        values[values.LEFT_SLAP_LITTLE_FINGER = 22] = "PEGAR MENIQUE IZQUIERDO";

        /** Plain dual (right and left) thumbs */
        values[values.PLAIN_DUAL_THUMBS = 31] = "COLOCAR AMBOS PULGARES";

        /** Plain right thumb from within a dual thumb impression */
        values[values.PLAIN_DUAL_THUMBS_RIGHT = 32] = "COLOCAR PULGAR DERECHO";

        /** Plain left thumb from within a dual thumb impression. */
        values[values.PLAIN_DUAL_THUMBS_LEFT = 33] = "COLOCAR PULGAR IZQUIERDO";

        /** Plain right index finger. */
        values[values.PLAIN_RIGHT_INDEX_FINGER = 80] = "COLOCAR INIDICE DERECHO";

        /** Plain right middle finger. */
        values[values.PLAIN_RIGHT_MIDDLE_FINGER = 81] = "COLOCAR MEDIO DERECHO";

        /** Plain right ring finger. */
        values[values.PLAIN_RIGHT_RING_FINGER = 82] = "COLOCAR ANULAR DERECHO";

        /** Plain right little finger. */
        values[values.PLAIN_RIGHT_LITTLE_FINGER = 83] = "COLOCAR MENIQUE DERECHO";

        /** Plain left index finger. */
        values[values.PLAIN_LEFT_INDEX_FINGER = 84] = "COLOCAR INDICE IZQUIERDO";

        /** Plain left middle finger. */
        values[values.PLAIN_LEFT_MIDDLE_FINGER = 85] = "COLOCAR MEDIO IZQUIERDO";

        /** Plain left ring finger. */
        values[values.PLAIN_LEFT_RING_FINGER = 86] = "COLOCAR ANULAR IZQUIERDO";

        /** Plain left little finger. */
        values[values.PLAIN_LEFT_LITTLE_FINGER = 87] = "COLOCAR MENIQUE IZQUIERDO";

        return values;
    })(),

    /** Properties used to control advanced features of devices.
     *  @enum {number} */
    DeviceProperty : 
    (function()
    {
        var values = {};
        /** X position to display a preview window for certain devices. */
        values[values.PREVIEW_WINDOW_POS_X = 1] = "VISTA PREVIA EJE X";

        /** Y position to display a preview window for certain devices. */
        values[values.PREVIEW_WINDOW_POS_Y = 2] = "VISTA PREVIA EJE Y";

        /** Width of the preview window to display. */
        values[values.PREVIEW_WINDOW_WIDTH = 3] = "ANCHURA VISTA PREVIA";

        /** Height of the preview window to display. */
        values[values.PREVIEW_WINDOW_HEIGHT = 4] = "ALTURA VISTA PREVIA";

        /** Enable liveness detection. */
        values[values.LIVENESS_DETECTION_ENABLE = 5] = "DETECCION DE TIEMPO REAL HABILITADA";

        /** Roll capture mode. */
        values[values.ROLL_CAPTURE_MODE = 6] = "MODO DE CAPTURA CON ROTACION";

        /** id_flat_supported, read only property, 1=supported 0=not
         *  supported -1=unknown. */
        values[values.ID_FLAT_SUPPORTED = 7] = "ID FLAT SOPORTADO";

        /** type4_flat_supported, read only property, 1=supported 0=not
         *  supported -1=unknown. */
        values[values.TYPE4_FLAT_SUPPORTED = 8] = "TIPO FLAT 4 SOPORTADO";

        /** 1=id flat mode. 0=type4 flat mode. */
        values[values.FLAT_CAPTURE_MODE = 9] = "MODO DE CAPTURA PLANO";

        /** flat_liveness_detection_supported, read only property,
         *  1=supported 0=not supported -1=unknown. */
        values[values.FLAT_LIVENESS_DETECTION_SUPPORTED = 10] = "DETECCION DE TIEMPO REAL EN MODO PLANO SOPORTADO";

        /** rolled_liveness_detection_supported, read only property,
         *  1=supported 0=not supported -1=unknown. */
        values[values.ROLLED_LIVENESS_DETECTION_SUPPORTED = 11] = "DETERCCION DE TIEMPO REAL CON RODADO SOPORTADO";

        /** The liveness_cutoff property is a confidence level for liveness
         *  determination. It is used by the aw_ls_device_get_value() method
         *  with the AW_LS_DEVICE_VALUE_IS_SUBJECT_ALIVE enum, when
         *  determing whether a finger is live. A high value of
         *  liveness_cutoff will cause most spoof fingers to be detected but
         *  may also result in more valid (live) fingers being flagged as
         *  spoofs. A low value of liveness_cutoff will cause some spoof
         *  fingers to not be detected but should reduce the number of valid
         *  (live) fingers being incorrectly flagged as spoofs. Users may
         *  want to do their own testing when determining the best values to
         *  use for the liveness_cutoff.  The default value for this
         *  property is 0, liveness_cutoff, write only property, range is
         *  (0-100). */
        values[values.LIVENESS_CUTOFF = 12] = "CORTE EN TIEMPO REAL";

        /** Whether the scanner supports calibration or not, read only
         *  property, 1=supported 0=not supported -1=unknown. */
        values[values.CALIBRATE_SUPPORTED = 13] = "CALIBRACION SOPORTADA";

        /** Scanner standby mode, write only property, 1=set the device in
         *  standby mode on a close or reset command 0=do not set the device
         *  in standby mode on a close or reset command -1=unknown,
         *  default=1.  Currently only useful with CrossMatch devices. */
        values[values.STANDBY_MODE = 14] = "MODO DE REPOSO";

        /** beep_supported, read only property, 1=supported 0=not supported. */
        values[values.BEEP_SUPPORTED = 15] = "BEEP SOPORTADO";

        /** beeps_enable, 1=enabled, 0=disabled, default=disabled. */
        values[values.BEEPS_ENABLE = 16] = "BEEP HABILITADO";

        /** has_graphic_display, read only property, 1=true 0=false. */
        values[values.HAS_GRAPHIC_DISPLAY = 17] = "TIENE DISPLAY GRAFICO";

        /** roll_status_supported, read only property, 1=true 0=false. */
        values[values.ROLL_STATUS_SUPPORTED = 18] = "ESTATUS DE RODADO SOPORTADO";

        /** roll_status_enable, 1=true 0=false. */
        values[values.ROLL_STATUS_ENABLE = 19] = "ESTADO DEL RODADO HABILITADO";

        return values;
    })(),


    /** List of error codes.
     *  @enum {number} */
    ErrorCode : 
    (function()
    {
        var values = {};
        /** No errors or warnings. */
        values[values.NO_ERRORS = 0] = "SIN ERRORES";

        /** Internal error. */
        values[values.INTERNAL_ERROR = 1] = "ERROR INTERNO";

        /** Failed to connect to the server. */
        values[values.FAILED_TO_CONNECT_TO_SERVER = 4] = "FALLO AL CONECTAR AL SERVIDOR";

        /** The library failed to allocate memory. */
        values[values.OUT_OF_MEMORY = 100] = "SIN MEMORIA";

        /** The fingerprint_capture object was NULL. */
        values[values.NULL_FINGERPRINT_CAPTURE_OBJ = 101] = "OBJETO NULO AL CAPTURAR HUELLA";

        /** Invalid image format. */
        values[values.INVALID_IMAGE_FORMAT = 102] = "FORMATO DE IMAGEN INVALIDA";

        /** Invalid conversion failed. */
        values[values.IMAGE_CONVERSION_FAILED = 103] = "CONVERSION DE IMAGEN FALLIDA";

        /** Could not open the file. */
        values[values.COULD_NOT_OPEN_FILE = 104] = "NO SE PUEDE ABRIR EL ARCHIVO";

        /** A device error occurred. */
        values[values.DEVICE_ERROR = 105] = "ERROR DE DISPOSITIVO";

        /** The DLL required to run the device is not present. */
        values[values.DEVICE_DLL_NOT_PRESENT = 106] = "DLL DEL DISPOSITIVO NO ESTA PRESENTE";

        /** The device functionality has not been implemented. */
        values[values.DEVICE_FUNCTIONALITY_NOT_IMPLEMENTED = 107] = "FUNCIONALIDAD DEL DISPOSITIVO NO SOPORTADA";

        /** Failed to parse the configuration file. */
        values[values.FAILED_TO_PARSE_CONFIG_FILE = 108] = "FALLO LA CONVERSION DEL ARCHIVO DE CONFIGURACION";

        /** The configuration file has not been loaded. */
        values[values.CONFIG_FILE_NOT_LOADED = 109] = "ARCHIVO DE CONFIGURACION NO CARGADO";

        /** The configuration file contained an invalid value. */
        values[values.INVALID_CONFIG_VALUE = 110] = "ARCHIVO DE CONFIGURACION INVALIDO";

        /** The device has not been initialized. */
        values[values.DEVICE_NOT_INITIALIZED = 111] = "DISPOSITIVO NO INICIALIZADO";

        /** Invalid resolution. */
        values[values.INVALID_RESOLUTION = 112] = "RESOLUCION INVALIDA";

        /** The device is not connected to the computer. */
        values[values.DEVICE_NOT_CONNECTED = 113] = "DISPOSITIVO NO CONECTADO";

        /** The device is not supported. */
        values[values.DEVICE_NOT_SUPPORTED = 114] = "DISPOSITIVO NO SOPORTADO";

        /** The device must be plugged in at startup. */
        values[values.DEVICE_NOT_PRESENT_AT_STARTUP = 115] = "DISPOSITIVO NO PRESENTE EN EL ARRANQUE";

        /** The device must be calibrated before proceeding. */
        values[values.DEVICE_NOT_CALIBRATED = 116] = "DISPOSITIVO NO CALIBRADO";

        /** The device must be turned off, unplugged from the computer and
         *  reconnected. */
        values[values.DEVICE_MUST_BE_RECONNECTED = 117] = "DEBE RECONECTAR EL DISPOSITIVO";

        /** The device does not support this functionality. */
        values[values.DEVICE_CAPABILITY_NOT_SUPPORTED = 118] = "CAPACIDAD DEL DISPOSITIVO NO SOPORTADA";

        /** This impression type is not supported by         this device
         *  model. */
        values[values.IMPRESSION_TYPE_NOT_SUPPORTED = 119] = "TIPO DE IMPRESION NO SOPORTADA";

        /** This impression is not supported by this device model. */
        values[values.IMPRESSION_NOT_SUPPORTED = 120] = "IMPRESION NO SOPORTADA";

        /** This resolution is not supported by this device model. */
        values[values.DEVICE_RESOLUTION_NOT_SUPPORTED = 121] = "RESOLUCION DEL DISPOSITIVO NO SOPORTADA";

        /** This LED setting is not supported by this device model. */
        values[values.DEVICE_LED_SETTING_NOT_SUPPORTED = 122] = "CONFIGURACION DE LED NO SOPORTADO";

        /** Liveness detection is not enabled. */
        values[values.DEVICE_LIVENESS_DETECTION_NOT_ENABLED = 123] = "DETECCION DE TIEMPO REAL DESHABILITADO";

        /** The scanner is busy and cannot complete the operation. */
        values[values.DEVICE_BUSY = 124] = "DISPOSITIVO OCUPADO";

        /** The device is not licensed for hardware autocapture. */
        values[values.NO_HW_AUTOCAPTURE_LICENSE_FOUND = 125] = "NO HAY LICENCIA PARA AUTOCAPTURA";

        /** The function doesn't support the specified finger position. */
        values[values.INVALID_FINGER_POSITION = 126] = "POSICION DE LOS DEDOS INVALIDA";

        /** There is no captured image available. */
        values[values.NO_CAPTURED_IMAGE = 200] = "NO HAY IMAGEN CAPTURADA";

        /** Failed to parse the JSON request. */
        values[values.FAILED_TO_PARSE_JSON = 10001] = "FALLO AL PARSEAR JSON";

        /** The function name was not valid. */
        values[values.INVALID_FUNCTION_NAME = 10002] = "NOMBRE DE FUNCION INVALIDA";

        /** The parameter list must be a JSON array. */
        values[values.INVALID_PARAMETER_LIST = 10003] = "LISTA DE PARAMETROS INVALIDA";

        /** A parameter had an incorrect type. */
        values[values.INVALID_PARAMETER_TYPE = 10004] = "TIPO DE PARAMETRO INVALIDO";

        /** The wrong number of parameters were passed to the function. */
        values[values.INCORRECT_PARAMETER_COUNT = 10005] = "CONTEO DE PARAMETRO INCORRECTO";

        /** The channel name is incorrect, hasn't been opened, or is closed. */
        values[values.INVALID_CHANNEL_NAME = 10006] = "NOMBRE DE CANAL INVALIDO";

        return values;
    })(),


};

/** Creates an object that implements the FingerprintCapture API.
  *
  * @param websocketHandle Handle to an open websocket connection, connected
  *      to the aw_bio_component_server. The caller is responsible for handling
  *      the "onerror" callback, whereas this class will handle the "onmessage"
  *      callback.
  *
  * @return Object that implements the FingerprintCapture API.
  */
var createFingerprintCapture = (function( transportObject, channelName )
{
    var callbacks = {};
    var onReturnDictionary = {};
    var currentMessageId = 0;
    var transport = transportObject;
    var channel = channelName;

    var onMessage = function( result )
    {
        var functionName = result.function;
        var isCallback = false;
        if ( !isCallback &&  functionName == "aw_fingerprint_capture_device_state_updated" )
        {
            if ( typeof callbacks.deviceStateUpdated != "undefined" )
            {
                callbacks.deviceStateUpdated.apply( null, result.args );
            }
            isCallback = true;
        }
        if ( !isCallback &&  functionName == "aw_fingerprint_capture_preview_image_updated" )
        {
            if ( typeof callbacks.previewImageUpdated != "undefined" )
            {
                callbacks.previewImageUpdated.apply( null, result.args );
            }
            isCallback = true;
        }
        if ( !isCallback &&  functionName == "aw_fingerprint_capture_preview_quality_score_updated" )
        {
            if ( typeof callbacks.previewQualityScoreUpdated != "undefined" )
            {
                callbacks.previewQualityScoreUpdated.apply( null, result.args );
            }
            isCallback = true;
        }
        if ( !isCallback &&  functionName == "aw_fingerprint_capture_autocapture_status_updated" )
        {
            if ( typeof callbacks.autocaptureStatusUpdated != "undefined" )
            {
                callbacks.autocaptureStatusUpdated.apply( null, result.args );
            }
            isCallback = true;
        }
        if ( !isCallback &&  functionName == "aw_fingerprint_capture_captured_image_updated" )
        {
            if ( typeof callbacks.capturedImageUpdated != "undefined" )
            {
                callbacks.capturedImageUpdated.apply( null, result.args );
            }
            isCallback = true;
        }
        if ( !isCallback &&  functionName == "aw_fingerprint_capture_current_impression_updated" )
        {
            if ( typeof callbacks.currentImpressionUpdated != "undefined" )
            {
                callbacks.currentImpressionUpdated.apply( null, result.args );
            }
            isCallback = true;
        }

        if ( !isCallback )
        {
            var messageId = result.message_id;
            if( !messageId ) return;
            var onReturn = onReturnDictionary[messageId.toString()];
            delete onReturnDictionary[messageId.toString()];
            if ( typeof onReturn == "function" )
            {
                onReturn(
                    result.return_value,
                    result.error.code,
                    result.error.message );
            }
        }
    };

    // Register the channel name with transport so we will receive messages from the server
    transport.register(channel, onMessage);

    var internalStoreOnReturn = function( onReturn )
    {
        if ( currentMessageId >= Number.MAX_SAFE_INTEGER )
        {
            currentMessageId = 0;
        }
        else
        {
            currentMessageId += 1;
        }
        onReturnDictionary[currentMessageId.toString()] = onReturn;
    };


    /** This function destroys the FingerprintCapture object.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var destroy = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_destroy";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Opens a session with one of the specified devices.
     *  @param {String} deviceList Comma separated list that specifies one
     *  or more fingerprint scanners. Each scanner will be attempted until
     *  one succeeds or all fail.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var openDevice = function( deviceList )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_open_device";
            jsonNode.args = [ deviceList ];
            transport.send( jsonNode );
        } );
    };

    /** Closes the session with the current device.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var close = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_close";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Performs a device calibration.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var calibrate = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_calibrate";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Indicates whether the device needs to be calibrated. For devices
     *  that do not support calibration, true is always returned.
     *  
     *  @returns {Promise<Boolean,Error>} True if the device does not need
     *  to have calibration run.
     *   */
    var deviceIsCalibrated = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_device_is_calibrated";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Sets the configuration file that is used to control the auto capture
     *  parameters.
     *  @param {String} autoCaptureConfiguration Auto capture configuration
     *  XML.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var setAutoCaptureConfiguration = function( autoCaptureConfiguration )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_set_auto_capture_configuration";
            jsonNode.args = [ autoCaptureConfiguration ];
            transport.send( jsonNode );
        } );
    };

    /** Sets the capture resolution for the livescan device. Must be set
     *  after opening a livescan device.
     *  @param {Number} resolution Capture resolution.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var setCaptureResolution = function( resolution )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_set_capture_resolution";
            jsonNode.args = [ resolution ];
            transport.send( jsonNode );
        } );
    };

    /** Gets the current capture resolution for the livescan device.
     *  
     *  @returns {Promise<Number,Error>} Capture resolution.
     *   */
    var getCaptureResolution = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_get_capture_resolution";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Starts collection of a fingerprint impression.
     *  preview_image_updated, preview_quality_score_updated, and
     *  autocapture_status_updated callbacks will be called as new data is
     *  collected. Once the previewed image is of sufficient quality, it
     *  will be captured and the captured_image_updated callback will be
     *  called.
     *  @param {Number} impression Impression to capture.
     *  @param {Number} imageFormat Desired image format for the preview.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var startAutoCapture = function( impression, imageFormat )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_start_auto_capture";
            jsonNode.args = [ impression, imageFormat ];
            transport.send( jsonNode );
        } );
    };

    /** Disables autocapture.
     *  @param {Boolean} disable If true, autocapture is disabled.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var disableAutoCapture = function( disable )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_disable_auto_capture";
            jsonNode.args = [ disable ];
            transport.send( jsonNode );
        } );
    };

    /** Ends the current auto capture collection.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var endAutoCapture = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_end_auto_capture";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Tells the scanner to initiate a final image capture, regardless of
     *  current auto capture status.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var captureImage = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_capture_image";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Plays an audio cue that indicates capture was successful.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var playOnCaptureAudio = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_play_on_capture_audio";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Plays an audio cue that indicates a failure.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var playOnFailureAudio = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_play_on_failure_audio";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Sets the finger as present or missing.
     *  @param {Number} finger Finger to change.
     *  @param {Boolean} missing Whether the finger is missing.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var setFingerMissing = function( finger, missing )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_set_finger_missing";
            jsonNode.args = [ finger, missing ];
            transport.send( jsonNode );
        } );
    };

    /** Sets all fingers as present.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var resetMissingFingers = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_reset_missing_fingers";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** This function queries for a given property, and if that property
     *  exists, returns its value
     *              for a given livescan device.
     *  @param {Number} property Which property to get.
     *  
     *  @returns {Promise<Number,Error>} The value of the property.
     *   */
    var deviceGetProperty = function( property )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_device_get_property";
            jsonNode.args = [ property ];
            transport.send( jsonNode );
        } );
    };

    /** This function sets a given property for a given livescan device.
     *  @param {Number} property Which property to get.
     *  @param {Number} value The value of the property.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var deviceSetProperty = function( property, value )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_device_set_property";
            jsonNode.args = [ property, value ];
            transport.send( jsonNode );
        } );
    };

    /** Turns on audio feedback on for devices that support audio.
     *  @param {Boolean} enableAudio If true, beep at the start and end of
     *  capture.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var deviceEnableAudio = function( enableAudio )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_device_enable_audio";
            jsonNode.args = [ enableAudio ];
            transport.send( jsonNode );
        } );
    };

    /** Retrieves the captured image in the specified image format.
     *  @param {Number} imageFormat Image format.
     *  
     *  @returns {Promise<String,Error>} Captured image.
     *   */
    var getCapturedImage = function( imageFormat )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_get_captured_image";
            jsonNode.args = [ imageFormat ];
            transport.send( jsonNode );
        } );
    };

    /** Sets the device_state_updated.
     *  @param {String} deviceStateUpdated Callback to notify when the
     *  device state has changed.
     *   */
    var setDeviceStateUpdated = function( deviceStateUpdated )
    {
        callbacks.deviceStateUpdated = deviceStateUpdated;
    };

    /** Sets the preview_image_updated.
     *  @param {String} previewImageUpdated Callback with the updated
     *  preview image.
     *   */
    var setPreviewImageUpdated = function( previewImageUpdated )
    {
        callbacks.previewImageUpdated = previewImageUpdated;
    };

    /** Requests that the next preview image be sent through the callback,
     *  when it is available.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var requestNextPreviewImage = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_request_next_preview_image";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Sets the preview_quality_score_updated.
     *  @param {String} previewQualityScoreUpdated Callback with the updated
     *  preview quality score.
     *   */
    var setPreviewQualityScoreUpdated = function( previewQualityScoreUpdated )
    {
        callbacks.previewQualityScoreUpdated = previewQualityScoreUpdated;
    };

    /** Sets the autocapture_status_updated.
     *  @param {String} autocaptureStatusUpdated Callback with the updated
     *  autocapture status score.
     *   */
    var setAutocaptureStatusUpdated = function( autocaptureStatusUpdated )
    {
        callbacks.autocaptureStatusUpdated = autocaptureStatusUpdated;
    };

    /** Sets the captured_image_updated.
     *  @param {String} capturedImageUpdated Callback with the captured
     *  image. The image format is the same as the preview image.
     *   */
    var setCapturedImageUpdated = function( capturedImageUpdated )
    {
        callbacks.capturedImageUpdated = capturedImageUpdated;
    };

    /** Sets the current_impression_updated.
     *  @param {String} currentImpressionUpdated Callback with the current
     *  impression.
     *   */
    var setCurrentImpressionUpdated = function( currentImpressionUpdated )
    {
        callbacks.currentImpressionUpdated = currentImpressionUpdated;
    };

    /** This function returns the manufacturer make from the active live
     *  scan device.
     *  
     *  @returns {Promise<String,Error>} The manufacturer make from the
     *  active live scan device.
     *   */
    var deviceGetMake = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_device_get_make";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** This function returns the manufacturer model from the active live
     *  scan device.
     *  
     *  @returns {Promise<String,Error>} The manufacturer model from the
     *  active live scan device.
     *   */
    var deviceGetModel = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_device_get_model";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** This function returns the serial number, or equivalent
     *  identification, from the active live scan device.
     *  
     *  @returns {Promise<String,Error>} The serial number, or equivalent
     *  identification, from the active live scan device.
     *   */
    var deviceGetSerialNumber = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_device_get_serial_number";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Returns integer value indicating the current version of the
     *  component.
     *  
     *  @returns {Promise<Number,Error>} An integer indicating the library
     *  version number.
     *   */
    var getVersion = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_get_version";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Returns a text string indicating the current version of the
     *  component.
     *  
     *  @returns {Promise<String,Error>} A string indicating the library
     *  version number.
     *   */
    var getVersionString = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in FingerprintCaptureApi.ErrorCode )
                    {
                        if ( FingerprintCaptureApi.ErrorCode[errorEntry] == errorCode )
                        {
                            error.errorName = errorEntry;
                            break;
                        }
                    }
                    reject( error );
                }
            } );
            var jsonNode = {};
            jsonNode.message_id = currentMessageId.toString();
            jsonNode.channel = channel;
            jsonNode.function = "aw_fingerprint_capture_get_version_string";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };




    var instance = {};
    instance.onMessage = onMessage;
    instance.channel = channel;
    instance.destroy = destroy;
    instance.openDevice = openDevice;
    instance.close = close;
    instance.calibrate = calibrate;
    instance.deviceIsCalibrated = deviceIsCalibrated;
    instance.setAutoCaptureConfiguration = setAutoCaptureConfiguration;
    instance.setCaptureResolution = setCaptureResolution;
    instance.getCaptureResolution = getCaptureResolution;
    instance.startAutoCapture = startAutoCapture;
    instance.disableAutoCapture = disableAutoCapture;
    instance.endAutoCapture = endAutoCapture;
    instance.captureImage = captureImage;
    instance.playOnCaptureAudio = playOnCaptureAudio;
    instance.playOnFailureAudio = playOnFailureAudio;
    instance.setFingerMissing = setFingerMissing;
    instance.resetMissingFingers = resetMissingFingers;
    instance.deviceGetProperty = deviceGetProperty;
    instance.deviceSetProperty = deviceSetProperty;
    instance.deviceEnableAudio = deviceEnableAudio;
    instance.getCapturedImage = getCapturedImage;
    instance.setDeviceStateUpdated = setDeviceStateUpdated;
    instance.setPreviewImageUpdated = setPreviewImageUpdated;
    instance.requestNextPreviewImage = requestNextPreviewImage;
    instance.setPreviewQualityScoreUpdated = setPreviewQualityScoreUpdated;
    instance.setAutocaptureStatusUpdated = setAutocaptureStatusUpdated;
    instance.setCapturedImageUpdated = setCapturedImageUpdated;
    instance.setCurrentImpressionUpdated = setCurrentImpressionUpdated;
    instance.deviceGetMake = deviceGetMake;
    instance.deviceGetModel = deviceGetModel;
    instance.deviceGetSerialNumber = deviceGetSerialNumber;
    instance.getVersion = getVersion;
    instance.getVersionString = getVersionString;

    return new Promise( function( resolve, reject )
    {
        internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
        {
            if ( errorCode == FingerprintCaptureApi.ErrorCode.NO_ERRORS )
            {
                resolve( instance );
            }
            else
            {
                reject( errorMessage );
            }
        } );
        var jsonNode = {};
        jsonNode.message_id = currentMessageId.toString();
        jsonNode.function = "aw_fingerprint_capture_create";
        jsonNode.channel = channel;
        transport.send( jsonNode );
    } );
});

