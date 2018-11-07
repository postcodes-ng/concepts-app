
var stateCache = null;
var streetCache = null;

jQuery(document).ready(function() {
	makeStateRequest();
});

/** Rural Event Handlers */
jQuery('#rp-state-select').on('change', function() {
    if (this.value !== '') {
        hideDiv('rp-result');
        hideDiv('npc-rp-village');
        hideDiv('npc-rp-area');
        makeLgaRequest( this.value, 'rp-loading',  buildRpLgaResult);
    }
});

jQuery('#rp-lga-select').on('change', function() {
    if (this.value !== '') {
        var valueList = this.value.split('|');
        const lgaSlug = valueList[0];
        const stateSlug = valueList[1];
        hideDiv('rp-result');
        hideDiv('npc-rp-village');
        makeRuralAreaRequest( lgaSlug, stateSlug );
    }
});

jQuery('#rp-area-select').on('change', function() {
    if (this.value !== '') {
        var valueList = this.value.split('|');
        const ruralAreaSlug = valueList[0];
        const lgaSlug = valueList[1];
        const stateSlug = valueList[2];
        hideDiv('rp-result');
        makeRuralVillageRequest( ruralAreaSlug, lgaSlug, stateSlug );
    }
});

jQuery('#rp-village-select').on('change', function() {
    if (this.value !== '') {
        hideDiv('rp-result');
        extractRpPostcode( this.value );
    }
});

/** Urban Event handlers */
jQuery('#up-state-select').on('change', function() {
    if (this.value !== '') {
        hideDiv('up-result');
        hideDiv('npc-up-street');
        hideDiv('npc-up-area');
        makeUrbanTownRequest( this.value, 'up-loading',  buildUpTownResult);
    }
});

jQuery('#up-town-select').on('change', function() {
    if (this.value !== '') {
        var valueList = this.value.split('|');
        const urbanTownSlug = valueList[0];
        const stateSlug = valueList[1];
        hideDiv('up-result');
        hideDiv('npc-up-street');
        makeUrbanAreaRequest( urbanTownSlug, stateSlug );
    }
});

jQuery('#up-area-select').on('change', function() {
    if (this.value !== '') {
        var valueList = this.value.split('|');
        const urbanAreaSlug = valueList[0];
        const urbanTownSlug = valueList[1];
        const stateSlug = valueList[2];
        hideDiv('up-result');
        makeUrbanStreetRequest( urbanAreaSlug, urbanTownSlug, stateSlug );
    }
});

jQuery('#up-street-select').on('change', function() {
    if (this.value !== '') {
        hideDiv('up-result');
        extractUpPostcode(this.value);
    }
});

/** Facility Event Handlers */
jQuery('#fp-state-select').on('change', function() {
    if (this.value !== '') {
        hideDiv('fp-result');
        hideDiv('npc-fp-facility');
        makeLgaRequest( this.value, 'fp-loading',  buildFpLgaResult);
    }
});

jQuery('#fp-lga-select').on('change', function() {
    if (this.value !== '') {
        var valueList = this.value.split('|');
        const lgaSlug = valueList[0];
        const stateSlug = valueList[1];
        hideDiv('fp-result');
        makeFacilitiesRequest( lgaSlug, stateSlug );
    }
});

jQuery('#fp-facility-select').on('change', function() {
    if (this.value !== '') {
        hideDiv('fp-result');
        extractFpPostcode( this.value );
    }
});

/** End of Event Handlers */

function makeStateRequest(spinnerId, responseHandler) {

    if (stateCache === null) {
        //start spinner
        startSpinner('page-loading');

        // Send to the server
        makeRequest('/api/lookup/states', 'GET', null, buildStateResult, 'page-loading');
    } else {
        buildStateResult('success', stateCache);
    }
    
}

function makeLgaRequest(stateSlug, spinnerId, responseHandler) {
	//start spinner
	startSpinner(spinnerId);

	// Send to the server
	makeRequest('/api/lookup/lgas?stateSlug=' + stateSlug, 'GET', null, responseHandler, spinnerId);
}

function makeRuralAreaRequest(lgaSlug, stateSlug) {
    //start spinner
    startSpinner('rp-loading');
	
	// Send to the server
	makeRequest('/api/lookup/ruralAreas?lgaSlug=' + lgaSlug + '&stateSlug=' + stateSlug, 'GET', null, buildRpAreaResult, 'rp-loading');
}

function makeRuralVillageRequest(ruralAreaSlug, lgaSlug, stateSlug) {
    //start spinner
    startSpinner('rp-loading');
	
	// Send to the server
	makeRequest('/api/lookup/ruralVillages?ruralAreaSlug=' + ruralAreaSlug + '&lgaSlug=' + lgaSlug + '&stateSlug=' + stateSlug, 'GET', null, buildRpTownResult, 'rp-loading');
}

function makeUrbanTownRequest(stateSlug, spinnerId, responseHandler) {
	
	//start spinner
	startSpinner(spinnerId);

	// Send to the server
	makeRequest('/api/lookup/urbanTowns?stateSlug='+stateSlug, 'GET', null, responseHandler, spinnerId);
}

function makeUrbanAreaRequest(urbanTownSlug, stateSlug) {
    //start spinner
    startSpinner('up-loading');
	
	// Send to the server
	makeRequest('/api/lookup/urbanAreas?urbanTownSlug=' + urbanTownSlug + '&stateSlug=' + stateSlug, 'GET', null, buildUpAreaResult, 'up-loading');
}

