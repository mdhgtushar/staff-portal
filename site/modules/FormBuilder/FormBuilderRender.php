<?php namespace ProcessWire;

/**
 * Form Builder Render provides rendering for a FormBuilderForm
 * 
 * @property FormBuilder $forms
 * @property string $scripts
 * @property string $styles
 * @property FormBuilderForm $form
 * @property FormBuilderFramework $framework
 * 
 * @method array getStyles()
 * @method array getScripts()
 * @method string renderInlineStyles($wrap = true, $extras = true)
 * 
 * 
 */

class FormBuilderRender extends WireData {

	/**
	 * @var FormBuilderForm
	 * 
	 */
	protected $form;

	/**
	 * Rendered form output 
	 * 
	 * @var string
	 * 
	 */
	protected $out; 

	/**
	 * @var FormBuilderFramework|null
	 * 
	 */
	protected $framework;

	/**
	 * Variables to pre-populate
	 * 
	 * @var array
	 * 
	 */
	protected $vars = array(); 

	/**
	 * Construct
	 * 
	 * @param FormBuilderForm $form
	 * @param array $vars Optional associative array of variables to pre-populate in form
	 * 
	 */
	public function __construct(FormBuilderForm $form, array $vars = array()) {
		$this->form = $form;
		$this->vars = $vars; 
		$this->form->setFbRender($this);
		$this->framework = $this->form->getFramework();
		$this->out = $this->_render();
	}

	/**
	 * Has the form been submitted?
	 * 
	 * @return bool
	 * 
	 */
	public function isSubmitted() {
		return $this->form->isSubmitted();
	}

	/**
	 * Typecast to string to return rendered form output
	 * 
	 * @return string
	 * 
	 */
	public function __toString() {
		return $this->out; 
	}

	/**
	 * Get property from this class
	 * 
	 * @param string $key
	 * @return mixed
	 * 
	 */
	public function get($key) {
		if($key == 'scripts') return $this->renderScripts();
		if($key == 'styles') return $this->renderStyles();
		if($key == 'form') return $this->form;
		if($key == 'framework') return $this->framework;
		return parent::get($key);
	}

	/**
	 * Alias for renderScripts
	 * 
	 * @return string
	 * 
	 */
	public function scripts() { 
		return $this->renderScripts();
	}

	/**
	 * Alias for renderStyles
	 * 
	 * @return string
	 * 
	 */
	public function styles() { 
		return $this->renderStyles();
	}

	/**
	 * Render inline styles
	 * 
	 * @param bool $wrap Wrap returned output in a <style> tag?
	 * @param bool $extras Get extras for the form-builder.php output template? Specify false if output is not form-builder.php
	 * @return string
	 * 
	 */
	public function ___renderInlineStyles($wrap = true, $extras = true) {
		$styles = '';
		if($extras && $this->wire('page')->template == 'form-builder') {
			// embed method A or B
			$styles .=
				"html, body { background: transparent; margin: 0; padding: 0; } " .
				"body { margin-top: 1px; } " .
				".pw-continer, .container { width: 100%; margin: 0; padding: 0; min-width: 100px; } " .
				"#content { margin: 0; padding: 1px; }";
		}
		$styles .= $this->framework->getInlineStyles();
		$mobilePx = $this->form->mobilePx;
		if(!$mobilePx) $mobilePx = "479px"; // default
		if($mobilePx != 1) { // 1=bypass
			if(ctype_digit("$mobilePx")) $mobilePx .= "px";
			$styles .=
				"\n/* Optional responsive adjustments for mobile - can be removed if not using 'Column Width' for fields */" . 
				"\n@media only screen and (max-width: {$mobilePx}) { " .
					".InputfieldFormWidths .Inputfield { " .
						"clear: both !important; " .
						"width: 100% !important; " .
						"margin-left: 0 !important; " .
						"margin-bottom: 1em !important; " .
					"} "  .
					".Inputfield .InputfieldContent, " .
					".Inputfield .InputfieldHeader { " .
						"padding-left: 0 !important; "  .
						"padding-right: 0 !important; "  .
						"float: none !important; " .
						"width: 100%; " .
					"} " .
					".InputfieldFormWidths .Inputfield .InputfieldHeader { " .
						"margin-bottom: 0; " .
					"}" .
					".InputfieldFormNoWidths .Inputfield .InputfieldHeader { " .
						"text-align: initial; " .
					"}" .
				"}";
		}

		// minify
		$styles = preg_replace('/\s{2,}/s', ' ', $styles);
		$styles = str_replace(array(' { ', ' } ', ': ', '; ', ', ', '} }'), array('{', '} ', ':', ';', ',', '}}'), $styles);
		
		if($styles && $wrap) return "\n\t<style type='text/css'>$styles</style>";
		
		return $styles;
	}

	/**
	 * Get stylesheet files
	 * 
	 * @return array
	 * 
	 */
	public function ___getStyles() {
		$styles = array();
		foreach($this->wire('config')->styles as $file) {
			$styles[] = $file;
		}
		return $styles;
	}

	/**
	 * Render stylesheet file links
	 * 
	 * @return string
	 * 
	 */
	public function renderStyles() {
		$out = '';
		foreach($this->getStyles() as $file) {
			$out .= "\n\t<link type='text/css' href='$file' rel='stylesheet' />";
		}
		$out .= $this->renderInlineStyles();
		return $out;
	}

