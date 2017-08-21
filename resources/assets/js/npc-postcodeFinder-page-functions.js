
var stateCache = null;
var streetCache = null;

jQuery(document).ready(function() {
	makeStateRequest();
});

/** Rural Event Handlers */
jQuery('#rp-state-select').on('change', function() {
    hideDiv('rp-result');
    hideDiv('npc-rp-town');
    makeLgaRequest( this.value, 'rp-loading',  buildRpLgaResult);
});

jQuery('#rp-lga-select').on('change', function() {
    hideDiv('rp-result');
    makeRuralPostcodeRequest( this.value );
});

jQuery('#rp-town-select').on('change', function() {
    hideDiv('rp-result');
    extractRpPostcode( this.value );
});

/** Urban Event handlers */
jQuery('#up-state-select').on('change', function() {
    hideDiv('up-result');
    hideDiv('npc-up-street');
    makeUrbanTownRequest( this.value, 'up-loading',  buildUpTownResult);
});

jQuery('#up-town-select').on('change', function() {
    hideDiv('up-result');
    showUrbanStreetInput();
});

jQuery('#up-street-input').bind('input propertychange', function() {
    hideDiv('up-result');
    getSuggestions(this.value);
});

/** Facility Event Handlers */
jQuery('#fp-state-select').on('change', function() {
    hideDiv('fp-result');
    hideDiv('npc-fp-town');
    makeLgaRequest( this.value, 'fp-loading',  buildFpLgaResult);
});

jQuery('#fp-lga-select').on('change', function() {
    hideDiv('fp-result');
    makeFacilityPostcodeRequest( this.value );
});

jQuery('#fp-facility-select').on('change', function() {
    hideDiv('fp-result');
    extractFpPostcode( this.value );
});

/** End of Event Handlers */

function makeStateRequest(spinnerId, responseHandler) {

    if (stateCache === null) {
        //start spinner
        startSpinner('page-loading');

        // Send to the server
        makeRequest('/api/states', 'GET', null, buildStateResult, 'page-loading');
    } else {
        buildStateResult('success', stateCache);
    }
    
}

function makeLgaRequest(state, spinnerId, responseHandler) {
	
	//start spinner
	startSpinner(spinnerId);

	// Send to the server
	makeRequest('/api/lgas?stateCode='+state, 'GET', null, responseHandler, spinnerId);
}

function makeUrbanTownRequest(state, spinnerId, responseHandler) {
	
	//start spinner
	startSpinner(spinnerId);

	// Send to the server
	makeRequest('/api/fetch-urban-towns?stateCode='+state, 'GET', null, responseHandler, spinnerId);
}

function makeRuralPostcodeRequest(value) {
	var values = value.split('|');
	var lga = values[0];
    var stateCode = values[1];
    
    //start spinner
    startSpinner('rp-loading');
	
	// Send to the server
	makeRequest('/api/rural-postcodes?stateCode=' + stateCode + '&lga=' + lga, 'GET', null, buildRpTownResult, 'rp-loading');
}

function makeFacilityPostcodeRequest(value) {
	var values = value.split('|');
	var lga = values[0];
    var stateCode = values[1];
    
    //start spinner
    startSpinner('fp-loading');
	
	// Send to the server
	makeRequest('/api/facility-postcodes?stateCode=' + stateCode + '&lga=' + lga, 'GET', null, buildFpFacilityResult, 'fp-loading');
}

function getSuggestions(hint) {
    if (hint.length > 0) {
        var stateCode = jQuery('#up-state-select').val();
        var town = jQuery('#up-town-select').val();
        //start spinner
        startSpinner('up-loading');

        // Send to the server
        makeRequest('/api/suggest-urban-postcodes?stateCode=' + stateCode + '&town=' + town + '&hint=' + hint, 'GET', null, buildUpStreetSuggestions, 'up-loading');
            
    } else {
        var streetMenu = jQuery('#up-street-menu');
        streetMenu.empty();
    }
}

function extractRpPostcode(value) {
    var values = value.split('|');
    var town = values[0];
    var lga = values[2];
    var postcode = values[4];

    var resultDiv = jQuery('#rp-result');
    jQuery('#rp-result-town').text(town);
    jQuery('#rp-result-lga').text(lga);
    jQuery('#rp-result-postcode').text(postcode);

    resultDiv.removeClass( "npc-hidden" );

}

function extractFpPostcode(value) {
    var values = value.split('|');
    var facility = values[0];
    var lga = values[1];
    var postcode = values[3];

    var resultDiv = jQuery('#fp-result');
    jQuery('#fp-result-facility').text(facility);
    jQuery('#fp-result-lga').text(lga);
    jQuery('#fp-result-postcode').text(postcode);

    resultDiv.removeClass( "npc-hidden" );

}

extractUpPostcode = function (street) {
    var streetMenu = jQuery('#up-street-menu');
    streetMenu.empty();
    var streetInput = jQuery('#up-street-input');
    streetInput.val(street);
    if (streetCache) {
        var result = streetCache[street];

        var street = result.street;
        var town = result.town;
        var postcode = result.postcode;

        var resultDiv = jQuery('#up-result');
        jQuery('#up-result-town').text(town);
        jQuery('#up-result-street').text(street);
        jQuery('#up-result-postcode').text(postcode);

        startSpinner('up-loading');

        setTimeout(function(){
            stopSpinner('up-loading');
            resultDiv.removeClass( "npc-hidden" );
            },
            500
        );
            
    }
}

function buildStateResult(status, results) {
    if (stateCache === null) {
        stateCache = results;
    }
    buildRpStateResult(status, results);
    buildUpStateResult(status, results);
    buildFpStateResult(status, results);
}

