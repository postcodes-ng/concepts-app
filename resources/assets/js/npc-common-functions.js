/**
 * Below are common functions for the NPC Concepts App
 */

startGlobalSpinner = function () {
	var globalSpinnerTarget = document.getElementById('mdl-spinner-global');
	globalSpinnerTarget.classList.remove('npc-hide');
	globalSpinnerTarget.classList.add('is-active');
	globalSpinnerTarget.classList.add('npc-show');
}
stopGlobalSpinner = function () {
	var globalSpinnerTarget = document.getElementById('mdl-spinner-global');
	globalSpinnerTarget.classList.remove('is-active');
	globalSpinnerTarget.classList.remove('npc-show');
	globalSpinnerTarget.classList.add('npc-hide');
}

/**
 * Make Ajax request.
 * 
 * @param url
 * @param method
 * @param data
 * @param customResponseHandler
 * @param spinnerId
 * @returns
 */
makeRequest = function (endpoint, method, data, customResponseHandler = null, spinnerId = null, contentType = 'application/json', headers = null) {
    httpRequest = new XMLHttpRequest();

    if (!httpRequest) {
      console.error('Giving up :( Cannot create an XMLHTTP instance');
      return false;
    }
    
    httpRequest.onreadystatechange = function() {
    	if (httpRequest.readyState === XMLHttpRequest.DONE) {
    	      if (httpRequest.status === 200) {
    	    	  
                  response = JSON.parse(httpRequest.responseText);
                  //console.log(response);
    	    	  if (customResponseHandler !== null) {
    	    		  customResponseHandler('success', response.response);
    	    	  }
    	      } else {
                  response = JSON.parse(httpRequest.responseText);
                  console.error(response);
    	    	  if (customResponseHandler !== null) {
    	    		  customResponseHandler('error', response.message);
    	    	  }
    	      }
    	      if (spinnerId) {
    	    	  stopSpinner(spinnerId);
    	      }
    	      
    	    }
    };
    
    httpRequest.open(method, buildUrl(endpoint));
    httpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    httpRequest.setRequestHeader('X-CSRF-TOKEN', window.Laravel.csrfToken);

    if (headers !== null) {
    	Object.keys(headers).forEach(function(key) {
        	httpRequest.setRequestHeader(key, headers[key]);
        });
    }
    
    if (method === 'POST' && contentType !== false) {
    	httpRequest.setRequestHeader('Content-Type', contentType);
    }
    makePreRequest(httpRequest, data);
}

function makePreRequest(primaryHttpRequest, data) {
    preHttpRequest = new XMLHttpRequest();

    if (!preHttpRequest) {
      console.error('Giving up :( Cannot create an XMLHTTP instance for pre request');
      return false;
    }

    preHttpRequest.onreadystatechange = function() {
    	if (preHttpRequest.readyState === XMLHttpRequest.DONE) {
    	      if (preHttpRequest.status === 200) {
    	    	  
                  response = JSON.parse(preHttpRequest.responseText);
                  //console.log(response);
    	    	  const apiToken = response.response.apiToken;
                  primaryHttpRequest.setRequestHeader('Authorization', 'Bearer ' + apiToken);
                  primaryHttpRequest.send(data);
    	      } else if (preHttpRequest.status === 403) {
                alert('Your Session has expired. Please refresh your window.')
              } else {
                console.error('Pre-request failed.');
    	      }
    	    }
    };

    preHttpRequest.open('GET', buildUrl('/api/token'));

    preHttpRequest.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    preHttpRequest.setRequestHeader('Authorization', 'Bearer ' + window.Laravel.webJWT);
    preHttpRequest.send();
}

fade = function (element, interval) {
    var op = 1;  // initial opacity
    element.style.display = 'inline';
    var timer = setInterval(function () {
        if (op <= 0.1){
            clearInterval(timer);
            element.style.display = 'none';
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op -= op * 0.1;
    }, interval);
}

unfade = function (element, interval) {
    var op = 0.1;  // initial opacity
    element.style.display = 'block';
    var timer = setInterval(function () {
        if (op >= 1){
            clearInterval(timer);
        }
        element.style.opacity = op;
        element.style.filter = 'alpha(opacity=' + op * 100 + ")";
        op += op * 0.1;
    }, interval);
}

buildUrl = function (endpoint) {
	var url = window.location.protocol +'//' + window.location.hostname + endpoint;
	
	return url;
}

goTo = function (relativeUrl) {
	window.location.href = window.location.protocol +'//' + window.location.hostname + relativeUrl;
}

redirectTo = function (relativeUrl) {
	window.location.replace(window.location.protocol +'//' + window.location.hostname + relativeUrl);
}

startSpinner = function (spinnerId) {
    var spinner = jQuery('#'+spinnerId);
    spinner.removeClass('npc-hidden');
}

stopSpinner = function (spinnerId) {
    var spinner = jQuery('#'+spinnerId);
    spinner.addClass('npc-hidden');
}

hideDiv = function(id) {
    var targetDiv = jQuery('#' + id);
    targetDiv.addClass( "npc-hidden" );
}

