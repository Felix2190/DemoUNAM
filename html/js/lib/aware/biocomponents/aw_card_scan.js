/* Copyright (C) 2017 Aware, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 */
 
/** @namespace
  */
var CardScanApi =
{
    /** Feature of an entity or identity.
     *  @enum {number} */
    Feature : 
    (function()
    {
        var values = {};
        /** Full name. */
        values[values.FULL_NAME = 0] = "FULL_NAME";

        return values;
    })(),

    /** Device.
     *  @enum {number} */
    DeviceId : 
    (function()
    {
        var values = {};
        /** Image will be passed in through a buffer */
        values[values.MEMORY = 0] = "MEMORY";

        /** Epson 1640SU scanner */
        values[values.EPSON_1640SU = 2] = "EPSON_1640SU";

        /** Epson 1640XL scanner */
        values[values.EPSON_1640XL = 3] = "EPSON_1640XL";

        /** Epson Perfection 1650 scanner */
        values[values.EPSON_PERF1650 = 4] = "EPSON_PERF1650";

        /** Epson Perfection 2450 scanner */
        values[values.EPSON_PERF2450 = 5] = "EPSON_PERF2450";

        /** Epson Perfection 3200 scanner */
        values[values.EPSON_PERF3200 = 6] = "EPSON_PERF3200";

        /** Epson Perfection 3170 scanner */
        values[values.EPSON_PERF3170 = 7] = "EPSON_PERF3170";

        /** Epson Perfection 4870 scanner */
        values[values.EPSON_PERF4870 = 8] = "EPSON_PERF4870";

        /** Epson Perfection 4180 scanner */
        values[values.EPSON_PERF4180 = 9] = "EPSON_PERF4180";

        /** Epson Expression 10000XL scanner */
        values[values.EPSON_PERF10000XL = 10] = "EPSON_PERF10000XL";

        /** Epson Perfection 4990 scanner */
        values[values.EPSON_PERF4990 = 11] = "EPSON_PERF4990";

        /** Epson Perfection 4490 scanner */
        values[values.EPSON_PERF4490 = 12] = "EPSON_PERF4490";

        /** Epson Perfection V700 scanner */
        values[values.EPSON_PERFV700 = 13] = "EPSON_PERFV700";

        /** Epson Perfection V500 scanner */
        values[values.EPSON_PERFV500 = 14] = "EPSON_PERFV500";

        /** Epson Expression 11000XL scanner */
        values[values.EPSON_PERF11000XL = 15] = "EPSON_PERF11000XL";

        /** Epson Perfection V550 scanner */
        values[values.EPSON_PERFV550 = 16] = "EPSON_PERFV550";

        /** Epson Perfection V800 scanner */
        values[values.EPSON_PERFV800 = 17] = "EPSON_PERFV800";

        return values;
    })(),

    /** Image format.
     *  @enum {number} */
    ImageFormat : 
    (function()
    {
        var values = {};
        /** RAW format. */
        values[values.RAW = 1] = "RAW";

        /** BMP format. */
        values[values.BMP = 2] = "BMP";

        /** WSQ format. */
        values[values.WSQ = 3] = "WSQ";

        /** JPEG format. */
        values[values.JPG = 4] = "JPG";

        /** PNG format. */
        values[values.PNG = 5] = "PNG";

        return values;
    })(),


    /** List of error codes.
     *  @enum {number} */
    ErrorCode : 
    (function()
    {
        var values = {};
        /** No errors or warnings. */
        values[values.NO_ERRORS = 0] = "NO_ERRORS";

        /** The library failed to allocate memory. */
        values[values.OUT_OF_MEMORY = 100] = "OUT_OF_MEMORY";

        /** The card_scan object was NULL. */
        values[values.NULL_CARD_SCAN_OBJ = 101] = "NULL_CARD_SCAN_OBJ";

        /** Failed to parse the JSON request. */
        values[values.FAILED_TO_PARSE_JSON = 10001] = "FAILED_TO_PARSE_JSON";

        /** The function name was not valid. */
        values[values.INVALID_FUNCTION_NAME = 10002] = "INVALID_FUNCTION_NAME";

        /** The parameter list must be a JSON array. */
        values[values.INVALID_PARAMETER_LIST = 10003] = "INVALID_PARAMETER_LIST";

        /** A parameter had an incorrect type. */
        values[values.INVALID_PARAMETER_TYPE = 10004] = "INVALID_PARAMETER_TYPE";

        /** The wrong number of parameters were passed to the function. */
        values[values.INCORRECT_PARAMETER_COUNT = 10005] = "INCORRECT_PARAMETER_COUNT";

        /** The channel name is incorrect, hasn't been opened, or is closed. */
        values[values.INVALID_CHANNEL_NAME = 10006] = "INVALID_CHANNEL_NAME";

        return values;
    })(),


};