function buildRpStateResult(status, results) {
    buildSelectResult(status, results, 'rp-state');
}

function buildUpStateResult(status, results) {
    buildSelectResult(status, results, 'up-state');
}

function buildFpStateResult(status, results) {
    buildSelectResult(status, results, 'fp-state');
}

function buildRpLgaResult(status, results) {
    buildSelectResult(status, results, 'rp-lga');
}

function buildFpLgaResult(status, results) {
    buildSelectResult(status, results, 'fp-lga');
}

function buildRpTownResult(status, results) {
    buildSelectResult(status, results, 'rp-town');
}

function buildUpTownResult(status, results) {
    buildSelectResult(status, results, 'up-town');
}

function buildFpFacilityResult(status, results) {
    if (results.length > 0) {
        buildSelectResult(status, results, 'fp-facility');
    } else {
        var errorDiv = jQuery('#fp-facility-error');
        var select = jQuery('#fp-facility-select');
        var formgroup = jQuery('#npc-fp-facility');
        errorDiv.children('span').text('No Facilities found for the selected LGA');
        errorDiv.removeClass( "npc-hidden" );
        select.addClass( "npc-hidden" );
        formgroup.removeClass( "npc-hidden" );
    }
}

function buildSelectResult(status, results, type) {
	var formgroup = jQuery('#npc-' + type);
    var select = jQuery('#' + type + '-select');
    var errorDiv = jQuery('#' + type + '-error');
    if (status === 'success') {
        if(select.prop) {
        var options = select.prop('options');
        }
        else {
        var options = select.attr('options');
        }
        jQuery('option', select).remove();

        options[options.length] = new Option(getDefaultOptionText(type), '');

        jQuery.each(results, function(i, result) {
            options[options.length] = buildOption(result, type);
        });
        select.removeClass( "npc-hidden" );
        errorDiv.addClass( "npc-hidden" );
    } else {
        console.error(results);
        errorDiv.children('span').text(getErrorText(type));
        errorDiv.removeClass( "npc-hidden" );
        select.addClass( "npc-hidden" );
    }
    formgroup.removeClass( "npc-hidden" );
}

function buildUpStreetSuggestions(status, results) {
    var streetMenu = jQuery('#up-street-menu');
    streetMenu.empty();
    streetCache = null;

    if (status === 'success') {
        if (results.length > 0) {
            var count = 0;
            var max = 5;
            streetCache = {};
            jQuery.each(results, function(i, result) {
                count++
                var suggested = result.street;
                var suggestedElement = '<a href="#" class="up-street-menu-item" onclick="extractUpPostcode(\'' + suggested + '\')">' + suggested + '</a>';
                streetMenu.append(suggestedElement);
                streetCache[result.street] = result;
                if (count === max) {
                    return false;
                }
            });
        } else {
            streetMenu.append('<p class="alert alert-info" role="alert">Not Found</p>');
        }
    } else {
        streetMenu.append('<p class="alert alert-danger" role="alert">Error occurred</p>');
    }
}   

function getErrorText(type) {
    if (type === 'rp-state'
         || type === 'up-state'
         || type === 'fp-state') {
        return 'Error fetching States';
    } else if (type === 'rp-lga'
             || type === 'fp-lga') {
        return 'Error fetching LGAs';
    } else if (type === 'rp-town' || type === 'up-town') {
        return 'Error fetching Towns';
    } else if (type === 'fp-facility') {
        return 'Error fetching Facilities';
    }
}

function getDefaultOptionText(type) {
    if (type === 'rp-state'
         || type === 'up-state'
         || type === 'fp-state') {
        return 'Select State';
    } else if (type === 'rp-lga'
             || type === 'fp-lga') {
        return 'Select LGA';
    } else if (type === 'rp-town') {
        return 'Select Town/Village';
    } else if (type === 'up-town') {
        return 'Select Town';
    } else if (type === 'fp-facility') {
        return 'Select Facility';
    }
}

function buildOption(result, type) {
    if (type === 'rp-state'
         || type === 'up-state'
         || type === 'fp-state') {
        return new Option(result.stateName, result.stateCode);;
    } else if (type === 'rp-lga'
             || type === 'fp-lga') {
        text = result.localGovernmentAreaName;
        value = result.localGovernmentAreaName + '|' + result.stateCode;
        return new Option(text, value);
    } else if (type === 'rp-town') {
        text = result.town;
        value = result.town + '|' + result.district + '|'
            + result.localGovernmentAreaName + '|' + result.stateName + '|' + result.postcode;
        return new Option(text, value);
    } else if (type === 'up-town') {
        text = result.town;
        value = result.town;
        return new Option(text, value);
    } else if (type === 'fp-facility') {
        text = result.facilityName;
        value = result.facilityName + '|'
            + result.localGovernmentAreaName + '|' + result.stateName + '|' + result.postcode;
        return new Option(text, value);
    }
}

function showUrbanStreetInput() {
    var streetMenu = jQuery('#up-street-menu');
    streetMenu.empty();
    var streetFormDiv = jQuery('#npc-up-street');
    streetFormDiv.removeClass( "npc-hidden" );

    var streetInput = jQuery('#up-street-input');
    streetInput.val('');

}

/** Custom Tab Url control */
jQuery(function(){
  var hash = window.location.hash;
  hash && jQuery('ul.nav a[href="' + hash + '"]').tab('show');

  jQuery('.nav-tabs a').click(function (e) {
    jQuery(this).tab('show');
    var scrollmem = jQuery('body').scrollTop() || jQuery('html').scrollTop();
    window.location.hash = this.hash;
    jQuery('html,body').scrollTop(scrollmem);
  });
});
