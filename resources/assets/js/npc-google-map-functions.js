var state = '';
var lga = '';
var infoWindow = null;
var npcMarkers = [];
var markerImage = '/img/geolocation-marker.png';
var nigeriaAdminLevel2Geojson = 'https://opendata.arcgis.com/datasets/6bb5e3eb654645ae944a697208b830ff_0.geojson';

initNpcMap = function () {
    var abuja = {lat: 9.027522, lng: 7.240537};
    var map = new google.maps.Map(document.getElementById('npc-map'), {
      zoom: 7,
      minZoom: 7,
      center: abuja,
      mapTypeId: 'roadmap',
      gestureHandling: 'greedy'
    });

    map.data.loadGeoJson(nigeriaAdminLevel2Geojson);

    map.data.setStyle({
        fillColor: 'green',
        fillOpacity: 0.1,
        strokeWeight: 2
      });

    map.data.addListener('click', function(e) {
        placeMarkerAndPanTo(e.latLng, map, e.feature);
        map.data.revertStyle();
        map.data.overrideStyle(e.feature, {fillColor: 'yellow'});
    });

  }

  function placeMarkerAndPanTo(latLng, map, feature) {
    closeInfoWindow();
    deleteMarkers();
    var marker = addMarker(latLng, map, feature);
    map.panTo(latLng);

    openInfoWindow(latLng, map, marker, feature);

  }

  function openInfoWindow(latLng, map, marker, feature)
  {
    infoWindow = new google.maps.InfoWindow({
        content: getInfoWindowContentTemplate()
    });
    clearEntityNames();
    setEntityNames(feature.getProperty('ADM1_NAME'), feature.getProperty('ADM2_NAME'));
    infoWindow.open(map, marker)
    getWha3WordsAddress(latLng.lat(), latLng.lng());

  }

  function closeInfoWindow()
  {
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

    
    marker.addListener('click', function() {
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

  function getWha3WordsAddress(lat, lng)
  {
    var spinnerId = "iwc-loading";
    //start spinner
    startSpinner(spinnerId);

    var result = makeRequest('/api/map/w3wAddress?latitude='+lat+'&longitude='+lng, 'GET', null, w3wResponseHandler, spinnerId);
  }

  function w3wResponseHandler(status, result)
  {
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

        infoWindowContentError.addClass( "npc-hidden" );
        infoWindowContentList.removeClass( "npc-hidden" );
    } else {
        infoWindowContentError.children('span').text("Error fetching content");

        infoWindowContentList.addClass( "npc-hidden" );
        infoWindowContentError.removeClass( "npc-hidden" );
    }

  }

  function getInfoWindowContentTemplate()
  {
      return '<div id="npc-infoWindowContent">' +
      '<div id="iwc-loading" class="npc-spinner-small npc-hidden"></div>' +
      '<div id="npc-ifc-list" class="npc-hidden"></div>' +
      '<div id="npc-ifc-error"  class="npc-hidden"><span></span></div>' +
      '</div>';
  }

  function buildInfoWindowContent(itemKeyText, itemValueText, itemImageUrl)
  {
    var listItem = $('<p></p>');
    var itemImage = $('<img width="20" height="20" src="'+itemImageUrl+'" />');
    var itemKey = $('<strong></strong>');
    var itemValue = $('<span></span>');

    itemKey.text(' '+itemKeyText+' : ');
    itemValue.text(itemValueText);

    listItem.append(itemImage);
    listItem.append(itemKey);
    listItem.append(itemValue);

    return listItem;
  }

  function setEntityNames(st, lg)
  {
    state = st;
    lga = lg;
  }

  function clearEntityNames()
  {
      state = '';
      lga = '';
  }

