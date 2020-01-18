// enter keyd
jQuery(document).ready(function() {
	$(document).bind('keypress', function(e) {
        if(e.keyCode == 13){
             $('#rlkp-button').trigger('click');
             return false;
        }
    });
});

/*
function toggleIcon(e) {
    $(e.target)
        .prev('#rlkp-result-table-body')
        .children('tr.first')
        .find(".more-less")
        .toggleClass('glyphicon-plus glyphicon-minus');
}
$('.rlkp-result-table-row').on('hide.bs.collapse', toggleIcon);
$('.rlkp-result-table-row').on('show.bs.collapse', toggleIcon);*/

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

function buildReverseLookupResult(status, results) {
    var resultDiv = jQuery('#rlkp-result');
    var errorDiv = jQuery('#rlkp-error');
    var successDiv = jQuery('#rlkp-success');
    if (status === 'success' && results.length > 0) {
        var type = results[0].postcodeType;
        successDiv.children('span').text(getSuccessMessage(type) );
        errorDiv.addClass( 'npc-hidden' );
        successDiv.removeClass( 'npc-hidden' );

        var resultSummaryDiv = jQuery('#rlkp-result-summary');
        resultSummaryDiv.empty();

        if (type === 'RURAL') {
            buildRpResultSummary(results);
        } else if (type === 'URBAN') {
            buildUpResultSummary(results);
        } else if (type === 'FACILITY') {
            buildFpResultSummary(results);
        }

    } else {
        errorDiv.children('span').text('No results found for this postcode');
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

function buildRpResultSummary(results) {
    var district = results[0].entity.entityName;
    var lga = results[0].entity.localGovernmentAreaName;
    var state = results[0].entity.stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p>This postcode is for the following rural areas in <strong>' + lga +  '</strong> LGA, <strong>' + state + '</strong> State.</p>');

    resultSummaryDiv.append(buildResultTable(results, 'RURAL'));

    resultSummaryDiv.removeClass( 'npc-hidden' );
}

function buildUpResultSummary(results) {
    var area = results[0].entity.entityName;
    var town = results[0].entity.urbanTownName;
    var state = results[0].entity.stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p>This postcode is for the following urban areas in <strong>' + town +  '</strong> town, <strong>' + state + '</strong> State.</p>');

    resultSummaryDiv.append(buildResultTable(results, 'URBAN'));
    
    resultSummaryDiv.removeClass( 'npc-hidden' );
}

function buildFpResultSummary(result) {
    var facility = result[0].entity.entityName;
    var lga = result[0].entity.localGovernmentAreaName;
    var state = result[0].entity.stateName;
    var resultSummaryDiv = jQuery('#rlkp-result-summary');
    resultSummaryDiv.append('<p>This postcode is for <strong>' + facility + '</strong> facility in <strong>' + lga +  '</strong> LGA, <strong>' + state + '</strong> State.</p>');

    resultSummaryDiv.removeClass( 'npc-hidden' );
}

function buildResultTable(results, type)
{
    var typeHeader = '<tr><th></th><th>Rural Area</th><th>Villages</th><th>LGA</th><th>State</th></tr>';
    if (type === 'URBAN') {
        typeHeader = '<tr><th></th><th>Urban Area</th><th>Streets</th><th>Urban Town</th><th>State</th></tr>';
    }
    var tableHeaderRow = jQuery('<thead></thead>');
    tableHeaderRow.append(typeHeader);
    var tableDiv = jQuery('<table  class="table"></table>');
    tableDiv.append(tableHeaderRow);

    jQuery.each(results, function(i, r) {
        tableDiv.append(buildResultTableRows(r, type, i));
    });

    return tableDiv;
}

function buildResultTableRows(result, type, index)
{
    var entityName = result.entity.entityName;
    var lgaOrTown = result.entity.localGovernmentAreaName;
    if (type === 'URBAN') {
        lgaOrTown = result.entity.urbanTownName;
    }
    var state = result.entity.stateName;
    var tableBody = jQuery('<tbody class="rlkp-result-table-body"></tbody>');
    tableBody.append('<tr data-toggle="collapse" data-target=".child'+index+'">' +
    '<td><a class="npc-show-hide"><span id="show-icon"><i class="more-less glyphicon glyphicon-plus"></i></span></a></td>' +
    '<td>' + entityName + '</td>' +
    '<td>Expand To See</td>' +
    '<td>' + lgaOrTown + '</td>' +
    '<td>' + state + '</td>' +
    '</tr>');

    jQuery.each(result.subEntities, function(i, r) {
        tableBody.append('<tr class="rlkp-result-table-row collapse child'+index+'">' +
        '<td></td>' +
        '<td></td>' +
        '<td>'+r.entityName+'</td>' +
        '<td>' + lgaOrTown + '</td>' +
        '<td>' + state + '</td>' +
        '</tr>');
    });

    return tableBody
}


