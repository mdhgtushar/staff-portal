/**
 * FormBuilder helpers for embed method D
 * 
 * Copyright 2016 by Ryan Cramer Design, LLC
 * https://processwire.com/FormBuilder/
 * 
 * Please note: This file must be loaded before the form is rendered. Meaning, the script tag
 * that links to it must be in the document <head> markup, or somewhere in the document <body> 
 * before the opening <form> tag.     
 * 
 */
var FormBuilderD = {

	/**
	 * Get the field from $form with the given name
	 * 
	 * The given value is used if the field can't be found solely by name. 
	 * 
	 * @param $form
	 * @param name
	 * @param value
	 * @returns {*} 
	 * 
	 */
	getField: function($form, name, value) {
		
		var $field;
		var $wrap; 

		// first attempt to locate field by the name attribute
		$field = $form.find('[name="' + name + '"]');
		if($field.length) return $field;

		// if didn't find it by name attribute, find by id attribute
		$field = $form.find('[id="Inputfield_' + name + '"]');
		if($field.length) return $field;
		
		$wrap = $form.find('[id="wrap_Inputfield_' + name + '"]');
		if(!$wrap.length) return $field;

		// if didn't find by name or id, it's probably a field_name[] multi-value field
		// find <option> or <input> that has the value we're looking for
		var val = typeof value == "object" ? value[0] : value;
		$wrap.find("option, input").each(function() {
			if($field.length) return;
			var $this = jQuery(this);
			if($this.attr('value') == val) {
				if($this.is("option")) {
					$field = $this.closest("select");
				} else {
					$field = $this;
				}
			}
		});
		
		return $field;
	},

	/**
	 * Populate the given $field with the given value
	 * 
	 * @param $field
	 * @param value
	 * 
	 */
	populateField: function($field, value) {
		
		switch($field[0].type) {
			case 'checkbox':
			case 'radio':
				$field.each(function() {
					var $f = jQuery(this);
					if($f.val() == value) $f.attr('checked', 'checked');
				});
				break;
			case 'select':
			case 'select-one':
			case 'select-multiple':
				$field.find("option").each(function() {
					var $option = jQuery(this);
					if($option.attr('value') == value) $option.attr('selected', 'selected');
				});
				break;
			default:
				$field.val(value);
		}
	},

	/**
	 * Populate the form having the given id with the given values
	 * 
	 * @param formID ID attribute of form
	 * @param values Values indexed by form field name
	 * 
	 */
	populate: function(formID, values) {

		//console.log(values);
		var $form = jQuery('#' + formID);

		jQuery.each(values, function(name, value) {
			
			if(typeof value == "undefined" || value === null) return;
			
			// work with multi-value so same logic works for all types
			if(typeof value != "object") value = [ value ];

			for(var n = 0; n < value.length; n++) {
				var v = value[n];
				var $field = FormBuilderD.getField($form, name, v);
				if($field.length) FormBuilderD.populateField($field, v);
			}
		});
			
	},

	/**
	 * Initialize the FormBuilder "D" embed method
	 * 
	 */
	init: function() {
		var $submitted = jQuery("#FormBuilderSubmitted");
		if($submitted.length) {
			var y = $submitted.offset().top;
			jQuery("body").animate( { scrollTop: y }, 'slow');
		}
	}
}

jQuery(document).ready(function() {
	FormBuilderD.init();	
});

