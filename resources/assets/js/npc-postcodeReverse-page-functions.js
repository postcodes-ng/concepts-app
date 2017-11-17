// enter keyd
jQuery(document).ready(function() {
	$(document).bind('keypress', function(e) {
        if(e.keyCode == 13){
             $('#rlkp-button').trigger('click');
             return false;
        }
    });
});


jQuery('#rlkp-button').on('click', function() {
    hideDiv('rlkp-result');
    hideDiv('rlkp-result-summary');
    makeReverseLookupRequest('rlkp-loading',  buildReverseLookupResult);
});

function makeReverseLookupRequest(spinnerId, responseHandler) {
    var postcode = jQuery('#rlkp-postcode').val();

    if (postcode && postcode != '') {
        //start spinner
        startSpinner(spinnerId);

        // Send to the server
        makeRequest('/api/search/byPostcode?postCode='+postcode, 'GET', null, responseHandler, spinnerId);
    }
}

function buildReverseLookupResult(status, result) {
    var resultDiv = jQuery('#rlkp-result');
    var errorDiv = jQuery('#rlkp-error');
    var successDiv = jQuery('#rlkp-success');
    if (status === 'success') {
        var type = result[0].postcodeType;
        successDiv.children('span').text(getSuccessMessage(type) );
        errorDiv.addClass( 'npc-hidden' );
        successDiv.removeClass( 'npc-hidden' );

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
        errorDiv.removeClass( 'npc-hidden' );
        successDiv.addClass( 'npc-hidden' );
    }
    resultDiv.removeClass( 'npc-hidden' );
}

function getSuccessMessage(type) {
    var message = '';
    if (type === 'RURAL' || type === 'FACILITY') {
        message = 'Found! This is a ' + type + ' postcode. See info below'
    } else if (type === 'URBAN') {
        message = 'Found! This is an ' + type + ' postcode. See info below'
    }
    return message;
}

function buildRpResultSummary(result) {
    var district = result[0].entity.entityName;
    var lga = result[0].entity.localGovernmentAreaName;
    var state = result[0].entity.stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p>This is the postcode for <strong>' + district + '</strong> rural area in <strong>' + lga +  '</strong> LGA, <strong>' + state + '</strong> State.</p>');
    resultSummaryDiv.append('<p><strong>' + district + '</strong> rural area is made up of the following villages.</p>');

    var col = jQuery('<div>').addClass('col-md-4')
    var ul = jQuery('<ul>').addClass('list-group');
    jQuery.each(result[0].subEntities, function(i, r) {
        ul.append('<li class="list-group-item">'+r.entityName+'</li>');
    });
    ul.appendTo(col);
    col.appendTo(resultSummaryDiv);
    resultSummaryDiv.removeClass( 'npc-hidden' );
}

function buildUpResultSummary(result) {
    var area = result[0].entity.entityName;
    var town = result[0].entity.urbanTownName;
    var state = result[0].entity.stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p>This is the postcode for <strong>' + area + '</strong> urban area in <strong>' + town +  '</strong> town, <strong>' + state + '</strong> State.</p>');
    resultSummaryDiv.append('<p><strong>' + area + '</strong> urban area is made up of the following streets.</p>');

    var col = jQuery('<div>').addClass('col-md-4')
    var ul = jQuery('<ul>').addClass('list-group');
    jQuery.each(result[0].subEntities, function(i, r) {
        ul.append('<li class="list-group-item">'+r.entityName+'</li>');
    });
    ul.appendTo(col);
    col.appendTo(resultSummaryDiv);
    resultSummaryDiv.removeClass( 'npc-hidden' );
}

function buildFpResultSummary(result) {
    var facility = result[0].entity.entityName;
    var lga = result[0].entity.localGovernmentAreaName;
    var state = result[0].entity.stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p>This is the postcode for <strong>' + facility + '</strong> facility in <strong>' + lga +  '</strong> LGA, <strong>' + state + '</strong> State.</p>');

    resultSummaryDiv.removeClass( 'npc-hidden' );
}

