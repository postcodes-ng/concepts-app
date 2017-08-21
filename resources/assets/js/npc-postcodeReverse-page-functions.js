
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
        makeRequest('/api/reverse-lookup-postcode?postCode='+postcode, 'GET', null, responseHandler, spinnerId);
    }
}

function buildReverseLookupResult(status, result) {
    var resultDiv = jQuery('#rlkp-result');
    var errorDiv = jQuery('#rlkp-error');
    var successDiv = jQuery('#rlkp-success');
    if (status === 'success') {
        var type = result.postcodeType;
        successDiv.children('span').text(getSuccessMessage(type) );
        errorDiv.addClass( 'npc-hidden' );
        successDiv.removeClass( 'npc-hidden' );

        var resultSummaryDiv = jQuery('#rlkp-result-summary');
        resultSummaryDiv.empty();

        if (type === 'rural') {
            buildRpResultSummary(result);
        } else if (type === 'urban') {
            buildUpResultSummary(result);
        } else if (type === 'facility') {
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
    if (type === 'rural' || type === 'facility') {
        message = 'Found! This is a ' + type + ' postcode. See info below'
    } else if (type === 'urban') {
        message = 'Found! This is an ' + type + ' postcode. See info below'
    }
    return message;
}

function buildRpResultSummary(result) {
    var postcode = result.ruralPostcodeResponses[0].postcode;
    var district = result.ruralPostcodeResponses[0].district;
    var lga = result.ruralPostcodeResponses[0].localGovernmentAreaName;
    var state = result.ruralPostcodeResponses[0].stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p><strong>' + postcode + '</strong> is the postcode for <strong>' + district + '</strong> district in <strong>' + lga +  '</strong> LGA, <strong>' + state + '</strong> State.</p>');
    resultSummaryDiv.append('<p><strong>' + district + '</strong> district is made up of the following villages.</p>');

    var col = jQuery('<div>').addClass('col-md-4')
    var ul = jQuery('<ul>').addClass('list-group');
    jQuery.each(result.ruralPostcodeResponses, function(i, r) {
        ul.append('<li class="list-group-item">'+r.town+'</li>');
    });
    ul.appendTo(col);
    col.appendTo(resultSummaryDiv);
    resultSummaryDiv.removeClass( 'npc-hidden' );
}

function buildUpResultSummary(result) {
    var postcode = result.urbanPostcodeResponses[0].postcode;
    var area = result.urbanPostcodeResponses[0].area;
    var town = result.urbanPostcodeResponses[0].town;
    var state = result.urbanPostcodeResponses[0].stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p><strong>' + postcode + '</strong> is the postcode for <strong>' + area + '</strong> area in <strong>' + town +  '</strong> town, <strong>' + state + '</strong> State.</p>');
    resultSummaryDiv.append('<p><strong>' + area + '</strong> area is made up of the following streets.</p>');

    var col = jQuery('<div>').addClass('col-md-4')
    var ul = jQuery('<ul>').addClass('list-group');
    jQuery.each(result.urbanPostcodeResponses, function(i, r) {
        ul.append('<li class="list-group-item">'+r.street+'</li>');
    });
    ul.appendTo(col);
    col.appendTo(resultSummaryDiv);
    resultSummaryDiv.removeClass( 'npc-hidden' );
}

function buildFpResultSummary(result) {
    var postcode = result.facilityPostcodeResponses[0].postcode;
    var facility = result.facilityPostcodeResponses[0].facilityName;
    var lga = result.facilityPostcodeResponses[0].localGovernmentAreaName;
    var state = result.facilityPostcodeResponses[0].stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p><strong>' + postcode + '</strong> is the postcode for <strong>' + facility + '</strong> facility in <strong>' + lga +  '</strong> LGA, <strong>' + state + '</strong> State.</p>');

    resultSummaryDiv.removeClass( 'npc-hidden' );
}

