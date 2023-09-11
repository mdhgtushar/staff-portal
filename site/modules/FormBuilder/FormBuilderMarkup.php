<?php namespace ProcessWire;

/**
 * FormBuilderMarkup used for embed method D 
 * 
 * Generates a /site/assets/cache/FormBuilder/form-[name].php file that the user can copy to
 * /site/templates/FormBuilder/form-[name].php and it will be used for rendering the form. 
 * 
 * 
 */
class FormBuilderMarkup extends WireData {

	/**
	 * @var InputfieldForm
	 * 
	 */
	protected $form;

	/**
	 * @var string
	 * 
	 */
	protected $markup;

	/**
	 * @var string
	 * 
	 */
	protected $markupHash;
	
	/**
	 * Construct
	 * 
	 * @param string $markup
	 * @param InputfieldForm $form
	 * @param FormBuilderFramework $framework
	 * @param array $texts Must have 'labels', 'descriptions' and 'notes' arrays
	 * 
	 */
	public function __construct($markup, InputfieldForm $form, FormBuilderFramework $framework, $texts = array()) {
	
		$this->form = $form;
		$fbForm = $framework->getForm();
		$fbRender = $fbForm->getFbRender();
		$config = $this->wire('config');
		$rootURL = $config->urls->root;
		$this->markupHash = md5($markup); 
		$this->testHash($this->markupHash);
		
		$markup = str_replace(array("~?php", "?~"), '', $markup);
		$out = '~?php' . 
			"\n" . 
			"\n/**" . 
			"\n * FormBuilder render file (embed method D) for form '$form->name'" . 
			"\n * " .
			"\n * Instructions" .
			"\n * ============" .
			"\n * " .
			"\n * 1. If not already in place, the contents of this file should be placed in this file:" .
			"\n * " .
			"\n *    /site/templates/FormBuilder/form-$form->name.php" .
			"\n * " .
			"\n *    When present, FormBuilder will always use this file for \$forms->render('$form->name'); calls, rather than " .
			"\n *    the markup that it generates at runtime." .
			"\n * " .
			"\n * 2. Move the indicated stylesheet <link> tags further-below to your document <head>, to appear when this form" .
			"\n *    is rendered. You may optionally omit any or all of the stylesheets if you don't think you will need them. " .
			"\n *    In particular, remove any that duplicate stylesheets you may already be loading (like from CSS frameworks)." .
			"\n * " .
			"\n * 3. Also move the indicated Javascript <script> tags below to your <head> or before closing the </body> tag," .
			"\n *    to appear when this form will be rendered. You may optionally omit any of the scripts if you don't think " . 
			"\n *    you will need them. In particular, remove any that duplicate scripts you may already be loading (like jQuery " . 
			"\n *    or CSS framework files). We recommend that you always keep the 'form-builder-d.js' script in place." .
			"\n * " .
			"\n * 4. Adjust the form markup below as you see fit. Keep the form field 'name' attributes in tact. Please note that" .
			"\n *    removing any 'id' or 'class' attributes (or other significant changes to the markup) may interfere with or" .
			"\n *    disable features provided by FormBuilder for a given field. So be sure to test any changes thoroughly." .
			"\n * " .
			"\n * 5. To render this form, place the following in a template file where you want the form to appear: " .
			"\n * " .
			"\n *    echo \$forms->render('$form->name'); " .
			"\n * " .
			"\n * Optional: Steps 2 and 3 above ask you copy <link> and <script> tags in your document <head>. We recommend that " .
			"\n * you surround them in something like if(\$page->id == 123) { ... }, so that you are only rendering these assets " .
			"\n * on the page where the form will be displayed (where '123' is the ID of the page)." .
			"\n * " .
			"\n * Please leave the following here" .
			"\n * ===============================" .
			"\n * Date: " . date('Y-m-d H:i:s') . 
			"\n * Hash: $this->markupHash" .
			"\n * " .
			"\n * If you get want to disable an 'out of date' warning from FormBuilder for this file, copy the 'Hash' (like seen " .
			"\n * above) from the /site/assets/cache/FormBuilder/form-$form->name.php file, and paste to make it replace the hash " . 
			"\n * value that you see above. We also recommend you update the 'Date' for your own reference." .
			"\n * " .
			"\n * " .
			"\n * Variables provided to this template" .
			"\n * ===================================" . 
			"\n * @var InputfieldForm \$form Form that is being rendered or processed" . 
			"\n * @var FormBuilderProcessor \$processor Processor of form" . 
			"\n * @var array \$values Existing values of field inputs, indexed by field name" .
			"\n * @var array \$labels Field labels indexed by field name" .
			"\n * @var array \$descriptions Field descriptions indexed by field name" .
			"\n * @var array \$notes Field notes indexed by field name" . 
			"\n * @var array \$errors Error messages to display (populated if form had errors)" . 
			"\n * @var bool \$submitted This is TRUE when the form has been successfully submitted" . 
			"\n * @var string \$successMessage The success message defined with the form (populated on success)" .
			"\n * @var string \$submitKey Unique hidden field value FormBuilder uses to detect valid form submission" . 
			"\n *" . 
			"\n */" . 
			"\n?~";
	
		$out .= "\n\n<!-- Move styles below to document <head> for pages where this form will appear -->";
		
		$styles = $fbRender->getStyles(); 
		$scripts = $fbRender->getScripts();
		$scripts[] = $config->urls->adminTemplates . "scripts/inputfields.min.js";

		$hasJqueryUI = false;
		foreach($scripts as $file) if(strpos($file, 'JqueryUI.')) $hasJqueryUI = true;	
		if($hasJqueryUI) {
			// if jQuery UI is used by the form, add in a jQuery UI theme
			if(!$fbForm->theme) $fbForm->theme = 'basic';
			$path = $this->wire('forms')->themesPath($fbForm->theme) . 'jquery-ui.css';
			if(is_file($path)) $styles[] = $this->wire('forms')->themesURL($fbForm->theme) . 'jquery-ui.css';
		}
		
		foreach($styles as $file) {
			$o = "\n<link rel='stylesheet' type='text/css' href='$file' />";
			$o = str_replace("href='$rootURL", "href='~?php echo \$config->urls->root; ?~", $o);
			$out .= $o;
		}
		
		$out .= "\n" . trim(str_replace(array("\n", "\r", "\t"), " ", $fbRender->renderInlineStyles(true, false))) . "\n";
		$out .= "\n<!-- Move scripts below to document <head> or before </body> for pages where this form will appear -->";

		$out .= "\n" . 
			'<script type="text/javascript">' .
				'var _pwfb={ ' .
				'config:~?php echo json_encode(' . 
					'array_merge(' . 
						'$config->js(),' . 
						'array(' . 
							'"urls"=>array(' . 
								'"root"=>$config->urls->root' . 
							'),' . 
							'"debug" => $config->debug' . 
						')' . 
					')' . 
				');?~};' .
				'if(typeof ProcessWire=="undefined"){' . 
					'var ProcessWire=_pwfb;' . 
				'}else{' .
					'for(var _pwfbkey in _pwfb.config) ProcessWire.config[_pwfbkey] = _pwfb.config[_pwfbkey];' . 
				'}' . 
				'if(typeof config=="undefined"){' .
					'var config=ProcessWire.config;' . // legacy
				'}' .
				'_pwfb=null;' . 
			'</script>';
		
		foreach($scripts as $file) {
			$o = "\n<script src='$file'></script>";
			$o = str_replace("src='$rootURL", "src='~?php echo \$config->urls->root; ?~", $o);
			$out .= $o;
		}
		$out .=
			"\n<!-- This next script (form-builder-d.js) must go either in the document head or somewhere before the <form> -->" . 
			"\n<script src='~?php echo \$config->urls->FormBuilder; ?~form-builder-d.js'></script>";
	
		// remove version info from link and script tags
		$out = preg_replace('/\?v=[-\d]+/', '', $out);
	
		$out .= "\n" . 
			"\n~?php if(\$submitted): /* When form submitted, show success message */ ?~" . 
			"\n" . 
			"\n\t<div id=\"FormBuilderSubmitted\">" . 
			"\n\t\t<h3>~?php echo \$successMessage; ?~</h3>" . 
			"\n\t</div>" . 
			"\n\n~?php else: /* Render the form markup */ ?~" . 
			$this->prettyHTML($markup);
		
		if(strpos($out, '_post_token')) {
			$input = '~?php echo $session->CSRF->renderInput(); ?~';
			$out = preg_replace('/<input\s+type=.hidden.\s+name=.TOKEN\d+[^>]+>/', $input, $out);
		}
		
		if(strpos($out, '{submitKey}')) {
			$input = '~?php echo $submitKey; ?~';
			$out = str_replace('{submitKey}', $input, $out);
		}


		$head = "\n\n\t~?php " . 
			"\n\t// output error messages" . 
			"\n\tif(count(\$errors)) {" .
			"\n\t\t\$form->getErrors(true); // reset" . 
			"\n\t\tforeach(\$errors as \$error) {" . 
			"\n\t\t\techo '<p class=\"error\">' . \$error . '</p>';" . 
			"\n\t\t}" .
			"\n\t}" . 
			"\n\t?~\n";
		
		$foot = "\n\n~?php " .
			"\nif(count(\$values)) {" .
			"\n\t// populate existing values to fields" . 
			"\n\techo \"<script>FormBuilderD.populate('\$form->id', \" . json_encode(\$values) . \");</script>\";" . 
			"\n}" .
			"\n\nendif;" . 
			"\n?~";
		
		$out = preg_replace('/(<form [^>]+>)/', '$1' . $head, $out);
		$out .= $foot;

		foreach(array('labels', 'descriptions', 'notes') as $type) {
			foreach($texts[$type] as $name => $text) {
				$find = "{pwfb:$type:$name}";
				$repl = "~?php echo \$" . $type . "['$name']; ?~";
				if($type == 'labels') $repl .= "<!-- $text -->";
				$out = str_replace($find, $repl, $out);
			}
		}

		$replacements = array(
			"./?modal=1" => "./", 
			' class="InputfieldMaxWidth"' => '', 
			' InputfieldMaxWidth' => '',
			"~?php" => "<" . "?php",
			"?~" => "?" . ">", 
		);
		
		$out = str_replace(array_keys($replacements), array_values($replacements), $out);
		
		$this->markup = $out; 
	}

