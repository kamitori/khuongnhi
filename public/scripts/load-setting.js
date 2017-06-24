themerUpdateColors(themerPrimaryColor, themerMenuColor);
var scrollers = [];
var mainYScroller;

$(function() {
	//document.addEventListener('touchmove', function(e){ e.preventDefault(); });
	var xScrollers = document.getElementsByClassName("scroll-x");
	for (var i = 0; i < xScrollers.length; i++)
		scrollers.push(new iScroll(xScrollers[i], {
			vScroll: false,
			hideScrollbar: true,
			onBeforeScrollStart: function(e) {
				var target = e.target;
				while (target.nodeType != 1) target = target.parentNode;

				if (target.tagName != 'SELECT' && target.tagName != 'INPUT' && target.tagName != 'TEXTAREA')
					e.preventDefault();
			}
		}));

	var yScrollers = $('.scroll-y').not('#mainYScroller');
	$.each(yScrollers, function(i, v) {
		var scroller = new iScroll($(v).attr('id'), {
			hScroll: false,
			hideScrollbar: true,
			onBeforeScrollStart: function(e) {
				var target = e.target;
				while (target.nodeType != 1) target = target.parentNode;

				if (target.tagName != 'SELECT' &&
					target.tagName != 'INPUT' &&
					target.tagName != 'TEXTAREA' &&
					$(target).parents('table-responsive').size() == 0)
					e.preventDefault();
			}
		});
		scrollers.push(scroller);
	});

});

if (typeof skin == 'undefined') { var skin = ''; }

if (typeof JSON == 'undefined')
{
	var JSON = JSON || {};
	//implement JSON.stringify serialization
	JSON.stringify = JSON.stringify || function(obj) {
		var t = typeof (obj);
		if (t != "object" || obj === null) {
			// simple data type
			if (t == "string")
				obj = '"' + obj + '"';
			return String(obj);
		} else {
			// recurse array or object
			var n, v, json = [], arr = (obj && obj.constructor == Array);
			for (n in obj) {
				v = obj[n];
				t = typeof (v);
				if (t == "string")
					v = '"' + v + '"';
				else if (t == "object" && v !== null)
					v = JSON.stringify(v);
				json.push((arr ? "" : '"' + n + '":') + String(v));
			}
			return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
		}
	};
}

/*
function scrollTo(id)
{
	$('html,body').animate({scrollTop: $("#"+id).offset().top},'slow');
}
*/

var MENU_JS,
	colMainLeftScroller,
	menuPosition,
	refreshScrollers,
	menuSize = null;