function makeUrbanStreetRequest(urbanAreaSlug, urbanTownSlug, stateSlug) {
    //start spinner
    startSpinner('up-loading');
	
	// Send to the server
	makeRequest('/api/lookup/urbanStreets?urbanAreaSlug=' + urbanAreaSlug + '&urbanTownSlug=' + urbanTownSlug + '&stateSlug=' + stateSlug, 'GET', null, buildUpStreetResult, 'up-loading');
}

function makeFacilitiesRequest(lgaSlug, stateSlug) {
    //start spinner
    startSpinner('fp-loading');
	
	// Send to the server
	makeRequest('/api/lookup/facilities?lgaSlug=' + lgaSlug + '&stateSlug=' + stateSlug, 'GET', null, buildFpFacilityResult, 'fp-loading');
}

function extractRpPostcode(value) {
    var values = value.split('|');
    var village = values[0];
    var lga = values[1];
    var postcode = values[2];

    var resultDiv = jQuery('#rp-result');
    var postcodesList = jQuery('#rp-result-postcodes');
    postcodesList.empty();
    jQuery('#rp-result-village').text(village);
    jQuery('#rp-result-lga').text(lga);
    jQuery('#rp-result-relationship').text("is within this postcode");

    var Objli = $('<li></li>');
    var Objh3 = $('<h3></h3>');

    Objh3.text(postcode);
    Objli.append(Objh3);
    postcodesList.append(Objli);

    resultDiv.removeClass( "npc-hidden" );
}

function extractUpPostcode(value) {
    var values = value.split('|');
    var street = values[0];
    var town = values[1];
    var postcode = values[2];

    var resultDiv = jQuery('#up-result');
    var postcodesList = jQuery('#up-result-postcodes');
    postcodesList.empty();
    jQuery('#up-result-street').text(street);
    jQuery('#up-result-town').text(town);
    jQuery('#up-result-relationship').text("is within this postcode");

    var Objli = $('<li></li>');
    var Objh3 = $('<h3></h3>');

    Objh3.text(postcode);
    Objli.append(Objh3);
    postcodesList.append(Objli);

    resultDiv.removeClass( "npc-hidden" );
}

function extractFpPostcode(value) {
    var values = value.split('|');
    var facility = values[0];
    var lga = values[1];
    var postcode = values[2];

    var resultDiv = jQuery('#fp-result');
    jQuery('#fp-result-facility').text(facility);
    jQuery('#fp-result-lga').text(lga);
    jQuery('#fp-result-postcode').text(postcode);

    resultDiv.removeClass( "npc-hidden" );

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

function buildRpAreaResult(status, results) {
    buildSelectResult(status, results, 'rp-area');
}

function buildRpTownResult(status, results) {
    buildSelectResult(status, results, 'rp-village');
}

function buildUpTownResult(status, results) {
    buildSelectResult(status, results, 'up-town');
}

function buildUpAreaResult(status, results) {
    buildSelectResult(status, results, 'up-area');
}

function buildUpStreetResult(status, results) {
    buildSelectResult(status, results, 'up-street');
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
                var suggested = result.urbanStreetName;
                var suggestedElement = '<a href="#" class="up-street-menu-item" onclick="extractUpPostcode(\'' + suggested + '\')">' + suggested + '</a>';
                streetMenu.append(suggestedElement);
                streetCache[result.urbanStreetName] = result;
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
    } else if (type === 'up-town') {
        return 'Error fetching Urban Towns';
    } else if (type === 'up-area') {
        return 'Error fetching Urban Areas';
    } else if (type === 'up-street') {
        return 'Error fetching Urban Streets';
    } else if (type === 'rp-area') {
        return 'Error fetching Rural Areas';
    } else if (type === 'rp-village') {
        return 'Error fetching Rural Villages';
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
    } else if (type === 'rp-area') {
        return 'Select Rural Area';
    } else if (type === 'rp-village') {
        return 'Select Village';
    } else if (type === 'up-town') {
        return 'Select Town';
    } else if (type === 'up-area') {
        return 'Select Urban Area';
    } else if (type === 'up-street') {
        return 'Select Street';
    } else if (type === 'fp-facility') {
        return 'Select Facility';
    }
}

function buildOption(result, type) {
    if (type === 'rp-state'
         || type === 'up-state'
         || type === 'fp-state') {
        return new Option(result.stateName, result.stateSlug);
    } else if (type === 'rp-lga'
             || type === 'fp-lga') {
        text = result.lgaName;
        value = result.lgaSlug + '|' + result.stateSlug;
        return new Option(text, value);
    } else if (type === 'rp-area') {
        text = result.ruralAreaName;
        value = result.ruralAreaSlug + '|' + result.lgaSlug + '|' + result.stateSlug;
        return new Option(text, value);
    } else if (type === 'rp-village') {
        text = result.villageName;
        value = result.villageName + '|'
        + result.lgaName + '|' + result.postcode;
        return new Option(text, value);
    } else if (type === 'up-area') {
        text = result.urbanAreaName;
        value = result.urbanAreaSlug + '|' + result.urbanTownSlug + '|' + result.stateSlug;
        return new Option(text, value);
    } else if (type === 'up-town') {
        text = result.urbanTownName;
        value = result.urbanTownSlug + '|' + result.stateSlug;
        return new Option(text, value);
    } else if (type === 'up-street') {
        text = result.streetName;
        value = result.streetName + '|'
        + result.urbanTownName + '|' + result.postcode;
        return new Option(text, value);
    } else if (type === 'fp-facility') {
        text = result.facilityName;
        value = result.facilityName + '|'
            + result.lgaName + '|' + result.postcode;
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
