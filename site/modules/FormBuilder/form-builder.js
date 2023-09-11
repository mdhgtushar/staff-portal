/**
 * Common JS used by form-builder template file.
 * 
 */

/**
 * Size viewport 
 * 
 */
function sizeFormBuilderViewport() {
	var formName = $("form.InputfieldForm[id^=FormBuilder_]").attr('name');
	if(!formName) formName = $("#FormBuilderSubmitted").attr('data-name');
	var viewport = parent.document.getElementById('FormBuilderViewport_' + formName);
	if(typeof viewport !== 'undefined' && viewport) {
		var $viewport = $(viewport); 
		// optional data-pad-bottom attribute that can be specified with the viewport
		// to reduce or increase the amount of default bottom padding (to prevent scrollbars or hidden content)
		// var bottom = $viewport.attr('data-pad-bottom');
		var targetHeight = $("#content").height();
		if(Math.abs(targetHeight - $viewport.height()) > 2 || Math.abs($viewport.height() - targetHeight) > 2) {
			$(viewport).height(targetHeight); 
		}
		$(viewport).attr('scrolling', 'no');
	}
}
	
function setupFormBuilderEditLinks() {
	var url = $("#FormBuilderPreview").val();
	$(".Inputfield").each(function() {
		var $label = $(this).children("label.ui-widget-header[for], label.InputfieldHeader[for]").eq(0);
		var forID = $label.attr('for');
		if(!forID) return;
		var $input = $(this).find('#' + forID);
		var name = $input.attr('name');
		if(typeof name == "undefined" || !name) return;
		if(name.indexOf('[') > 0) name = name.substring(0, name.indexOf('['));
		var $edit = $(
			"<a class='FormBuilderEditField' title='Edit Field' href='" + url + name + "'>" +
			"<span class='ui-icon ui-icon-pencil'></span></a>").click(function(e) {
				e.stopPropagation();
				window.top.location.href = $edit.attr('href');
			});
		$label.append($edit);
	});
}

function setupFormBuilderSubmitted($) {
	// if form submitted, we will scroll to its place in the page
	if(window.parent.jQuery) {
		var formName = $("form.InputfieldForm[id^=FormBuilder_]").attr('name'); // @todo
		if(!formName) formName = $("#FormBuilderSubmitted").attr('data-name');
		var $viewport = window.parent.jQuery('#FormBuilderViewport_' + formName);
		if($viewport.length) {
			var y = $viewport.offset().top;
		} else {
			var y = window.parent.jQuery('#FormBuilderSubmitted').offset().top;
		}
		// window.parent.jQuery("body").animate( { scrollTop: y }, 'slow');
		window.parent.jQuery("html, body").animate( { scrollTop: y }, 'slow');
	} else {
		// scroll just to top if no jQuery to use
		// @todo update this to scroll to the correct location
		window.parent.window.scrollTo(0,0);
	}
}

function initFormBuilderLegacy($) {
	// legacy framework
	$(".Inputfields > .Inputfield > .ui-widget-header").click(function () {
		// resize the viewport when they open/collapse fields
		setTimeout('sizeFormBuilderViewport()', 250);
	});

	$("select.asmSelect").change(function () {
		// resize when items are added to an asmSelect, which adjusts the form height
		setTimeout('sizeFormBuilderViewport()', 50);
	});

	// size the viewport at the beginning of the request
	sizeFormBuilderViewport();

	$(window).resize(function (e) {
		setTimeout('sizeFormBuilderViewport()', 250);
	});

	// edit links, currently in legacy frameworks only
	if($("#FormBuilderPreview").length) setupFormBuilderEditLinks();
}

/**
 * Remember form values
 * 
 */
