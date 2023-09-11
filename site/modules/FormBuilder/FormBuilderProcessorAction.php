<?php namespace ProcessWire;

/**
 * FormBuilder Processor Action Plugin Module (base class)
 * 
 * @property FormBuilderProcessor $processor
 * @property FormBuilderForm $fbForm
 * @property InputfieldForm $form
 * @property string $formName
 * 
 */
abstract class FormBuilderProcessorAction extends WireData implements Module {
	
	/**
	 * @var FormBuilderProcessor
	 * 
	 */
	protected $processor = null;
	
	/**
	 * @var FormBuilderForm
	 *
	 */
	protected $fbForm = null;

	/**
	 * @var InputfieldForm|null
	 * 
	 */
	protected $form = null;

	/**
	 * Construct
	 *
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Form ready to be rendered or processed
	 * 
	 * Called when module has all required data and hooks can be added, etc. 
	 * 
	 */
	public function formReady() { }

	/**
	 * Form ready to be rendered
	 * 
	 */
	public function renderReady() { }

	/**
	 * Form ready to be processed
	 * 
	 */
	public function processReady() { }

	/**
	 * Form being viewed in the admin
	 * 
	 */
	public function adminViewEntry() { }

	/**
	 * Form being edited in the admin
	 * 
	 */
	public function adminEditEntry() { }

	/**
	 * Get or set FormBuilderForm 
	 * 
	 * @param FormBuilderForm $fbForm
	 * @return FormBuilderForm|null
	 *
	 */
	public function fbForm($fbForm = null) {
		if($fbForm !== null) $this->fbForm = $fbForm;
		if(!$this->fbForm && $this->processor) $this->fbForm = $this->processor->getFbForm();
		return $this->fbForm;
	}

	/**
	 * Get or set InputfieldForm 
	 * 
	 * @param InputfieldForm $form
	 * @return null|InputfieldForm
	 * 
	 */
	public function form($form = null) {
		if($form !== null) $this->form = $form;
		if(!$this->form && $this->processor) $this->form = $this->processor->getInputfieldsForm();
		return $this->form;
	}

	/**
	 * Get the FormBuilder module instance
	 * 
	 * @return FormBuilder
	 * 
	 */
	public function forms() {
		return $this->wire('forms');
	}

	/**
	 * Get or set processor
	 * 
	 * @param FormBuilderProcessor|null
	 * @return null|FormBuilderProcessor
	 *
	 */
	public function processor($processor = null) {
		if($processor) $this->processor = $processor;
		if(!$this->processor && $this->fbForm) $this->processor = $this->fbForm->processor();
		return $this->processor;
	}
	
	/**
	 * Set a config value for this action/module here and in the FormBuilder form
	 *
	 * @param string $name Name of configuration property to set
	 * @param string|array|int|float $value Value of configuration property 
	 * @param bool $saveNow Also save to the database now? (default=false)
	 * @return self
	 *
	 */
	public function setConfigValue($name, $value, $saveNow = false) {
		$this->set($name, $value);
		$fbForm = $this->fbForm();
		$ns = $this->className();
		$settings = $fbForm->get($ns);
		if(!is_array($settings)) $settings = array();
		$settings[$name] = $value;
		$fbForm->set($ns, $settings);
		if($saveNow) $this->forms()->save($fbForm);
		return $this;
	}

	/**
	 * Set and save to DB a config value for this action/module here and in the FormBuilder form
	 * 
	 * This is the same as calling setConfigValue() with the 3rd argument as true. 
	 *
	 * @param string $name Name of configuration property to set
	 * @param string|array|int|float $value Value of configuration property
	 * @return self
	 *
	 */
	public function saveConfigValue($name, $value) {
		return $this->setConfigValue($name, $value, true); 
	}

	/**
	 * Get Inputfields to configure action
	 * 
	 * @param InputfieldWrapper $inputfields
	 * 
	 */
	public function getConfigInputfields(InputfieldWrapper $inputfields) { }

	/**
	 * Get property from module 
	 * 
	 * @param object|string $key
	 * @return mixed|null|FormBuilderForm|FormBuilderProcessor|InputfieldForm
	 * 
	 */
	public function get($key) {
		if($key === 'processor') return $this->processor();
		if($key === 'form') return $this->form();
		if($key === 'formName') return $this->fbForm()->name;
		if($key === 'forms') return $this->forms();
		if($key === 'fbForm') return $this->fbForm();
		return parent::get($key);
	}

	/**
	 * Is this plugin action enabled? (recommended true)
	 * 
	 * @return bool
	 * 
	 */
	public function isEnabled() {
		return true;
	}

	/**
	 * Is autoload module? (recommended false)
	 * 
	 * @return bool
	 * 
	 */
	public function isAutoload() {
		return false;
	}

	/**
	 * Is singular module? (recommended false)
	 * 
	 * @return bool
	 * 
	 */
	public function isSingular() {
		return false;
	}
	
}