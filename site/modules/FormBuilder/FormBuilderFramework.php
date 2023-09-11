<?php namespace ProcessWire;

/**
 * Abstract base class used by output frameworks for FormBuilder
 * 
 * @property array $noLoad Bypass automatic file loading for files referenced in this array
 * 
 */

abstract class FormBuilderFramework extends WireData {

	/**
	 * @var FormBuilderForm
	 * 
	 */
	protected $form;

	/**
	 * @var array
	 * 
	 */
	protected $styles = array();

	/**
	 * @var array
	 * 
	 */
	protected $scripts = array();

	/**
	 * @var string
	 * 
	 */
	protected $inlineStyles = '';

	/** 
	 * Construct
	 * 
	 * @param FormBuilderForm|null $form
	 * 
	 */
	public function __construct(FormBuilderForm $form = null) {
		if($form) $this->setForm($form);
		$this->set('noLoad', array());
		foreach($this->getConfigDefaults() as $key => $value) {
			$this->set($key, $value); 
		}
	}

	/**
	 * Method to call when framework is ready to be used for output
	 * 
	 */
	public function ready() {
		if($this->allowLoad('jquery')) {
			$this->wire('modules')->get('JqueryCore')->use('latest');
		}
	}

	/**
	 * Load the framework
	 * 
	 * @return string
	 * 
	 */
	abstract public function load();

	/**
	 * Set the form this framework will be used with
	 * 
	 * @param FormBuilderForm $form
	 * 
	 */
	public function setForm(FormBuilderForm $form) {
		$this->form = $form;
	}

	/**
	 * Get the name of the framework
	 * 
	 * @return mixed
	 * 
	 */
	public function getName() {
		return str_replace('FormBuilderFramework', '', $this->className());
	}

	/**
	 * Get the framework prefix
	 * 
	 * @return string
	 * 
	 */
	public function getPrefix() {
		$prefix = "fr" . $this->getName() . '_';
		return $prefix; 
	}

	/**
	 * Get the form used by this framework
	 * 
	 * @return FormBuilderForm
	 * 
	 */
	public function getForm() {
		return $this->form; 
	}

	/**
	 * Get the rendered inline styles
	 * 
	 * @return string
	 * 
	 */
	public function getInlineStyles() {
		return $this->inlineStyles;
	}

	/**
	 * Add an inline style
	 * 
	 * @param string $str
	 * 
	 */
	public function addInlineStyles($str) {
		$this->inlineStyles .= $str;
	}
	
	/**
	 * Get the URL where the actual 3rd party framework files exist
	 * 
	 * @return string
	 * 
	 */
	abstract public function getFrameworkURL();

	/**
	 * Get the framework version
	 * 
	 * @return string
	 * 
	 */
	static public function getFrameworkVersion() {
		return '';
	}
	
	/**
	 * Return Inputfields for configuration of framework
	 * 
	 * @return InputfieldWrapper
	 * 
	 */
	public function getConfigInputfields() {
		
		$inputfields = $this->wire('modules')->get('InputfieldFieldset'); 
		$label = str_replace('FormBuilderFramework', '', $this->className()); 
		$inputfields->label = sprintf($this->_('Framework: %s'), $label); 
		$inputfields->description = sprintf($this->_('Configuration specific to the %s framework.'), $label); 
		
		$f = $this->wire('modules')->get('InputfieldCheckboxes'); 
		$f->attr('name', 'noLoad'); 
		$f->label = $this->_('Bypass automatic file loading'); 
		$f->description = $this->_('If your site already loads any of these assets, you can tell this form not to load them automatically by checking the appropriate boxes below.');
		$f->addOption('framework', sprintf($this->_('Do not load %s framework files*'), $this->getName()));
		$f->addOption('jquery', $this->_('Do not load jQuery*'));
		$f->addOption('jqueryui', $this->_('Do not load jQuery UI when requested by input field*'));
		$f->notes = $this->_('*This option is only applicable to embed methods C and D.'); 
		$f->attr('value', $this->noLoad); 
		$f->collapsed = Inputfield::collapsedBlank;
		$inputfields->add($f); 
		
		return $inputfields; 
	}
	
	/**
	 * Return array of property => value representing defaults for each config property
	 *
	 * @return array
	 *
	 */
	public function getConfigDefaults() {
		return array(
			'noLoad' => array()
		);
	}


	/**
	 * Allow loading of files for: jquery, jqueryui, or framework
	 * 
	 * @param $type
	 * @param bool $alwaysAllowAB Whether to always allowLoad for embed mode A and B (which use form-builder.php template file)
	 * @return bool
	 * 
	 */
	public function allowLoad($type, $alwaysAllowAB = true) {
		if(!in_array($type, $this->noLoad)) return true; 
		if($alwaysAllowAB && $this->wire('page')->template == 'form-builder') return true; // always required
		return false;
	}

	/**
	 * Sanitize and validate a URL for the given extension
	 * 
	 * @param string $value URL
	 * @param string $extension Extension that the URL must have (optional)
	 * @return string
	 * 
	 */
	protected function sanitizeURL($value, $extension = '') {
		
		$value = $this->wire('sanitizer')->url($value);
		if(!strlen($extension)) return $value;
		
		if(strpos($value, '?') !== false) {
			list($url, $queryString) = explode('?', $value);
			$queryString = '?' . $queryString;
		} else {
			$url = $value;
			$queryString = '';
		}

		if(strpos($extension, '.') !== 0) $extension = ".$extension";
		
		if(strtolower(substr($url, -4)) !== strtolower($extension)) {
			$this->error("This URL must point to an '$extension' file: $value");
			return '';
		}
		
		return $url . $queryString;
	}
	
}