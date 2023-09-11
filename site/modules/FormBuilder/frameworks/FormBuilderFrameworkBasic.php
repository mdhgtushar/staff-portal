<?php namespace ProcessWire;

/**
 * FormBuilder Basic framework initialization file
 * 
 * @property string $cssURL
 * @property string|null $buttonBgColor
 * @property string $itemContent
 * 
 * @todo v3 add framework config for font-family/size/color, submit button colors, input background color
 * @todo v3 add framework config of classes for alert, error, success, description, notes
 *
 */

class FormBuilderFrameworkBasic extends FormBuilderFramework {
	
	/**
	 * Construct
	 *
	 * @param FormBuilderForm|null $form
	 *
	 */
	public function __construct(FormBuilderForm $form = null) {
		parent::__construct($form);
	}
	
	public function ready() {
		parent::ready();
	}

	public function load() {
	
		$itemContent = '';
		foreach($this->itemContent as $placeholder) {
			$itemContent .= '{' . $placeholder . '}';
		}
		if(empty($itemContent)) $itemContent = '{description}{out}{error}{notes}{detail}';
		
		// general Inputfield markup
		$markup = array(
			'list' => "<div {attrs}>{out}</div>",
			'item' => "<div {attrs}>{out}</div>",
			'item_label' => "<label class='InputfieldHeader' for='{for}'>{out}</label>",
			'item_label_hidden' => "<label class='InputfieldHeader InputfieldHeaderHidden'><span>{out}</span></label>",
			'item_content' => "<div class='InputfieldContent {class}'>$itemContent</div>",
			'item_error' => "<div class='input-error error'>{out}</div>",
			'item_description' => "<p class='description'>{out}</p>",
			'item_notes' => "<p class='notes'>{out}</p>",
			'success' => "<p class='alert alert-success success'>{out}</p>",
			'error' => "<p class='alert alert-error error'>{out}</p>",
			'item_icon' => "", // framework does not use icons
			'item_toggle' => "", // framework does not use open/close toggle
		);
	
		// markup specific to InputfieldFieldset
		$markup['InputfieldFieldset'] = array(
			'item' => "<fieldset {attrs}>{out}</fieldset>",
			'item_label' => "<legend>{out}</legend>",
			'item_label_hidden' => "<legend style='display:none'>{out}</legend>",
			'item_content' => "<div class='InputfieldContent'>{out}</div>",
			'item_description' => $markup['item_description'], 
			'item_notes' => $markup['item_notes'],
		);

		// general Inputfield classes
		$classes = array(
			'form' => '', 
			'list' => 'Inputfields',
			'list_clearfix' => 'pw-clearfix',
			'item' => 'Inputfield Inputfield_{name} {class}',
			'item_required' => 'InputfieldStateRequired',
			'item_error' => 'InputfieldStateError',
			'item_collapsed' => 'InputfieldStateCollapsed',
			'item_column_width' => 'InputfieldColumnWidth',
			'item_column_width_first' => 'InputfieldColumnWidthFirst',
			'InputfieldFieldset' => array(
				'item' => 'Inputfield Inputfield_{name} {class}',
			)
		);

		//$markup['InputfieldFormBuilderForm'] = $markup['InputfieldFieldset'];
		//$classes['InputfieldFormBuilderForm'] = $classes['InputfieldFieldset'];
		
		$config = $this->wire('config');
		$config->inputfieldColumnWidthSpacing = 0;

		InputfieldWrapper::setMarkup($markup);
		InputfieldWrapper::setClasses($classes);

		$cssURL = $this->cssURL;
		if(strlen($cssURL) && strpos($cssURL, '//') === false && strpos($cssURL, $config->urls->root) !== 0) {
			$cssURL = $config->urls->root . ltrim($cssURL, '/');
		}

		$config->styles->append($config->urls->FormBuilder . 'FormBuilder.css');
		if(strlen($cssURL)) $config->styles->append($cssURL);

		if(!$this->form->theme) $this->form->theme = 'basic';

		// change markup of submit button
		$this->addHookBefore('InputfieldSubmit::render', $this, 'hookInputfieldSubmitRender');
	}