/** Creates an object that implements the CardScan API.
  *
  * @param websocketHandle - Handle to an open websocket connection, connected
  *      to the aw_bio_component_server. The caller is responsible for handling
  *      the "onerror" callback, whereas this class will handle the "onmessage"
  *      callback.
  *
  * @return Object that implements the CardScan API.
  */
var createCardScan = (function( transportObject, channelName )
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


    /** This function destroys the CardScan object.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var destroy = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_destroy";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Loads scanning configuration from a file.
     *  @param {String} configurationFilePath Configuration XML.
     *  
     *  @returns {Promise<Number,Error>} Status.
     *   */
    var loadConfigurationFile = function( configurationFilePath )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_load_configuration_file";
            jsonNode.args = [ configurationFilePath ];
            transport.send( jsonNode );
        } );
    };

    /** Loads scanning configuration from a buffer.
     *  @param {String} configurationFileBuffer Configuration buffer.
     *  
     *  @returns {Promise<Number,Error>} Status.
     *   */
    var loadConfigurationBuffer = function( configurationFileBuffer )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_load_configuration_buffer";
            jsonNode.args = [ configurationFileBuffer ];
            transport.send( jsonNode );
        } );
    };

    /** Sets units of the scanning template file.
     *  @param {Number} units Card units. Units can either be inches
     *  (default) or centimeters. 0 for inches and 1 for centimeters.
     *  
     *  @returns {Promise<Number,Error>} Status.
     *   */
    var setUnits = function( units )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_set_units";
            jsonNode.args = [ units ];
            transport.send( jsonNode );
        } );
    };

    /** Add a new page or modify an existing page in the template file.
     *  @param {Number} top Top.
     *  @param {Number} left Left.
     *  @param {Number} height Height.
     *  @param {Number} width Width.
     *  @param {Number} resolution Resolution.
     *  @param {Number} page Page number.
     *  
     *  @returns {Promise<Number,Error>} Status.
     *   */
    var setPage = function( top, left, height, width, resolution, page )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_set_page";
            jsonNode.args = [ top, left, height, width, resolution, page ];
            transport.send( jsonNode );
        } );
    };

    /** Delete page.
     *  @param {Number} page Page number.
     *  
     *  @returns {Promise<Number,Error>} Status.
     *   */
    var deletePage = function( page )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_delete_page";
            jsonNode.args = [ page ];
            transport.send( jsonNode );
        } );
    };

    /** This function returns an array of all the crop regions in the
     *  current template.
     *  
     *  @returns {Promise<Object,Error>} List of crop regions.
     *   */
    var getCropRegions = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_get_crop_regions";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Add a new crop region or modify an existing crop region in the
     *  template file.
     *  @param {Number} index Crop region index.
     *  @param {Number} top Top.
     *  @param {Number} left Left.
     *  @param {Number} height Height.
     *  @param {Number} width Width.
     *  @param {Number} page Page number.
     *  
     *  @returns {Promise<Number,Error>} Status.
     *   */
    var setCropRegion = function( index, top, left, height, width, page )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_set_crop_region";
            jsonNode.args = [ index, top, left, height, width, page ];
            transport.send( jsonNode );
        } );
    };

    /** Delete crop region.
     *  @param {Number} index Crop region index.
     *  
     *  @returns {Promise<Number,Error>} Statu.
     *   */
    var deleteCropRegion = function( index )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_delete_crop_region";
            jsonNode.args = [ index ];
            transport.send( jsonNode );
        } );
    };

    /** Save template buffer
     *  
     *  @returns {Promise<String,Error>} Template file buffer.
     *   */
    var saveTemplateFile = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_save_template_file";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Gets a list of the scanners that are available.
     *  
     *  @returns {Promise<Object,Error>} Device id.
     *   */
    var getAvailableScanners = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_get_available_scanners";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Set scanner type.
     *  @param {Number} device Device id.
     *  
     *  @returns {Promise<,Error>}
     *   */
    var setScannerType = function( device )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve();
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_set_scanner_type";
            jsonNode.args = [ device ];
            transport.send( jsonNode );
        } );
    };

    /** Connect.
     *  
     *  @returns {Promise<Number,Error>} Status.
     *   */
    var connect = function( )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_connect";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };

    /** Scan.
     *  @param {Number} page Page number.
     *  
     *  @returns {Promise<Number,Error>} Status.
     *   */
    var scan = function( page )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_scan";
            jsonNode.args = [ page ];
            transport.send( jsonNode );
        } );
    };

    /** Loads image buffer.
     *  @param {String} image Image file.
     *  @param {Number} page Page number.
     *  
     *  @returns {Promise<Number,Error>} Status.
     *   */
    var loadImageBuffer = function( image, page )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_load_image_buffer";
            jsonNode.args = [ image, page ];
            transport.send( jsonNode );
        } );
    };

    /** Gets the card image.
     *  @param {Number} page Page number.
     *  @param {Number} subres Sub-resolution to get (1-full image,
     *  2-quarter image, 4-sixteenth image).
     *  @param {Number} format Output image format
     *  
     *  @returns {Promise<String,Error>} Image buffer.
     *   */
    var getCardImage = function( page, subres, format )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_get_card_image";
            jsonNode.args = [ page, subres, format ];
            transport.send( jsonNode );
        } );
    };

    /** Gets crop image by index.
     *  @param {Number} index Crop index number.
     *  @param {Number} subres Sub-resolution to get (1-full image,
     *  2-quarter image, 4-sixteenth image).
     *  @param {Number} format Output image format
     *  
     *  @returns {Promise<String,Error>} Image buffer.
     *   */
    var getCropImage = function( index, subres, format )
    {
        return new Promise( function( resolve, reject )
        {
            internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
            {
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_get_crop_image";
            jsonNode.args = [ index, subres, format ];
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
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_get_version";
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
                if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
                {
                    resolve( returnValue );
                }
                else
                {
                    var error = new Error( errorMessage );
                    error.errorCode = errorCode;
                    for ( var errorEntry in CardScanApi.ErrorCode )
                    {
                        if ( CardScanApi.ErrorCode[errorEntry] == errorCode )
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
            jsonNode.function = "aw_card_scan_get_version_string";
            jsonNode.args = [ ];
            transport.send( jsonNode );
        } );
    };




    var instance = {};
    instance.onMessage = onMessage;
    instance.channel = channel;
    instance.destroy = destroy;
    instance.loadConfigurationFile = loadConfigurationFile;
    instance.loadConfigurationBuffer = loadConfigurationBuffer;
    instance.setUnits = setUnits;
    instance.setPage = setPage;
    instance.deletePage = deletePage;
    instance.getCropRegions = getCropRegions;
    instance.setCropRegion = setCropRegion;
    instance.deleteCropRegion = deleteCropRegion;
    instance.saveTemplateFile = saveTemplateFile;
    instance.getAvailableScanners = getAvailableScanners;
    instance.setScannerType = setScannerType;
    instance.connect = connect;
    instance.scan = scan;
    instance.loadImageBuffer = loadImageBuffer;
    instance.getCardImage = getCardImage;
    instance.getCropImage = getCropImage;
    instance.getVersion = getVersion;
    instance.getVersionString = getVersionString;

    return new Promise( function( resolve, reject )
    {
        internalStoreOnReturn( function( returnValue, errorCode, errorMessage )
        {
            if ( errorCode == CardScanApi.ErrorCode.NO_ERRORS )
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
        jsonNode.function = "aw_card_scan_create";
        jsonNode.channel = channel;
        transport.send( jsonNode );
    } );
});

