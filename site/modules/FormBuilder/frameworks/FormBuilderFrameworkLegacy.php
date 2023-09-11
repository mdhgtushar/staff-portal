<?php namespace ProcessWire;

/**
 * FormBuilder Legacy framework initialization file
 * 
 */

class FormBuilderFrameworkLegacy extends FormBuilderFramework {

	/**
	 * Construct
	 *
	 * @param FormBuilderForm|null $form
	 *
	 */
	public function __construct(FormBuilderForm $form = null) {
		parent::__construct($form);
		$config = $this->wire('config');
		$config->inputfieldColumnWidthSpacing = 1;
	}
	
	public function load() {
		
		$config = $this->wire('config');
		$legacyURL = $config->urls->get('FormBuilder') . 'frameworks/legacy/';
		
		$config->inputfieldColumnWidthSpacing = 1;
		
		$config->styles->prepend($legacyURL . 'reset.css');
		$config->styles->append($legacyURL . 'inputfields.css');
		$config->styles->append($config->urls->FormBuilder . 'form-builder.css');

		if(!$this->form->theme) $this->form->theme = 'default';

		// legacy framework uses markup defined in FormBuilder module settings

		$markup = array();
		$markupKeys = InputfieldWrapper::getMarkup();
		if(!isset($markupKeys['success'])) $markupKeys['success'] = '';
		if(!isset($markupKeys['error'])) $markupKeys['error'] = '';
		foreach($markupKeys as $key => $value) {
			$k = 'markup_' . $key;
			$value = wire('forms')->$k;
			if(!empty($value)) $markup[$key] = $value;
		}
		InputfieldWrapper::setMarkup($markup);

		$classes = array();
		foreach(InputfieldWrapper::getClasses() as $key => $value) {
			$k = 'classes_' . $key;
			$value = wire('forms')->$k;
			if(!empty($value)) $classes[$key] = $value;
		}
		InputfieldWrapper::setClasses($classes);

		if($this->wire('forms')->classes_form) {
			$this->addHookBefore('FormBuilderProcessor::renderReady', $this, 'addFormClass'); 
		}
	}

	/**
	 * Hook that adds a module configured form class (classes_form) to the InputfieldForm
	 * 
	 * @param HookEvent $event
	 * 
	 */
	public function addFormClass($event) {
		$class = $this->wire('forms')->classes_form;
		if(!empty($class)) {
			$inputfieldForm = $event->arguments(0);
			$inputfieldForm->addClass($class);
		}
	}

	/**
	 * Return Inputfields for configuration of framework
	 *
	 * @return InputfieldWrapper
	 *
	 */
	public function getConfigInputfields() {
		$inputfields = parent::getConfigInputfields();
		/** @var InputfieldCheckboxes $f */
		$f = $inputfields->getChildByName('noLoad');
		$f->removeOption('framework');
		return $inputfields;
	}
	
	public function getFrameworkURL() {
		return $this->wire('config')->urls->adminTemplates;
	}

	/**
	 * Get the framework version
	 *
	 * @return string
	 *
	 */
	static public function getFrameworkVersion() {
		return '1.0.0';
	}

}

