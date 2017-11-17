/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 49);
/******/ })
/************************************************************************/
/******/ ({

/***/ 49:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(50);


/***/ }),

/***/ 50:
/***/ (function(module, exports) {

// enter keyd
jQuery(document).ready(function () {
    $(document).bind('keypress', function (e) {
        if (e.keyCode == 13) {
            $('#rlkp-button').trigger('click');
            return false;
        }
    });
});

jQuery('#rlkp-button').on('click', function () {
    hideDiv('rlkp-result');
    hideDiv('rlkp-result-summary');
    makeReverseLookupRequest('rlkp-loading', buildReverseLookupResult);
});

function makeReverseLookupRequest(spinnerId, responseHandler) {
    var postcode = jQuery('#rlkp-postcode').val();

    if (postcode && postcode != '') {
        //start spinner
        startSpinner(spinnerId);

        // Send to the server
        makeRequest('/api/search/byPostcode?postCode=' + postcode, 'GET', null, responseHandler, spinnerId);
    }
}

function buildReverseLookupResult(status, result) {
    var resultDiv = jQuery('#rlkp-result');
    var errorDiv = jQuery('#rlkp-error');
    var successDiv = jQuery('#rlkp-success');
    if (status === 'success') {
        var type = result[0].postcodeType;
        successDiv.children('span').text(getSuccessMessage(type));
        errorDiv.addClass('npc-hidden');
        successDiv.removeClass('npc-hidden');

        var resultSummaryDiv = jQuery('#rlkp-result-summary');
        resultSummaryDiv.empty();

        if (type === 'RURAL') {
            buildRpResultSummary(result);
        } else if (type === 'URBAN') {
            buildUpResultSummary(result);
        } else if (type === 'FACILITY') {
            buildFpResultSummary(result);
        }
    } else {
        errorDiv.children('span').text(result);
        errorDiv.removeClass('npc-hidden');
        successDiv.addClass('npc-hidden');
    }
    resultDiv.removeClass('npc-hidden');
}

function getSuccessMessage(type) {
    var message = '';
    if (type === 'RURAL' || type === 'FACILITY') {
        message = 'Found! This is a ' + type + ' postcode. See info below';
    } else if (type === 'URBAN') {
        message = 'Found! This is an ' + type + ' postcode. See info below';
    }
    return message;
}

function buildRpResultSummary(result) {
    var district = result[0].entity.entityName;
    var lga = result[0].entity.localGovernmentAreaName;
    var state = result[0].entity.stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p>This is the postcode for <strong>' + district + '</strong> rural area in <strong>' + lga + '</strong> LGA, <strong>' + state + '</strong> State.</p>');
    resultSummaryDiv.append('<p><strong>' + district + '</strong> rural area is made up of the following villages.</p>');

    var col = jQuery('<div>').addClass('col-md-4');
    var ul = jQuery('<ul>').addClass('list-group');
    jQuery.each(result[0].subEntities, function (i, r) {
        ul.append('<li class="list-group-item">' + r.entityName + '</li>');
    });
    ul.appendTo(col);
    col.appendTo(resultSummaryDiv);
    resultSummaryDiv.removeClass('npc-hidden');
}

function buildUpResultSummary(result) {
    var area = result[0].entity.entityName;
    var town = result[0].entity.urbanTownName;
    var state = result[0].entity.stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p>This is the postcode for <strong>' + area + '</strong> urban area in <strong>' + town + '</strong> town, <strong>' + state + '</strong> State.</p>');
    resultSummaryDiv.append('<p><strong>' + area + '</strong> urban area is made up of the following streets.</p>');

    var col = jQuery('<div>').addClass('col-md-4');
    var ul = jQuery('<ul>').addClass('list-group');
    jQuery.each(result[0].subEntities, function (i, r) {
        ul.append('<li class="list-group-item">' + r.entityName + '</li>');
    });
    ul.appendTo(col);
    col.appendTo(resultSummaryDiv);
    resultSummaryDiv.removeClass('npc-hidden');
}

function buildFpResultSummary(result) {
    var facility = result[0].entity.entityName;
    var lga = result[0].entity.localGovernmentAreaName;
    var state = result[0].entity.stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p>This is the postcode for <strong>' + facility + '</strong> facility in <strong>' + lga + '</strong> LGA, <strong>' + state + '</strong> State.</p>');

    resultSummaryDiv.removeClass('npc-hidden');
}

/***/ })

/******/ });