function initFormBuilderCookies() {
	var $ = jQuery;
	function populateForm($form, cookieVal) {
		for(var inputId in cookieVal) {
			var inputVal = cookieVal[inputId];
			var $input = $form.find('#' + inputId);
			if(!$input.length) continue;
			if($input.attr('type') === 'file') continue;
			if(inputVal === true || inputVal === false) {
				$input.prop('checked', inputVal); // checkbox
			} else {
				$input.val(inputVal);
			}
			$input.change();
		}
		return cookieVal;
	}
	function inputfieldChange($inputfield, cookieVal) {
		$inputfield.find(':input').each(function() {
			var $input = $(this);
			var inputId = $input.attr('id');
			var inputType = $input.attr('type');
			var inputVal = $input.val();
			if(typeof inputType == 'undefined') inputType = $input.tagName;
			if(inputType == 'checkbox' || inputType == 'radio') {
				inputVal = $input.is(':checked') ? true : false;
			}
			cookieVal[inputId] = inputVal;
		}); 
		return cookieVal;
	}	
	$('.FormBuilderUseCookies').each(function() {
		var $form = $(this);
		var formId = $form.attr('id');
		var cookieVal = $.cookie(formId);
		cookieVal = cookieVal ? populateForm($form, cookieVal) : {};
		$form.on('change', ':input', function() {
			inputfieldChange($(this).closest('.Inputfield'), cookieVal);
			// @todo add support for expires setting for cookie
			$.cookie(formId, cookieVal);
		}); 
	}); 
}

function initFormBuilderChangeTracking() {
	$(document).on('change', 'form.FormBuilder :input, form.FormBuilder .Inputfield', function() {
		var $this = $(this);
		if($this.hasClass('Inputfield')) {
			// an .Inputfield element
			if(!$this.hasClass('InputfieldIgnoreChanges')) $this.addClass('InputfieldStateChanged');
			return false;
		} else {
			// an :input element
			if($this.hasClass('InputfieldIgnoreChanges') || $this.closest('.InputfieldIgnoreChanges').length) return false;
			$this.closest('.Inputfield').addClass('InputfieldStateChanged');
		}
	});
}

function initFormBuilderPagination() {

	// pagination navigation (if present)
	var $select = jQuery('.InputfieldFormBuilderPageBreakNav').find('select');
	if($select.length) {
		jQuery(document).on('change', '.InputfieldFormBuilderPageBreakNav', function() {
			var pageNum = $select.val();
			var url = $select.attr('data-url') + '&page_num=' + pageNum;

			// if label item or current pagination, do nothing
			if(pageNum === '0' || pageNum === '') return;

			$select.next('button').val(pageNum).click();
			$select.closest('form').trigger('submit');
		});
	}

	// submit event to capture and remember fields not shown 
	// applicable only when showSummary option is used with a PageBreak field
	var $noshows  = jQuery('#_pwfb_noshows');
	if($noshows.length) {
		jQuery('form.FormBuilder').on('submit', function() {
			var $form = jQuery(this);
			var $hiddens = $form.find('.InputfieldStateShowIf.InputfieldStateHidden');
			var a = [];

			$hiddens.each(function() {
				var name = jQuery(this).attr('id').replace('wrap_Inputfield_', '');
				a.push(name);
			});

			$noshows.val(a.join(','));
		});
	}
}

function initFormBuilder($) {
	// non-legacy frameworks
	
	$(".Inputfields > .Inputfield > .InputfieldHeader").click(function () {
		// resize the viewport when they open/collapse fields
		setTimeout('sizeFormBuilderViewport()', 250);
	});

	$("select.asmSelect").change(function () {
		// resize when items are added to an asmSelect, which adjusts the form height
		setTimeout('sizeFormBuilderViewport()', 50);
	});

	// size the viewport at the beginning of the request
	sizeFormBuilderViewport();

	$(window).resize(function (e) {
		setTimeout('sizeFormBuilderViewport()', 50);
	});
} 

jQuery(document).ready(function($) {
	if($(".FormBuilderFrameworkLegacy").length) {
		initFormBuilderLegacy($);
	} else {
		initFormBuilder($);
	}
	initFormBuilderCookies();
	initFormBuilderChangeTracking();
	initFormBuilderPagination();
	if($("#FormBuilderSubmitted").length) setupFormBuilderSubmitted($);
}); 
