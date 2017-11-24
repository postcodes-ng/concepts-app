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
/******/ 	return __webpack_require__(__webpack_require__.s = 51);
/******/ })
/************************************************************************/
/******/ ({

/***/ 51:
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(52);


/***/ }),

/***/ 52:
/***/ (function(module, exports) {

var state = '';
var lga = '';
var infoWindow = null;
var npcMarkers = [];
var markerImage = '/img/geolocation-marker.png';
var nigeriaAdminLevel2Geojson = 'https://opendata.arcgis.com/datasets/6bb5e3eb654645ae944a697208b830ff_0.geojson';

initW3wMap = function initW3wMap() {
  var abuja = { lat: 9.027522, lng: 7.240537 };
  var map = new google.maps.Map(document.getElementById('npc-map'), {
    zoom: 7,
    minZoom: 7,
    center: abuja,
    mapTypeId: 'roadmap'
  });

  map.data.loadGeoJson(nigeriaAdminLevel2Geojson);

  map.data.setStyle({
    fillColor: 'green',
    fillOpacity: 0.1,
    strokeWeight: 2
  });

  map.data.addListener('click', function (e) {
    placeMarkerAndPanTo(e.latLng, map, e.feature);
    map.data.revertStyle();
    map.data.overrideStyle(e.feature, { fillColor: 'yellow' });
  });
};

function placeMarkerAndPanTo(latLng, map, feature) {
  closeInfoWindow();
  deleteMarkers();
  var marker = addMarker(latLng, map, feature);
  map.panTo(latLng);

  openInfoWindow(latLng, map, marker, feature);
}

function openInfoWindow(latLng, map, marker, feature) {
  infoWindow = new google.maps.InfoWindow({
    content: getInfoWindowContentTemplate()
  });
  clearEntityNames();
  setEntityNames(feature.getProperty('ADM1_NAME'), feature.getProperty('ADM2_NAME'));
  infoWindow.open(map, marker);
  getWha3WordsAddress(latLng.lat(), latLng.lng());
}

function closeInfoWindow() {
  if (infoWindow !== null) {
    infoWindow.close();
  }
  infoWindow = null;
}

// Adds a marker to the map and push to the array.
function addMarker(location, map, feature) {
  var marker = new google.maps.Marker({
    position: location,
    map: map,
    icon: markerImage
  });

  marker.addListener('click', function () {
    //infowindow.open(marker.get('map'), marker);
    closeInfoWindow();
    openInfoWindow(location, map, marker, feature);
  });
  npcMarkers.push(marker);
  return marker;
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
  for (var i = 0; i < npcMarkers.length; i++) {
    npcMarkers[i].setMap(null);
  }
  npcMarkers = [];
}

function getWha3WordsAddress(lat, lng) {
  var spinnerId = "iwc-loading";
  //start spinner
  startSpinner(spinnerId);

  var result = makeRequest('/api/map/w3wAddress?latitude=' + lat + '&longitude=' + lng, 'GET', null, w3wResponseHandler, spinnerId);
}

function w3wResponseHandler(status, result) {
  var infoWindowContentList = jQuery('#npc-ifc-list');
  var infoWindowContentError = jQuery('#npc-ifc-error');
  infoWindowContentList.empty();
  if (status === 'success') {
    var listItem1 = buildInfoWindowContent('what3words', result.w3wAddress, '/img/w3w/what3words-logo.png');
    var listItem2 = buildInfoWindowContent('LGA', lga, '/img/geolocation-marker-main.png');
    var listItem3 = buildInfoWindowContent('State', state, '/img/geolocation-marker-main.png');
    infoWindowContentList.append(listItem1);
    infoWindowContentList.append(listItem2);
    infoWindowContentList.append(listItem3);

    infoWindowContentError.addClass("npc-hidden");
    infoWindowContentList.removeClass("npc-hidden");
  } else {
    infoWindowContentError.children('span').text("Error fetching content");

    infoWindowContentList.addClass("npc-hidden");
    infoWindowContentError.removeClass("npc-hidden");
  }
}

function getInfoWindowContentTemplate() {
  return '<div id="npc-infoWindowContent">' + '<div id="iwc-loading" class="npc-spinner-small npc-hidden"></div>' + '<div id="npc-ifc-list" class="npc-hidden"></div>' + '<div id="npc-ifc-error"  class="npc-hidden"><span></span></div>' + '</div>';
}

function buildInfoWindowContent(itemKeyText, itemValueText, itemImageUrl) {
  var listItem = $('<p></p>');
  var itemImage = $('<img width="20" height="20" src="' + itemImageUrl + '" />');
  var itemKey = $('<strong></strong>');
  var itemValue = $('<span></span>');

  itemKey.text(' ' + itemKeyText + ' : ');
  itemValue.text(itemValueText);

  listItem.append(itemImage);
  listItem.append(itemKey);
  listItem.append(itemValue);

  return listItem;
}

function setEntityNames(st, lg) {
  state = st;
  lga = lg;
}

function clearEntityNames() {
  state = '';
  lga = '';
}

/***/ })

/******/ });