	/**
	 * Test to see if the given hash is present in the current custom markup file
	 * 
	 * If it's not present, an error message is triggered. 
	 * 
	 * @param string $testHash
	 * @return bool
	 * 
	 */
	public function testHash($testHash) {
		$testFile = $this->wire('config')->paths->templates . "FormBuilder/form-{$this->form->name}.php";
		$testURL = $this->wire('config')->urls->templates . "FormBuilder/form-{$this->form->name}.php";
		if(file_exists($testFile)) {
			$data = file_get_contents($testFile);
			if(strpos($data, $testHash)) return true; 	
			$this->wire('forms')->error(
				sprintf($this->_('Warning: your custom form markup file at %s is not up-to-date with this form.'), $testURL)
			);
			return false;
		} else {
			// file not present yet
			return true;
		}
	}

	/**
	 * Save markup to the given filename
	 * 
	 * @param string $filename
	 * @return int|bool Returns positive number on success or 0|false on fail
	 * 
	 */
	public function saveTo($filename) {
		
		$dir = dirname($filename);
		if(!is_dir($dir)) wireMkdir($dir);
		
		return file_put_contents($filename, $this->markup);
	}

	/**
	 * 
	 * @param $html
	 * @return string
	 * 
	 */
	protected function prettyHTML($html) {

		$out = '';
		$html = str_replace(array("\r", "\n", "\t", "<wbr>"), "", $html);
		$tags = explode('<', $html);
		$singles = array('option', 'span', 'i', 'textarea', 'small', 'p');
		$inSingle = false;
		$indent = 0;
	
		foreach($tags as $tag) {
			
			$open = false;
			$close = false;
			$single = false;

			$c = substr($tag, 0, 1);

			if($c === '/') {
				// closing tag
				$close = true;

			} else if($c === '!' || $c == '?') {
				// comment or PHP tag
				$out .= "<$tag";
				continue;

			} else {
				// opening tag
				$open = true;
				foreach($singles as $name) {
					if(strpos($tag, "$name ") === 0) $single = true;
				}
			}

			if(!$inSingle) $out .= "\n";

			if($open) {
				if($indent > 1 && !$inSingle) $out .= str_repeat("\t", $indent-1);
				if(!strpos($tag, "/>")) $indent++;
				if($single) $inSingle = true;
			} else if($close) {
				if($indent) $indent--;
				if($indent > 1 && !$inSingle) $out .= str_repeat("\t", $indent-1);
				$inSingle = false;
			}

			$parts = explode('>', $tag, 2);
			$out .= "<$parts[0]>";
			if(isset($parts[1]) && strlen(trim($parts[1]))) {
				// non-markup text that comes after tag
				if($inSingle) {
					$out .= $parts[1];
				} else {
					$out .= "\n" . str_repeat("\t", $indent - 1) . $parts[1];
				}
			}
		}

		// normalize quote style
		$out = preg_replace('/=\'([^\'"]*)\'/', '="$1"', $out);

		$replacements = array(
			'<>' => '',
			' class=" ' => ' class="',
			'<option  ' => '<option ',
			' ">' => '">',
		);
		
		$out = str_replace(array_keys($replacements), array_values($replacements), $out);

		return $out;
	}

}