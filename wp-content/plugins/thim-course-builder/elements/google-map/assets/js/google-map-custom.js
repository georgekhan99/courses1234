/**
 * (c) Greg Priday, freely distributable under the terms of the GPL 2.0 license.
 */
(function ($) {
	"use strict";

	$(window).load(function () {
		thim_sc_googlemap.load();
	});


	var thim_sc_googlemap = window.thim_sc_googlemap = {

		load    : function () {
			if ($('.thim-sc-googlemap').length > 0) {
				if ($('.thim-sc-googlemap').data('cover')) {
					thim_sc_googlemap.cover();
				} else {
					thim_sc_googlemap.load_api();
				}
			}
		},
		load_api: function () {
			var apiKey = $('.ob-google-map-canvas').data('api_key');
			var apiUrl = 'https://maps.googleapis.com/maps/api/js?v=3.exp&callback=thim_sc_googlemap_init';

			if (apiKey) {
				apiUrl += '&key=' + apiKey;
			} else {
				var api = 'AIzaSyDNnrBbNMIqC2x_wTYJNEzHYSrMqQF-YVo';
				apiUrl += '&key=' + api;
			}
			var script = $('<script type="text/javascript" src="' + apiUrl + '"></script>');
			$('body').append(script);
		},

		cover: function () {
			$('.thim-sc-googlemap .map-cover').on('hover', function () {
				$(this).remove();
				thim_sc_googlemap.load_api();
			});
		}

	};


})(jQuery);


/**
 * function thim_shortcode_googlemap_init
 * create google map
 */
function thim_sc_googlemap_init() {
	thim_sc_googlemap_create_map(window.jQuery);
}


/**
 * create map
 * @param $ : jquery
 */
function thim_sc_googlemap_create_map($) {
	$('.ob-google-map-canvas').each(function () {
		var $$ = $(this);
		// We use the ob_geocoder
		var ob_geocoder = new google.maps.Geocoder();
		ob_geocoder.geocode({'address': $$.data('address')}, function (results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				var zoom = Number($$.data('zoom'));
				if (!zoom) zoom = 14;
				var userMapTypeId = 'user_map_style';
				var mapOptions = {
					zoom                 : zoom,
					scrollwheel          : Boolean($$.data('scroll-zoom')),
					//   draggable: Boolean( $$.data('draggable') ),
					center               : results[0].geometry.location,
					mapTypeControlOptions: {
						mapTypeIds: [google.maps.MapTypeId.ROADMAP, userMapTypeId]
					}
				};

				var map = new google.maps.Map($$.get(0), mapOptions);


				var userMapStyles = $$.data('style');

				var userMapOptions = {
					name: userMapStyles
				};

				var style_light = [{
					"featureType": "water",
					"elementType": "geometry",
					"stylers"    : [{"color": "#e9e9e9"}, {"lightness": 17}]
				}, {
					"featureType": "landscape",
					"elementType": "geometry",
					"stylers"    : [{"color": "#f5f5f5"}, {"lightness": 20}]
				}, {
					"featureType": "road.highway",
					"elementType": "geometry.fill",
					"stylers"    : [{"color": "#ffffff"}, {"lightness": 17}]
				}, {
					"featureType": "road.highway",
					"elementType": "geometry.stroke",
					"stylers"    : [{"color": "#ffffff"}, {"lightness": 29}, {"weight": 0.2}]
				}, {
					"featureType": "road.arterial",
					"elementType": "geometry",
					"stylers"    : [{"color": "#ffffff"}, {"lightness": 18}]
				}, {
					"featureType": "road.local",
					"elementType": "geometry",
					"stylers"    : [{"color": "#ffffff"}, {"lightness": 16}]
				}, {
					"featureType": "poi",
					"elementType": "geometry",
					"stylers"    : [{"color": "#f5f5f5"}, {"lightness": 21}]
				}, {
					"featureType": "poi.park",
					"elementType": "geometry",
					"stylers"    : [{"color": "#dedede"}, {"lightness": 21}]
				}, {
					"elementType": "labels.text.stroke",
					"stylers"    : [{"visibility": "on"}, {"color": "#ffffff"}, {"lightness": 16}]
				}, {
					"elementType": "labels.text.fill",
					"stylers"    : [{"saturation": 36}, {"color": "#333333"}, {"lightness": 40}]
				}, {"elementType": "labels.icon", "stylers": [{"visibility": "off"}]}, {
					"featureType": "transit",
					"elementType": "geometry",
					"stylers"    : [{"color": "#f2f2f2"}, {"lightness": 19}]
				}, {
					"featureType": "administrative",
					"elementType": "geometry.fill",
					"stylers"    : [{"color": "#fefefe"}, {"lightness": 20}]
				}, {
					"featureType": "administrative",
					"elementType": "geometry.stroke",
					"stylers"    : [{"color": "#fefefe"}, {"lightness": 17}, {"weight": 1.2}]
				}];

				if (userMapStyles && userMapStyles != 'default') {
					switch (userMapStyles) {
						case 'light':
							userMapStyles = style_light;
							break;
						default:
							break;
					}
					var userMapType = new google.maps.StyledMapType(userMapStyles, userMapOptions);

					map.mapTypes.set(userMapTypeId, userMapType);
					map.setMapTypeId(userMapTypeId);
				}

				if (Boolean($$.data('marker-at-center'))) {

					new google.maps.Marker({
						position: results[0].geometry.location,
						map     : map,
						//  draggable: Boolean( $$.data('markers-draggable') ),
						icon    : $$.data('marker-icon'),
						title   : ''
					});
				}
				var markerPositions = $$.data('marker-positions');
				if (markerPositions && markerPositions.length) {
					markerPositions.forEach(
						function (mrkr) {
							ob_geocoder.geocode({'address': mrkr.place}, function (res, status) {
								if (status == google.maps.GeocoderStatus.OK) {
									new google.maps.Marker({
										position: res[0].geometry.location,
										map     : map,
										// draggable: Boolean( $$.data('markers-draggable') ),
										icon    : $$.data('marker-icon'),
										title   : ''
									});
								}
							});
						}
					);
				}
				var directions = $$.data('directions');
				if (directions) {

					if (directions.waypoints && directions.waypoints.length) {
						directions.waypoints.map(
							function (wypt) {
								wypt.stopover = Boolean(wypt.stopover);
							}
						);
					}

					var directionsRenderer = new google.maps.DirectionsRenderer();
					directionsRenderer.setMap(map);

					var directionsService = new google.maps.DirectionsService();
					directionsService.route({
							origin           : directions.origin,
							destination      : directions.destination,
							travelMode       : directions.travelMode.toUpperCase(),
							avoidHighways    : Boolean(directions.avoidHighways),
							avoidTolls       : Boolean(directions.avoidTolls),
							waypoints        : directions.waypoints,
							optimizeWaypoints: Boolean(directions.optimizeWaypoints)

						},
						function (result, status) {
							if (status == google.maps.DirectionsStatus.OK) {
								directionsRenderer.setDirections(result);
							}
						});
				}
			}
			else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
				$$.append('<div><p><strong>There were no results for the place you entered. Please try another.</strong></p></div>');
			}
		});
	});
}