	/**
	 * Hook beore InputfieldSubmit::render() to use different markup for submit button
	 * 
	 * @param $event
	 * 
	 */
	public function hookInputfieldSubmitRender($event) {
		/** @var InputfieldSubmit $in */
		$in = $event->object;
		$event->replace = true;
		$value = $this->wire('sanitizer')->entities1($in->value);
		$class = array();
		if($in->secondary) $class[] = 'InputfieldSubmitSecondary';
		$class = count($class) ? " class='" . implode(' ', $class) . "'" : '';
		$style = '';
		if($this->buttonBgColor) $style = " style='background-color:#$this->buttonBgColor'";
		$out = "<button type='submit' name='$in->name' value='$value'$class$style>$value</button>";
		if($in->small) $out = "<small>$out</small>";
		$event->return = $out;
	}
	
	/**
	 * Return Inputfields for configuration of framework
	 *
	 * @return InputfieldWrapper
	 *
	 */
	public function getConfigInputfields() {
		$inputfields = parent::getConfigInputfields();
		$defaults = $this->getConfigDefaults();
	
		/** @var InputfieldURL $f */
		$f = $this->wire('modules')->get('InputfieldURL');
		$f->attr('name', 'cssURL');
		$f->label = $this->_('URL to CSS file that styles this form');
		$f->description = $this->_('Specify a URL/path relative to root of ProcessWire installation.');
		$f->attr('value', $this->cssURL);
		$cssURL = $this->wire('config')->urls->root . ltrim($defaults['cssURL'], '/'); 
		$f->notes = $this->_('Default value:') . " [$defaults[cssURL]]($cssURL)";
		$inputfields->add($f);

		/** @var InputfieldText $f */
		$f = $this->wire('modules')->get('InputfieldText'); 
		$f->attr('name', 'buttonBgColor'); 
		$f->label = $this->_('Button background color'); 
		$f->description = $this->_('Enter CSS hex color value or CSS color name. Omit to use the color from the framework’s CSS file.'); 
		$f->notes = $this->_('Note the button foreground (text) color is white, so it’s best to avoid light background colors.'); 
		$f->size = 10;
		$f->collapsed = Inputfield::collapsedBlank;
		$f->attr('value', $this->buttonBgColor); 
		$inputfields->add($f); 
	
		/** @var InputfieldAsmSelect $f */
		$f = $this->wire()->modules->get('InputfieldAsmSelect');
		$f->attr('name', 'itemContent');
		$f->label = $this->_('Inputfield content order'); 
		$f->addOptions($this->getItemContentLabels());
		$f->val($this->itemContent);
		$f->setAsmSelectOption('deletable', false);
		$f->setAsmSelectOption('addable', false);
		$inputfields->add($f); 
		
		return $inputfields;
	}

	public function getConfigDefaults() {
		$defaults = parent::getConfigDefaults();
		$cssURL = $this->getFrameworkURL() . 'main.css';
		$rootURL = $this->wire('config')->urls->root;
		if($rootURL != '/') {
			$cssURL = '/' . ltrim(substr($cssURL, strlen($rootURL)), '/');
		}
		$defaults['cssURL'] = $cssURL;
		$defaults['buttonBgColor'] = '';
		$defaults['itemContent'] = array_keys($this->getItemContentLabels());
		return $defaults;
	}
	
	public function getFrameworkURL() {
		return $this->wire('config')->urls->get('FormBuilder') . 'frameworks/basic/';
	}
	
	public function set($key, $value) {
		if($key == 'cssURL' && strlen($value)) $value = $this->sanitizeURL($value, 'css');
		if($key == 'buttonBgColor' && strlen($value)) {
			$value = ltrim($value, '#');
			if(!ctype_alnum("$value")) $value = preg_replace('/[^-A-Za-z0-9]/', '', $value); 
		}
		return parent::set($key, $value);
	}

	/**
	 * Get the framework version
	 *
	 * @return string
	 *
	 */
	static public function getFrameworkVersion() {
		return '3.0.0';
	}
	
	public function getItemContentLabels() {
		return array(
			'description' => $this->_('Description text'), 
			'out' => $this->_('Input element'), 
			'error' => $this->_('Inline error text'), 
			'notes' => $this->_('Notes text'), 
		);
	}
}