	/**
	 * Get JS script files
	 * 
	 * @return array
	 * 
	 */
	public function ___getScripts() {
		$scripts = array();
		$jquery = $this->framework->allowLoad('jquery');
		$jqueryui = $this->framework->allowLoad('jqueryui');
		$hasJQuery = 0;
	
		foreach($this->wire('config')->scripts as $file) {
			if(strpos($file, 'JqueryCore') !== false) {
				$jq = strpos($file, 'JqueryCore.js') !== false;
				if(!$jq) $jq = strpos($file, '/jquery-') && preg_match('/jquery-[\d.]+(?:\.min)?.js/', $file);
				if(!$jquery && $jq) continue;
				if($jq) $hasJQuery++;
			} else if(stripos($file, '/jquery.js') || stripos($file, '/jquery.min.js')) {
				if(!$jquery) continue;
				$hasJQuery++;
			}
			if(!$jqueryui && strpos($file, 'JqueryUI') !== false) continue; 
			$scripts[] = $file;
		}
		if($hasJQuery > 1) {
			// more than one jQuery file included? remove JqueryCore.js
			foreach($scripts as $key => $file) {
				if(strpos($file, 'JqueryCore.js') !== false) unset($scripts[$key]);	
			}
		}
		return $scripts;
	}

	/**
	 * Render inline scripts
	 * 
	 * @return string
	 * 
	 */
	public function renderInlineScripts() {
	
		/** @var Config $config */
		$config = $this->wire('config');
		/** @var array $jsConfig */
		$jsConfig = $config->js();
		$jsConfig['debug'] = $config->debug;
		$jsConfig['urls'] = array('root' => $config->urls->root); //'modules' => $config->urls->modules,

		$out =
			"<script type='text/javascript'>" .
				"var _pwfb={config:" . wireEncodeJSON($jsConfig, true, $config->debug) . "};" .
				"if(typeof ProcessWire=='undefined'){" .
					"ProcessWire=_pwfb;" . 
				"}else{" . 
					"for(var _pwfbkey in _pwfb.config) ProcessWire.config[_pwfbkey]=_pwfb.config[_pwfbkey];" . 
				"}" .
				"if(typeof config=='undefined') var config=ProcessWire.config;" . 
				"_pwfb=null;" .
			"</script>";
		
		return $out; 
	}

	/**
	 * Render script file links
	 * 
	 * @param bool $alsoRenderInline Specify false if you don't want inline scripts included
	 * @return string
	 * 
	 */
	public function renderScripts($alsoRenderInline = true) {
	
		$out = $alsoRenderInline ? $this->renderInlineScripts() : '';
		
		foreach($this->getScripts() as $file) {
			$out .= "\n\t<script type='text/javascript' src='$file'></script>";
		}
		
		return $out;
	}

	/**
	 * Get the output for this render
	 * 
	 * @return string
	 * 
	 */	
	public function render() {
		$out = $this->out; 
		$this->out = '';
		return $out; 
	}

	/**
	 * Render the form, for embed method A, B or C
	 *
	 * This method should be called before getScripts/renderScripts and getStyles/renderStyles
	 *
	 * @return string
	 *
	 */
	protected function _render() {

		$form = $this->form;
		$processor = $form->processor();
		$processor->setFbRender($this);
		$config = $this->wire('config');
		$out = $form->render();
		$jqueryUI = false;
		
		// identify if we will be using jQuery UI themes
		if($form->framework == 'Legacy') {
			// legacy always requires jQuery UI theme
			$jqueryUI = true; 
			
		} else if($form->framework == 'Admin') {
			// admin already loads jquery ui, so we don't need it a second time
			$jqueryUI = false;
			
		} else {
			// see if any Inputfields trigger jQuery UI to be loaded
			foreach($config->scripts as $file) {
				if(strpos($file, '/JqueryUI/')) {
					$jqueryUI = true;
				}
			}
		}
		
		if($jqueryUI) {
			// i.e. default when framework selected but not theme
			if(!$form->theme) $form->theme = 'delta';
			foreach(array('jquery-ui', 'inputfields', 'main') as $file) {
				// we only use the jquery-ui file(s) when a non-legacy framework is in use
				if($file != 'jquery-ui' && $form->framework != 'Legacy') continue;
				$path = $this->forms->themesPath($form->theme) . $file;
				$url = $this->forms->themesURL($form->theme) . $file;
				if(is_file("$path.css")) $config->styles->append("$url.css");
				if(is_file("$path.js")) $config->scripts->append("$url.js");
			}
		}

		$minfile = $config->paths->adminTemplates . "scripts/inputfields.min.js";
		if($config->debug && is_file($minfile)) {
			$config->scripts->append($config->urls->adminTemplates . "scripts/inputfields.min.js");
		} else {
			$config->scripts->append($config->urls->adminTemplates . "scripts/inputfields.js");
		}
		$config->scripts->append($config->urls->FormBuilder . "form-builder.js");
		
		$this->checkTemplateVersion($out);
		
		return $out;
	}

	/**
	 * Check the template version in the given output and log error if appropriate
	 * 
	 * @param string $out
	 * 
	 */
	protected function checkTemplateVersion(&$out) {
		if($this->wire('forms')->getTemplateVersion() < FormBuilder::requireTemplateVersion) {
			$page = $this->wire('page');
			if($page->template == 'form-builder') {
				$error = "<strong>This template file (/site/templates/form-builder.php) is out of date.</strong> Please replace it with a new copy from /site/modules/FormBuilder/form-builder.php. ";
				$error .= "This error message only visible to administrators.";
				if($page->editable()) {
					$markup = InputfieldWrapper::getMarkup();
					$out = str_replace('{out}', $error, $markup['error']) . $out;
				}
				$this->wire('forms')->log($error);
			}
		}
	}
}