$(function()
{
	
	/*
	 * Toggle menu position: Footer navbar
	 */
	$('#footer [data-toggle="menu-position"]').on('click', function(e)
	{
		e.preventDefault();
		var p = $(this).attr('data-menu-position');
		
		menuTogglePosition(p);
	})
	.parent().removeClass('active')
	.find('[data-menu-position="'+menuPosition+'"]')
	.parent().addClass('active');
	
	
	/*
	 * Toggle menu size: Footer navbar
	 */
	$('#footer [data-toggle="menu-size"]').on('click', function(e)
	{
		e.preventDefault();
		var s = $(this).attr('data-menu-size');
		
		menuToggleSizeHelper(s);
	})
	.parent().removeClass('active')
	.find('[data-menu-size="'+menuSize+'"]')
	.parent().addClass('active');
	
	/*
	 * Toggle menu size: Themer options
	 */
	var themerMenuSizeSelect = $('#themer-menu-size');
	$.each(themerMenuSizes, function( i, p ) {
		var option = $('<option data-className="' + p.className + '"></option>').text(p.name).val(i);
		themerMenuSizeSelect.append(option);
	});
	themerMenuSizeSelect.on('change', function(e) 
	{
		e.preventDefault();
		menuToggleSizeHelper(themerMenuSizeSelect.val());
	});
	if (themerMenuSizeSelect.length)
		themerMenuSizeSelect.val(menuSize);
	
	/*
	 * Enable/Disable Themer menu options
	 */
	function themerMenuOptionsToggle(disable)
	{
		var o = [themerMenuPositionSelect, themerMenuSizeSelect];
		$.each(o, function(k,v)
		{
			v.prop('disabled', disable);
			if (disable === true) v.parent().tooltip({ placement: 'left', title: "Layout options in this section are disabled" });
		});
	}
	
	
	
	
	var registerInit = false;
	$('.btn-register a').click(function(e)
	{
		e.preventDefault();
		colMainLeft.stop().animate({ width: '0px' }, 250, function()
		{
			$(this).addClass('hidden-phone');
			if (!registerInit)
			{
				$('.positionWrapper.registerWrapper')
					.css({
						position: 'absolute',
						left: $(document).width()/2 - $('.positionWrapper.registerWrapper').width()/2,
						top: -$('.positionWrapper.registerWrapper').height()
					})
					.removeClass('hide')
					.animate({
						top: 0,
						paddingTop: ($('.col.main-right .rrow').height()*0.05),
						paddingBottom: ($('.col.main-right .rrow').height()*0.05) + $('.btn-login').height()
					}, 1000, function(){
						$(this).parents('div:first').height($(this).outerHeight());
						$(window).resize();
						registerInit = true;
					});
				
				$('.navbar.main .btn-navbar').removeClass('hide');
			}
		});
	});

	
	var allowSubmit = false;
	$('form.fts').submit(function(e)
	{
		if (allowSubmit) return true;
		
		e.preventDefault();
		var fts = $(this);
		$('.navbar.main').find('*').fadeOut(500);
		colMainRight.find('*').hide();
		colMainLeft.animate({ width: 0 }, 500, function()
		{
			allowSubmit = true;
			fts.submit();
		});
	});
	
	
	
	$("[rel='tooltip']").tooltip();
	$("[rel='popover']").popover();
	

	
	$('.disable-click').click(function(e){ e.preventDefault(); });
	
	

	
	/* wysihtml5 */
	if ($('textarea.wysihtml5').size() > 0)
		$('textarea.wysihtml5').wysihtml5();
	
	/* DataTables */
	if ($('.dynamicTable').size() > 0)
	{
		$('.dynamicTable').dataTable({
			"sPaginationType": "bootstrap",
			"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
			"oLanguage": {
				"sLengthMenu": "_MENU_ records per page"
			}
		});
	}
	
	/*
	 * Helper function for JQueryUI Sliders Create event
	 */
	function JQSliderCreate()
	{
		$(this)
			.removeClass('ui-corner-all ui-widget-content')
			.wrap('<span class="ui-slider-wrap"></span>')
			.find('.ui-slider-handle')
			.removeClass('ui-corner-all ui-state-default');
	}
	
	/*
	 * JQueryUI Slider: Default slider
	 */
	if ($('.slider-single').size() > 0)
	{
		$( ".slider-single" ).slider({
			create: JQSliderCreate,
			value: 10,
			animate: true,
			start: function() { if (typeof mainYScroller != 'undefined') mainYScroller.disable(); },
			stop: function() { if (typeof mainYScroller != 'undefined') mainYScroller.enable(); }
		});
	}
	
	/*
	 * JQueryUI Slider: Multiple Vertical Sliders
	 */
	$( ".sliders-vertical > span" ).each(function() 
	{
		var value = parseInt( $( this ).text(), 10 );
		$( this ).empty().slider({
			create: JQSliderCreate,
			value: value,
			range: "min",
			animate: true,
			orientation: "vertical",
			start: function() { if (typeof mainYScroller != 'undefined') mainYScroller.disable(); },
			stop: function() { if (typeof mainYScroller != 'undefined') mainYScroller.enable(); }
		});
	});
	
	/*
	 * JQueryUI Slider: Range Slider
	 */
	if ($('.range-slider').size() > 0)
	{
		$( ".range-slider .slider" ).slider({
			create: JQSliderCreate,
			range: true,
			min: 0,
			max: 500,
			values: [ 75, 300 ],
			slide: function( event, ui ) {
				$( ".range-slider #amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
			},
			start: function() { if (typeof mainYScroller != 'undefined') mainYScroller.disable(); },
			stop: function() { if (typeof mainYScroller != 'undefined') mainYScroller.enable(); }
		});
		$( ".range-slider #amount" ).val( "$" + $( ".range-slider .slider" ).slider( "values", 0 ) +
				" - $" + $( ".range-slider .slider" ).slider( "values", 1 ) );
	}
	
	/*
	 * JQueryUI Slider: Snap to Increments
	 */
	if ($('.increments-slider').size() > 0)
	{
		$( ".increments-slider .slider" ).slider({
			create: JQSliderCreate,
			value:100,
			min: 0,
			max: 500,
			step: 50,
			slide: function( event, ui ) {
				$( ".increments-slider #amount" ).val( "$" + ui.value );
			},
			start: function() { if (typeof mainYScroller != 'undefined') mainYScroller.disable(); },
			stop: function() { if (typeof mainYScroller != 'undefined') mainYScroller.enable(); }
		});
		$( ".increments-slider #amount" ).val( "$" + $( ".increments-slider .slider" ).slider( "value" ) );
	}
	
	/*
	 * JQueryUI Slider: Vertical Range Slider
	 */
	if ($('.vertical-range-slider').size() > 0)
	{
		$( ".vertical-range-slider .slider" ).slider({
			create: JQSliderCreate,
			orientation: "vertical",
			range: true,
			min: 0,
			max: 500,
			values: [ 100, 400 ],
			slide: function( event, ui ) {
				$( ".vertical-range-slider #amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
			},
			start: function() { if (typeof mainYScroller != 'undefined') mainYScroller.disable(); },
			stop: function() { if (typeof mainYScroller != 'undefined') mainYScroller.enable(); }
		});
		$( ".vertical-range-slider #amount" ).val( "$" + $( ".vertical-range-slider .slider" ).slider( "values", 0 ) +
				" - $" + $( ".vertical-range-slider .slider" ).slider( "values", 1 ) );
	}
	
	/*
	 * JQueryUI Slider: Range fixed minimum
	 */
	if ($('.slider-range-min').size() > 0)
	{
		$( ".slider-range-min .slider" ).slider({
			create: JQSliderCreate,
			range: "min",
			value: 150,
			min: 1,
			max: 700,
			slide: function( event, ui ) {
				$( ".slider-range-min #amount" ).val( "$" + ui.value );
			},
			start: function() { if (typeof mainYScroller != 'undefined') mainYScroller.disable(); },
			stop: function() { if (typeof mainYScroller != 'undefined') mainYScroller.enable(); }
		});
		$( ".slider-range-min #amount" ).val( "$" + $( ".slider-range-min .slider" ).slider( "value" ) );
	}
	
	/*
	 * JQueryUI Slider: Range fixed maximum
	 */
	if ($('.slider-range-max').size() > 0)
	{
		$( ".slider-range-max .slider" ).slider({
			create: JQSliderCreate,
			range: "max",
			min: 1,
			max: 700,
			value: 150,
			slide: function( event, ui ) {
				$( ".slider-range-max #amount" ).val( "$" + ui.value );
			},
			start: function() { if (typeof mainYScroller != 'undefined') mainYScroller.disable(); },
			stop: function() { if (typeof mainYScroller != 'undefined') mainYScroller.enable(); }
		});
		$( ".slider-range-max #amount" ).val( "$" + $( ".slider-range-max .slider" ).slider( "value" ) );
	}
	
	/*
	 * Boostrap Extended
	 */
	// custom select for Boostrap using dropdowns
	$('.selectpicker').selectpicker();
	
	// bootstrap-toggle-buttons
	$('.toggle-button').toggleButtons();
	
	// dropdown hover
	//$('.dropdown-toggle').dropdownHover();
	
	/*
	 * UniformJS: Sexy form elements
	 */
	$('.uniformjs').find("select, input, button, textarea").uniform();
	
	// colorpicker
	if ($('#colorpicker').size() > 0)
	{
		$('#colorpicker').farbtastic('#colorpickerColor');
	}
	// datepicker
	if ($('#datepicker').length) 
	{
		$("#datepicker").datepicker({
			showOtherMonths:true
		});
	}
	if ($('#datepicker-inline').length)
	{
		$('#datepicker-inline').datepicker({
			inline: true,
			showOtherMonths:true
		});
	}
	
	// bookings daterange
	if ($('#dateRangeFrom').length && $('#dateRangeTo').length)
	{
		$( "#dateRangeFrom" ).datepicker({
			defaultDate: "+1w",
			changeMonth: false,
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
				$( "#dateRangeTo" ).datepicker( "option", "minDate", selectedDate );
			}
		}).datepicker( "option", "maxDate", $('#dateRangeTo').val() );

		$( "#dateRangeTo" ).datepicker({
			defaultDate: "+1w",
			changeMonth: false,
			numberOfMonths: 2,
			onClose: function( selectedDate ) {
				$( "#dateRangeFrom" ).datepicker( "option", "maxDate", selectedDate );
			}
		}).datepicker( "option", "minDate", $('#dateRangeFrom').val() );
	}
	
	$('.checkboxs thead :checkbox').change(function(){
		if ($(this).is(':checked'))
		{
			$('.checkboxs tbody :checkbox').prop('checked', true).parent().addClass('checked');
			$('.checkboxs tbody tr.selectable').addClass('selected');
			$('.checkboxs_actions').show();
		}
		else
		{
			$('.checkboxs tbody :checkbox').prop('checked', false).parent().removeClass('checked');
			$('.checkboxs tbody tr.selectable').removeClass('selected');
			$('.checkboxs_actions').hide();
		}
	});
	
	$('.checkboxs tbody').on('click', 'tr.selectable', function(e){
		var c = $(this).find(':checkbox');
		var s = $(e.srcElement);
		
		if (e.srcElement.nodeName == 'INPUT')
		{
			if (c.is(':checked'))
				$(this).addClass('selected');
			else
				$(this).removeClass('selected');
		}
		else if (e.srcElement.nodeName != 'TD' && e.srcElement.nodeName != 'TR' && e.srcElement.nodeName != 'DIV')
		{
			return true;
		}
		else
		{
			if (c.is(':checked'))
			{
				c.prop('checked', false).parent().removeClass('checked');
				$(this).removeClass('selected');
			}
			else
			{
				c.prop('checked', true).parent().addClass('checked');
				$(this).addClass('selected');
			}
		}
		if ($('.checkboxs tr.selectable :checked').size() == $('.checkboxs tr.selectable :checkbox').size())
			$('.checkboxs thead :checkbox').prop('checked', true).parent().addClass('checked');
		else
			$('.checkboxs thead :checkbox').prop('checked', false).parent().removeClass('checked');

		if ($('.checkboxs tr.selectable :checked').size() >= 1)
			$('.checkboxs_actions').show();
		else
			$('.checkboxs_actions').hide();
	});
	
	if ($('.checkboxs tbody :checked').size() == $('.checkboxs tbody :checkbox').size() && $('.checkboxs tbody :checked').length)
		$('.checkboxs thead :checkbox').prop('checked', true).parent().addClass('checked');
	
	if ($('.checkboxs tbody :checked').length)
		$('.checkboxs_actions').show();
	
	$('.radioboxs tbody tr.selectable').click(function(e){
		var c = $(this).find(':radio');
		if (e.srcElement.nodeName == 'INPUT')
		{
			if (c.is(':checked'))
				$(this).addClass('selected');
			else
				$(this).removeClass('selected');
		}
		else if (e.srcElement.nodeName != 'TD' && e.srcElement.nodeName != 'TR')
		{
			return true;
		}
		else
		{
			if (c.is(':checked'))
			{
				c.attr('checked', false);
				$(this).removeClass('selected');				
			}
			else
			{
				c.attr('checked', true);
				$('.radioboxs tbody tr.selectable').removeClass('selected');
				$(this).addClass('selected');
			}
		}
	});
	
	// Knob
	if ($('.knob').length)
	{
		$('.knob').knob({
			draw: function() 
			{
				if ($(this.i).attr('data-prepend'))
					$(this.i).val($(this.i).attr('data-prepend') + this.cv);
			}
		});
	}
	
	// sortable tables
	if ($( ".js-table-sortable" ).length)
	{	
		$( ".js-table-sortable" ).sortable(
		{
			placeholder: "ui-state-highlight",
			items: "tbody tr",
			handle: ".js-sortable-handle",
			forcePlaceholderSize: true,
			helper: function(e, ui) 
			{
				ui.children().each(function() {
					$(this).width($(this).width());
				});
				return ui;
			},
			start: function(event, ui) 
			{
				if (typeof mainYScroller != 'undefined') mainYScroller.disable();
				ui.placeholder.html('<td colspan="' + $(this).find('tbody tr:first td').size() + '">&nbsp;</td>');
			},
			stop: function() { if (typeof mainYScroller != 'undefined') mainYScroller.enable(); }
		});
	}


	$("input[data-type=number]").each(function(key,element){
		$(element).keydown(function(e){
				if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
					 // Allow: Ctrl+A
					(e.keyCode == 65 && e.ctrlKey === true) ||
					 // Allow: home, end, left, right
					(e.keyCode >= 35 && e.keyCode <= 39)) {
						 // let it happen, don't do anything
						 return;
				}
				// Ensure that it is a number and stop the keypress
				if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)  ) {
					e.preventDefault();
				}
			});

		$(element).keyup(function(e){
			if($(this).val().length){
				var value = $(this).val().replace(',','');
				while(value.indexOf(',') > 0){
					value = value.replace(',','');
				}
				value = parseInt(value);
				value = value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				$(this).val(value);
				
			}
		})
		$(element).on("blur",function(){
			$(this).trigger('change');
		})
	});

	$("select[data-type=select2]").each(function(key,element){
		$(element).select2();
	});
	$(".btn-navbar").on("click",function(){
		$(".bs-docs-sidenav").toggle();
	})
	$(".showload").hide(5);
});